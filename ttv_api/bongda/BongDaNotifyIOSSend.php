<?php

// This script should be run as a background process on the server. It checks
// every few seconds for new messages in the database table push_queue and 
// sends them to the Apple Push Notification Service.
//
// Usage: php push.php development &
//    or: php push.php production &
//
// The & will detach the script from the shell and run it in the background.
//
// The "development" or "production" parameter determines which APNS server
// the script will connect to. You can configure this in "push_config.php".
// Note: In development mode, the app should be compiled with the development
// provisioning profile and it should have a development-mode device token.
//
// If a fatal error occurs (cannot establish a connection to the database or
// APNS), this script exits. You should probably have some type of watchdog
// that restarts the script or at least notifies you when it quits. If this
// script isn't running, no push notifications will be delivered!

try
{
    require_once('BongDaConfig.php');

    ini_set('display_errors', 'on');

    $mode="production";
    $config = $config[$mode];

    writeToLog("Push script started ($mode mode)");

    $obj = new APNS_Push($config);
    $obj->start();
}
catch (Exception $e)
{
    fatalError($e);
}

////////////////////////////////////////////////////////////////////////////////

function writeToLog($message)
{
    global $config;
    if ($fp = fopen($config['logfileIOS'], 'at'))
    {
        fwrite($fp, date('c') . ' ' . $message . PHP_EOL);
        fclose($fp);
    }
}

function fatalError($message)
{
    writeToLog('Exiting with fatal error: ' . $message);
    exit;
}

////////////////////////////////////////////////////////////////////////////////

class APNS_Push
{
    private $fp = NULL;
    private $server;
    private $certificate;
    private $passphrase;

    function __construct($config)
    {
        $this->server = $config['server'];
        $this->certificate = $config['certificate'];
        $this->passphrase = $config['passphrase'];
        $this->config = $config;

    }

    // This is the main loop for this script. It polls the database for new
    // messages, sends them to APNS, sleeps for a few seconds, and repeats this
    // forever (or until a fatal error occurs and the script exits).
    function start()
    {
        writeToLog('Connecting to ' . $this->server);

       while (true)
        {
            // Do at most 20 messages at a time. Note: we send each message in
            // a separate packet to APNS. It would be more efficient if we 
            // combined several messages into one packet, but this script isn't
            // smart enough to do that. ;-)
            $messages = $this->getNotifyToSend();
            $this->connectToAPNS();
             
            foreach ($messages as $message)
            {
               if ($this->sendNotification($message["id"], $message["device_token"], $message["payload"]))
                {
                   var_dump($message["id"]."\n");
                   $this->deleteNotify($message["id"]);
                }
               
            }
            
            $this->disconnectFromAPNS();
            unset($messages);            
            sleep(10);
        }
    }
    
    function connectBongDaDB(){
        
        $this->server = $this->config['server'];
        // Create a connection to the database.
        $connect = new PDO(
            'mysql:host=' . $this->config['db']['host'] . ';dbname=' . $this->config['db']['dbname'], 
            $this->config['db']['username'], 
            $this->config['db']['password'],
            array());

        // If there is an error executing database queries, we want PDO to
        // throw an exception.
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // We want the database to handle all strings as UTF-8.
        $connect->query('SET NAMES utf8');
        return  $connect;
   }
   
   function getNotifyToSend()
    {
        $connect = $this->connectBongDaDB();
        $sql = "SELECT * FROM fb_notice_queue Where os_type = 3 And send_status = 1 LIMIT 200";
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array());   
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();  
        $i = 0;  
        while($row = $q->fetch()) {
             $arr[$i] =  $row;
             
             $i++;
            
        }
        
        $connect = null;
        return $arr;   
       
    } 
    
    
    function deleteNotify($id)
    {   
        try{
            $connect = $this->connectBongDaDB();
            $sql = "Delete From fb_notice_queue  WHERE id = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($id);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
        return $count;   
    }
    
    // Opens an SSL/TLS connection to Apple's Push Notification Service (APNS).
    // Returns TRUE on success, FALSE on failure.
    function connectToAPNS()
    {
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->certificate);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);

        $this->fp = stream_socket_client(
            'ssl://' . $this->server, $err, $errstr, 60,
            STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$this->fp)
        {
            writeToLog("Failed to connect: $err $errstr");
            return FALSE;
        }

        writeToLog('Connection OK');
        return TRUE;
    }

    // Drops the connection to the APNS server.
    function disconnectFromAPNS()
    {
        fclose($this->fp);
        $this->fp = NULL;
    }

    // Attempts to reconnect to Apple's Push Notification Service. Exits with
    // an error if the connection cannot be re-established after 3 attempts.
    function reconnectToAPNS()
    {
        $this->disconnectFromAPNS();
    
        $attempt = 1;
    
        while (true)
        {
            writeToLog('Reconnecting to ' . $this->server . ", attempt $attempt");

            if ($this->connectToAPNS())
                return;

            if ($attempt++ > 3)
                fatalError('Could not reconnect after 3 attempts');

            sleep(10);
        }
    }

    // Sends a notification to the APNS server. Returns FALSE if the connection
    // appears to be broken, TRUE otherwise.
    function sendNotification($messageId, $deviceToken, $payload)
    {
        if (strlen($deviceToken) != 64)
        {
            writeToLog("Message $messageId has invalid device token");
            return TRUE;
        }

        if (strlen($payload) < 10)
        {
            writeToLog("Message $messageId has invalid payload");
            return TRUE;
        }

        writeToLog("Sending message $messageId to '$deviceToken', payload: '$payload'");

        if (!$this->fp)
        {
            writeToLog('No connection to APNS');
            return FALSE;
        }

        // The simple format
        $msg = chr(0)                       // command (1 byte)
             . pack('n', 32)                // token length (2 bytes)
             . pack('H*', $deviceToken)     // device token (32 bytes)
             . pack('n', strlen($payload))  // payload length (2 bytes)
             . $payload;                    // the JSON payload

        /*
        // The enhanced notification format
        $msg = chr(1)                       // command (1 byte)
             . pack('N', $messageId)        // identifier (4 bytes)
             . pack('N', time() + 86400)    // expire after 1 day (4 bytes)
             . pack('n', 32)                // token length (2 bytes)
             . pack('H*', $deviceToken)     // device token (32 bytes)
             . pack('n', strlen($payload))  // payload length (2 bytes)
             . $payload;                    // the JSON payload
        */

        $result = @fwrite($this->fp, $msg, strlen($msg));

        if (!$result)
        {
            writeToLog('Message not delivered');
            return FALSE;
        }

        writeToLog('Message successfully delivered');
        return TRUE;
    }
}

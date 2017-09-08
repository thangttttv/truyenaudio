<?php
try
{
    require_once('AudioNoticeConfig.php');
    ini_set('display_errors', 'on');

    $mode="development";
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
    if ($fp = fopen($config['logfileIOSSend'], 'at'))
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

        // Create a connection to the database.
        $this->pdo = new PDO(
        'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], 
        $config['db']['username'], 
        $config['db']['password'],
        array());

        // If there is an error executing database queries, we want PDO to
        // throw an exception.
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // We want the database to handle all strings as UTF-8.
        $this->pdo->query('SET NAMES utf8');
    }

    // This is the main loop for this script. It polls the database for new
    // messages, sends them to APNS, sleeps for a few seconds, and repeats this
    // forever (or until a fatal error occurs and the script exits).
    function start()
    {
        writeToLog('Connecting to ' . $this->server);

        if (!$this->connectToAPNS())
            exit;

        while (true)
        {
            // Do at most 20 messages at a time. Note: we send each message in
            // a separate packet to APNS. It would be more efficient if we 
            // combined several messages into one packet, but this script isn't
            // smart enough to do that. ;-)

            $stmt = $this->pdo->prepare('SELECT * FROM c_story_audio_notice_queue Where os_type = 3   LIMIT 100');
            $stmt->execute();
            $messages = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($messages as $message)
            {
                if ($this->sendNotification($message->id, $message->device_token, $message->payload))
                {
                    var_dump($message->id);
                    $stmt = $this->pdo->prepare('Delete From c_story_audio_notice_queue  WHERE id = ?');
                  //  $stmt->execute(array($message->id));
                }
                else  // failed to deliver
                {
                    $this->reconnectToAPNS();
                }
            }

            unset($messages);            
            sleep(5);
        }
    }

    // Opens an SSL/TLS connection to Apple's Push Notification Service (APNS).
    // Returns TRUE on success, FALSE on failure.
    function connectToAPNS()
    {
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->certificate);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);
        
        echo $this->certificate;
        echo $this->passphrase;

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

            sleep(60);
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

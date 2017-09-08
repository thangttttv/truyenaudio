<?php
  try
{
    require_once('BongDaConfig.php');
    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

    writeToLog("Push script started ($mode mode)");

    $obj = new APNS_Android_Push($config);
    $obj->start();
}
catch (Exception $e)
{
    fatalError($e);
}

function writeToLog($message)
{
    global $config;
    if ($fp = fopen($config['logfile'], 'at'))
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

?>


<?php 
////////////////////////////////////////////////////////////////////////////////

class APNS_Android_Push
{
    private $fp = NULL;
    private $server;
    private $certificate;
    private $passphrase;

    function __construct($config)
    {
       $this->server = $config['server'];
       $this->config = $config;
    }

    // This is the main loop for this script. It polls the database for new
    // messages, sends them to APNS, sleeps for a few seconds, and repeats this
    // forever (or until a fatal error occurs and the script exits).
    function start()
    {
           while (true)
            {
                // Do at most 20 messages at a time. Note: we send each message in
                // a separate packet to APNS. It would be more efficient if we 
                // combined several messages into one packet, but this script isn't
                // smart enough to do that. ;-)
                $messages = $this->getNotifyToSend();
                foreach ($messages as $message)
                {
                   if ($this->send_push_notification($message["id"],$message["device_token"], $message["payload"],0))
                    {
                        var_dump("Send Notify ID: ".$message["id"]."\n");
                        $this->deleteNotify($message["id"]);
                    }else{
                         echo $message["id"];
                    }
                }
                unset($messages);            
                sleep(5);
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
        $sql = "SELECT * FROM fb_notice_queue Where os_type = 2 And send_status = 1 LIMIT 200";
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
   
    //Sending Push Notification
   function send_push_notification($messageId,$registatoin_ids, $message) {
        // Set POST variables
        $channel =  0;
        $arrChannelKey = Array("0"=>"AIzaSyACB-qfTLf0u-Mjh2OD6o4rp9vQHTV_qXM");
        try {
            $url =   'https://android.googleapis.com/gcm/send';;
            $fields = array(
                'registration_ids' => array($registatoin_ids),
                "data" => json_decode($message),
            );
            
            $headers = array(
                'Authorization: key=' . $arrChannelKey[strval($channel)],
                'Content-Type: application/json'
            );
            
            writeToLog("Sending message $messageId to '$registatoin_ids', payload: '$message'");
            //var_dump("Sending message $messageId to '$registatoin_ids', payload: '$message'");
            // Open connection
            $ch = curl_init();
     
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
     
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
                 writeToLog('Message not delivered');
                 var_dump('Message not delivered');
                 return 0;
            }
            
            
            writeToLog('Message successfully delivered');
            //var_dump('Message successfully delivered');
            // Close connection
            curl_close($ch);
           // echo $result;
            return 1;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        return 0;
        
    }
    

}


?>
<?php
  try
{
    require_once('AudioNoticeConfig.php');

    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

    writeToLog("Push script started ($mode mode)");

    $obj = new Audio_APNS_Android_Push($config);
    $obj->start();
}
catch (Exception $e)
{
    fatalError($e);
}

function writeToLog($message)
{
    global $config;
    if ($fp = fopen($config['logfileAndroidSend'], 'at'))
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

class Audio_APNS_Android_Push
{
    private $fp = NULL;
    private $server;
    private $certificate;
    private $passphrase;

    function __construct($config)
    {
        $this->server = $config['server'];
      
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
       
           while (true)
            {
                $stmt = $this->pdo->prepare('SELECT * FROM c_story_audio_notice_queue Where os_type = 2  LIMIT 100');
                $stmt->execute();
                $messages = $stmt->fetchAll(PDO::FETCH_OBJ);
               
                foreach ($messages as $message)
                {
                   if ($this->send_push_notification($message->id,$message->device_token, $message->payload))
                    {
                        var_dump("TC".$message->id."\n");
                        $stmt = $this->pdo->prepare('Delete From c_story_audio_notice_queue  WHERE id = ?');
                      //  $stmt->execute(array($message->id));
                    }else{
                         echo $message->id;
                    }
                   
                }

                unset($messages);            
                sleep(5);
            }
    }

    
    //Sending Push Notification
   function send_push_notification($messageId,$registatoin_ids, $message) {
       try {
                 // Set POST variables
                $url =   'https://android.googleapis.com/gcm/send';;
                $data_string = '{"price" :"doata"}';
                $fields = array(
                    'registration_ids' => array($registatoin_ids),
                    "data" => json_decode($message),
                );
                
               
               $headers = array(
                    'Authorization: key=' . "AIzaSyD0RasRyXNTcJ4gb8iJDF_5VApbNEZg3Ns",
                    'Content-Type: application/json'
                );
                writeToLog("Sending message $messageId to '$registatoin_ids', payload: '$message'");
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
                     return 0;
                }
                
                
                writeToLog('Message successfully delivered');
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
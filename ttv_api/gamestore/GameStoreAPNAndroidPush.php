<?php
  try
{
    require_once('GameStoreAPNAndroidPushConfig.php');
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
                   if ($this->send_push_notification($message["id"],$message["device_token"], $message["payload"],$message["channel"]))
                    {
                        var_dump("TC".$message["id"]."\n");
                        $this->deleteNotify($message["id"]);
                    }else{
                         echo $message["id"];
                         $this->deleteNotify($message["id"]);
                    }
                   
                }

                unset($messages);            
                sleep(5);
            }
    }

     function connectDB(){
        
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
        $connect = $this->connectDB();
        $sql = "SELECT * FROM g_notice_queue Where os_type = 2  LIMIT 200";
        var_dump($sql) ;
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
            $connect = $this->connectDB();
            $sql = "Delete From g_notice_queue  WHERE id = ?";
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
    
    function deleteToken($token)
    {   
        try{
            $connect = $this->connectDB();
            $sql = "Delete From g_notice_user  WHERE device_token = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($token);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
        return $count;   
    }
    
     function updateTokenChanel($token,$channel)
    {   
        try{
            $connect = $this->connectDB();
            $sql = "Update  g_notice_user  set channel = ? WHERE device_token = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($channel,$token);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
        return $count;   
    }
    
    //Sending Push Notification
   function send_push_notification($messageId,$registatoin_ids, $message,$channel) {
        // Set POST variables
        $arrChannelKey = Array("0"=>"AIzaSyARWYEwVGtawyWLP1MTkrTdkSvnLBQo_Ak","1"=>"AIzaSyB591JNcRpDMJrtPMKE3wYJVTM11dVEqBk","2"=>"AIzaSyAYpUP9Y0R2jnShn1TfZYm0aHoWU-goyHk");
        try {
            $url =   'https://android.googleapis.com/gcm/send';;
            $data_string = '{"price" :"doata"}';
            $fields = array(
                'registration_ids' => array($registatoin_ids),
                "data" => json_decode($message),
            );
            
       
            //AIzaSyB591JNcRpDMJrtPMKE3wYJVTM11dVEqBk
            //AIzaSyARWYEwVGtawyWLP1MTkrTdkSvnLBQo_Ak
            $headers = array(
                'Authorization: key=' . $arrChannelKey[strval($channel)],
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
             $arrResult = json_decode($result);
             
            if ($arrResult->failure === 1) {
                 $arrError = $arrResult->results;
                 
                 if(strcasecmp("MissingRegistration",$arrError[0]->error)==0||strcasecmp("InvalidRegistration",$arrError[0]->error)==0||strcasecmp("InvalidRegistration",$arrError[0]->error)==0||strcasecmp("NotRegistered",$arrError[0]->error)==0){
                     $this->deleteToken($registatoin_ids);
                 }
                 if(strcasecmp("MismatchSenderId",$arrError[0]->error)==0){
                     $c = 0;
                     foreach($arrChannelKey as $chanelKey){
                         if($channel!=$c){
                         $kq = $this->send_push_notification($messageId,$registatoin_ids, $message,$c);
                         if($kq==1){
                             var_dump('Update token'.$registatoin_ids);
                             $this->updateTokenChanel($registatoin_ids,$c);
                         } 
                         }
                         $c++;
                     }
                 }
                 writeToLog('Message not delivered  '.$registatoin_ids);
                 var_dump('Message not delivered '.$arrError[0]->error);
                 return 0;
            }else {
                var_dump('Message success delivered');
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

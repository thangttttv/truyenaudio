<?php
  try
{
    require_once('XosoAPNPushConfig.php');

    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

   // writeToLog("Notify_Push_Queue script started ($mode mode)");

    $obj = new Xoso_Notify_Push_Queue($config);
   
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

class Xoso_Notify_Push_Queue
{
    private $fp = NULL;
    private $server;
    private $certificate;
    private $passphrase;
    private $config;

    function __construct($config)
    {
        $this->server = $config['server'];
        $this->config = $config;
      
    }
    
    function connectGameStoreDB(){
        
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
   
    // This is the main loop for this script. It polls the database for new
    // messages, sends them to APNS, sleeps for a few seconds, and repeats this
    // forever (or until a fatal error occurs and the script exits).
    function start()
    {
       
           while (true)
            {
                $messages = $this->getNoticeToSend();
            
                foreach ($messages as $message)
                {
                    echo "---->NoticeID: ".$message["id"]."\n";
                    
                    $to_user = $message["to_user"];
                    $icon = $message["icon"];
                    // if send all user
                   if (empty($to_user))
                    {
                       $arr_token = $this->getTokenAll();
                       foreach($arr_token as $token){
                           echo "--------->app_client_id: ".$token["app_client_id"]."-".$message["object_id"]."\n";
                            
                           $payload = $this->createPayLoadNotify($message["content"],"view",$message["TYPE"],$message["object_id"],$message["from_user"],$icon);
                         
                           if(!empty($payload))
                           $this->insertNotifyToQueue($message["id"],$token["device_token"],$payload,$message["time_sent"],$token["os_type"]);
                       }
                    }else{
                        $arr_token = $this->getTokenByUserIds($to_user);
                        
                         foreach($arr_token as $token){
                             echo "--------->User_ID: ".$token["user_id"]."\n";
                             
                            $payload = $this->createPayLoadNotify($message["content"],"view",$message["TYPE"],$message["object_id"],$message["from_user"],$icon);
                            
                             if(!empty($payload))
                            $this->insertNotifyToQueue($message["id"],$token["device_token"],$payload,$message["time_sent"],$token["os_type"]);
                           
                       }
                    }
                    
                     echo "-------------------\n";
                     $this->updateInactiveNotice($message["id"]);
                   
                }

                unset($messages);            
                sleep(15);
            }
    }

  
  function insertNotifyToQueue($notice_id,$device_token,$payload,$time_sent,$os_type)
    {   
        $count = 0;
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "INSERT INTO x_notice_queue (notice_id,device_token,payload,time_queued,time_sent, os_type)
    VALUES (:notice_id,:device_token,:payload,NOW(),:time_sent,:os_type);";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":notice_id"=>$notice_id,":device_token"=>$device_token,":payload"=>$payload
            ,":time_sent"=>$time_sent,":os_type"=>$os_type);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
           // var_dump($e);
          $count = 0;
        }
        
         return $count;   
    }  
   
    function updateInactiveNotice($notice_id)
    {   
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "UPDATE x_notice SET STATUS = 0 WHERE id = ? ";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($notice_id);
            
            $count = $q->execute($arrV);
            
            $connect = null;
        }catch (Exception $e) {
           // var_dump($e);
          $count = 0;
        }
        
        return $count;   
    }
    
    function getNoticeToSend()
    {
        $connect = $this->connectGameStoreDB();
        $sql = "SELECT id,object_id,from_user,to_user,content,url,icon,TYPE,STATUS,time_sent,create_date,create_user FROM x_notice WHERE STATUS = 1 LIMIT 0, 5;";
     //  echo $sql;
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
    
    function getTokenAll()
    {
        $connect = $this->connectGameStoreDB();
        $sql = "SELECT  DISTINCT app_client_id,user_id,device_token,os_type FROM x_notice_user ";
    //   echo $sql;
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
    
    function getTokenByUserIds($ids)
    {
        $connect = $this->connectGameStoreDB();
        $last_char = substr($ids, -1);
        if(strcmp($last_char,",")==0)
        $ids = substr($ids,0,strlen($ids)-1);
        
        $sql = "SELECT user_id,device_token,os_type FROM x_notice_user Where user_id in (".$ids.") ";
       
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute();   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $i++;
            }
            
            $connect =  null;
            return $arr;   
       
    } 
      
    //Create Payload Notification
  function createPayLoadNotify($body,$action_loc_key,$type,$oid,$from_user,$icon)
  {
     $arr_cdata = array();
     $arr_cdata["type"] = $type;
     //$arr_cdata["oid"] = $oid;
     //$arr_cdata["fid"] = $from_user;
     //$arr_cdata["icon"] = $icon;
     
     $arr_alert = array();
     $arr_alert["body"] = $body;
     $arr_alert["action-loc-key"] = $action_loc_key;
     $arr_alert["cdata"] = $arr_cdata;
     
     $arr_aps = array();
     $arr_aps["alert"] = $arr_alert;
     $arr_aps["sound"] = "default";
     
     $arr_out = array();
     $arr_out["aps"] = $arr_aps;
      echo $oid;
     return json_encode($arr_out);
  }
    

}


?>
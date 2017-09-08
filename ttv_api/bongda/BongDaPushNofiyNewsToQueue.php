<?php
  try
{
    require_once('BongDaConfig.php');

    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

   // writeToLog("Notify_Push_Queue script started ($mode mode)");

    $obj = new News_Notify_Push_Queue($config);
   
    $obj->start();
}
catch (Exception $e)
{
    fatalError($e);
}

function writeToLog($message)
{
    global $config;
    if ($fp = fopen($config['logfileNewsQueue'], 'at'))
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

class News_Notify_Push_Queue
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
   
    // This is the main loop for this script. It polls the database for new
    // messages, sends them to APNS, sleeps for a few seconds, and repeats this
    // forever (or until a fatal error occurs and the script exits).
    function start()
    {
           $limit = 1000;
           while (true)
            {
                $listNews = $this->getAllNews();
                $i=1;
                foreach ($listNews as $news)
                {
                    echo "---->NewsID: ".$news["id"]."\n";
                    echo "---->Cup_id: ".$news["cup_id"]."\n";
                    $icon = $news["image"];
                   $i=1;
                    //Send To Token Form Cup Favorite
                    if(!empty($news["cup_id"]))
                    while($i<1000000000){
                        $arrTokenCup =  $this->getTokenSendFromCup($news["cup_id"],$i,$limit);
                        if(count($arrTokenCup)==0)break;
                        foreach($arrTokenCup as $token){
                              $payload = $this->createPayLoadNotify($news["title"],2,$news["id"],0,$icon);
                               if(!empty($payload))
                               $this->insertNotifyToQueue(0,$news["id"],2,$token["device_token"],$payload,$news["create_date"],$token["os_type"]);
                        }
                        $i++;
                    }
                    
                    $i=1;
                    
                    //Send To Token Form Club Favorite
                     if(!empty($news["club_id"]))
                     while($i<1000000000){
                        $arrTokenCup =  $this->getTokenSendFromClub($news["club_id"],$i,$limit);
                        if(count($arrTokenCup)==0)break;
                        foreach($arrTokenCup as $token){
                              $payload = $this->createPayLoadNotify($news["title"],2,$news["id"],0,$icon);
                               if(!empty($payload))
                               $this->insertNotifyToQueue(0,$news["id"],2,$token["device_token"],$payload,$news["create_date"],$token["os_type"]);
                        }
                        $i++;
                    }
                    

                     $this->updateHadNofifyNews($news["id"]);
                     $this->updateSendSatusInQueue($news["id"]);
                     echo "-------------------\n";
                   
                }
                unset($listNews);            
                sleep(5);
            }
    }

  
  function insertNotifyToQueue($notice_id,$object_id,$object_type,$device_token,$payload,$time_sent,$os_type)
    {   
        $count = 0;
        try{
            $connect = $this->connectBongDaDB();
            $sql = "INSERT INTO fb_notice_queue (notice_id,object_id,object_type,device_token,payload,time_queued,time_sent, os_type)
    VALUES (:notice_id,:object_id,:object_type,:device_token,:payload,NOW(),:time_sent,:os_type);";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":notice_id"=>$notice_id,":object_id"=>$object_id,":object_type"=>$object_type,":device_token"=>$device_token,":payload"=>$payload,":time_sent"=>$time_sent,":os_type"=>$os_type);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }  
   
    function updateHadNofifyNews($news_id)
    {   
        try{
            $connect = $this->connectBongDaDB();
            $sql = "UPDATE fb_news SET had_notify  = 1 WHERE id  = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($news_id);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
        return $count;   
    }
    
    function updateSendSatusInQueue($object_id)
    {   
        try{
            $connect = $this->connectBongDaDB();
            $sql = "UPDATE fb_notice_queue SET send_status  = 1 WHERE object_id  = ? ";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($object_id);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
        return $count;   
    }
    
    function getTokenSendFromCup($cup_id,$page,$limit)
    {
        $connect = $this->connectBongDaDB();
        $startRecord = ($page - 1) * $limit;
        $sql = "SELECT u.app_client_id,u.device_token,u.os_type FROM fb_notice_user u INNER JOIN fb_cup_favorite c ON u.app_client_id = c.app_client_id WHERE c.cup_id = ? Order by u.app_client_id DESC LIMIT " . $startRecord . ", " . $limit;
     
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($cup_id));   
            
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
    
    function getTokenSendFromClub($club_id,$page,$limit)
    {
        $connect = $this->connectBongDaDB();
        $startRecord = ($page - 1) * $limit;
        $sql = "SELECT u.app_client_id,u.device_token,u.os_type FROM fb_notice_user u INNER JOIN fb_club_favorite c ON u.app_client_id = c.app_client_id WHERE c.club_id = ? Order by u.app_client_id DESC LIMIT " . $startRecord . ", " . $limit;
       
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($club_id));   
            
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
    
   
  function getAllNews()
    {
        $connect = $this->connectBongDaDB();
        $sql = "SELECT id,title,image,cup_id,club_id,create_date FROM fb_news WHERE STATUS = 1 AND had_notify = 0; ";
       
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
                 $arr[$i]['image'] = "http://kenhkiemtien.com/upload/bongda/news/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];              
                 $i++;
            }
            
            $connect =  null;
            return $arr;   
       
    } 
      
    //Create Payload Notification
  function createPayLoadNotify($body,$type,$oid,$from_user,$icon)
  {
     $arr_cdata = array();
     $arr_cdata["type"] = $type;
     $arr_cdata["oid"] = $oid;
     $arr_cdata["fid"] = $from_user;
     $arr_cdata["icon"] = $icon;
     
     $arr_alert = array();
     $arr_alert["body"] ="[NEWS] ". $body;
     $arr_alert["cdata"] = $arr_cdata;
     
     $arr_aps = array();
     $arr_aps["alert"] = $arr_alert;
     $arr_aps["sound"] = "default";
     
     $arr_out = array();
     $arr_out["aps"] = $arr_aps;
      
     return json_encode($arr_out);
  }
}
?>
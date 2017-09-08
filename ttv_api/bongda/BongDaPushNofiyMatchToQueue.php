<?php
  try
{
    require_once('BongDaConfig.php');

    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

   // writeToLog("Notify_Push_Queue script started ($mode mode)");

    $obj = new Match_Notify_Push_Queue($config);
   
    $obj->start();
}
catch (Exception $e)
{
    fatalError($e);
}

function writeToLog($message)
{
    global $config;
    if ($fp = fopen($config['logfileMatchQueue'], 'at'))
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

class Match_Notify_Push_Queue
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
                $listMatchEvent = $this->getAllEventMatch();
                $i=1;
                foreach ($listMatchEvent as $event)
                {
                    echo "---->Event: ".$event["id"]."\n";
                    echo "---->Match_id: ".$event["match_id"]."\n";
                    $matchDetail = $this->getMatchDetail($event["match_id"]);
                    
                     $i=1;
                    //Send To Token Form Match Favorite
                    if(!empty($matchDetail)){
                        $bodyM = "[".$matchDetail["club_name_1"]." ".$matchDetail["result"]." ".$matchDetail["club_name_2"]."] ";  
                         while($i<1000000000){
                            $arrTokenCup =  $this->getTokenSendFromMatch($event["match_id"],$i,$limit);
                            if(count($arrTokenCup)==0)break;
                            foreach($arrTokenCup as $token){
                                 echo "---->Event: ".$event["id"]."-".$token["device_token"]."-".$token["os_type"]."\n";
                                  
                                  if($token["os_type"]==2)    
                                  $payload = $this->createPayLoadNotifyIOS($bodyM,1,$event["match_id"],$event["m_minute"],$event["event"]);
                                  else $payload = $this->createPayLoadNotifyIOS($bodyM,1,$event["match_id"],$event["m_minute"],$event["event"]);
                                  
                                  if(!empty($payload))
                                   $this->insertNotifyToQueue(0,$event["id"],1,$token["device_token"],$payload,$event["create_date"],$token["os_type"]);
                            }
                            $i++;
                        }
                    }
                    $i=1;
                    
                    //Send To Token Form Club Favorite
                      if(!empty($matchDetail)){
                         while($i<1000000000){
                            $bodyM = "[".$matchDetail["club_name_1"]." ".$matchDetail["result"]." ".$matchDetail["club_name_2"]."] ";
                            $arrTokenCup =  $this->getTokenSendFromClub($matchDetail["club_id_1"],$matchDetail["club_id_2"],$i,$limit);
                            if(count($arrTokenCup)==0)break;
                            foreach($arrTokenCup as $token){
                                
                                if($token["os_type"]==2)
                                  $payload = $this->createPayLoadNotifyIOS($bodyM,1,$event["match_id"],$event["m_minute"],$event["event"]);
                                else $payload = $this->createPayLoadNotifyIOS($bodyM,1,$event["match_id"],$event["m_minute"],$event["event"]);
                                
                                if(!empty($payload))
                                  $this->insertNotifyToQueue(0,$event["id"],1,$token["device_token"],$payload,$event["create_date"],$token["os_type"]);
                            }
                            $i++;
                        }
                    }

                     $this->updateHadNofifyMatchEvent($event["id"]);
                     $this->updateSendSatusInQueue($event["id"]);
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
   
    function updateHadNofifyMatchEvent($event_id)
    {   
        try{
            $connect = $this->connectBongDaDB();
            $sql = "UPDATE fb_match_summary SET had_notify  = 1 WHERE id  = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($event_id);
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
    
    function getTokenSendFromClub($club_id_1,$club_id_2,$page,$limit)
    {
        $connect = $this->connectBongDaDB();
        $startRecord = ($page - 1) * $limit;
        $sql = "SELECT u.app_client_id,u.device_token,u.os_type FROM fb_notice_user u INNER JOIN fb_club_favorite c ON u.app_client_id = c.app_client_id WHERE (c.club_id = ? OR c.club_id = ? ) Order by u.app_client_id DESC LIMIT " . $startRecord . ", " . $limit;
       
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($club_id_1,$club_id_2));   
            
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
    
     function getTokenSendFromMatch($match_id,$page,$limit)
    {
        $connect = $this->connectBongDaDB();
        $startRecord = ($page - 1) * $limit;
        $sql = "SELECT u.app_client_id,u.device_token,u.os_type FROM fb_notice_user u INNER JOIN fb_match_favorite c ON u.app_client_id = c.app_client_id WHERE c.match_id = ? Order by u.app_client_id DESC LIMIT " . $startRecord . ", " . $limit;
      
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($match_id));   
            
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
    
   
  function getAllEventMatch()
    {
        $connect = $this->connectBongDaDB();
        $sql = "SELECT id,match_id,club_id,cup_id,m_minute,i_minute,event,create_date FROM fb_match_summary WHERE  had_notify = 0  ORDER BY m_minute ASC  ";
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
    
    function getMatchDetail($id)
    {
        $connect = $this->connectBongDaDB();
        $sql = "SELECT id,cup_id,ROUND,club_id_1,club_id_2,club_code_1,club_code_2,club_name_1,club_name_2,club_logo_1,club_logo_2,result FROM fb_match WHERE  id = ?; ";
       
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
         
            if($row = $q->fetch()) {
                 $arr =  $row;
                 
            }
            
            $connect =  null;
            return $arr;   
       
    } 
      
      
    //Create Payload Notification
      function createPayLoadNotify($body,$type,$oid,$minute,$event)
      {
         $arr_cdata = array();
         $arr_cdata["type"] = $type;
         $arr_cdata["oid"] = $oid;
         $arr_cdata["minute"] = $minute;
         $arr_cdata["event"] = $event;
         
         $arr_alert = array();
         $arr_alert["body"] = $body;
         $arr_alert["cdata"] = $arr_cdata;
         
         $arr_aps = array();
         $arr_aps["alert"] = $arr_alert;
         $arr_aps["sound"] = "default";
         
         $arr_out = array();
         $arr_out["aps"] = $arr_aps;
          
         return json_encode($arr_out);
      }
      
       function createPayLoadNotifyIOS($body,$type,$oid,$minute,$event)
      {
         $arr_cdata = array();
         $arr_cdata["type"] = $type;
         $arr_cdata["oid"] = $oid;
         //$arr_cdata["minute"] = $minute;
         //$arr_cdata["event"] = $event;
         $body .= " ".$minute.":";         
         $arrJson = json_decode($event);
       
         foreach($arrJson as $event){
             $strBodyEvent  =  "[".$this->getActionFromImage($event->icon)."]" ."-".$event->footballer." ";
             $body .=    $strBodyEvent;
         }
         
         $arr_alert = array();
         $arr_alert["body"] = $body;
         $arr_alert["cdata"] = $arr_cdata;
         
         $arr_aps = array();
         $arr_aps["alert"] = $arr_alert;
         $arr_aps["sound"] = "default";
         
         $arr_out = array();
         $arr_out["aps"] = $arr_aps;
          
         return json_encode($arr_out);
      }
      
      function getActionFromImage($icon){
          $action ="";
            if(strpos($icon,"yc.png")>0) $action ="YC";
            else if(strpos($icon,"rc.png")>0) $action ="RC";
            else if(strpos($icon,"2yc.png")>0) $action ="2YC";  
            else if(strpos($icon,"in.png")>0) $action ="IN";  
            else if(strpos($icon,"out.png")>0) $action ="OUT"; 
            else if(strpos($icon,"g.png")>0) $action ="G";         
            else if(strpos($icon,"go.png")>0) $action ="GO";         
            else if(strpos($icon,"gp.png")>0) $action ="GP";
            
            return   $action;          
      }
}
?>
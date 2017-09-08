<?php
  try
{
    require_once('GameStoreAPNAndroidPushConfig.php');

    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

   // writeToLog("Notify_Push_Queue script started ($mode mode)");

    $obj = new UserBanCron($config);
   
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

class UserBanCron
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
                $userBans = $this->getAllUserBanExpire();
            
                foreach ($userBans as $user)
                {
                    echo "---->Ban: ".$user["user_id"]."\n";
                    
                    $user_id = $user["user_id"];
                    $type = $user["type"];
                  
                    if($type==1){
                        $this->removeBanChat($user_id);
                    }else{
                        $this->removeBanComment($user_id);
                    }
                    
                    $this->deleteUserBan($user_id,$type);
                     echo "-------------------\n";
                   
                }

                unset($games);            
                sleep(30);
            }
    }

  
  function removeBanChat($user_id)
    {   
        $count = 0;
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "UPDATE  vtc_game_store.g_user SET is_ban_chat = 0 Where id  =  :id ";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":id"=>$user_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    } 
    
    function removeBanComment($user_id)
    {   
        $count = 0;
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "UPDATE  vtc_game_store.g_user SET is_ban_comment_new = 0 Where id  =  :id ";
           
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":id"=>$user_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }
    
    
    function deleteUserBan($user_id,$type)
    {   
        $count = 0;
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "DELETE FROM vtc_game_store.g_user_ban WHERE user_id = :user_id AND type = :type ";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":user_id"=>$user_id,":type"=>$type);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }   
   
   
    
    function getAllUserBanExpire()
    {
        $connect = $this->connectGameStoreDB();
        $sql = "SELECT * FROM g_user_ban WHERE date_expire < NOW() ";
       
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
    
    
}

?>
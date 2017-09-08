<?php
  try
{
    require_once('GameStoreAPNAndroidPushConfig.php');

    ini_set('display_errors', 'on');

    $mode="development";
    $config = $config[$mode];

   // writeToLog("Notify_Push_Queue script started ($mode mode)");

    $obj = new UserDownloadViewCron($config);
   
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

class UserDownloadViewCron
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
                $games = $this->getAllGame();
            
                foreach ($games as $game)
                {
                    echo "---->Game: ".$game["id"]."-".$game["name"]."\n";
                    $this->deleteUserDownloadView($game["id"]);
                    
                    $game_id = $game["id"];
                    $userDownload = $this->getUserDownload($game_id);
                    if(!empty($userDownload)){
                         $user_id = $userDownload["user_id"];
                        
                         $user = $this->getUserById($user_id);
                         if(!empty($user)){
                             if(empty($user["fullname"]))$user["fullname"] = $user["username"];
                             $this->insertUserDownloadView($user_id,$game_id,$userDownload["os_type"],$user["username"],$user["fullname"],$user["avatar"]);
                         }
                    }
                   
                     echo "-------------------\n";
                   
                }

                unset($games);            
                sleep(3000);
            }
    }

  
  function insertUserDownloadView($user_id,$game_id,$os_type,$username,$fullname,$avatar)
    {   
        $count = 0;
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_user_download_view (user_id,game_id,os_type,username,fullname,avatar)
    VALUES (:user_id,:game_id,:os_type,:username,:fullname,:avatar);";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":user_id"=>$user_id,":game_id"=>$game_id,":os_type"=>$os_type
            ,":username"=>$username,":fullname"=>$fullname,":avatar"=>$avatar);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    } 
    
    
    function deleteUserDownloadView($game_id)
    {   
        $count = 0;
        try{
            $connect = $this->connectGameStoreDB();
            $sql = "DELETE FROM vtc_game_store.g_user_download_view WHERE game_id = :game_id ";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array(":game_id"=>$game_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }   
   
   
    
    function getAllGame()
    {
        $connect = $this->connectGameStoreDB();
        $sql = "SELECT id,name FROM vtc_game_store.g_game Where (count_android_view >0 Or count_ios_download > 0) ";
        echo $sql;
       
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
    
    function getUserDownload($game_id)
    {
        $connect = $this->connectGameStoreDB();
        
        $sql = "SELECT user_id,game_id,os_type FROM  vtc_game_store.g_user_download WHERE game_id = ? AND user_id IS NOT NULL    ORDER BY id DESC  LIMIT 0, 50;";
       
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $i++;
            }
            
            $userDownload = array();
            if(!empty($arr)) {
                $sl = count($arr)>50?50:count($arr);
                $i = rand(0,$sl-1);
                $userDownload = $arr[$i];
            }
            
            $connect =  null;
            return $userDownload;   
       
    } 
    
   
   function getUserById($user_id)
    {
        $connect = $this->connectGameStoreDB();
        
        $sql = "SELECT username,fullname,avatar FROM  vtc_game_store.g_user WHERE id = ?  ";
       
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($user_id));   
            
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
}

?>

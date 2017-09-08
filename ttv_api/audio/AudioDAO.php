<?php
   define("TIME_15", 900);
   define("TIME_30", 1800);
   define("ROOT_UPLOAD","/home/truyenaudi/domains/truyenaudio.mobi/public_html/upload");
   
    function baseUrl(){
        return "http://truyenaudio.mobi/";
    }
   
    function baseUrlUpload()
    {
        return "http://truyenaudio.mobi/upload/";
    }
    
   function connectAudioDB(){
        include('AudioConfig.php');
        $mode="development";
        $config = $config[$mode];
        
        // Create a connection to the database.
        $connect = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], 
            $config['db']['username'], 
            $config['db']['password'],
            array());

        // If there is an error executing database queries, we want PDO to
        // throw an exception.
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // We want the database to handle all strings as UTF-8.
        $connect->query('SET NAMES utf8');
        return  $connect;
   }
   
   
   function getCategoryAudio($app_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $app_id = intval($app_id);
        
        $sql = "SELECT id,NAME,CODE,picture,create_date FROM c_category WHERE app_ids & ".$app_id." = ".$app_id." AND TYPE = 5 AND status = 1 ORDER BY id ASC "; 
        //$sql = "SELECT id,NAME,CODE,picture,create_date FROM c_category WHERE  TYPE = 5 AND status = 1 ORDER BY id //ASC "; 
        
		$querykey = "KEY" . md5($sql);
        $result = $meminstance->get($querykey);
        
        //if(1>0){
       
	   if (!$result) {
            # creating the statement
            $connect = connectAudioDB();
            $connect = $connect->query($sql);
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",$row['create_date']);
                 if($row['picture']!="")
                    $arr[$i]['picture'] = baseUrl()."/upload/category/".$time."/".$row['picture'];
                    $i++;
            }
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            return $arr;
            
        }else{
            return $result;
        }
           
    } 
    
    
    function getAudioNew($app_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $app_id = intval($app_id);
        
        $sql = "SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,create_date FROM c_story_audio WHERE 
        app_ids & ".$app_id." = ".$app_id." AND  STATUS=1 ORDER BY create_date DESC LIMIT 100"; 
        $querykey = "KEY" . md5($sql);
        $result = $meminstance->get($querykey);
        
         if (1>0) {
        //if (!$result) {
            # creating the statement
            $connect = connectAudioDB();
            $connect = $connect->query($sql);
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",$row['create_date']);
                 if($row['image']!="")
                    $arr[$i]['image'] = baseUrl()."upload/audio/".$time."/".$row['image'];
                    $i++;
            }
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            return $arr;
            
        }else{
            return $result;
        }
           
    } 
    
    
    function getAudioHot($app_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $app_id = intval($app_id);
        
        $sql = "SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,create_date FROM c_story_audio WHERE 
        app_ids & ".$app_id." = ".$app_id." AND   STATUS=1 ORDER BY c_listen DESC LIMIT 100"; 
        $querykey = "KEY" . md5($sql);
        $result = $meminstance->get($querykey);
        
     //if (1>0) {
     if (!$result) {
            # creating the statement
            $connect = connectAudioDB();
            $connect = $connect->query($sql);
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",$row['create_date']);
                 if($row['image']!="")
                    $arr[$i]['image'] = baseUrl()."upload/audio/".$time."/".$row['image'];
                    $i++;
            }
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            return $arr;
            
        }else{
            return $result;
        }
           
    } 
    
    
    function getAudioNewByCat($app_id,$cat_id,$page,$limit)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT a.id,a.title,a.author,a.image,a.reader,a.c_listen,a.c_chapter,a.c_download,a.create_date FROM c_story_audio a INNER JOIN c_category_story_audio c ON a.id = c.story_audio_id WHERE a.app_ids & ".$app_id." = ".$app_id." AND a.status=1 AND c.cat_id = ".$cat_id." ORDER BY a.id DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY.getAudioNewByCat.".$cat_id.".".$page.".".$app_id;
        $result = $meminstance->get($querykey);
       
       // if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",$row['create_date']);
                 if($row['image']!="")
                    $arr[$i]['image'] = baseUrl()."upload/audio/".$time."/".$row['image'];
                    $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            
            $sl = countAudioByCat($cat_id);
         
            $arrOut = array();
            $arrOut["audio"] = $arr;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             
             return $arrOut;
        }else{
           $sl = countAudioByCat($cat_id);
         
            $arrOut = array();
            $arrOut["audio"] = $result;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrOut;
        }
           
    }
    
    function getAudioHotByCat($app_id,$cat_id,$page,$limit)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT a.id,a.title,a.author,a.image,a.reader,a.c_listen,a.c_chapter,a.c_download,a.create_date FROM c_story_audio a INNER JOIN c_category_story_audio c ON a.id = c.story_audio_id WHERE a.app_ids & ".$app_id." = ".$app_id." AND a.status=1 AND c.cat_id = ".$cat_id." ORDER BY a.c_listen DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY.getAudioNewByCat.".$cat_id.".".$page.".".$app_id;
        $result = $meminstance->get($querykey);
       
        //if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",$row['create_date']);
                 if($row['image']!="")
                    $arr[$i]['image'] = baseUrl()."upload/audio/".$time."/".$row['image'];
                    $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            
            $sl = countAudioByCat($cat_id);
         
            $arrOut = array();
            $arrOut["audio"] = $arr;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             
             return $arrOut;
        }else{
           $sl = countAudioByCat($cat_id);
         
            $arrOut = array();
            $arrOut["audio"] = $result;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrOut;
        }
           
    }
    
    
    function getAudioHotDownByCat($app_id,$cat_id,$page,$limit)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT a.id,a.title,a.author,a.image,a.reader,a.c_listen,a.c_chapter,a.c_download,a.create_date FROM c_story_audio a INNER JOIN c_category_story_audio c ON a.id = c.story_audio_id WHERE a.app_ids & ".$app_id." = ".$app_id." AND  a.status=1 AND c.cat_id = ".$cat_id." ORDER BY a.c_download DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY.getAudioHotDownByCat.".$cat_id.".".$page.".".$app_id;
        $result = $meminstance->get($querykey);
       
        //if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",$row['create_date']);
                 if($row['image']!="")
                    $arr[$i]['image'] = baseUrl()."upload/audio/".$time."/".$row['image'];
                    $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            
            $sl = countAudioByCat($cat_id);
         
            $arrOut = array();
            $arrOut["audio"] = $arr;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             
             return $arrOut;
        }else{
           $sl = countAudioByCat($cat_id);
         
            $arrOut = array();
            $arrOut["audio"] = $result;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrOut;
        }
           
    }
    
    function countAudioByCat($cat_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $cat_id = intval($cat_id);
        
        $sql = "SELECT COUNT(*) as sl FROM c_story_audio a INNER JOIN c_category_story_audio c ON a.id = c.story_audio_id WHERE  a.status=1 AND c.cat_id = ".$cat_id;
        $querykey = "KEY" . md5($sql);
       
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectAudioDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    }  
    
    
    function getAudioFile($audio_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $limit =30;
        $audio_id = intval($audio_id);
//        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT *  FROM c_story_audio_file WHERE story_audio_id=".$audio_id." ORDER BY id ASC";
        $querykey = "KEY.getAudioFile.".$audio_id;
        $result = $meminstance->get($querykey);
       
        //if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $arr[$i]['file'] = baseUrl()."upload/audio/".date("Y/md",$row['create_date'])."/".$row['file'];
                 $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            
           
             
             return $arr;
        }else{
            return $result;
        }
           
    }
    
    function getAudioDetail($audio_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $audio_id = intval($audio_id);
        $sql ="SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,description,price,create_date FROM c_story_audio WHERE id=".$audio_id;
        
        $querykey = "KEY.getAudioDetail.".$audio_id;
        $result = $meminstance->get($querykey);
      
        //if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            if($row = $connect->fetch()) {
                 $arr =  $row;
                 $arr['image'] = baseUrl()."upload/audio/".date("Y/md",$row['create_date'])."/".$row['image'];
                 $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
             
            return $arr;
        }else{
            return $result;
        }
           
    }
    
    
    function registerMemberAudio($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$sso_id){
        $insertId = 0;
        try{
            // init user info
            $avatar=baseUrlUpload()."audio/avatar_d.png";
            $username = "audio".$app_client_id.substr(time(),-3);
            $PASSWORD=md5(md5(time()));
           
            $fMobile ="";$vMobile="";
             if(!empty($mobile))
            {
                $fMobile=",mobile";
                $vMobile=",'".$mobile."'";
            }
            
            $fBirthday ="";$vBirthday="";
            if(!IsNullOrEmptyString($birthday))
            {
                $fBirthday =",birthday";
                $vBirthday=",'".$birthday."'";
            }
            
            $sql = "INSERT INTO c_story_audio_user (app_client_id, username, PASSWORD, fullname, avatar_url, email,sso_id,create_date,create_user".$fBirthday.$fMobile.")VALUES('$app_client_id','$username','$PASSWORD','$fullname','$avatar','$email','$sso_id',NOW(),'$fullname'".$vBirthday.$vMobile.");";
            
            $connect = connectAudioDB(); 
            $q = $connect->prepare($sql);
            $arrV = array();
          
            $count = $q->execute($arrV);
            $insertId = $connect->lastInsertId();
            $connect = null;
            
            //echo $sql;
           

        }catch (Exception $e) {
        }
        return $insertId;  
    }
    
    
    function getUserAudioByEmail($email)
    {
       
        $sql ="SELECT * FROM c_story_audio_user WHERE email='".$email."'";
        # creating the statement
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arr =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arr;
           
    }
    
    function getUserAudioBySSOID($sso_id)
    {
        
        $sql ="SELECT * FROM c_story_audio_user WHERE sso_id='".$sso_id."'";
        # creating the statement
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arr =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arr;
           
    }
    
    function getUserAudioByID1($id)
    {
        $id = intval($id);
        $sql ="SELECT * FROM c_story_audio_user WHERE id=".$id;
        # creating the statement
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arr =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arr;
           
    }
    
    function getAppHeaderAudio($app_header,$app_client_id,$os_version,$imei){
       $app_header = mysql_escape_string($app_header);
       $app_client_id = mysql_escape_string($app_client_id);
       $os_version = mysql_escape_string($os_version);
       $imei = mysql_escape_string(trim($imei));
       
       $arrKq = array();
       //get app header config 
       $arrAppHeader =  checkAppHeaderAudio($app_header);
       
       if(empty($arrAppHeader)) return "";
       
       $arrKq["app_header"] = $arrAppHeader;  
       $app_header_id =  $arrAppHeader["id"];
       $os =    $arrAppHeader["os"];     
       // check by app_client_id
       $checkByAppClientID = 0;
       $checkByImei = 0;
       
       if(!empty($app_client_id)&&intval($app_client_id)>0){
           $app_client_id = checkAppClientIdAudioExist($app_client_id);
       }
       
       if(!empty($imei)&&intval($app_client_id)== 0){
           $app_client_id = checkImeiAudioExist($imei);
       }
       
       if($app_client_id==0){
           $app_client_id = createAppClientIdAudio($app_header_id,$arrAppHeader["os"],$os_version,$imei);
          
       }
       
       
       $arrKq["app_client_id"] = $app_client_id;
       //insertAppTracking($app_header_id,$app_client_id);
       return    $arrKq;
   }
   
   function checkAppHeaderAudio1($app_header)
    {
        $app_header= cleanQuery($app_header);
        $sql = "SELECT id,app_header,type_payment,os,isFree,VERSION,link_update,sms,admob_id FROM c_app_header  WHERE app_header = '$app_header'" ;
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arrAppHeader = array();   
      
        if($row = $connect->fetch()) {
             $arrAppHeader =  $row;
           
        }
       
        $connect = NULL;
        return $arrAppHeader;
    }
    
    function checkAppHeaderAudio($app_header)
    {
        $app_header= cleanQuery($app_header);
        $sql = "SELECT id,app_header,type_payment,os,isFree,VERSION,link_update,sms,admob_id,admob_id_tg,sms_mcv FROM c_app_header  WHERE app_header = '$app_header'" ;
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arrAppHeader = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arrAppHeader =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arrAppHeader;
    }  
    
    function checkAppClientIdAudioExist($app_client_id)
    {
        $app_client_id= cleanQuery($app_client_id);
        $sql = "SELECT * FROM c_app_client  WHERE id= '$app_client_id'";
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
       
        $i=0; $kq=0; 
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             $i++;
        }
       
        $connect = NULL;
        return $kq;
    }  
    
    function checkImeiAudioExist($imei)
    {
        $imei= cleanQuery($imei);
        $sql = "SELECT * FROM c_app_client  WHERE imei= '$imei'";
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
       
        $i=0; $kq=0; 
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             $i++;
        }
       
        $connect = NULL;
        return $kq;
    } 
    
    
    function createAppClientIdAudio($app_header_id,$os,$os_version,$imei){
      
       if(empty($imei))
            $sql = "INSERT INTO c_app_client (os,os_version,app_header_id) VALUES ($os,'$os_version',$app_header_id);";
       else
            $sql = "INSERT INTO c_app_client (os,os_version,app_header_id,imei) VALUES ($os,'$os_version',$app_header_id,'$imei');";
       
        $connect = connectAudioDB(); 
        $q = $connect->prepare($sql);
        $arrV = array();
      
        $count = $q->execute($arrV);
        $insertId = $connect->lastInsertId();
        $connect = null;
      
        return $insertId;
   }
   
   
    function updateAvatarUserAudio($id,$avatar){
      
        $sql = "Update c_story_audio_user SET avatar_url = ? Where id = ?";
       
        $connect = connectAudioDB(); 
        $q = $connect->prepare($sql);
        $arrV = array($avatar,$id);
      
        $count = $q->execute($arrV);
        $connect = null;
      
        return $count;
   }
   
   
    function updateCountListen($id){
      
        $sql = "Update c_story_audio SET c_listen = c_listen +1  Where id = ?";
       
        $connect = connectAudioDB(); 
        $q = $connect->prepare($sql);
        $arrV = array($id);
      
        $count = $q->execute($arrV);
        $connect = null;
      
        return $count;
   }
   
   function updateCountDownload($id){
      
        $sql = "Update c_story_audio SET c_download = c_download +1  Where id = ?";
       
        $connect = connectAudioDB(); 
        $q = $connect->prepare($sql);
        $arrV = array($id);
      
        $count = $q->execute($arrV);
        $connect = null;
      
        return $count;
   }
   
   
   
    function getUserAudioById($id)
    {
        $id= intval($id);
        $sql = "SELECT * FROM c_story_audio_user  WHERE id = '$id'" ;
        $connect = connectAudioDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arrUser = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arrUser =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arrUser;
    }  
    
     function insertAppTrackingAudio($app_header,$app_client_id,$LOGS,$ip)
    {   
        $connect = connectAudioDB();
        $sql = "INSERT INTO c_story_audio_app_tracking (app_header,app_client_id,LOGS,ip,create_date) VALUES (?,?,?,?,NOW())";
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($app_header,$app_client_id,$LOGS,$ip);
        $count = $q->execute($arrV);
       
        $connect = NULL;
        return $count;   
    }
    
    
    function uploadAvatarAudio($user_id){
         $uploaddir = '/upload/audioavatar/';
         $userInfo = getUserAudioById ($user_id);
         $avatar_url =$userInfo["avatar_url"];
         
         
         $arrKQ = array();
        try {
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['upfile']['error']) ||
                is_array($_FILES['upfile']['error']||empty($user_id))
            ) {
                //throw new RuntimeException('Invalid parameters.');
               // throw new RuntimeException('1.');
                $arrKQ["result"]=1;
                $arrKQ["avatar"]=$avatar_url;
                echo json_encode($arrKQ);return;
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    //throw new RuntimeException('No file sent.');
                    $arrKQ["result"]=2;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
                    throw new RuntimeException($exception);
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    //throw new RuntimeException('Exceeded filesize limit.');
                    $arrKQ["result"]=3;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
                    throw new RuntimeException($exception);
                default:
                    //throw new RuntimeException('Unknown errors.');
                    $arrKQ["result"]=100;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
                    throw new RuntimeException($exception);
            }

            // You should also check filesize here. 
            if ($_FILES['upfile']['size'] > 10000000) {
                $arrKQ["result"]=3;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
                throw new RuntimeException($exception);
            }

            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($_FILES['upfile']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
                //throw new RuntimeException('Invalid file format.');
                $arrKQ["result"]=5;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
                throw new RuntimeException($exception);
            }

            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
             $pathdate = date("Y/md/");
             $file = basename($_FILES['upfile']['name']);
             $file = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $file);
             $file = basename($file, ".".$ext)."-".$user_id.".".$ext;
             $file = sanitize($file,true);
             $pathUrl= $uploaddir.$pathdate;
             $uploaddir = $_SERVER['DOCUMENT_ROOT'].$uploaddir.$pathdate;
             makeFolder($uploaddir);
             $uploadfile =$uploaddir . $file;
           
             if (!move_uploaded_file($_FILES['upfile']['tmp_name'],$uploadfile)) {
                //throw new RuntimeException('Failed to move uploaded file.');
                $arrKQ["result"]=4;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
                throw new RuntimeException($exception);
            }else{
                $avatar_url="http://".$_SERVER['SERVER_NAME'].$pathUrl . $file;
                updateAvatarUserAudio($user_id,$avatar_url);
            }
            
          
            
            $arrKQ["result"]=0;
            $arrKQ["avatar"]=$avatar_url;
            echo json_encode($arrKQ);

        } catch (RuntimeException $e) {

            $arrKQ["result"]=100;
            $arrKQ["avatar"]=$avatar_url;
            $exception = json_encode($arrKQ);
            throw new RuntimeException($exception);

        }
    }
    
    
    function getCommentByAudio($audio_id,$page,$limit)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT c.id,c.user_id,c.story_audio_id,c.comment,c.status,c.create_date,u.fullname,u.avatar_url FROM c_story_audio_comment c INNER JOIN c_story_audio_user u ON c.user_id = u.id  WHERE c.story_audio_id = ".$audio_id ." ORDER BY c.id  DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY.getCommentByAudio.".$audio_id.".".$page;
        $result = $meminstance->get($querykey);
       
        //if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
            
            $sl = countCommentByAudio($audio_id);
         
            $arrOut = array();
            $arrOut["comment"] = $arr;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             
             return $arrOut;
        }else{
           $sl = countCommentByAudio($audio_id);
         
            $arrOut = array();
            $arrOut["comment"] = $result;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrOut;
        }
           
    }
    
    
    function countCommentByAudio($audio_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $audio_id = intval($audio_id);
        
        $sql = "SELECT COUNT(*) as sl FROM c_story_audio_comment WHERE story_audio_id = ".$audio_id;
        $querykey = "KEY.countCommentByAudio." . $audio_id;
       
        $sl = $meminstance->get($querykey);
        //echo $sql;
        //if(1>0){
        if (!$sl) {
            # creating the statement
            $connect = connectAudioDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    } 
    
    
    function postCommentAudio($user_id,$audio_id,$comment,$create_user,$update_user)
    {   
        $connect = connectAudioDB();
        $sql = "INSERT INTO c_story_audio_comment (user_id,story_audio_id,COMMENT,create_date,create_user,update_date,update_user)
    VALUES(?,?,?,NOW(),?,NOW(),?);";
        $comment = cleanQuery($comment);
        $create_user = cleanQuery($create_user);
        $update_user = cleanQuery($update_user);
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($user_id,$audio_id,$comment,$create_user,$update_user);
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function searchAudio($keyword,$page,$limit) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.AudioSearch","/home/search/audio/");
        $topDocs = $searcher->query($keyword,$page, $limit); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
        
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["title"] =trim(java_values($docs[$i]->title));
         // $arrGame[$i]["description"] = java_values($docs[$i]->description);
         
          $arrGame[$i]["image"] = java_values($docs[$i]->image);
          $arrGame[$i]["cat_id"] = java_values($docs[$i]->cat_id);
          $arrGame[$i]["c_chapter"] = java_values($docs[$i]->c_chapter);
          $arrGame[$i]["c_download"] = java_values($docs[$i]->c_download);
          $arrGame[$i]["c_listen"] = java_values($docs[$i]->c_listen);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          
          $arrGame[$i]["author"] = java_values($docs[$i]->author);
          $arrGame[$i]["reader"] = java_values($docs[$i]->reader);
          
          $time =  date("Y/md",$arrGame[$i]["create_date"]);    
          if(!empty($arrGame[$i]['image']))
          $arrGame[$i]['image'] = baseUrl()."upload/audio/".$time."/".$arrGame[$i]["image"];
              
        }
        
        $total = java_values($searcher->getTotalHit());
       
        $arrGameKQ["audio"]=$arrGame;
        $page = intval($total/$limit)+($total%$limit>0?1:0);
        $arrGameKQ["page"] = $page;
        return $arrGameKQ;
  }
    
  function deleteCacheAudioByKey($key){
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($key);
     }
     
    
    function checkKeyNotifyAudioByAppClient($app_client_id)
    {
        $sql = "SELECT id FROM c_story_audio_notice_user WHERE app_client_id = ?" ;
        
        # creating the statement
        $connect = connectAudioDB();
        $q = $connect->prepare($sql);
        $q->execute(array($app_client_id));
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $kq = 0;    
        if($row = $q->fetch()) {
             $kq =  1;
               
        } 
       
        $connect = null;
        return $kq;  
       
    } 
    
     function insertNoticeUserAudio($app_client_id,$user_id,$device_token,$os_type)
    {
        $count = 0;
        try{
            $connect = connectAudioDB();
            $sql = "INSERT INTO c_story_audio_notice_user (app_client_id,user_id,device_token,os_type,create_date) 
                     VALUES (:app_client_id,:user_id,:device_token,:os_type,NOW())";
             
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':app_client_id'=>$app_client_id,':user_id'=>$user_id,':device_token'=>$device_token,':os_type'=>$os_type));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
            
        }
        
        return $count;   
    } 
    
    
    function updateNoticeUserAudio($app_client_id,$device_token)
    {
        $count = 0;
        try{
             $connect = connectAudioDB();
            $sql = "Update  c_story_audio_notice_user Set device_token = ? where  app_client_id = ?  ";
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array($device_token,$app_client_id));
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    function getNotices()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $sql = "SELECT  audio_id,content,icon FROM  vtc_kenhkiemtien.c_story_audio_notice ORDER BY id DESC LIMIT 0, 50;";
        
        $querykey = "KEY.getNotices";
        $result = $meminstance->get($querykey);
       
        //if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectAudioDB(); 
            $connect = $connect->query($sql); 
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $i++;
            }
           
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_30);
           
            return $arr;
        }else{
           return $result;
        }
           
    }
      
   
   
?>

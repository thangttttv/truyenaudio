<?php
   define("TIME_15", 900);
   define("TIME_30", 1800);
   define("ROOT_UPLOAD","/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/upload");
   
   function connectGameStoreDB(){
        include('GameStoreConfig.php');
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
   
   function getCategory()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT id,name, image,count_game, create_date FROM vtc_game_store.g_category Where STATUS = 1 Order By order_view "; 
        $querykey = "KEY" . md5($sql);
        
        $result = $meminstance->get($querykey);
       // if(1>0){
        if (!$result) {
            # creating the statement
            $connect = connectGameStoreDB();
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/category/".$time."/".$row['image'];
                    $i++;
            }
            $connect = NULL;
            $meminstance->set($querykey, $arr, 0, TIME_15);
            return $arr;
            
        }else{
            return $result;
        }
           
    } 
    
    function getPublisher()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
       
        $sql = "SELECT id,name, image,count_game,create_date FROM vtc_game_store.g_publisher Where STATUS = 1 Order By order_view "; 
        $querykey = "KEY" . md5($sql);
        $result = $meminstance->get($querykey);
      
       //if(1>0){
       if(!$result){
            $connect = connectGameStoreDB(); 
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();
            $i=0;
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));   
               
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/publisher/".$time."/".$row['image'];
                 $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            $connect = NULL;
            return $arr;   
        }else{
            return $result;
        }
        
    } 
        function getUserDownloadView($games,$os_type)
    {
        $arr = array();   
        if(empty($games))return $arr;
        $str_ids ="";
        foreach($games as $game){
            $str_ids .=$game["id"].",";
             
        }
        $str_ids = substr($str_ids,0,strlen($str_ids)-1);
       
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql ="SELECT d.game_id,d.user_id,d.username,d.fullname,d.avatar,g.count_ios_download FROM g_user_download_view d inner join g_game g On d.game_id = g.id WHERE  game_id IN (".$str_ids.")";
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
         
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $i=0; 
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            return $arr;
            
          }else{
            
             return $resultCache;
          }
        
    }
    
        function getGameAPKHomeHot($limit, $page,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT  id,name,description,icon,banner,version_android,version_os_android, 
    size_android,count_android_download,count_ios_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_android = 1 AND is_hot = 1 AND status = 1 ".$play." ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
        
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0; 
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));   
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_android_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];
                 $arr[$i]['count_android_view'] = $arr[$i]['count_ios_view']+$arr[$i]['count_android_view'];
                 $i++;
            }
         
            $meminstance->set($querykey, $arr, 0, TIME_15);
            $arrResult = array();
            $arrResult["game"] = $arr;
            
            $sl = countGameAPKHot($is_play);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;     
        }else{
            $arrResult = array();
            $arrResult["game"] = $resultCache;
            
            $sl = countGameAPKHot();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;     
        }   
    }
    
     function getUserDownload($game_id,$limit,$page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT u.id,u.username,u.fullname,u.avatar FROM g_user u INNER JOIN g_user_download d ON u.id = d.user_id 
        WHERE d.game_id = ?  ORDER BY d.id DESC  LIMIT " . $startRecord . ", " . $limit; 
       
        $querykey = "KEY" . md5($sql.$game_id);
        $resultCache = $meminstance->get($querykey);
       
       //if(1>0){
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
                
            $arrResult = array();
            $arrResult["user"] = $arr;
            
            $sl = countUserDownloadGame($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;        
        } else {
            $arrResult = array();
            $arrResult["user"] = $resultCache;
            
            $sl = countUserDownloadGame($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        } 
    }
    
    
    
    function getGameAPKByCategoryHot($category_id,$limit, $page,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT  id,name,description,icon,banner,version_android,version_os_android, 
    size_android,count_android_download,count_ios_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_android = 1 AND is_hot = 1 AND status = 1 AND category_id = ? ".$play." ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit; 
        
        $querykey = "KEY" . md5($sql.$category_id);
        $resultCache = $meminstance->get($querykey);
       
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_android_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];
                 $arr[$i]['count_android_view'] = $arr[$i]['count_ios_view']+$arr[$i]['count_android_view'];
                    $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
                
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $arr;
            
            $sl = countGameAPKHotByCategoryID($category_id,$is_play);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;        
        } else {
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameAPKHotByCategoryID($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        } 
    }
    
    function getGameAPKByCategoryNew($category_id,$limit, $page,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $connect = connectGameStoreDB();
        $sql = "SELECT  id,name,description,icon,banner,version_android,version_os_android, 
    size_android,count_android_download,count_ios_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_android = 1  AND status = 1 AND category_id = ? ".$play." ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY" . md5($sql.$category_id);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache)  {
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0; 
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                $arr[$i]['count_android_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];
                $arr[$i]['count_android_view'] = $arr[$i]['count_ios_view']+$arr[$i]['count_android_view'];
                    $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $arr;
            
            $sl = countGameAPKByCategoryID($category_id,$is_play);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
             $connect = null;
             return $arrResult;      
        }else{
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameAPKByCategoryID($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
            return $arrResult;      
        }
    }
    
    
    function getGameAPKByPublisherNew($publisher_id,$limit, $page,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT  id,name,description,icon,banner,version_android,version_os_android, 
    size_android,count_android_download,count_ios_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_android = 1  AND status = 1 AND publisher_id = ? ".$play."  ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY" . md5($sql.$publisher_id);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($publisher_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;   
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_android_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];
                 $arr[$i]['count_android_view'] = $arr[$i]['count_ios_view']+$arr[$i]['count_android_view'];
                 
                    
                 $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $arr;
            
            $sl = countGameAPKByPublisherID($publisher_id,$is_play);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
             $connect = null;
             return $arrResult;      
        }else{
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameAPKByPublisherID($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;      
        }
    }
    
    
     function getGameAPKByPublisherHot($publisher_id,$limit, $page,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT  id,name,description,icon,banner,version_android,version_os_android, 
    size_android,count_android_download,count_ios_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_android = 1 AND is_hot = 1  AND status = 1 AND publisher_id = ? ".$play." ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
      
        $querykey = "KEY" . md5($sql.$publisher_id);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB(); 
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($publisher_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                    
                 $arr[$i]['count_android_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];
                 $arr[$i]['count_android_view'] = $arr[$i]['count_ios_view']+$arr[$i]['count_android_view'];
                 $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $arr;
            
            $sl = countGameAPKHotByPublisherID($publisher_id,$is_play);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
             $connect = null;
             return $arrResult;   
             
        }else{
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameAPKHotByPublisherID($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }
    }
    
     function getGameAPKHomeNew($limit, $page,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT  id,name,description,icon,banner,version_android,version_os_android, 
    size_android,count_android_download,count_ios_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_android = 1 AND status = 1 ".$play." ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
         
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array(); 
            $i=0;  
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_android_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];
                 $arr[$i]['count_android_view'] = $arr[$i]['count_ios_view']+$arr[$i]['count_android_view'];
              
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            $arrResult = array();
                        
            $arrResult["game"] = $arr;
            
            $sl = countGameAPK($is_play);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;   
       }else{
            $arrResult = array();
            $arrResult["game"] = $resultCache;
            
            $sl = countGameAPK();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
       }
       
    }
    
     function getGameIOSHomeHot($limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND is_hot = 1 AND status = 1 ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
    
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey); 
        
        if(!$resultCache){
             $connect = connectGameStoreDB(); 
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;    
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));  
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_ios_download'] =strval($arr[$i]['count_android_download']+$arr[$i]['count_ios_download']);
                 $arr[$i]['count_ios_view'] = strval($arr[$i]['count_ios_view']+$arr[$i]['count_android_view']);
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["game"] = $arr;
            
            $sl = countGameIOSHot();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;
        }else{
            $arrResult = array();
            $arrResult["game"] = $resultCache;
            
            $sl = countGameIOSHot();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;
        }
       
    }
    
     function getGameIOSHomeNew($limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1  AND status = 1 ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
    
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey); 
        
       // if(1>0){
        if(!$resultCache) {
             $connect = connectGameStoreDB();
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  $i=0;      
            while($row = $connect->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));    
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_ios_download'] =strval( $arr[$i]['count_android_download']+$arr[$i]['count_ios_download']);  
                 $arr[$i]['count_ios_view'] =strval( $arr[$i]['count_ios_view']+$arr[$i]['count_android_view']);
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["game"] = $arr;
            
            $sl = countGameIOS();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;   
        }else{
            $arrResult = array();
            $arrResult["game"] = $resultCache;
            
            $sl = countGameIOS();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult; 
        }
       
    } 
    
     function getGameIOSByPublisherHot($publisher_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND is_hot = 1 AND status = 1 AND publisher_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;; 
        
        $querykey = "KEY" . md5($sql.$publisher_id);
        $resultCache = $meminstance->get($querykey);
        
       //if(1>0){
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($publisher_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array(); $i=0;       
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));    
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 $arr[$i]['count_ios_download'] = strval($arr[$i]['count_android_download']+$arr[$i]['count_ios_download']); 
                 $arr[$i]['count_ios_view'] = strval($arr[$i]['count_ios_view']+$arr[$i]['count_android_view']); 
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $arr;
            
            $sl = countGameIOSHotByPublisherID($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
             $connect = null;
             return $arrResult;   
        }else{
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameIOSHotByPublisherID($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }
    } 
    
    function getGameIOSByPublisherNew($publisher_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
       
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND  status = 1 AND publisher_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
    
        $querykey = "KEY" . md5($sql.$publisher_id);
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($publisher_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array(); $i=0;   
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));    
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                
                $arr[$i]['count_ios_download'] =strval($arr[$i]['count_android_download']+$arr[$i]['count_ios_download']); 
                $arr[$i]['count_ios_view'] = strval($arr[$i]['count_ios_view']+$arr[$i]['count_android_view']);  
                    
                  $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $arr;
            
            $sl = countGameIOSByPublisherID($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
             $connect = null;
             return $arrResult;   
        }else{
            $arrResult = array();
                        
            $publisherDetail = getPublisherDetail($publisher_id);
            $arrResult["publisher"] = $publisherDetail;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameIOSByPublisherID($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }
    }
    
    function getGameIOSByCategoryNew($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND  status = 1 AND category_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
     
        $querykey = "KEY" . md5($sql.$category_id);
        $resultCache = $meminstance->get($querykey);
       
       //if(1>0){
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  $i=0;      
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));    
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                    
                 $arr[$i]['count_ios_download'] = strval($arr[$i]['count_android_download']+$arr[$i]['count_ios_download']);  
                 $arr[$i]['count_ios_view'] = strval($arr[$i]['count_ios_view']+$arr[$i]['count_android_view']);
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $arr;
            
            $sl = countGameIOSByCategoryID($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult; 
      }else{
            $arrResult = array();

            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $resultCache;
          
            $sl = countGameIOSByCategoryID($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;
      }  
    } 
    
    
    function countGameIOSByPublisherID($publisher_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where  is_ios = 1 & publisher_id =  ".intval($publisher_id) ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countGameIOSHotByPublisherID($publisher_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where is_hot = 1 & is_ios = 1  & publisher_id =  ".intval($publisher_id) ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function countGameIOS()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where  is_ios = 1  " ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function countGameIOSHot()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where  is_ios = 1 AND is_hot = 1  " ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countGameAPKHotByPublisherID($publisher_id,$is_play=0)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where status = 1 & is_hot = 1 & is_android = 1  & publisher_id =  ".intval($publisher_id)." ".$play ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
   
    
    function countGameAPKByPublisherID($publisher_id,$is_play=0)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $play = $is_play==1?" AND is_play=1 ":"";
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where status = 1 & is_android = 1  & publisher_id =  ".intval($publisher_id)." ".$play ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
     function countGameAPKByCategoryID($category_id,$is_play=0)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $play = $is_play==1?" & is_play=1 ":"";
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where status = 1 & is_android = 1  & category_id =  ".intval($category_id)." ".$play ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countUserDownloadGame($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_user_download Where  game_id =  ".intval($game_id) ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
     function countGameAPKHotByCategoryID($category_id,$is_play=0)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $play = $is_play==1?" & is_play=1 ":"";
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where status = 1 & is_android = 1 & is_hot=1 & category_id =  ".intval($category_id)." ".$play ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function countGameAPKHot($is_play=0)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $play = $is_play==1?" & is_play=1 ":"";
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where status = 1 & is_android = 1 & is_hot=1 ".$play ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countGameAPK($is_play=0)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $play = $is_play==1?" & is_play=1 ":"";
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where status = 1 & is_android = 1 & is_hot=1 ".$play ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    }                                                                                                                                                                                                                                                                               function countGameIOSByCategoryID($category_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where  is_ios = 1 & category_id =  ".intval($category_id) ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countGameIOSHotByCategoryID($category_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game Where is_hot = 1 & is_ios = 1 & category_id =  ".intval($category_id) ;
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function getGameIOSByCategoryHot($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND is_hot = 1 AND status = 1 AND category_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit; 
       
       $querykey = "KEY" . md5($sql.$category_id);
       $resultCache = $meminstance->get($querykey);
      
       if(!$resultCache){
           $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array(); $i=0;   
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));
                 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $arr[$i]['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                
                 $arr[$i]['count_ios_download'] = strval($arr[$i]['count_android_download']+$arr[$i]['count_ios_download']);  
                 $arr[$i]['count_ios_view'] = strval($arr[$i]['count_ios_view']+$arr[$i]['count_android_view']);
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $arr;
            
            $sl = countGameIOSHotByCategoryID($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;   
        }else{
            $arrResult = array();
                        
            $category = getCategoryDetail($category_id);
            $arrResult["category"] = $category;
            $arrResult["game"] = $resultCache;
            
            $sl = countGameIOSHotByCategoryID($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }
    } 

  
    function getGameAPKDetail($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  id,packet_id,publisher_id,name,room_name,room_password,description,content,icon,banner,images,version_android,version_os_android,size_android,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_name,game_relate FROM vtc_game_store.g_game WHERE status = 1 AND id = ? " ;
        $querykey = "KEY.getGameAPKDetail." . $game_id;
        $result = $meminstance->get($querykey);
        
        if (!$result) {
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            $game_relate  ="";
            if($row = $q->fetch()) {
                 $arr =  $row;
                 
                 $game_relate =  $row["game_relate"];
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['icon']!="")
                    $arr['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                        
                 if($row['images']!="") {
                      $arrImage =  json_decode($arr['images']);
                      $i=0;
                      while($i<count($arrImage)){
                              $arrImage[$i]=   "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrImage[$i];
                              $i++;
                      } 
                      $arr['images'] =   $arrImage;  
                 }  
                 
                  $arr['count_android_view'] = $arr['count_ios_view']+$arr['count_android_view'];
                   
            } 
            
            $arrGameRelate = array();    
             if(!empty($game_relate))
             {
                  $game_relate = str_replace("[","",$game_relate);
                  $game_relate = str_replace("]","",$game_relate);
                  $arrGameRelate  = getGameRelate($game_relate,2);
             }
               
             
             $meminstance->set($querykey, $arr, 0, TIME_30);
             $connect = null;
             addCountAndroidViewGame($game_id);
             $giftcode = getGiftCodeIdByGameId($game_id);
             if(!empty($giftcode))$arr["giftcode_id"]=$giftcode["id"];else $arr["giftcode_id"]= 0;
             
             $arrOut = array();
             $arrOut["GameDetail"] = $arr;
             $arrOut["GameRelate"] = $arrGameRelate;
             
             return $arrOut;
             
        }else{
            $game_relate =  $result["game_relate"];
            $arrGameRelate = array();    
             if(!empty($game_relate))
             {
                  $game_relate = str_replace("[","",$game_relate);
                  $game_relate = str_replace("]","",$game_relate);
                  $arrGameRelate  = getGameRelate($game_relate,2);
             }
             
             $giftcode = getGiftCodeIdByGameId($game_id);
             if(!empty($giftcode))$result["giftcode_id"]=$result["id"];else $result["giftcode_id"]= 0;
             
            addCountAndroidViewGame($game_id);
            
            $arrOut = array();
             $arrOut["GameDetail"] = $result;
             $arrOut["GameRelate"] = $arrGameRelate;
             
            return $arrOut;
        }
    } 
    
    
    function getGameRelate($game_ids,$os_type)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        if($os_type==2){
            $sql = "SELECT id,name, icon,category_id,publisher_id,publisher_name,create_date FROM  g_game WHERE
             is_android = 1 And id IN (".$game_ids.")"; 
        }else{
            $sql = "SELECT id,name, icon,category_id,publisher_id,publisher_name,create_date FROM  g_game WHERE 
             is_ios = 1 And id IN (".$game_ids.")"; 
        }
        
       $querykey = "KEY" . md5($sql.$game_ids);
       $resultCache = $meminstance->get($querykey);
      
       //if(1>0){
       if(!$resultCache){
           $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array());
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
            
            # showing the results
            $arr = array(); $i=0;   
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date']));
                // echo 1;
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 $i++;
            }
           
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $connect = null;
            return $arr;   
        }else{
            return $resultCache;   
        }
    } 

    
    function getRoomInfo($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT room_name,room_password FROM vtc_game_store.g_game WHERE  id = ? " ;
        $querykey = "KEY" . md5($sql.$game_id);
        $result = $meminstance->get($querykey);
        
        //if (1>0) {
        if (!$result) {
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                   
            } 
            
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
           
             return $arr;
             
        }else{
            return $result;
        }
    } 
    
    
     function getContactGame($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT email,website,fanpage,phone FROM g_game WHERE id = ? " ;
        $querykey = "KEY" . md5($sql.$game_id);
        $result = $meminstance->get($querykey);
        
        if (!$result) {
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
            } 
            
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;
             
        }else{
            return $result;
        }
    } 
    
    
    function getGameIOSDetail($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  id,bundle_id,itune_id,url_scheme,publisher_id,name,room_name,room_password,description,content,images,icon,banner,version_ios,version_os_ios,size_ios,count_ios_download,count_ios_view,count_android_view,count_review,mark,tags,create_date,category_id,publisher_name,game_relate FROM vtc_game_store.g_game WHERE is_ios = 1 AND status = 1 AND id = ? " ;
        $querykey = "KEY.getGameIOSDetail." . $game_id;
        $result = $meminstance->get($querykey);
        
       
       if (!$result) {
            # creating the statement
            $connect = connectGameStoreDB();
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $game_relate = ""; 
            if($row = $q->fetch()) {
                 $arr =  $row;
                 $game_relate = $row["game_relate"];
                
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['icon']!="")
                    $arr['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $arr['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 if($row['images']!="") {
                      $arrImage =  json_decode($arr['images']);
                      $i=0;
                      while($i<count($arrImage)){
                              $arrImage[$i]=   "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrImage[$i];
                              $i++;
                      } 
                      $arr['images'] =   $arrImage;  
                 }  
                 
                 $arr['count_ios_view'] = $arr['count_ios_view']+$arr['count_android_view'];
                   
            } 
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             addCountIOSViewGame($game_id);
             
             $arrGameRelate = array();    
             if(!empty($game_relate))
             {
                  $game_relate = str_replace("[","",$game_relate);
                  $game_relate = str_replace("]","",$game_relate);
                  
                  $arrGameRelate  = getGameRelate($game_relate,3);
             }
             
             $giftcode = getGiftCodeIdByGameId($game_id);
             if(!empty($giftcode))$arr["giftcode_id"]=$giftcode["id"];else $arr["giftcode_id"]= 0;
             
             $arrOut = array();
             $arrOut["GameDetail"] = $arr;
             $arrOut["GameRelate"] = $arrGameRelate;
             
             return $arrOut;
        }else{
            addCountIOSViewGame($game_id);
            $game_relate =  $result["game_relate"];
            
             $arrGameRelate = array();    
             if(!empty($game_relate))
             {
                  $game_relate = str_replace("[","",$game_relate);
                  $game_relate = str_replace("]","",$game_relate);
                  $arrGameRelate  = getGameRelate($game_relate,3);
             }
             
             $giftcode = getGiftCodeIdByGameId($game_id);
             if(!empty($giftcode))$result["giftcode_id"]=$giftcode["id"]; else $result["giftcode_id"]= 0;
             
             $arrOut = array();
             $arrOut["GameDetail"] = $result;
             $arrOut["GameRelate"] = $arrGameRelate;
             
            return $arrOut;
        }   
    }  
    
     function getPublisherDetail($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  id,name,image,count_game,create_date FROM  vtc_game_store.g_publisher Where id =  ".intval($id) ;
        $querykey = "KEY" . md5($sql);
        
        $result = $meminstance->get($querykey);
        
        if (!$result) {
            # creating the statement
            $connect = connectGameStoreDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                 
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['image']!="")
                    $arr['image'] = "http://kenhkiemtien.com/upload/gamestore/publisher/".$time."/".$row['image'];
                   
            } 
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;  
        }else{
            return $result;
        } 
    }    
    
    function getCategoryDetail($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  id,name,image,create_date FROM vtc_game_store.g_category WHERE id = ".intval($id) ;
        $querykey = "KEY" . md5($sql);
        $result = $meminstance->get($querykey);
        
        if (!$result) {
            # creating the statement
            $connect = connectGameStoreDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                 
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['image']!="")
                    $arr['image'] = "http://kenhkiemtien.com/upload/gamestore/category/".$time."/".$row['image'];
                   
            } 
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;  
        }else{
            return $result;
        } 
    }
    
    
    function countNew()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_news Where status = 1 ";
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countNewByCategory($category_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_news Where status = 1 AND category_id  = ".intval($category_id);
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countNewByPublisher($publisher_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_news Where status = 1 AND publisher_id  = ".intval($publisher_id);
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function countNewByGame($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_news Where status = 1 AND game_id  = ".intval($game_id);
        $querykey = "KEY" . md5($sql);
        
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
     function getNewsHome($limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,title,description,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  vtc_game_store.g_news Where status = 1 Order By id DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY.getNewsHome.".$page;
        $resultCache = $meminstance->get($querykey);
        
       // if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();
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
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                 $arr[$i]['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
                 $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["news"] = $arr;
            $sl = countNew();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }else{
            $arrResult = array();
            $arrResult["news"] = $resultCache;
            $sl = countNew();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }
        
    }          
    
    function getNewsCategory($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT id,title,description,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  
        vtc_game_store.g_news Where status = 1 And category_id = ? ORDER BY id DESC  LIMIT " . $startRecord . ", " . $limit;
      
        $querykey = "KEY" . md5($sql.$category_id);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB(); 
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   $i = 0;   
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                 $arr[$i]['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["news"] = $arr;
            $sl = countNewByCategory($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }else{
            $arrResult = array();
            $arrResult["news"] = $resultCache;
            $sl = countNewByCategory($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }
        
    }  
    
    function getNewsByCategory($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,title,description,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  
        vtc_game_store.g_news Where status = 1 And category_id = ? ORDER BY id DESC  LIMIT " . $startRecord . ", " . $limit;
        
        $querykey = "KEY.getNewsByCategory.".$category_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                 $arr[$i]['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
                    $i++;
            }
           
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["news"] = $arr;
            $sl = countNewByCategory($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;   
        }else{
           $arrResult = array();
           $arrResult["news"] = $resultCache;
           $sl = countNewByCategory($category_id);
           $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
           return $arrResult;    
        } 
    }                                                                                                                                    
                                                                                                                                     
     function getNewsByPublisher($publisher_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT   id,title,description,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  
        vtc_game_store.g_news Where status = 1 And publisher_id = ?  ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
         
        $querykey = "KEY.getNewsByPublisher.".$publisher_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($publisher_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                 
                 $arr[$i]['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
                 
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["news"] = $arr;
            $sl = countNewByPublisher($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;    
        }else{
            $arrResult = array();
            $arrResult["news"] = $resultCache;
            $sl = countNewByPublisher($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;    
        }
        
    }  
    
    function getNewsByGame($game_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT     id,title,description,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  
        vtc_game_store.g_news Where status = 1 And game_id = ? ORDER BY id DESC   LIMIT " . $startRecord . ", " . $limit;
       
        $querykey = "KEY.getNewsByGame.".$game_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
             $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();
            $i= 0;    
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                    
                 $arr[$i]['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
                 $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["news"] = $arr;
            $sl = countNewByGame($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;       
        }else{
            $arrResult = array();
            $arrResult["news"] = $resultCache;
            $sl = countNewByGame($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;       
        }
       
    } 
    
    
    function getNewsDetail($news_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT  id,title,description,content,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  vtc_game_store.g_news Where status = 1 And id = ?   " ;
        
        $querykey = "KEY.getNewsDetail." . $news_id;
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($news_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                    $arr['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
     function getNewsDetailContent($news_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT  id,title,description,content,image,game_id,category_id,publisher_id,count_view,count_like,count_comment,create_date FROM  vtc_game_store.g_news Where status = 1 And id = ?   " ;
        
        $querykey = "KEY" . md5($sql.$news_id."content");
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($news_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['image']!="")
                    $arr['image'] = "http://kenhkiemtien.com/upload/gamestore/news/".$time."/".$row['image'];
                    $arr['create_date'] = date("d-m-Y",strtotime($row['create_date'])); 
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
        
    
    function countCommentNews($news_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_news_comment Where news_id =  ".intval($news_id);
        
        $querykey = "KEY.countCommentNews." . $news_id;
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function getCommentByNewsId($news_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  c.id,c.user_id,c.news_id,c.comment,DATE_FORMAT(c.create_date,'%h-%i %d-%m-%Y') as create_date,u.username,u.fullname,u.avatar,u.create_date as u_create_date FROM vtc_game_store.g_news_comment c INNER JOIN g_user u ON c.user_id = u.id Where c.news_id = ? ORDER BY c.id DESC LIMIT " . $startRecord . ", " . $limit;
        
        //$querykey = "KEY" . md5($sql.$news_id);
        $querykey = "KEY.comment.news." . $news_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($news_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
            $i = 0; 
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['u_create_date']));
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["comment"] = $arr;
            $sl = countCommentNews($news_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            $arrResult["count"] = $sl;
            
            $connect = null;
            return $arrResult;   
        }else{
            $arrResult = array();
            $arrResult["comment"] = $resultCache;
            $sl = countCommentNews($news_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            $arrResult["count"] = $sl;
            
            return $arrResult;   
        }
       
    } 
    
    
    function countGiftCode()
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_giftcode ";
        
        $querykey = "KEY" . md5($sql);
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function countGiftCodeByCategory($category_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_giftcode Where category_id = ".intval($category_id);
            
        $querykey = "KEY" . md5($sql);
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function countGiftCodeByPublisher($publisher_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_giftcode Where publisher_id = ".intval($publisher_id);
        
        $querykey = "KEY" . md5($sql);
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    function getGiftCodeHome($limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        //c.available_giftcode >0 AND
        $sql = "  SELECT g.name,g.icon,g.count_review,g.mark,g.publisher_name,c.id,c.title,c.available_giftcode,c.total_giftcode,g.create_date FROM g_giftcode c 
         INNER JOIN g_game g ON c.game_id = g.id WHERE  c.status = 1  ORDER BY c.id DESC LIMIT " . $startRecord . ", " . $limit;
         
        $querykey = "KEY.getGiftCodeHome" . $page;
        $resultCache = $meminstance->get($querykey);
       
        // if(1>0){ 
         if(!$resultCache){
             $connect = connectGameStoreDB(); 
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute();   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["giftCode"] = $arr;
            $sl = countGiftCode();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult;   
        }else{
            $arrResult = array();
            $arrResult["giftCode"] = $resultCache;
            $sl = countGiftCode();
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;
        }
       
    }
    
    function getGiftCodeByCategory($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
       
        $sql = "  SELECT g.name,g.icon,g.count_review,g.mark,g.publisher_name,c.id,c.title,c.available_giftcode,c.total_giftcode,g.create_date FROM g_giftcode c 
         INNER JOIN g_game g ON c.game_id = g.id WHERE  c.category_id = ? AND c.status = 1 ORDER BY c.id DESC LIMIT " . $startRecord . ", " . $limit;
        
        $querykey = "KEY.getGiftCodeByCategory.".$category_id.".". $page;
        $resultCache = $meminstance->get($querykey);
        
         //if(1>0){ 
         if(!$resultCache){
            $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($category_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 $i++;
            }
            
           
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["giftCode"] = $arr;
            $sl = countGiftCodeByCategory($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult; 
               
        }else{
            $arrResult = array();
            $arrResult["giftCode"] = $resultCache;
            $sl = countGiftCodeByCategory($category_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult; 
        }
       
    }
    
    function getGiftCodeByPublisher($publisher_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "  SELECT g.name,g.icon,g.count_review,g.mark,g.publisher_name,c.id,c.title,c.available_giftcode,c.total_giftcode,g.create_date FROM g_giftcode c 
         INNER JOIN g_game g ON c.game_id = g.id WHERE  c.publisher_id = ? AND c.status = 1 ORDER BY c.id DESC LIMIT " . $startRecord . ", " . $limit;
         
        $querykey = "KEY.getGiftCodeByPublisher.".$publisher_id.".". $page;
        $resultCache = $meminstance->get($querykey);
        
         //if(1>0){ 
         if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($publisher_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["giftCode"] = $arr;
            $sl = countGiftCodeByPublisher($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult; 
            
        }else{
            $arrResult = array();
            $arrResult["giftCode"] = $resultCache;
            $sl = countGiftCodeByPublisher($publisher_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;  
        }
         
    }
    
    
     function getGiftCodeByGameId($game_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "  SELECT g.name,g.icon,g.count_review,g.mark,g.publisher_name,c.id,c.title,c.available_giftcode,c.total_giftcode,g.create_date FROM g_giftcode c 
         INNER JOIN g_game g ON c.game_id = g.id WHERE c.available_giftcode >0 And c.game_id = ? ORDER BY c.id DESC LIMIT " . $startRecord . ", " . $limit;
         
        $querykey = "KEY.getGiftCodeByGameId." . $game_id;
        $resultCache = $meminstance->get($querykey);
        
        // if(1>0){ 
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["giftCode"] = $arr;
            $sl = countGiftCodeByPublisher($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult; 
            
        }else{
            $arrResult = array();
            $arrResult["giftCode"] = $resultCache;
            $sl = countGiftCodeByPublisher($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrResult;  
        }
         
    }
    
    
    function getGiftCodeDetailAPK($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT g.id,g.packet_id,g.publisher_id,g.name,g.description,g.content,g.images,g.icon,g.banner,g.version_android,g.version_os_android, 
    g.size_android,g.count_android_download,g.count_android_view,g.count_ios_view,g.count_review,g.mark,g.tags,g.create_date,g.category_id,g.publisher_name,c.id as giftcode_id,c.title,c.available_giftcode,c.total_giftcode,c.description as code_description FROM g_giftcode c 
         INNER JOIN g_game g ON c.game_id = g.id WHERE  c.id = ? ";
         
        $querykey = "KEY.getGiftCodeDetailAPK." .$id;
        $resultCache = $meminstance->get($querykey);
      
        if(1>0){ 
       //if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            if($row = $q->fetch()) {
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $row['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 if(!empty($row['banner']))
                    $row['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                   if($row['images']!="") {
                      $arrImage =  json_decode($row['images']);
                      $i=0;
                      while($i<count($arrImage)){
                              $arrImage[$i]=   "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrImage[$i];
                              $i++;
                      } 
                      $row['images'] =   $arrImage;  
                 }  
                 
                 $row['count_android_view'] = $row['count_ios_view']+$row['count_android_view'];
            }
            
            $meminstance->set($querykey, $row, 0, TIME_15);
             
            $connect = null;
            return $row; 
            
        }else{
            return $resultCache;  
        }
         
    }
    
    
    function getGiftCodeDetailIOS($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
      
         $sql = "  SELECT g.id,g.publisher_id,g.name,g.description,g.content,g.images,g.icon,g.banner,g.version_ios,g.version_os_ios,g.size_ios,g.count_ios_download,g.count_ios_view,g.count_android_view,
         g.count_review,g.mark,g.tags,g.create_date,g.category_id,g.publisher_name,c.id as giftcode_id,c.title,c.available_giftcode,c.total_giftcode,c.description as code_description FROM g_giftcode c 
         INNER JOIN g_game g ON c.game_id = g.id WHERE  c.id = ? ";
         
        $querykey = "KEY.getGiftCodeDetailIOS." .$id;
        $resultCache = $meminstance->get($querykey);
        
        if(1>0){ 
        //if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i=0;  
            if($row = $q->fetch()) {
                 $time =    date("Y/md",strtotime($row['create_date'])); 
                 if($row['icon']!="")
                    $row['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 
                 if(!empty($row['banner']))
                    $row['banner'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['banner'];
                 
                 if($row['images']!="") {
                      $arrImage =  json_decode($row['images']);
                      $i=0;
                      while($i<count($arrImage)){
                              $arrImage[$i]=   "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrImage[$i];
                              $i++;
                      } 
                      $row['images'] =   $arrImage;  
                 }  
                 $row['count_ios_view'] = $row['count_ios_view']+$row['count_android_view'];
                 $i++;
            }
            
            $meminstance->set($querykey, $row, 0, TIME_15);
             
            $connect = null;
            return $row; 
            
        }else{
            return $resultCache;  
        }
         
    }
    
    function getGiftCodeDetail($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
      
         $sql = "SELECT id,title,game_id,category_id,publisher_id,total_giftcode, available_giftcode, description FROM vtc_game_store.g_giftcode  WHERE id =  ? AND status = 1 ";
         
        $querykey = "KEY.getGiftCodeDetail." .$id;
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){ 
        if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $i=0;  
            if($row = $q->fetch()) {
                $meminstance->set($querykey, $row, 0, TIME_15);
            }
             
            $connect = null;
            return $row; 
            
        }else{
            return $resultCache;  
        }
         
    }
    
    
     function countDiscussionByGame($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_discussion Where game_id = ".intval($game_id);
        
        $querykey = "KEY" . md5($sql);
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    
    function countCommentDiscussion($discussion_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_discusstion_comment Where discussion_id = ".intval($discussion_id);
        
        $querykey = "KEY.countCommentDiscussion." . $discussion_id;
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
     function deleteDiscussionsCache($game_id,$page){
         $querykey = "KEY.discussion.list." .$game_id.".".$page;
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($querykey);
     }
     
     function deleteCommentsNewsCache($news_id,$page){
         $querykey = "KEY.comment.news." . $news_id.".".$page;
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($querykey);
     }
     
     function deleteCommentDiscussionsCache($discussion_id,$page){
         $querykey = "KEY.comment.discussion." .$discussion_id.".".$page;
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($querykey);
     }
     
     function deleteCacheByKey($key){
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($key);
     }
     
     function deleteReviewGameCache($game_id,$page){
         $querykey = "KEY.review.game." . $game_id.".".$page;
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($querykey);
     }
     
     function getDiscussionByGameId($game_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
       
        $sql = "SELECT d.id,d.user_id,d.content,d.image,d.image_width,d.image_height,d.create_date,d.count_like,d.count_comment,u.username,u.fullname,u.avatar,u.create_date as u_create_date FROM 
        vtc_game_store.g_discussion AS d INNER JOIN g_user u ON d.user_id = u.id Where game_id = ? ORDER BY id DESC  LIMIT " . $startRecord . ", " . $limit;
        
        $querykey = "KEY.discussion.list." .$game_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
         // if(1>0){
          if(!$resultCache){
            $connect = connectGameStoreDB();
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
                 $time_d =    date("Y/md",strtotime($row['create_date'])); 
                 $time_u =    date("Y/md",strtotime($row['u_create_date'])); 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/discussion/".$time_d."/".$row['image'];
                    $i++;
            }
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
            $arrResult["discussion"] = $arr;
            $sl = countDiscussionByGame($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult; 
        }
        else
        {
            $arrResult = array();
            $arrResult["discussion"] = $resultCache;
            $sl = countDiscussionByGame($game_id);
            $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            $connect = null;
            return $arrResult; 
        }
        
    }
     
    function getDiscussionDetail($discussion_id,$page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
         
        $sql = "SELECT d.id,d.user_id,d.game_id,d.content,d.image,d.image_width,d.image_height,d.count_like,d.count_comment,d.create_date,u.username,u.fullname,u.avatar,u.create_date as u_create_date FROM 
        vtc_game_store.g_discussion AS d INNER JOIN g_user u ON d.user_id = u.id Where d.id = ? ORDER BY d.id DESC  ";
        
        $querykey = "KEY.getDiscussionDetail.".$discussion_id;
        $resultCache = $meminstance->get($querykey);
        
       // if(1>0){
       if(!$resultCache){
            $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($discussion_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            if($row = $q->fetch()) {
                 $arr =  $row;
                 $time_d =    date("Y/md",strtotime($row['create_date'])); 
                 $time_u =    date("Y/md",strtotime($row['u_create_date'])); 
                 
                 if($row['image']!="")
                    $arr['image'] = "http://kenhkiemtien.com/upload/gamestore/discussion/".$time_d."/".$row['image'];
                $i++;   
            }
             $meminstance->set($querykey, $arr, 0, TIME_15);
             
             $arrResult = array();
             $arrResult["discussion"] = $arr;
             $arrResult["discussionComment"] = getDiscussionComment($discussion_id,10,$page);
          
             $connect = null;
             return $arrResult;   
        }else{
            $arrResult = array();
            $arrResult["discussion"] = $resultCache; 
            $arrResult["discussionComment"] = getDiscussionComment($discussion_id,10,$page);
               
            return $arrResult;
        }
        
    }    
    
    
     function getDiscussionDetail2($discussion_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
         
        $sql = "SELECT d.id,d.user_id,d.game_id,d.content,d.image,d.image_width,d.image_height,d.count_like,d.count_comment,d.create_date,u.username,u.fullname,u.avatar,u.create_date as u_create_date FROM 
        vtc_game_store.g_discussion  d INNER JOIN g_user u ON d.user_id = u.id Where d.id = ? ORDER BY d.id DESC  ";
        
        $querykey = "KEY.getDiscussionDetail.".$discussion_id;
        $resultCache = $meminstance->get($querykey);
       
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($discussion_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            if($row = $q->fetch()) {
                 $arr =  $row;
                 $time_d =    date("Y/md",strtotime($row['create_date'])); 
                 $time_u =    date("Y/md",strtotime($row['u_create_date'])); 
               
                 if($row['image']!="")
                    $arr['image'] = "http://kenhkiemtien.com/upload/gamestore/discussion/".$time_d."/".$row['image'];
                $i++;   
            }
           
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    }  
    
    
    function getUserIDCommentDiscussionOther($discussion_id,$user_ids)
    {
          $sql = "SELECT DISTINCT user_id FROM g_discusstion_comment WHERE discussion_id = ? AND user_id NOT IN (".$user_ids.") ";
          $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($discussion_id));   
            
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
    
    function getDiscussionComment($discussion_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  c.id,c.discussion_id,c.user_id,c.comment,c.image,DATE_FORMAT(c.create_date,\"%h-%i %d-%m-%Y\") AS create_date,c.create_date as create_date_s,u.username,u.fullname,u.avatar,u.create_date as u_create_date FROM vtc_game_store.g_discusstion_comment c INNER JOIN g_user u ON c.user_id = u.id 
        WHERE c.discussion_id = ? ORDER BY c.id DESC LIMIT " . $startRecord . ", " . $limit;
        
        $querykey = "KEY.comment.discussion." .$discussion_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();
          
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($discussion_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();   
             $i = 0;     
            while($row = $q->fetch()) {
                 $arr[$i] =  $row;
               
                 $time_d =    date("Y/md",strtotime($row['create_date_s'])); 
                 $time_u =    date("Y/md",strtotime($row['u_create_date'])); 
                 
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/discussion/".$time_d."/".$row['image'];
                 
                  $i++;   
            }
             $meminstance->set($querykey, $arr, 0, TIME_15);
             
             
             $arrResult = array();
             $arrResult["comment"] = $arr;
             $sl = countCommentDiscussion($discussion_id);
             $arrResult["page"] =  ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             $arrResult["count"] =$sl;
             
             $connect = null;
             return $arrResult; 
        }else{
            $arrResult = array();
            $arrResult["comment"] = $resultCache;
            $sl = countCommentDiscussion($discussion_id);
            $arrResult["page"] =  ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            $arrResult["count"] =$sl;
             
            return $arrResult; 
        }  
    }
    
     function getGameReview($game_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT  r.id,r.game_id,r.user_id,r.content,r.mark,r.create_date,u.username,u.fullname,u.avatar,u.create_date as u_create_date FROM vtc_game_store.g_game_review r INNER JOIN g_user u ON r.user_id = u.id Where game_id = ? ORDER BY r.create_date DESC LIMIT " . $startRecord . ", " . $limit;
        
        $querykey = "KEY.review.game." . $game_id.".".$page;
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB(); 
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
                 $time =    date("Y/md",strtotime($row['u_create_date']));
                 $i++;   
            }
             $meminstance->set($querykey, $arr, 0, TIME_15);
             
             $arrResult = array();
             $arrResult["review"] = $arr;
             $sl = countGameReview($game_id);
             $arrResult["page"] =  ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             $arrResult["count"] =  $sl;
             $connect = null;
             return $arrResult;   
        }else
        {
            $arrResult = array();
            $arrResult["review"] = $resultCache;
            $sl = countGameReview($game_id);
            $arrResult["page"] =  ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            $arrResult["count"] =  $sl;
             
            return $arrResult;   
        }
        
    }
    
    function countGameReview($game_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT count(id) as sl FROM  vtc_game_store.g_game_review Where game_id = ".intval($game_id);
        
        $querykey = "KEY.countGameReview." .$game_id;
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectGameStoreDB();
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
    
    //1: Top Hot, 2: Top New
    function getBannerIOSByPosition($position)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT b.name,b.image,g.id,g.name,g.icon,g.size_ios,g.version_ios,b.create_date,g.create_date as g_create_date,g.publisher_id,g.publisher_name FROM g_banner b INNER JOIN g_game g ON b.game_id = g.id WHERE b.position = ".intval($position)." AND b.status = 1 AND b.os = 3 Order by b.id DESC limit 5";
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB(); 
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
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/banner/".$time."/".$row['image'];
                 $time =    date("Y/md",strtotime($row['g_create_date']));
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                
                 $i++;   
            }
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;   
        }else
        {
            return $resultCache;   
        }
        
    }
    
    
    //1: Top Hot, 2: Top New
    function getBannerAndroidByPosition($position)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT b.name,b.image,g.id,g.name,g.icon,g.size_android,g.version_android,b.create_date,g.create_date as g_create_date,g.publisher_id,g.publisher_name FROM g_banner b INNER JOIN g_game g ON b.game_id = g.id WHERE b.position = ".intval($position)." AND b.status = 1 AND b.os = 2 Order by b.id DESC limit 5";
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB(); 
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
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['image']!="")
                    $arr[$i]['image'] = "http://kenhkiemtien.com/upload/gamestore/banner/".$time."/".$row['image'];
                 $time =    date("Y/md",strtotime($row['g_create_date']));
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                
                 $i++;   
            }
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;   
        }else
        {
            return $resultCache;   
        }
        
    }
    
    
    function getGameDownloadByUser($user_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT g.id,g.name,g.icon,g.category_id,g.publisher_id,g.publisher_name,g.create_date FROM g_game g INNER JOIN g_user_download u ON g.id = u.game_id WHERE u.user_id = ".intval($user_id);
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB(); 
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
                 $time =    date("Y/md",strtotime($row['create_date']));
                 if($row['icon']!="")
                    $arr[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$row['icon'];
                 $i++;   
            }
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;   
        }else
        {
            return $resultCache;   
        }
        
    }
    
    // Post content DAO.
     
   function postReviewGame($game_id,$user_id, $content,$mark,$create_user)
    {
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_game_review (game_id,user_id,content,mark,create_date,create_user) 
                     VALUES (:game_id,:user_id,:content,:mark,NOW(),:create_user)";
              
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':game_id'=>$game_id,':user_id'=>$user_id,':content'=>$content,':mark'=>$mark,':create_user'=>$create_user));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    
     // Post comment app.
     
   function postCommentApp($user_id,$type,$comment,$email)
    {
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_comment_app (user_id,TYPE,COMMENT,email,create_date) 
                     VALUES (:user_id,:TYPE,:COMMENT,:email,NOW())";
              
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':user_id'=>$user_id,':TYPE'=>$type,':COMMENT'=>$comment,':email'=>$email));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    
    function postUpdateReviewGame($game_id,$user_id, $content,$mark)
    {
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "UPDATE  vtc_game_store.g_game_review SET  content = :content , mark = :mark , create_date = NOW() Where game_id = :game_id AND  user_id = :user_id ";
            
           # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':content'=>$content,':mark'=>$mark,':game_id'=>$game_id,':user_id'=>$user_id));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    function postCommentNews($user_id,$news_id, $comment,$create_user,$update_user)
    {   
        $connect = connectGameStoreDB();
        $sql = "INSERT INTO vtc_game_store.g_news_comment (user_id,news_id,COMMENT,create_date,create_user,update_date,update_user)
    VALUES(?,?,?,NOW(),?,NOW(),?);";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($user_id,$news_id,$comment,$create_user,$update_user);
      
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function postCommentDiscussion($discussion_id,$user_id, $comment,$image,$create_user)
    {  
        $connect = connectGameStoreDB();
        $sql = "INSERT INTO vtc_game_store.g_discusstion_comment (discussion_id,user_id,COMMENT,image,create_date,create_user)
    VALUES(?,?,?,?,NOW(),?);";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id,$user_id,$comment,$image,$create_user);
     
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
     function postDiscussion($user_id,$game_id,$content,$image,$create_user,$image_width,$image_height)
    {   
        $connect = connectGameStoreDB();
        $sql = "INSERT INTO vtc_game_store.g_discussion (user_id,game_id,content,image,create_date,create_user,image_width,image_height)
    VALUES (?,?,?,?,NOW(),?,?,?)";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($user_id,$game_id,$content,$image,$create_user,$image_width,$image_height);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }                                                                                                                                                                                                                                                                            
     function insertAppClient($os,$os_version,$app_header_id,$imei)
    {   
        $connect = connectGameStoreDB();
        $sql = "INSERT INTO vtc_game_store.g_app_client (os,os_version,app_header_id,imei) VALUES (?,?,?,?)";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($os,$os_version,$app_header_id,$imei);
        //var_dump($arrV);
        $count = $q->execute($arrV);
        $insertId = $connect->lastInsertId();
        $connect = null;
        return $insertId;   
    }    
    
     function insertAppTrackingGS($app_header,$app_client_id,$LOGS,$ip)
    {  
     $count = 0;
        try{
             $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_app_tracking (app_header,app_client_id,LOGS,ip,create_date) VALUES (?,?,?,?,NOW())";
           
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_header,$app_client_id,$LOGS,$ip);
          
            $count = $q->execute($arrV);
           
            $connect = NULL;
           
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            $count = 0;
        }
        return $count;   
    }                                                                                                                                                                                                                                                                   
     function insertUser($app_client_id,$username,$PASSWORD,$fullname,$email,$mobile,$address,$avatar,$is_ban_chat,$is_ban_comment_new)
    {   
        $connect = connectGameStoreDB();
        $PASSWORD=md5(md5(time()));
        $sql = "INSERT INTO vtc_game_store.g_user (app_client_id,username,PASSWORD,fullname,email,mobile,address, 
    avatar,is_ban_chat,is_ban_comment_new,create_date,create_user,update_date,update_user)
    VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),?,NOW(),?);";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($app_client_id,$username,$PASSWORD,$fullname,$email,$mobile,$address,$avatar,$is_ban_chat,
        $is_ban_comment_new,$username,$username);
        
        $count = $q->execute($arrV);
        
        $insertId = $connect->lastInsertId();
        
        $folderId = $insertId%1000;
        $avatar="http://kenhkiemtien.com/upload/gamestore/avatar/".$folderId."/".$insertId.".png";
        $uploaddir = '../upload/gamestore/avatar/'.$folderId."";
        makeFolder($uploaddir);
        copy("../upload/gamestore/avatar/avatar_d.png",$uploaddir."/".$insertId.".png");
        
        $sql = "Update vtc_game_store.g_user SET avatar = ? Where id = ?";
        $arrV = array($avatar,$insertId);
        $q = $connect->prepare($sql);
        $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }
    
    
    function insertUserDefault($app_client_id)
    {   
        $connect = connectGameStoreDB();
        $username = "iGamer".$app_client_id;
       
        $PASSWORD=md5(md5(time()));
        $fullname="";$email="";$mobile="";$address="";
        $avatar="http://kenhkiemtien.com/upload/gamestore/avatar/avatar_d.png";$is_ban_chat=0;$is_ban_comment_new=0;
        
        $sql = "INSERT INTO vtc_game_store.g_user (app_client_id,username,PASSWORD,fullname,email,mobile,address, 
    avatar,is_ban_chat,is_ban_comment_new,create_date,create_user,update_date,update_user,birthday,facebook_id)
    VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),?,NOW(),?,?,?);";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($app_client_id,$username,$PASSWORD,$fullname,$email,$mobile,$address,$avatar,$is_ban_chat,
        $is_ban_comment_new,$username,$username,0,"");
        
        $count = $q->execute($arrV);
        
        $insertId = $connect->lastInsertId();
        
        $folderId = $insertId%1000;
        $avatar="http://kenhkiemtien.com/upload/gamestore/avatar/".$folderId."/".$insertId.".png";
        $uploaddir = '../upload/gamestore/avatar/'.$folderId."";
        makeFolder($uploaddir);
        copy("../upload/gamestore/avatar/avatar_d.png",$uploaddir."/".$insertId.".png");
        
        $sql = "Update vtc_game_store.g_user SET avatar = ? Where id = ? ";
        $arrV = array($avatar,$insertId);
        $q = $connect->prepare($sql);
        $q->execute($arrV);
        
        $connect = null;
        return $count;   
    }
    
    
    function insertUserDowload($user_id,$game_id,$os_type)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            if($user_id==0){
                $sql = "INSERT INTO vtc_game_store.g_user_download (game_id,os_type,create_date) VALUES (?,?,NOW())";
                 # creating the statement
                $q = $connect->prepare($sql);
                $arrV = array($game_id,$os_type);
                $count = $q->execute($arrV);
            }
            else{
                $sql = "INSERT INTO vtc_game_store.g_user_download (user_id,game_id,os_type,create_date) VALUES (?,?,?,NOW())";
                 # creating the statement
                $q = $connect->prepare($sql);
                $arrV = array($user_id,$game_id,$os_type);
                $count = $q->execute($arrV);
            }
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }  
    
    
    function insertLikeNews($user_id,$news_id)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_news_like (user_id,news_id) VALUES (?,?);";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($user_id,$news_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }   
    
    
    function deleteLikeNews($user_id,$news_id)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "DELETE FROM g_news_like WHERE user_id = ? AND news_id = ?";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($user_id,$news_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }   
    
    function countLikeNews($news_id)
    {
        
        $sql = "SELECT count(*) as sl FROM  vtc_game_store.g_news_like Where  news_id = ".intval($news_id) ;
        # creating the statement
        $connect = connectGameStoreDB();
        $q = $connect->prepare($sql);
        $q->execute();
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $sl = 0;    
        if($row = $q->fetch()) {
             $sl =  $row["sl"];
               
        } 
        
        
         $connect = null;
         return $sl;  
      
    } 
    
    
    function countLikeDiscussion($discussion_id)
    {
        
        $sql = "SELECT count(*) as sl FROM  vtc_game_store.g_discussion_like Where  discussion_id = ".intval($discussion_id) ;
        # creating the statement
        $connect = connectGameStoreDB();
        $q = $connect->prepare($sql);
        $q->execute();
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $sl = 0;    
        if($row = $q->fetch()) {
             $sl =  $row["sl"];
               
        } 
        
         $connect = null;
         return $sl;  
      
    } 
    
    function deleteLikeDiscussion($user_id,$discussion_id)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "DELETE FROM g_discussion_like WHERE user_id = ? AND discussion_id = ? ";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($user_id,$discussion_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }   
    
    
    function insertLikeDiscussion($user_id,$discussion_id)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_discussion_like (user_id,discussion_id) VALUES (?,?);";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($user_id,$discussion_id);
            $count = $q->execute($arrV);
            $connect = null;
           
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }                         
                                                                                                                                                                                                                                                                 
    function addCountLikeNews($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_like =count_like + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function updateCountLikeNews2($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_like =(SELECT COUNT(*) FROM g_news_like WHERE news_id = ? )  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id,$news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function subCountLikeNews($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_like =count_like - 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
    function updateCountLikeNews($news_id,$count_like)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_like = ?  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($count_like,$news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
    function updateCountLikeDiscussion($discussion_id,$count_like)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_discussion SET count_like = ?  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($count_like,$discussion_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }    
    
    
     function updateCountLikeDiscussion2($discussion_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_discussion SET count_like = (SELECT COUNT(*) FROM g_discussion_like WHERE discussion_id = ?)  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id,$discussion_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
           
    
    function getCountLikeNews($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "Select count_like FROM vtc_game_store.g_news WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id);
        $q->execute($arrV);
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
        
        $sl = 0;
        if($row = $q->fetch()) {
               $sl = $row["count_like"];
                
         }
 
        $connect = null;
        return $sl;   
    }   
    
    function getCountLikeDiscussion($discussion_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "Select count_like FROM vtc_game_store.g_discussion WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id);
        $q->execute($arrV);
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $sl = 0;
        if($row = $q->fetch()) {
               $sl = $row["count_like"];
                
         }
 
        $connect = null;
        return $sl;   
    }     
    
    function addCountViewNews($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_view =count_view + 1  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
                                                                                                                                                 
    function addCountCommentNews($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_comment =count_comment + 1  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
    
    function updateCountCommentNews($news_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_news SET count_comment =(SELECT COUNT(*) FROM g_news_comment WHERE news_id = ? )  WHERE id = ?
 ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($news_id,$news_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }                                                                                                                                                                                                                         
    
    function addCountIOSDownloadGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_ios_download =count_ios_download + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function updateCountIOSDownloadGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_ios_download = (SELECT COUNT(*) FROM g_user_download WHERE game_id = ? AND os_type = 3 )  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id,$game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function addCountIOSViewGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_ios_view =count_ios_view +  1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }  
    
    
    
    function addCountAndroidDownloadGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_android_download =count_android_download + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    
    function updateCountAndroidDownloadGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_android_download = (SELECT COUNT(*) FROM g_user_download WHERE game_id = ? AND os_type = 2 )  WHERE id =  ?";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id,$game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function addCountAndroidViewGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_android_view =count_android_view + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }  
                                                                                                                                                
    function addCountReviewViewGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_review =count_review + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }
    
     function updateCountReviewGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET count_review = (SELECT COUNT(*) FROM g_game_review WHERE game_id = ? )  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id,$game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }
    
    function updateMarkReviewGame($game_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_game SET mark = (SELECT ROUND(SUM(mark)/COUNT(*),1) FROM g_game_review WHERE game_id = ? )  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($game_id,$game_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }
    
    function addCountGameCategory($category_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_category SET count_game =count_game + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($category_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function addCountGamePublisher($publisher_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_publisher SET count_game =count_game + 1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($publisher_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
    function addCountCommentDiscussion($discussion_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_discussion SET count_comment =count_comment +  1  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }     
    
    function updateCountCommentDiscussion($discussion_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_discussion SET count_comment = (SELECT COUNT(*) FROM g_discusstion_comment WHERE discussion_id = ? )  WHERE id = ? ;";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id,$discussion_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }                                                                                                                                                                                                                                                                 
    
    function addCountLikeDiscussion($discussion_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_discussion SET count_like =count_like + 1  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
    function subCountLikeDiscussion($discussion_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_discussion SET count_like =count_like - 1  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    }   
    
     function subAvailableGiftCode($giftcode_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_giftcode SET available_giftcode =available_giftcode - 1  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($giftcode_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
     function updateAvailableGiftCode($giftcode_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_giftcode SET available_giftcode =(SELECT COUNT(*) FROM g_giftcode_store WHERE STATUS = 1 AND giftcode_id = ?
)  WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($giftcode_id,$giftcode_id);
        
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
    function updateUserReceiveGiftCode($code_id,$user_id)
    {   
        $connect = connectGameStoreDB();
        $sql = "UPDATE vtc_game_store.g_giftcode_store SET user_id = ? , status = 0  WHERE id = ? AND status = 1 ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($user_id,$code_id);
        
        $count = $q->execute($arrV);
        
        $connect = null;
        return $count;   
    }                                       
    
    
    function updateUserInfo($user_id,$fullname,$sex,$mobile,$birthday,$email,$facebook_id)
    {
    	$connect = connectGameStoreDB();
    	$sql = "UPDATE vtc_game_store.g_user SET ";
    	
    	$arrV = array();
    	$i = 0;
    	if(!IsNullOrEmptyString($fullname)){
    		$sql .=  " fullname = ? ";
    		$arrV[$i]=$fullname;
    		$i++;
    	}
    	
    	if(!IsNullOrEmptyString($sex)){
    		$sql .= $i==0?" sex = ?":", sex = ? ";
    		$arrV[$i]=$sex;
    		$i++;
    	}
    	
    	if(!IsNullOrEmptyString($email)){
    		$sql .= $i==0?" email = ?":", email = ? ";
    		$arrV[$i]=$email;
         	$i++;
    	}
    	
    	if(!IsNullOrEmptyString($mobile)){
    		$sql .= $i==0?" mobile = ?": ", mobile = ? ";
    		$arrV[$i]=$mobile;
    		$i++;
    	}
    	
    	if(!IsNullOrEmptyString($birthday)){
    		$sql .= $i==0?" birthday = ?":", birthday = ? ";
    		$arrV[$i]=$birthday;
    		$i++;
    	}
    	
    	if(!IsNullOrEmptyString($facebook_id)){
    		$sql .= $i==0?" facebook_id = ?": ", facebook_id = ? ";
    		$arrV[$i]=$facebook_id;
    		$i++;
    	}
    	
        $sql .=" Where id = ? ";
    	$arrV[$i]=$user_id;
        
    	# creating the statement
    	$q = $connect->prepare($sql);
    	$count = $q->execute($arrV);
        
        writeLog($sql."kq".$count);
       
   
    	$connect = null;
    	return $count;
    }
    
    
    function updateAvatar($user_id,$avatar)
    {
    	$connect = connectGameStoreDB();
    	$sql = "UPDATE vtc_game_store.g_user SET avatar = ?  WHERE id = ? ";
    
    	# creating the statement
    	$q = $connect->prepare($sql);
    	$arrV = array($avatar,$user_id);
    
    	$count = $q->execute($arrV);
    
    	$connect = null;
    	return $count;
    }
    
    
    function getGiftCodeStoreAvailable($giftcode_id)
    {
        $sql = "SELECT id,giftcode_id,code FROM vtc_game_store.g_giftcode_store WHERE giftcode_id = ? AND STATUS = 1 Order By id Limit 1";
        $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($giftcode_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            if($row = $q->fetch()) {
                 $arr =  $row;
                
            }
          
            $connect = null;
            return $arr;   
       
    } 
    
    
     function ktGiftcodePhat($giftcode_id,$user_id)
    {
        $sql = "SELECT id,giftcode_id,code FROM vtc_game_store.g_giftcode_store WHERE giftcode_id = ? AND user_id = ?  Order By id Limit 1";
        $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($giftcode_id,$user_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $kq = 0;
            if($row = $q->fetch()) {
                 $kq = 1;
                
            }
           
            $connect = null;
            return $kq;   
       
    } 
    
    
     function getGiftCodeIdByGameId($game_id)
    {
        $sql = "SELECT id FROM g_giftcode  WHERE available_giftcode > 0 AND game_id = ? AND status = 1  ORDER BY id DESC LIMIT 1";
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $querykey = "KEY" . md5($sql.$game_id);
        
        $result = $meminstance->get($querykey);
        
        if (!$result) {
            
            $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($game_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            if($row = $q->fetch()) {
                 $arr =  $row;
                
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            $connect = null;
            return $arr;   
            
        }else{
             return $result;   
        }
    } 
    
    function checkGiftCodeStoreAvailable($code_id)
    {
        $sql = "SELECT id,giftcode_id,code FROM vtc_game_store.g_giftcode_store WHERE id = ? AND status = 1 ";
        $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($code_id));   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
            
            # showing the results
            $kq = 0;  
            if($row = $q->fetch()) {
                 $kq = 1;
            }
           
            $connect = null;
            return $kq;   
       
    }                                          
                                             
    
    
    // Get AppHeader And Create Client App Id
   function getAppHeaderStore($app_header,$app_client_id,$os_version,$imei){
      
       $app_header = mysql_escape_string($app_header);
       $app_client_id = mysql_escape_string($app_client_id);
       $os_version = mysql_escape_string($os_version);
       $imei = mysql_escape_string(trim($imei));
       
       $arrKq = array();
       //get app header config 
       $arrAppHeader = getAppHeader($app_header);
       
       if(empty($arrAppHeader)) return "";
       
       $arrKq["app_header"] = $arrAppHeader;  
       
       $app_header_id =  $arrAppHeader["id"];
       $os =    $arrAppHeader["os"];     
       
       
       if(empty($app_client_id)||intval($app_client_id)==0){
               $app_client_id ="0";
               $app_client_id = insertAppClient($os,$os_version,$app_client_id,$imei);
             //  insertUserDefault($app_client_id);
              
       }else{
           if(!checkAppClientIdExist($app_client_id)){
                // Tao client id moi và Tao xo so user 
               $app_client_id ="0";
               $app_client_id = insertAppClient($os,$os_version,$app_client_id,$imei);
             //  insertUserDefault($app_client_id);
           }
       }
       
        $arrKq["app_client_id"] = $app_client_id;
       /* $user   = getUserByAppClientId($app_client_id);
        if(!empty($user)){
            $user_token = md5(md5($user["id"].time()."gamestore!@#"));
            updateUserToken($user["id"],$user_token);
        }
        $arrKq["user"] = $user; */
        $arrKq["token"] = md5(md5($app_client_id."_"."ttvgamestorii@#$%"));  
        
        $arrChat = array(); 
        $arrChat["resource"] = "mobile";
        $arrChat["id"] = "2";
        $arrChat["guest"] = "guest";
        $arrChat["password"] = "14e1b600b1fd579f47433b88e8d85291";
        
        $arrKq["chat"] = $arrChat; 
     
        return    $arrKq;
   }
   
    function checkToken($app_client_id,$token){
        if(empty($token)) return 0;
        $toke_check =  md5(md5($app_client_id."_"."ttvgamestorii@#$%")); 
        if(strcmp($toke_check,$token)==0)  return 1; else return 0;
    }
    
    function getUserByAppClientId($app_client_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id,  
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE app_client_id = ?" ;
        
        $querykey = md5("KEY.ttv.g_user.getUserByAppClientId.".$app_client_id);
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($app_client_id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    
    function getUserById($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id, 
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE id = ?" ;
        
        $querykey = md5("KEY.ttv.g_user.getUserById.".$id);
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();  
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
             
         $meminstance->set($querykey, $arr, 0, TIME_15);
        
         $connect = null;
         return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    
    function getUserToken($user_token)
    {
         
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id, 
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE user_token = ?" ;
        
        $connect = connectGameStoreDB();  
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array($user_token)); 
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();    
        if($row = $q->fetch()) {
             $arr =  $row;
            
        }
        
         $connect = null;
         return $arr;   
        
    } 
    
    
    function getDateExpireBan($user_id,$type)
    {
         
        $sql = "SELECT date_expire,reason FROM g_user_ban WHERE user_id = ? AND TYPE = ? ORDER BY date_expire DESC LIMIT 1" ;
        
        $connect = connectGameStoreDB();  
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array($user_id,$type)); 
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array(); 
        if($row = $q->fetch()) {
             $arr =  $row;
            
        }
        
         $connect = null;
         return $arr;   
        
    }
    
    
    function getUsernameById($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT username FROM  vtc_game_store.g_user WHERE id = ? " ;
        
        $querykey = md5("KEY.ttv.g_user.getUsernameById.".$id);
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            $arr["username"] = "";
            if($row = $q->fetch()) {
                 $arr["username"] =  $row["username"];
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    
    function getFullnameById($id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT fullname FROM  vtc_game_store.g_user WHERE id = ? " ;
        
        $querykey = md5("KEY.ttv.g_user.getFullnameById.".$id);
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($id)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            $arr["fullname"] = "";
            if($row = $q->fetch()) {
                 $arr["fullname"] =  $row["fullname"];
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    
    function getFullnameByIds($ids)
    {
        $last_char = substr($ids, -1);
        if(strcmp($last_char,",")==0)
        $ids = cleanQuery(substr($ids,0,strlen($ids)-1));
        
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT id,fullname FROM  vtc_game_store.g_user WHERE id in (".$ids.") " ;
        
        $querykey = md5("KEY.ttv.g_user.getFullnameByIds.".$ids);
        $resultCache = $meminstance->get($querykey);
        
        //if(1>0){
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            $i = 0;
            while($row = $q->fetch()) {
                 $arr[$i]["fullname"] = "";
                 $arr[$i] =  $row;
                 $i++;
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    
    function getUserByUserName($username)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id, 
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE username = ?" ;
        
        $querykey = md5("KEY.ttv.g_user.getUserByUserName.".$username);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($username)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    function getUserByEmail($email)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id, 
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE email = ?" ;
        
        $querykey = md5("KEY.ttv.g_user.getUserByEmail.".$email);
        $resultCache = $meminstance->get($querykey);
        
        if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($email)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    function getUserByEmailNoCache($email)
    {
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id, 
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE email = ?" ;
        
        $connect = connectGameStoreDB();  
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array($email)); 
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();    
        if($row = $q->fetch()) {
             $arr =  $row;
            
        }
         
         $connect = null;
         return $arr;   
    } 
    
    
    function getUserByFacebookID($facebook_id)
    {
        $sql = "SELECT id,app_client_id,username,fullname,password,email,mobile,avatar,sex,birthday,facebook_id, 
        is_ban_chat,is_ban_comment_new, create_date,user_token  FROM  vtc_game_store.g_user WHERE facebook_id = ? Limit  1" ;
        
        $connect = connectGameStoreDB();  
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array($facebook_id)); 
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();    
        if($row = $q->fetch()) {
             $arr =  $row;
            
        }
         
         $connect = null;
         return $arr;   
    } 
    
    
    function getAppHeader($app_header)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
       
        $sql = "SELECT id,app_header,os,version,isViewGame,link_update,update_info,chat_hostname,chat_port FROM vtc_game_store.g_app_header WHERE app_header = ? " ;
     //   echo $sql
        $querykey = "KEY" . md5($sql.$app_header);
        $resultCache = $meminstance->get($querykey);
        
        if(1>0){
        //if(!$resultCache){
            $connect = connectGameStoreDB();  
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($app_header)); 
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                
            }
             
             $meminstance->set($querykey, $arr, 0, TIME_15);
            
             $connect = null;
             return $arr;   
        }else{
            
            return $resultCache;
        }
        
    } 
    
    
   function checkAppClientIdExist($app_client_id)
    {
        $kq=0;
        $sql = "SELECT * FROM vtc_game_store.g_app_client  WHERE id= ? ";
        $connect = connectGameStoreDB();  
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array($app_client_id)); 
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        if($row = $q->fetch()) {
             $kq =  1;
            
        }
        
        $connect = null;

        return $kq;     
    } 
    
    
    function checkUserNameUpdateInfo($username,$user_id)
    {
    	$username= cleanQuery($username);
    	$user_id = cleanQuery($user_id);
    	$kq=0;
    	$sql = "SELECT * FROM g_user  WHERE username = ?  And  id  <> ? ";
    	$connect = connectGameStoreDB();  
        # creating the statement
        $q = $connect->prepare($sql);
        $q->execute(array($username,$user_id)); 
        
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        if($row = $q->fetch()) {
             $kq =  1;
            
        }
        
        $connect = null;

        return $kq; 
    }
    
    
     function getGameFile($game_id,$os_type,$is_play)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT file_path,file_plist FROM vtc_game_store.g_game_file  WHERE  game_id = ? And  os_type = ? AND is_play = ? Order By id DESC Limit 1 " ;
        $querykey = "KEY" . md5($sql.$game_id.$os_type.$is_play);
        $result = $meminstance->get($querykey);
        
       
       //if (1>0) {
       if (!$result) {
            # creating the statement
            $connect = connectGameStoreDB();
            $q = $connect->prepare($sql);
            $q->execute(array($game_id,$os_type,$is_play));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
            } 
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             
             return $arr;
        }else{
            return $result;
        }   
    }  
    
    
     function getVersionStore($app_header)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT app_header,VERSION,update_info,link_update FROM vtc_game_store.g_app_header WHERE  app_header = ? " ;
        $querykey = "KEY" . md5($sql.$app_header);
        $result = $meminstance->get($querykey);
        
        //if(1>0){
        if (!$result) {
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($app_header));
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();    
            if($row = $q->fetch()) {
                 $arr =  $row;
                   
            } 
            
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
           
             return $arr;
             
        }else{
            return $result;
        }
    } 
    
    
   
   function insertNoticeIOSUser($app_client_id,$device_token,$user_id,$username,$ip_address,$app_header)
    {
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_notice_ios_user  (app_client_id,user_id,device_token,username,ip_address,create_date,app_header) 
                     VALUES (:app_client_id,:user_id,:device_token,:username,:ip_address,NOW(),:app_header)";
             
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':app_client_id'=>$app_client_id,':user_id'=>$user_id,':device_token'=>$device_token,':username'=>$username,':ip_address'=>$ip_address,':app_header'=>$app_header));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    
     function checkKeyNotify($user_id,$app_client_id)
    {
        $sql = "SELECT id FROM g_notice_user WHERE app_client_id = ? AND  user_id = ?  " ;
        
        # creating the statement
        $connect = connectGameStoreDB();
        $q = $connect->prepare($sql);
        $q->execute(array($app_client_id,$user_id));
       
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
    
    function checkKeyNotifyByAppClientID($app_client_id)
    {
        $sql = "SELECT id FROM g_notice_user WHERE app_client_id = ?" ;
        
        # creating the statement
        $connect = connectGameStoreDB();
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
    
    
     function insertNoticeUser($app_client_id,$user_id,$device_token,$os_type,$app_header,$channel)
    {
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_notice_user (app_client_id,user_id,device_token,os_type,create_date,app_header,channel) 
                     VALUES (:app_client_id,:user_id,:device_token,:os_type,NOW(),:app_header,:channel)";
             
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':app_client_id'=>$app_client_id,':user_id'=>$user_id,':device_token'=>$device_token,':os_type'=>$os_type,':app_header'=>$app_header,':channel'=>$channel));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
            
        }
        
        return $count;   
    } 
    
    
    function updateNoticeUser($user_id,$app_client_id,$device_token)
    {
        $count = 0;
        try{
             $connect = connectGameStoreDB();
            $sql = "Update  vtc_game_store.g_notice_user Set device_token = ? where user_id = ? And app_client_id = ?  ";
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array($device_token,$user_id,$app_client_id));
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    
    function insertNotice($object_id,$from_userid,$to_user,$content,$url,$icon,$type,$create_user)
    {
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO vtc_game_store.g_notice (object_id,from_user,to_user,content, url,icon, TYPE, STATUS, time_sent,create_date,create_user)
    VALUES (:object_id,:from_user,:to_user,:content,:url,:icon,:type,'1',NOW(),NOW(),:create_user);";
             
            
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':object_id'=>$object_id,':from_user'=>$from_userid,':to_user'=>$to_user,':content'=>$content,':url'=>$url,':icon'=>$icon,':type'=>$type,':create_user'=>$create_user));
           
            $connect = null;
        }catch (Exception $e){
          
            $count = 0;
        }
        
        return $count;   
    } 
   
   function deleteTokenByAppClientID($app_client_id)
    {
        $connect = connectGameStoreDB();
        $sql = "DELETE FROM vtc_game_store.g_notice_user WHERE app_client_id = ? ";
    
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($app_client_id);
    
        $count = $q->execute($arrV);
    
        $connect = null;
        return $count;
    }
    
    
   function deleteDiscussion($id,$user_id)
    {
        $connect = connectGameStoreDB();
        $sql = "DELETE FROM vtc_game_store.g_discussion WHERE id = ? AND user_id = ? ";
    
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($id,$user_id);
    
        $count = $q->execute($arrV);
    
        $connect = null;
        return $count;
    }
    
    function deleteDiscussionComment($discussion_id)
    {
        $connect = connectGameStoreDB();
        $sql = "DELETE FROM vtc_game_store.g_discusstion_comment WHERE discussion_id = ? ";
    
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id);
    
        $count = $q->execute($arrV);
    
        $connect = null;
        return $count;
    }
    
    function deleteDiscussionLike($discussion_id)
    {
        $connect = connectGameStoreDB();
        $sql = "DELETE FROM vtc_game_store.g_discussion_like WHERE discussion_id = ? ";
    
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($discussion_id);
    
        $count = $q->execute($arrV);
    
        $connect = null;
        return $count;
    }
    
    
     function getGameHadEvent()
    {
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         
        $sql = "SELECT distinct game_id FROM g_news WHERE is_event = 1 AND (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(create_date))/86400 < 5 Order By id DESC Limit 20";
        
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey);
       
       if(!$resultCache){
            $connect = connectGameStoreDB();   
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array());   
            
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $arr = array();  
            $i = 0;  
            while($row = $q->fetch()) {
                 $arr[$i] =  $row["game_id"];
                 $i++;   
            }
            
             $meminstance->set($querykey, $arr, 0, TIME_15);
             $connect = null;
             return $arr;   
             
             }else{
            
                 return $resultCache;
        }
        
    }      
    
    function registerMember($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$facebook_id,$user_token){
        $insertId = 0;
        
        try{
            $connect = connectGameStoreDB();
            $username = "igamer".$app_client_id.substr(time(),-3);
           
            $PASSWORD=md5(md5(time()));
            $address="";
            $avatar="http://kenhkiemtien.com/upload/gamestore/avatar/avatar_d.png";$is_ban_chat=0;$is_ban_comment_new=0;
            
            if(empty($facebook_id))
            {
                $facebook_id = "NULL";
            }
            
            $sql = "INSERT INTO vtc_game_store.g_user (app_client_id,username,PASSWORD,fullname,sex,email,mobile,address, 
        avatar,is_ban_chat,is_ban_comment_new,create_date,create_user,update_date,update_user,birthday,facebook_id,user_token)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW(),?,NOW(),?,?,?,?);";
            
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$username,$PASSWORD,$fullname,$sex,$email,$mobile,$address,$avatar,$is_ban_chat,
            $is_ban_comment_new,$username,$username,$birthday,$facebook_id,$user_token);
            
            $count = $q->execute($arrV);
            
            $insertId = $connect->lastInsertId();
            
            #update avatar
            $folderId = $insertId%1000;
            $avatar="http://kenhkiemtien.com/upload/gamestore/avatar/".$folderId."/".$insertId.".png";
            $uploaddir = ROOT_UPLOAD.'/gamestore/avatar/'.$folderId."";
            makeFolder($uploaddir);
            copy(ROOT_UPLOAD."/gamestore/avatar/avatar_d.png",$uploaddir."/".$insertId.".png");
            
            $sql = "Update vtc_game_store.g_user SET avatar = ? Where id = ? ";
            $arrV = array($avatar,$insertId);
            $q = $connect->prepare($sql);
            $q->execute($arrV);
            
            $connect = null;
        }catch (Exception $e) {
          //  echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        return $insertId;  
        
    }
    
    // http://www.9lessons.info/2009/03/upload-and-resize-image-with-php.html
    //http://sinhvienit.net/forum/huong-dan-resize-anh-bang-php.168534.html
    function uploadImageDiscussion($app_client_id,&$image,&$image_width,&$image_height){
         $uploaddir = ROOT_UPLOAD.'/gamestore/discussion/';
        try {
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['upfile']['error']) ||
                is_array($_FILES['upfile']['error'])
            ) {
                //throw new RuntimeException('Invalid parameters.');
               // throw new RuntimeException('1');
               return 1;
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    //throw new RuntimeException('No file sent.');
                    throw new RuntimeException('2');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    //throw new RuntimeException('Exceeded filesize limit.');
                    throw new RuntimeException('3');
                default:
                    //throw new RuntimeException('Unknown errors.');
                    throw new RuntimeException('100');
            }

            // You should also check filesize here. 
            if ($_FILES['upfile']['size'] > 10000000) {
                throw new RuntimeException('3');
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
                throw new RuntimeException('5');
            }

            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
             $pathdate = date("Y/md/");
             $file = basename($_FILES['upfile']['name']);
             $time = strval(time());
             $file = basename($file, ".".$ext)."-".$app_client_id.$time.".".$ext;
             $file = sanitize($file,true);
           
             $uploaddir = $uploaddir.$pathdate;
             makeFolder($uploaddir);
             $uploadfile =$uploaddir . $file;
             $image_info = getimagesize($_FILES["upfile"]["tmp_name"]);
             
            if (!move_uploaded_file($_FILES['upfile']['tmp_name'],$uploadfile)) {
                //throw new RuntimeException('Failed to move uploaded file.');
                throw new RuntimeException('4');
            }else{
               $image =  $file;
               $image_width = $image_info[0];
               $image_height = $image_info[1];
              
            }
            
            return '0';

        } catch (RuntimeException $e) {

            echo $e->getMessage();

        }
    }
    
    function uploadAvatar($user_id){
        $folderId = $user_id%1000;
        $uploaddir =ROOT_UPLOAD. '/gamestore/avatar/'.$folderId."/";
        $pathUrl ='/upload/gamestore/avatar/'.$folderId."/";
        
        $userInfo = getUserById ($user_id);
        $avatar_url =$userInfo["avatar"];
        $arrKQ = array();
       
    	try {
    		// Undefined | Multiple Files | $_FILES Corruption Attack
    		// If this request falls under any of them, treat it invalid.
    		if (!isset($_FILES['upfile']['error']) ||is_array($_FILES['upfile']['error']||empty($user_id))
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
                    $arrKQ["result"]=1;
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
                    $arrKQ["result"]=100;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
    				//throw new RuntimeException('Unknown errors.');
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
    		//$pathdate = date("Y/md/");
    		//$file = basename($_FILES['upfile']['name']);
    		//$file = basename($file, ".".$ext)."-".$app_client_id.".".$ext;
    		//$file = sanitize($file,true);
            $file = $user_id.".jpg";
            makeFolder($uploaddir);
    		$uploadfile =$uploaddir . $file;
    
    		if (!move_uploaded_file($_FILES['upfile']['tmp_name'],$uploadfile)) {
    			//throw new RuntimeException('Failed to move uploaded file.');
                $arrKQ["result"]=4;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
    			
                throw new RuntimeException($exception);
    		}else{
    			$avatar_url="http://kenhkiemtien.com".$pathUrl . $file;
    			updateAvatar($user_id, $avatar_url);
    		}
    
    	    $arrKQ["result"]=0;
            $arrKQ["avatar"]=$avatar_url;
    		echo json_encode($arrKQ);
    
    	} catch (RuntimeException $e) {
    
    		echo $e->getMessage();
    
    	}
    }
   
  function searchKeywordIOS($keyword,$page,$limitItem) {
    require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
    $searcher = new java("com.ttv.search.GameIOSSearch","/home/search/gameIOS/");
    $topDocs = $searcher->query($keyword,$page, $limitItem); ;
    $docs = java_values($topDocs) ;
    $num_row=count($docs);
    
    $arrGame = array();
    $arrGameKQ = array();
    for($i=0;$i<$num_row;$i++)
    {
      
      $arrGame[$i]["id"] = java_values($docs[$i]->id);   
      $arrGame[$i]["name"] = java_values($docs[$i]->name);
      $arrGame[$i]["description"] = java_values($docs[$i]->description);
      $arrGame[$i]["category_id"] = java_values($docs[$i]->category_id);
      $arrGame[$i]["publisher_id"] = java_values($docs[$i]->publisher_id);
      $arrGame[$i]["publisher_name"] = java_values($docs[$i]->publisher_name);
      $arrGame[$i]["icon"] = java_values($docs[$i]->icon);
      $arrGame[$i]["version_ios"] = java_values($docs[$i]->version_ios);
      $arrGame[$i]["version_os_ios"] = java_values($docs[$i]->version_os_ios);
     
      $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
      $arrGame[$i]["size_ios"] = java_values($docs[$i]->size_ios);
      $arrGame[$i]["mark"] = java_values($docs[$i]->mark);
      
      $arrGame[$i]["count_ios_download"] = java_values($docs[$i]->count_ios_download);
      $arrGame[$i]["count_ios_view"] = java_values($docs[$i]->count_ios_view)+java_values($docs[$i]->count_android_view);
      $arrGame[$i]["count_review"] = java_values($docs[$i]->count_review);
      $arrGame[$i]["is_hot"] = java_values($docs[$i]->is_hot);
      
      $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
      if($arrGame[$i]['icon']!="")
         $arrGame[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrGame[$i]['icon'];
          
    }
    
    $total = java_values($searcher->getTotalHit());
    $arrGameKQ["game"]=$arrGame;
    $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
    $arrGameKQ["page"] = $page;
    
    return $arrGameKQ;
  }
  
  
  function searchKeywordRecommentIOS($keyword) {
    require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
    $searcher = new java("com.ttv.search.GameIOSSearch","/home/search/gameIOS/");
    $topDocs = $searcher->queryRecomment($keyword); ;
    $docs = java_values($topDocs) ;
    $num_row=count($docs);
    
    $arrGame = array();
    $arrGameKQ = array();
    for($i=0;$i<$num_row;$i++)
    {
      
      $arrGame[$i]["id"] = java_values($docs[$i]->id);   
      $arrGame[$i]["name"] = java_values($docs[$i]->name);
      $arrGame[$i]["description"] = java_values($docs[$i]->description);
      $arrGame[$i]["category_id"] = java_values($docs[$i]->category_id);
      $arrGame[$i]["publisher_id"] = java_values($docs[$i]->publisher_id);
      $arrGame[$i]["publisher_name"] = java_values($docs[$i]->publisher_name);
      $arrGame[$i]["icon"] = java_values($docs[$i]->icon);
      $arrGame[$i]["version_ios"] = java_values($docs[$i]->version_ios);
      $arrGame[$i]["version_os_ios"] = java_values($docs[$i]->version_os_ios);
     
      $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
      $arrGame[$i]["size_ios"] = java_values($docs[$i]->size_ios);
      $arrGame[$i]["mark"] = java_values($docs[$i]->mark);
      
      $arrGame[$i]["count_ios_download"] = java_values($docs[$i]->count_ios_download);
      $arrGame[$i]["count_ios_view"] = java_values($docs[$i]->count_ios_view)+java_values($docs[$i]->count_android_view);
      $arrGame[$i]["count_review"] = java_values($docs[$i]->count_review);
      $arrGame[$i]["is_hot"] = java_values($docs[$i]->is_hot);
      
      $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
      if($arrGame[$i]['icon']!="")
         $arrGame[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrGame[$i]['icon'];
          
    }
    
    $total = java_values($searcher->getTotalHit());
    $arrGameKQ["game"]=$arrGame;
    $page = 1;
    $arrGameKQ["page"] = $page;
    return $arrGameKQ;
  }
  
  
  function searchKeywordAndroid($keyword,$page,$limitItem) {
    require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
    $searcher = new java("com.ttv.search.GameAndroidSearch","/home/search/gameAndroid/");
    $topDocs = $searcher->query($keyword,$page, $limitItem); ;
    $docs = java_values($topDocs) ;
    $num_row=count($docs);
    
    $arrGame = array();
    $arrGameKQ = array();
    for($i=0;$i<$num_row;$i++)
    {
      
      $arrGame[$i]["id"] = java_values($docs[$i]->id);   
      $arrGame[$i]["name"] = java_values($docs[$i]->name);
      $arrGame[$i]["description"] = java_values($docs[$i]->description);
      $arrGame[$i]["category_id"] = java_values($docs[$i]->category_id);
      $arrGame[$i]["publisher_id"] = java_values($docs[$i]->publisher_id);
      $arrGame[$i]["publisher_name"] = java_values($docs[$i]->publisher_name);
      $arrGame[$i]["icon"] = java_values($docs[$i]->icon);
      $arrGame[$i]["version_android"] = java_values($docs[$i]->version_android);
      $arrGame[$i]["version_os_android"] = java_values($docs[$i]->version_os_android);
     
      $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
      $arrGame[$i]["size_android"] = java_values($docs[$i]->size_android);
      $arrGame[$i]["mark"] = java_values($docs[$i]->mark);
      
      $arrGame[$i]["count_android_download"] = java_values($docs[$i]->count_android_download);
      $arrGame[$i]["count_android_view"] = java_values($docs[$i]->count_android_view)+java_values($docs[$i]->count_ios_view);
      $arrGame[$i]["count_review"] = java_values($docs[$i]->count_review);
      $arrGame[$i]["is_hot"] = java_values($docs[$i]->is_hot);
      
      $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
      if($arrGame[$i]['icon']!="")
         $arrGame[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrGame[$i]['icon'];
                 
                    
    }
    
    $total = java_values($searcher->getTotalHit());
    $arrGameKQ["game"]=$arrGame;
    $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
    $arrGameKQ["page"] = $page;
   
    return $arrGameKQ;
  }
  
  function searchKeywordRecommentAndroid($keyword) {
    require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
    $searcher = new java("com.ttv.search.GameAndroidSearch","/home/search/gameAndroid/");
    $topDocs = $searcher->queryRecomment($keyword); ;
    $docs = java_values($topDocs) ;
    $num_row=count($docs);
    
    $arrGame = array();
    $arrGameKQ = array();
    for($i=0;$i<$num_row;$i++)
    {
      
      $arrGame[$i]["id"] = java_values($docs[$i]->id);   
      $arrGame[$i]["name"] = java_values($docs[$i]->name);
      $arrGame[$i]["description"] = java_values($docs[$i]->description);
      $arrGame[$i]["category_id"] = java_values($docs[$i]->category_id);
      $arrGame[$i]["publisher_id"] = java_values($docs[$i]->publisher_id);
      $arrGame[$i]["publisher_name"] = java_values($docs[$i]->publisher_name);
      $arrGame[$i]["icon"] = java_values($docs[$i]->icon);
      $arrGame[$i]["version_android"] = java_values($docs[$i]->version_ios);
      $arrGame[$i]["version_os_android"] = java_values($docs[$i]->version_os_ios);
     
      $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
      $arrGame[$i]["size_android"] = java_values($docs[$i]->size_ios);
      $arrGame[$i]["mark"] = java_values($docs[$i]->mark);
      
      $arrGame[$i]["count_android_download"] = java_values($docs[$i]->count_android_download);
      $arrGame[$i]["count_android_view"] = java_values($docs[$i]->count_android_view)+java_values($docs[$i]->count_ios_view);
      $arrGame[$i]["count_review"] = java_values($docs[$i]->count_review);
      $arrGame[$i]["is_hot"] = java_values($docs[$i]->is_hot);
      
      $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
      if($arrGame[$i]['icon']!="")
         $arrGame[$i]['icon'] = "http://kenhkiemtien.com/upload/gamestore/game/".$time."/".$arrGame[$i]['icon'];
                 
      
                    
    }
    $limitItem = 10;
    $total = java_values($searcher->getTotalHit());
    $arrGameKQ["game"]=$arrGame;
    $page = 1;
    $arrGameKQ["page"] = $page;
  
    return $arrGameKQ;
  }
  
  
  function getKeywordAndroidRecommend() {
      $arrKeyword = array("Bom bom","Teen teen","Game Bai","Game co","Kiếm hiệp","Võ lâm","Tiên hiệp","Bóng đá");
      return $arrKeyword;
  }
  
  function getKeywordIOSRecommend() {
      $arrKeyword = array("Bom bom","Teen teen","Game Bai","Game co","Kiếm hiệp","Võ lâm","Tiên hiệp","Bóng đá");
      return $arrKeyword;
  }                                            
                                                                                                    
  function writeLog($mo){
        $date = date('Y-m-d H:i:s');
        $file = dirname(__FILE__).'/logGameStore.txt';
        
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        $current =$date."  :  ". $mo."\n";
        
        // Write the contents back to the file
        file_put_contents($file, $current,FILE_APPEND | LOCK_EX);
     }                                                                                                                                                
?>
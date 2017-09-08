<?php
  
   function getGameIOSHomeHotItune($limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND is_hot = 1 AND status = 1 AND is_market = 1  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
    
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
            $arr = array();  
            $i=0;    
            while($row = $connect->fetch()) {
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
    
    
    function getGameIOSHomeNewItune($limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1  AND status = 1 AND  is_market = 1 ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
    
        $querykey = "KEY" . md5($sql);
        $resultCache = $meminstance->get($querykey); 
        
       //if(1>0){
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
    
    
    function getGameIOSByCategoryHotItune($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND is_hot = 1 AND status = 1 AND is_market = 1 AND category_id = ?   ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit; 
       
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
    
    
    function getGameIOSByCategoryNewItune($category_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND  status = 1 AND  is_market = 1 AND category_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
     
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
                 
                 $arr[$i]['count_ios_download'] =strval( $arr[$i]['count_android_download']+$arr[$i]['count_ios_download']);  
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
    
    function getGameIOSByPublisherNewItune($publisher_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
       
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND  status = 1 AND  is_market = 1 AND publisher_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;
    
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
    
    
    function getGameIOSByPublisherHotItune($publisher_id,$limit, $page)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit;    
        
        $sql = "SELECT  id,name,description,icon,banner,version_ios,version_os_ios, 
    size_ios,count_ios_download,count_android_download,count_android_view,count_ios_view,count_review,mark,tags,create_date,category_id,publisher_id,publisher_name FROM vtc_game_store.g_game WHERE is_ios = 1 AND is_hot = 1 AND status = 1 AND  is_market = 1    AND publisher_id = ?  ORDER BY id DESC LIMIT  " . $startRecord . ", " . $limit;; 
        
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
    
?>

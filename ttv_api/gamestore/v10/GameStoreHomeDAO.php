<?php
  
  function getGameAPKHomeView($type_view)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  g.id,g.name,g.description,g.icon,g.banner,g.version_android,g.version_os_android, 
    g.size_android,g.count_android_download,g.count_ios_download,g.count_android_view,g.count_ios_view,g.count_review,g.mark,g.tags,g.create_date,g.category_id,g.publisher_id,g.publisher_name FROM g_game_view v LEFT JOIN  vtc_game_store.g_game g On v.game_id = g.id WHERE  v.type_view = ? AND g.is_android = 1  AND g.status = 1  ORDER BY v.order_view ASC LIMIT  5  ";
        
        $querykey = "KEY" . md5($sql.$type_view);
        $resultCache = $meminstance->get($querykey);
       
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($type_view));
           
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
                 $arr[$i]['count_android_view'] = $arr[$i]['count_android_view']+$arr[$i]['count_ios_view'];
                    $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
                
            $arrResult = array();
                        
            $arrResult["game"] = $arr;
            
            $connect = null;
            return $arrResult;        
        } else {
            $arrResult = array();
                        
            $arrResult["game"] = $resultCache;
            
            return $arrResult;   
        } 
    }
    
    
    function getGameAPKHomeViewMore($type_view)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  g.id,g.name,g.description,g.icon,g.banner,g.version_android,g.version_os_android, 
    g.size_android,g.count_android_download,g.count_ios_download,g.count_android_view,g.count_ios_view,g.count_review,g.mark,g.tags,g.create_date,g.category_id,g.publisher_id,g.publisher_name FROM g_game_view v LEFT JOIN  vtc_game_store.g_game g On v.game_id = g.id WHERE  v.type_view = ? AND g.is_android = 1  AND g.status = 1  ORDER BY v.order_view ASC LIMIT  5,100  ";
        
        $querykey = "KEY" . md5($sql.$type_view);
        $resultCache = $meminstance->get($querykey);
       
       if(!$resultCache){
            $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($type_view));
           
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
                 $arr[$i]['count_android_view'] = $arr[$i]['count_android_view']+$arr[$i]['count_ios_view'];
                    $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
                
            $arrResult = array();
                        
          
            $arrResult["game"] = $arr;
          
            $connect = null;
            return $arrResult;        
        } else {
            $arrResult = array();
           
            $arrResult["game"] = $resultCache;
           
            return $arrResult;   
        } 
    }
    
    
    
     function getGameIOSHomeView($type_view)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        
        $sql = "SELECT  g.id, g.name, g.description, g.icon,g.banner, g.version_ios, g.version_os_ios, 
     g.size_ios, g.count_ios_download, g.count_android_download, g.count_ios_view,g.count_android_view, g.count_review, g.mark,tags, g.create_date, g.category_id, g.publisher_id, g.publisher_name FROM g_game_view v LEFT JOIN  vtc_game_store.g_game g On v.game_id = g.id WHERE  v.type_view = ? AND g.is_ios = 1 AND  g.status = 1   ORDER BY v.order_view ASC LIMIT 5  " ; 
       
       $querykey = "KEY" . md5($sql.$type_view);
       $resultCache = $meminstance->get($querykey);
      
       if(!$resultCache){
           $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($type_view));
           
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
                
                 $arr[$i]['count_ios_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download'];  
                 $arr[$i]['count_ios_view'] = $arr[$i]['count_android_view']+$arr[$i]['count_ios_view'];
                 
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $arrResult["game"] = $arr;
           
            $connect = null;
            return $arrResult;   
        }else{
            $arrResult = array();
       
            $arrResult["game"] = $resultCache;
          
            return $arrResult;   
        }
    }
    
    
     function getGameIOSHomeViewMore($type_view)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $sql = "SELECT  g.id, g.name, g.description, g.icon,g.banner, g.version_ios, g.version_os_ios, 
     g.size_ios, g.count_ios_download, g.count_android_download, g.count_ios_view,g.count_android_view, g.count_review, g.mark,tags, g.create_date, g.category_id, g.publisher_id, g.publisher_name FROM g_game_view v LEFT JOIN  vtc_game_store.g_game g On v.game_id = g.id WHERE  v.type_view = ? AND g.is_ios = 1 AND  g.status = 1   ORDER BY v.order_view ASC LIMIT 5,100  " ; 
       
       $querykey = "KEY" . md5($sql.$type_view);
       $resultCache = $meminstance->get($querykey);
      
       if(!$resultCache){
           $connect = connectGameStoreDB();
            # creating the statement
            $q = $connect->prepare($sql);
            $q->execute(array($type_view));
           
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
                    
                 $arr[$i]['count_ios_download'] = $arr[$i]['count_android_download']+$arr[$i]['count_ios_download']; 
                 $arr[$i]['count_ios_view'] = $arr[$i]['count_android_view']+$arr[$i]['count_ios_view']; 
                 $i++;
            }
            
            $meminstance->set($querykey, $arr, 0, TIME_15);
            
            $arrResult = array();
                        
            $arrResult["game"] = $arr;
              
            $connect = null;
            return $arrResult;   
        }else{
            $arrResult = array();
       
            $arrResult["game"] = $resultCache;
         
            return $arrResult;   
        }
    }
    
?>

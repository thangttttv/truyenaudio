<?php
 date_default_timezone_set('Asia/Saigon');   
  function getCategory($appId,$type)
    {
        $sql = "SELECT id,name,code,picture,create_date FROM c_category WHERE status = 1 AND type=".$type." AND ".$appId." & app_ids = ".$appId." ORDER BY id ASC"; 
        $result = @mysql_query($sql);    
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
         $arr = array();
        foreach($rows as $key =>$value){
            $value['picture'] = "http://kenhkiemtien.com/upload/category/".date("Y/md",$value['create_date'])."/".$value['picture'];
            $arr[$key] = $value;
        }
        
        mysql_free_result($result);   
        return $arr;   
    }  
    
    function getCategoryApple($appId,$type)
    {
        $sql = "SELECT id,name,code,picture,create_date FROM c_category WHERE id NOT IN (34,37,38) AND status = 1 AND type=".$type." AND ".$appId." & app_ids = ".$appId." ORDER BY id ASC"; 
        $result = @mysql_query($sql);    
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
         $arr = array();
        foreach($rows as $key =>$value){
            $value['picture'] = "http://kenhkiemtien.com/upload/category/".date("Y/md",$value['create_date'])."/".$value['picture'];
            $arr[$key] = $value;
        }
        
         mysql_free_result($result);   
        return $arr;   
    } 
    
     function getCategoryGooglePlay($appId,$type)
    {
        $sql = "SELECT id,name,code,picture,create_date FROM c_category WHERE id NOT IN (34) AND status = 1 AND type=".$type." AND ".$appId." & app_ids = ".$appId."  UNION  SELECT id,NAME,CODE,picture,create_date FROM c_category WHERE id in (40,43) ORDER BY id ASC"; 
        $result = @mysql_query($sql);  
       // echo $sql;  
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
         $arr = array();
        foreach($rows as $key =>$value){
            $value['picture'] = "http://kenhkiemtien.com/upload/category/".date("Y/md",$value['create_date'])."/".$value['picture'];
            $arr[$key] = $value;
        }
        
         mysql_free_result($result);   
        return $arr;   
    }  
     
    
    
    function getCategoryF8($appId,$type)
    {
        date_default_timezone_set('Asia/Saigon');    
        $hour = date('H', time());
        if(18> intval($hour) &&  intval($hour) > 7) {
            $sql = "SELECT id,name,code,picture,create_date FROM c_category WHERE (id NOT IN (34)  AND status = 1 AND type=".$type." AND ".$appId." & app_ids = ".$appId.")  ORDER BY id ASC";      
        } else{
             $sql = "SELECT id,name,code,picture,create_date FROM c_category WHERE ( status = 1 AND type=".$type." AND ".$appId." & app_ids = ".$appId.")  ORDER BY id ASC";  
        }
        
        $result = @mysql_query($sql);    
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
         $arr = array();
        foreach($rows as $key =>$value){
            $value['picture'] = "http://kenhkiemtien.com/upload/category/".date("Y/md",$value['create_date'])."/".$value['picture'];
            $arr[$key] = $value;
        }
        
        mysql_free_result($result);   
        return $arr;   
    }  
    
?>

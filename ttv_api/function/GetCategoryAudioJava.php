<?php
  function getCategoryJava($appId,$type)
    {
        $sql = "SELECT id,name,picture,create_date FROM c_category WHERE status = 1 AND type=".$type." AND ".$appId." & app_ids = ".$appId; 
        $result = @mysql_query($sql);    
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
         $arr = array();
        foreach($rows as $key =>$value){
            $value['picture'] = "http://kenhkiemtien.com/upload/category/".date("Y/md",$value['create_date'])."/m_".$value['picture'];
            $arr[$key] = $value;
        }
        
        mysql_free_result($result);   
        return $arr;   
    }  
    
?>

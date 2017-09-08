<?php
  function getContentDetailAudio($content_id,$appId)
    {   $sql1 ="SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,description,price,create_date FROM c_story_audio WHERE id=".$content_id." AND ".$appId." & app_ids = ".$appId ;
        $result1 = @mysql_query($sql1);    
        $arrs  = @mysql_fetch_assoc($result1);
        
        
        $sql = "SELECT *  FROM c_story_audio_file WHERE story_audio_id=".$content_id." ORDER BY id ASC"; 
        $result = @mysql_query($sql);  
        $rows = array();  
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
        
        mysql_free_result($result);  
        mysql_free_result($result1);  
        return array($arrs,$rows);
    }  
?>

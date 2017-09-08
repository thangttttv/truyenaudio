<?php
  function getContentDetailAudioJava($content_id,$appId,$page,$limit)
    {   
        $startRecord = ($page - 1) * $limit;
        $sql1 ="SELECT * FROM c_story_audio WHERE id=".$content_id." AND ".$appId." & app_ids = ".$appId ;
        $result1 = @mysql_query($sql1);    
        $arrs  = @mysql_fetch_assoc($result1);
        
        
        $sql2 = "SELECT count(id) as count FROM c_story_audio_file  WHERE story_audio_id=".$content_id; 
        $result2 = @mysql_query($sql2);
        $count =@mysql_fetch_assoc($result2);
        $max_page = ceil(intval($count["count"])/$limit);
        
        $sql = "SELECT * FROM c_story_audio_file WHERE story_audio_id=".$content_id . "  LIMIT " . $startRecord . ", " . $limit; 
        $result = @mysql_query($sql);  
        $rows = array();  
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
       
        mysql_free_result($result1);  
        mysql_free_result($result2);  
        mysql_free_result($result);  
          
        return array($arrs,$rows,$max_page);
    }  
?>

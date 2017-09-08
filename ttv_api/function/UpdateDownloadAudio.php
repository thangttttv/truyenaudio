<?php
   function updateDownload($content_id)
    {   $sql1 = "SELECT c_download FROM c_story_audio    WHERE id=".$content_id; 
        $result1 = @mysql_query($sql1);    
        $download = @mysql_fetch_assoc($result1);
        $download = $download['c_download'];
        $download +=1;
        
        $sql = "UPDATE c_story_audio SET c_download=".$download." WHERE id=".$content_id; 
        $result = @mysql_query($sql);    
        return $result;
    }  
?>

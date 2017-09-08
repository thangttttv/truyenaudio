<?php
  function updateListen($content_id)
    {   $sql1 = "SELECT c_listen FROM c_story_audio    WHERE id=".$content_id; 
        $result1 = @mysql_query($sql1);    
        $listen = @mysql_fetch_assoc($result1);
        $listen = $listen['c_listen'];
        $listen +=1;
        
        $sql = "UPDATE c_story_audio SET c_listen=".$listen." WHERE id=".$content_id; 
        $result = @mysql_query($sql);

        return $result;
    }  
?>

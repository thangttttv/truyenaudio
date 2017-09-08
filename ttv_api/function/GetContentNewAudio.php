<?php

    function getContentNewAudio($appId,$limit)
    {
        $sql = "SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,create_date FROM c_story_audio WHERE ".$appId." & app_ids = ".$appId." AND status=1 ORDER BY create_date DESC LIMIT ".$limit;   
        $result = @mysql_query($sql);   
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
        $arr = array();
        foreach($rows as $key =>$value){
            $value['image'] = "http://kenhkiemtien.com/upload/audio/".date("Y/md",$value['create_date'])."/m_".$value['image'];
            $arr[$key] = $value;
        }
        
        
        mysql_free_result($result);
        
        return $arr;
    }    

    
?>
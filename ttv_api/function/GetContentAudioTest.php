<?php
 function getContentAudioTest($catId, $page, $limit,$orderBy,$appId)
    {
        $startRecord = ($page - 1) * $limit;
        
        $sql3 = "SELECT code FROM c_category WHERE id=".$catId;
        $result3 = @mysql_query($sql3);
        $code= $count =@mysql_fetch_array($result3);
        
        
        $sql1 = "SELECT story_audio_id FROM c_category_story_audio WHERE cat_id=".$catId;
        $result1 = @mysql_query($sql1);
        $arrs = array();
        while($arr = @mysql_fetch_assoc($result1)){
            $arrs[] = $arr;
        }
        $arr_audio_id ="0";
        foreach($arrs as $key =>$value){
            $arr_audio_id=$arr_audio_id.",".$value['story_audio_id'];
        }
        $condition="";
        if(!empty($arrs)){
            $condition.=" AND id IN(".$arr_audio_id.")";
        }
        $condition.=" AND ".$appId." & app_ids = ".$appId;
        if(!empty($orderBy)){
            $condition.=" ORDER BY ".$orderBy." DESC ";
        } else{
            $condition.=" ORDER BY id DESC ";
        }
        
        $sql2 = "SELECT count(id) as count FROM c_story_audio WHERE 1 AND status = 1 " . $condition ;
        $result2 = @mysql_query($sql2);
        $count =@mysql_fetch_assoc($result2);
        $max_page = ceil(intval($count["count"])/$limit);
        
        $sql = "SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,create_date FROM c_story_audio WHERE 1 AND status = 1 " . $condition . "  LIMIT " . $startRecord . ", " . $limit;
        $result = @mysql_query($sql);
        $rows = array();
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
        
        /*mysql_free_result($result);
        mysql_free_result($result3);  
        mysql_free_result($result2);  
        mysql_free_result($result1);  
        */
        return array($rows,$max_page,$code[0]);   
        
    }
?>

<?php
  function getSearchAudioTest($catId, $page, $limit,$keyword,$appId)
    {
        $limit = intval($limit);
        $limit = $limit>100?100:$limit;
        $limit = $limit<=0?10:$limit;
        
        $startRecord = ($page - 1) * $limit;
        $arrs = array();
        $sql1 = "SELECT story_audio_id FROM c_category_story_audio WHERE cat_id=".$catId;
        $result1 = @mysql_query($sql1);
        while($arr = @mysql_fetch_assoc($result1)){
            $arrs[] = $arr;
        }
        $arr_audio_id ="0";
        foreach($arrs as $key =>$value){
            $arr_audio_id=$arr_audio_id.",".$value['story_audio_id'];
        }
        $condition="";
        $str_sql =" ORDER BY create_date DESC";
        if(!empty($arrs)){
            $condition.=" AND id IN(".$arr_audio_id.")";
        }
        $condition.=" AND ".$appId." & app_ids = ".$appId;
        if(!empty($keyword)){
            $condition.=" AND title_no_sign LIKE '%".$keyword."%' ";
        }
        $sql2 = "SELECT count(id) as count FROM c_story_audio WHERE 1 " . $condition ;
        $result2 = @mysql_query($sql2);
        $count =@mysql_fetch_assoc($result2);
        $max_page = ceil(intval($count["count"])/$limit);
        
        $sql = "SELECT id,title,author,image,reader,c_listen,c_chapter,c_download,create_date  FROM c_story_audio WHERE 1 " . $condition .$str_sql. "  LIMIT " . $startRecord . ", " . $limit;
        $result = @mysql_query($sql);
        $rows = array();
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
        return array($rows,$max_page);   
        
    }
?>

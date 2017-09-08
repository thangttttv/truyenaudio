<?php
    function getAudioNew($limit,$page)
    {   
        $startRecord = ($page - 1) * $limit;
        $sql3 = "SELECT count(id) as count FROM c_story_audio" ;
        $result3 = @mysql_query($sql3);
        $count =@mysql_fetch_assoc($result3);
        $max_page = ceil(intval($count["count"])/$limit);

        $sql = "SELECT id,title,author,image,c_chapter,description,create_date FROM c_story_audio ORDER BY create_date DESC LIMIT ". $startRecord . ", " . $limit;
        $result = @mysql_query($sql);   
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
        $arr = array();
        foreach($rows as $key =>$value){
            $value['image'] = "http://kenhkiemtien.com/upload/audio/".date("Y/md",$value['create_date'])."/m_".$value['image'];
            $arr[$key] = $value;
            $sql2="SELECT file FROM c_story_audio_file WHERE story_audio_id =".$value['id']." LIMIT 1 "; 
            $result2 = @mysql_query($sql2);   
            $file_audio =  @mysql_fetch_assoc($result2);
            $arr[$key]['file'] = "http://kenhkiemtien.com/upload/audio/".date("Y/md",$value['create_date'])."/".$file_audio['file'];

        }

        mysql_free_result($result3);
        mysql_free_result($result);
        mysql_free_result($result2);
        
        return array($arr,$max_page) ;
    }
    function getVideoNew($limit,$page,$cat){
        $startRecord = ($page - 1) * $limit;
        $condition ="";
        if(!empty($cat)){
            $condition.= " AND categoryId =".$cat ;
        }else{
            $condition.="";
        }
        $sql = "SELECT count(id) as count FROM c_video WHERE 1 ".$condition ;
        $result = @mysql_query($sql);
        $count =@mysql_fetch_assoc($result);
        $max_page = ceil(intval($count["count"])/$limit);

        $sql1 = "SELECT id,categoryId,title,picture,picture_240_320,picture_320_240,introtext,file,file_mp4,create_date FROM c_video WHERE 1 ".$condition." ORDER BY create_date DESC LIMIT ". $startRecord . ", " . $limit;
        $result1 = @mysql_query($sql1);   
        while($row1 = @mysql_fetch_assoc($result1)){
            $rows1[] = $row1;
        }
        $arr1 = array();
        foreach($rows1 as $key =>$value){
            $value['picture'] = "http://kenhkiemtien.com/upload/video/".date("Y/md",$value['create_date'])."/".$value['picture'];
            $value['picture_240_320'] = "http://kenhkiemtien.com/upload/video/".date("Y/md",$value['create_date'])."/".$value['picture_240_320'];
            $value['picture_320_240'] = "http://kenhkiemtien.com/upload/video/".date("Y/md",$value['create_date'])."/".$value['picture_320_240'];
            $value['file'] = "http://kenhkiemtien.com/upload/video/".date("Y/md",$value['create_date'])."/".$value['file'];
            $value['file_mp4'] = "http://kenhkiemtien.com/upload/video/".date("Y/md",$value['create_date'])."/".$value['file_mp4'];
            $arr1[$key] = $value;
        }
        
        
        mysql_free_result($result);
        mysql_free_result($result2);
        
        return array($arr1,$max_page) ;
    }
    function getCategory(){
        $sql = "SELECT id,name FROM c_category WHERE type = 2";   
        $result = @mysql_query($sql);   
        while($row = @mysql_fetch_assoc($result)){
            $rows[] = $row;
        }
        
        mysql_free_result($result);
        return $rows;
    }
?>

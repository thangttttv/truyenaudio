<?php
    function getCategoryCode($storyId)
    {   
        $sql2 = "SELECT cat_id FROM c_category_story_audio WHERE story_audio_id=".$storyId;
        $result2 = @mysql_query($sql2);   
        while($arr = @mysql_fetch_assoc($result2)){
            $arrs[] = $arr;
        }
        $arrCat= "0";
        foreach($arrs as $key =>$value){
            $arrCat=$arrCat.",".$value['cat_id'];
        }

        $sql3 = "SELECT code,name FROM c_category WHERE id IN(".$arrCat.")";
        $result3 = @mysql_query($sql3);
        while($row = @mysql_fetch_assoc($result3)){
            $code[] = $row;
        }
        
        mysql_free_result($result2);   
        mysql_free_result($result3);   
        return $code;
    }
    function checkPayment($username)
    {   
        $arr = explode("-",$username);
        $userId = $arr[1];
        $usernameALL = "ALL-".$userId;
        $sql2 = "SELECT SUM(STATUS) FROM asm_users_f8m WHERE( username='$username' OR username='$usernameALL')";
        $result2 = @mysql_query($sql2);   
        $status = @mysql_fetch_row($result2);
        
        mysql_free_result($result2);   
        
        return $status[0];
    }
    function checkCatCodeActive($username)
    {   
        $arr = explode("-",$username);
        $userId = $arr[1];
        $sql2 = "SELECT username FROM asm_users_f8m WHERE username LIKE '%-".$userId."' AND status = 1";
        $result2 = @mysql_query($sql2);   
        while($row = @mysql_fetch_assoc($result2)){
            $status[] = $row;
        }
        $activeCat = "";
        foreach ($status as $key=>$value){
            $arr= explode("-",$value['username']);
            $catCode = $arr[0];
            $activeCat.=",".$catCode;
        }
        
        mysql_free_result($result2);   
        return ltrim($activeCat,",");
    }
?>

<?php
   define("TIME_15", 900);
   define("TIME_30", 1800);
   define("ROOT_UPLOAD","/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/upload");
   
   function connectGameStoreDB(){
        include('BongDaConfig.php');
        $mode="development";
        $config = $config[$mode];
        
        // Create a connection to the database.
        $connect = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], 
            $config['db']['username'], 
            $config['db']['password'],
            array());

        // If there is an error executing database queries, we want PDO to
        // throw an exception.
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // We want the database to handle all strings as UTF-8.
        $connect->query('SET NAMES utf8');
        return  $connect;
   }
   
    function saveSmsLog($request_id,$phone,$shortcode,$sms,$mt,$status)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "INSERT INTO fb_sms_log (request_id,phone,shortcode,sms,mt,create_date,status) VALUES (?,?,?,?,?,NOW(),?)";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($request_id,$phone,$shortcode,$sms,$mt,$status);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }  
    
    function updateSmsLog($request_id,$phone,$shortcode,$sms,$mt,$status)
    {   
        $count = 0;
        try{
            $connect = connectGameStoreDB();
            $sql = "Update  fb_sms_log SET phone=?,shortcode=?,sms=?,mt=?,status=? Where request_id = ? ";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($phone,$shortcode,$sms,$mt,$status,$request_id);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }   
    
    function checkSMSLog($request_id)
    {
        $request_id = intval($request_id);
        $sql = "SELECT id FROM fb_sms_log WHERE request_id = $request_id   "; 
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $kq=0;  
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             
        }
        $connect = NULL;
       // echo "kq".$kq;
        return $kq;
    }
    
    
   function getLTDByCup($cup_id)
    {
        $cup_id = intval($cup_id);
        $sql = "SELECT ROUND,club_id_1,club_id_2,club_code_1,club_code_2,stadium,result,result_1,STATUS,match_time,match_minute,DATE_FORMAT(match_time,\"%d/%m\") AS match_day,DATE_FORMAT(match_time,\"%H:%i\") AS match_min  FROM fb_match WHERE cup_id = ".$cup_id." AND match_time >= CURRENT_TIMESTAMP ORDER BY match_time "; 
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getLTDByClub($club_id)
    {
        $club_id = intval($club_id);
        $sql = "SELECT ROUND,club_id_1,club_id_2,club_code_1,club_code_2,stadium,result,result_1,STATUS,match_time,match_minute,DATE_FORMAT(match_time,\"%d/%m\") AS match_day,DATE_FORMAT(match_time,\"%H:%i\") AS match_min  FROM fb_match WHERE (club_id_1 = ".$club_id." OR club_id_2 = ".$club_id.")  AND match_time >= CURRENT_TIMESTAMP ORDER BY match_time Limit 5 "; 
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getKQByCup($cup_id)
    {
        $cup_id = intval($cup_id);
        $sql = "SELECT cup_id,ROUND,club_id_1,club_id_2,club_code_1,club_code_2,result,STATUS,match_minute FROM fb_match WHERE cup_id = $cup_id AND match_time < DATE_ADD(NOW(),INTERVAL 1 DAY) ORDER BY match_time DESC   "; 
       
       // echo $sql;
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function filterLTDByCup($arrKQ){
        $arrKQEcho = array();
        
        if(!empty($arrKQ)){
            $i = 0;$vong_dau = "";
            
            while($i<count($arrKQ)){
                if($i==0)
                $vong_dau = $arrKQ[$i]["ROUND"];
               
                if(strcasecmp($vong_dau,$arrKQ[$i]["ROUND"])!=0) break;
                $arrKQEcho [$i]=$arrKQ[$i];
                $i++;
            }
            
        }
        return $arrKQEcho;
    }
    
    function filterKQByCup($arrKQ){
        $arrKQEcho = array();
        
        if(!empty($arrKQ)){
            $i = 0;$vong_dau = "";
            
            while($i<count($arrKQ)){
                if($i==0)
                $vong_dau = $arrKQ[$i]["ROUND"];
                if(strcasecmp($vong_dau,$arrKQ[$i]["ROUND"])!=0) break;
                 $arrKQEcho [$i]=$arrKQ[$i];
                $i++;
            }
            
        }
        return $arrKQEcho;
    }
    
    
    function getCupByCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_cup WHERE CODE = UPPER('".$code."') "; 
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function getCupLikeCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_cup WHERE CODE = UPPER('".$code."') OR refe LIKE  '%,".$code.",%' Limit 1 "; 
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        
        $connect = NULL;
        return $arr;
    }
    
    
    function getClubLikeCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_club WHERE CODE = UPPER('".$code."') OR refe LIKE  '%,".$code.",%' Limit 1 "; 
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        
        $connect = NULL;
        return $arr;
    }
    
     function getClubByCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_club WHERE CODE = UPPER('".$code."') "; 
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        $connect = NULL;
        return $arr;
    }
    
    function getClubByCodeOrName($club)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_club WHERE CODE = UPPER('".$club."') or name like \"%".$club."%\" "; 
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getMatchLatestBy($code)
    {
        $code = trim($code);
        $sql = "SELECT id,cup_id,ROUND,club_id_1,club_id_2,club_code_1,club_code_2,result,result_1,STATUS,match_minute FROM fb_match WHERE   (club_code_1 = UPPER('".$code."') OR club_code_2 = UPPER('".$code."') ) AND (STATUS = \"LIVE\" OR STATUS = \"HT\" OR STATUS = \"FT\" ) ORDER BY match_time DESC LIMIT 1 "; 
      
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        $connect = NULL;
        return $arr;
    }
    
    function getTyLeByMatchId($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT * FROM fb_tyle WHERE match_id = ".$match_id; 
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getThongKeByMatchId($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT * FROM fb_match_statistics WHERE match_id = ".$match_id; 
        
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
           
        }
        $connect = NULL;
        return $arr;
    }
    
    
     function getTyleByCupIDAndDate($cupId,$date)
    {
        $cupId = intval($cupId);
        $sql = "SELECT m.club_code_1,m.club_code_2,t.chau_a_tt_catran,t.chau_a_tt_bt,t.chau_a_catran,t.chau_a_bt_catran FROM fb_tyle t INNER JOIN fb_match m ON t.match_id = m.id WHERE t.match_id IN (SELECT id FROM fb_match WHERE cup_id = ".$cupId." AND DATE_FORMAT(match_time,\"%Y-%m\") = \"".$date."\") AND (t.chau_a_tt_catran IS NOT NULL OR t.chau_a_tt_bt IS NOT NULL  OR t.chau_a_catran IS NOT NULL OR t.chau_a_bt_catran IS NOT NULL) ORDER BY t.id DESC LIMIT 10 ";
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i = 0;
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $i++;
        }
        
        $connect = NULL;
        return $arr;
    }
    
    
    function getBXHByCupAndSeason($cupId,$season)
    {
        $cupId = intval($cupId);
        $sql = "SELECT rate,club_id,CODE,NAME,so_tran,so_tran_thang,so_tran_hoa,so_tran_bai,ban_thang,ban_bai,hieu_so,diem FROM fb_charts WHERE cup_id = $cupId AND season = \"".$season."\"  ORDER BY rate ASC ";
       
        # creating the statement
        $connect = connectGameStoreDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i = 0;
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $i++;
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function outSMSContentLTD($arrLTD,$ktXuongDong){
        $outContent = "";
        $i = 0;$day = "";
        $day = $arrLTD[0]["match_day"];
        $outContent = $day;
        while($i<count($arrLTD)){
            //$day = $arrLTD[$i]["match_day"];
            //echo $day;
            if(strcasecmp($day,$arrLTD[$i]["match_day"])==0){
                $outContent .= " ".$arrLTD[$i]["match_min"] ." ".$arrLTD[$i]["club_code_1"] ."-".$arrLTD[$i]["club_code_2"].$ktXuongDong  ;
            }else{
                $day = $arrLTD[$i]["match_day"];
                $outContent .=" ".$day." ".$arrLTD[$i]["match_min"] ." ".$arrLTD[$i]["club_code_1"] ."-".$arrLTD[$i]["club_code_2"].$ktXuongDong  ; 
            }
            $i++;
        }
       return  $outContent;
    }
    
    function outSMSContentKQ($arrKQ,$ktXuongDong){
        $outContent = "";
        $i = 0;
       
        while($i<count($arrKQ)){
            $minute = empty($arrKQ[$i]["match_minute"])?" ":$arrKQ[$i]["match_minute"];
            
            $arrKQ[$i]["result"] = preg_replace ("/\s{1,}/", "", $arrKQ[$i]["result"]);
            $outContent .=" ".$minute." ".$arrKQ[$i]["club_code_1"] ." ".$arrKQ[$i]["result"] ." ".$arrKQ[$i]["club_code_2"].$ktXuongDong  ;
           $i++;
        }
       return  $outContent;
    }
    
    function outSMSContentKQClub($match,$tyle,$thongke,$ktXuongDong){
        $outContent = "";
        $i = 0;
        if(!empty($match)){
            $match["result"] = preg_replace ("/\s{1,}/", "", $match["result"]);
            $outContent = $match["match_minute"]." ".$match["club_code_1"]." ".$match["result"]." ".$match["club_code_2"].$ktXuongDong;
        }
        
        if(!empty($tyle)){
            $strtyle = empty($tyle["chau_a_tt_catran"])?$tyle["chau_a_catran"]:$tyle["chau_a_tt_catran"];
            $taixiu = empty($tyle["chau_a_tt_bt"])?$tyle["chau_a_bt_catran"]:$tyle["chau_a_tt_bt"];
            
            if(!empty($tyle)&&!empty($taixiu))
           // $outContent .= " ".$tyle["chau_a_catran"]." ".$tyle["chau_a_hiep1"].$ktXuongDong;
             $outContent .= " ".$strtyle." ".$taixiu.$ktXuongDong;
        }
        
        if(!empty($match)&&(intval($match["match_minute"])>45||strcasecmp("FT",$match["match_minute"])==0)){
            $match["result_1"] = preg_replace ("/\s{1,}/", "", $match["result_1"]);
            $outContent .= " HT ".$match["result_1"].$ktXuongDong;
        }
        
        if(!empty($thongke)){
            $sut = explode("-",$thongke["goal_attempts"]);
            $sut_on = explode("-",$thongke["shots_on_goal"]);
            $outContent .= " Bong ".$thongke["ball_possession"].$ktXuongDong;
            $outContent .= " Sut ".$sut[0]."(".$sut_on[0].")-"."(".$sut_on[1].")".$sut[1].$ktXuongDong;
            $outContent .= " Goc ".$thongke["corner_kicks"].$ktXuongDong;
            $outContent .= " Loi ".$thongke["fouls"].$ktXuongDong;
            $outContent .= " Tv ".$thongke["yellow_card"].$ktXuongDong;
            $outContent .= " Td ".$thongke["red_card"].$ktXuongDong;
            $outContent .= " Vv ".$thongke["offsides"].$ktXuongDong;
        }
       
       
      
       return  $outContent;
    }
    
    function outSMSContentTyle($arrKQ,$stt,$cup_code,$ktXuongDong){
        $outContent = "";
        $i = 0;
        $sodoi  = 3;
        $i = $stt*$sodoi;
        $to = $stt*$sodoi+$sodoi;
        
        $to = $to>count($arrKQ)?count($arrKQ):$to;
        $soBanTin = floor(count($arrKQ)/$sodoi)+(count($arrKQ)%$sodoi>0?1:0);
        $banTinTiep =($soBanTin-1)>$stt?$stt+1:-1;
       
        while($i<$to){
            $tyle = empty($arrKQ[$i]["chau_a_tt_catran"])?$arrKQ[$i]["chau_a_catran"]:$arrKQ[$i]["chau_a_tt_catran"];
            $taixiu = empty($arrKQ[$i]["chau_a_tt_bt"])?$arrKQ[$i]["chau_a_bt_catran"]:$arrKQ[$i]["chau_a_tt_bt"];
            
            if(!empty($tyle)&&!empty($taixiu))
            $outContent .= $arrKQ[$i]["club_code_1"] ."-".$arrKQ[$i]["club_code_2"]." ".$tyle." ".$taixiu.$ktXuongDong;
           $i++;
        }
        if($banTinTiep!=-1) $outContent .=" Xem Tiep: BD TL".$banTinTiep." ".$cup_code;
       return  $outContent;
    }
    
    
    
    function outSMSContentBXH($arrKQ,$stt,$cup_code,$ktXuongDong){
        $outContent = "";
        $i = $stt*7;
        $to = $stt*7+7;
        $to = $to>count($arrKQ)?count($arrKQ):$to;
        $soBanTin = floor(count($arrKQ)/7)+(count($arrKQ)%7>0?1:0);
        $banTinTiep =($soBanTin-1)>$stt?$stt+1:-1;
       
        while($i<$to){
            $outContent .=" ". $arrKQ[$i]["rate"] .".".$arrKQ[$i]["CODE"]." ".$arrKQ[$i]["diem"]." ".$arrKQ[$i]["so_tran_thang"]." ".$arrKQ[$i]["so_tran_hoa"]." ".$arrKQ[$i]["so_tran_bai"].$ktXuongDong;
           $i++;
        }
       
        if($banTinTiep!=-1) $outContent .=" Xem Tiep Soan: BD BXH".$banTinTiep." ".$cup_code;
       return  $outContent;
    }
    
    function outSMSContentKQ2($arrKQ,$cup_code,$stt,$ktXuongDong){
        $outContent = "";
        $i = 0;
        $outContent = "";
        $i = 0;
        $sodoi  = 6;
        $i = $stt*$sodoi;
        $to = $stt*$sodoi+$sodoi;
        
        $to = $to>count($arrKQ)?count($arrKQ):$to;
        $soBanTin = floor(count($arrKQ)/$sodoi)+(count($arrKQ)%$sodoi>0?1:0);
        $banTinTiep =($soBanTin-1)>$stt?$stt+1:-1;
       
        while($i<$to){
            $minute = empty($arrKQ[$i]["match_minute"])?" ":$arrKQ[$i]["match_minute"];
            
            $arrKQ[$i]["result"] = preg_replace ("/\s{1,}/", "", $arrKQ[$i]["result"]);
            $result =$arrKQ[$i]["result"];
            if(empty($arrKQ[$i]["result"]))$result="-";
            $outContent .=" ".$minute." ".$arrKQ[$i]["club_code_1"] ." ".$result ." ".$arrKQ[$i]["club_code_2"].$ktXuongDong  ;
           $i++;
        }
         if($banTinTiep!=-1) $outContent .=" Xem Tiep: BD KQ".$banTinTiep." ".$cup_code;
       return  $outContent;
    }
   
   
?>

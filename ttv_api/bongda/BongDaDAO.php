<?php
   define("TIME_15", 900);
   define("TIME_30", 1800);
   define("ROOT_UPLOAD","/home/truyenaudi/domains/truyenaudio.mobi/public_html/upload");
  
    function baseUrl(){
        return "http://truyenaudio.mobi/";
    }
   
    function baseUrlUpload()
    {
        return "http://truyenaudio.mobi/upload/";
    }
    
   function connectFBDB(){
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
            $connect = connectFBDB();
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
            $connect = connectFBDB();
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
        $connect = connectFBDB();
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
        $connect = connectFBDB();
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
        $connect = connectFBDB();
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
        $connect = connectFBDB();
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
        $sql = "SELECT * FROM fb_cup WHERE code = UPPER('".$code."') "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function getCupLikeCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_cup WHERE code = UPPER('".$code."') OR refe LIKE  '%,".$code.",%' Limit 1 "; 
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
           
        }
        
        $connect = NULL;
        return $arr;
    }
    
    
    function getClubLikeCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_club WHERE code = UPPER('".$code."') OR refe LIKE  '%,".$code.",%' Limit 1 "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
           
        }
        
        $connect = NULL;
        return $arr;
    }
    
     function getClubByCode($code)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_club WHERE code = UPPER('".$code."') "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
           
        }
        $connect = NULL;
        return $arr;
    }
    
    function getClubByCodeOrName($club)
    {
        $code = trim($code);
        $sql = "SELECT * FROM fb_club WHERE code = UPPER('".$club."') or name like \"%".$club."%\" "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
           
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getMatchLatestBy($code)
    {
        $code = trim($code);
        $sql = "SELECT id,cup_id,ROUND,club_id_1,club_id_2,club_code_1,club_code_2,result,result_1,STATUS,match_minute FROM fb_match WHERE   (club_code_1 = UPPER('".$code."') OR club_code_2 = UPPER('".$code."') ) AND (STATUS = \"LIVE\" OR STATUS = \"HT\" OR STATUS = \"FT\" ) ORDER BY match_time DESC LIMIT 1 "; 
      
        # creating the statement
        $connect = connectFBDB();
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
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array("id"=>0,"match_id"=>0,"chau_a_tt_catran"=>"","chau_a_tt_bt"=>"","chau_a_catran"=>""
        ,"chau_a_hiep1"=>"","chau_au"=>"","chau_a_bt_catran"=>"","chau_a_bt_hiep1"=>"","create_date"=>"");   
       
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
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $arr["match_id"] = $match_id;
        $arr["ball_possession"] = "";
        $arr["goal_attempts"] = "";
        $arr["shots_on_goal"] =  "";
        $arr["shots_off_goal"] =  "";
        $arr["blocked_shots"] =  "";
        $arr["free_kicks"] =  "";
        $arr["corner_kicks"] =  "";
        $arr["offsides"] =  "";
        $arr["throw_in"] =  "";
        $arr["goalkeeper_Saves"] =  "";
        $arr["fouls"] =  "";
        $arr["yellow_card"] =  "";
        $arr["red_card"] =  "";
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
        $connect = connectFBDB();
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
        $sql = "SELECT rate,club_id,code,name,so_tran,so_tran_thang,so_tran_hoa,so_tran_bai,ban_thang,ban_bai,hieu_so,diem FROM fb_charts WHERE cup_id = $cupId AND season = \"".$season."\"  ORDER BY rate ASC ";
       
        # creating the statement
        $connect = connectFBDB();
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
            $outContent .=" ". $arrKQ[$i]["rate"] .".".$arrKQ[$i]["code"]." ".$arrKQ[$i]["diem"]." ".$arrKQ[$i]["so_tran_thang"]." ".$arrKQ[$i]["so_tran_hoa"]." ".$arrKQ[$i]["so_tran_bai"].$ktXuongDong;
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
    
    
    function getMatchByDate($str_date)
    {
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_code_1,m.club_code_2,m.club_name_1,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,c.create_date,c.rate,m.club_redcard_1,m.club_redcard_2,m.had_video  FROM fb_match m   
        LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE  date_format(m.match_time,'%d-%m-%Y') = '".$str_date."' 
        ORDER BY c.rate ASC, m.match_time DESC   "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    function getMatchFavoriteByCup($str_date,$cups)
    {
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_code_1,m.club_code_2,m.club_name_1
        ,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,c.create_date,m.club_redcard_1,m.club_redcard_2,m.had_video  FROM fb_match m   
        LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE  date_format(m.match_time,'%d-%m-%Y') = '".$str_date."' 
        AND m.cup_id in (".$cups.") ORDER BY m.match_time DESC   "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getMatchFavoriteByMatch($str_date,$matchs)
    {
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_code_1,m.club_code_2,m.club_name_1
        ,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,c.create_date,m.club_redcard_1,m.club_redcard_2,m.had_video  FROM fb_match m   
        LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE  date_format(m.match_time,'%d-%m-%Y') = '".$str_date."' 
        AND m.id in (".$matchs.") ORDER BY m.match_time DESC   "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getMatchFavoriteByClub($str_date,$clubs)
    {
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_code_1,m.club_code_2,m.club_name_1
        ,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,c.create_date,m.club_redcard_1,m.club_redcard_2,m.had_video  FROM fb_match m   
        LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE  date_format(m.match_time,'%d-%m-%Y') = '".$str_date."' 
        AND (m.club_id_1 in (".$clubs.") OR m.club_id_2 in (".$clubs.")) ORDER BY m.match_time DESC   "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    

    
    function getClubFavorite($app_client_id)
    {
        $app_client_id= intval($app_client_id);
        $sql = "SELECT club_id FROM fb_club_favorite WHERE app_client_id = ".$app_client_id; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0; $strClubFavorite  ="";
        while($row = $connect->fetch()) {
             $strClubFavorite .= $row["club_id"].",";
             $i++;
        }
        if(!empty($strClubFavorite))$strClubFavorite = substr($strClubFavorite,0,strlen($strClubFavorite)-1);
        $connect = NULL;
        return $strClubFavorite;
    }
    
    
    function getCupFavorite($app_client_id)
    {
        $app_client_id= intval($app_client_id);
        $sql = "SELECT cup_id FROM fb_cup_favorite WHERE app_client_id = ".$app_client_id; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0; $strClubFavorite  ="";
        while($row = $connect->fetch()) {
             $strClubFavorite .= $row["cup_id"].",";
             $i++;
        }
        if(!empty($strClubFavorite))$strClubFavorite = substr($strClubFavorite,0,strlen($strClubFavorite)-1);
        $connect = NULL;
        return $strClubFavorite;
    }
    
    
    function getMatchFavorite($app_client_id)
    {
        $app_client_id= intval($app_client_id);
        $sql = "SELECT match_id FROM fb_match_favorite WHERE app_client_id = ".$app_client_id; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0; $strClubFavorite  ="";
        while($row = $connect->fetch()) {
             $strClubFavorite .= $row["match_id"].",";
             $i++;
        }
        if(!empty($strClubFavorite))$strClubFavorite = substr($strClubFavorite,0,strlen($strClubFavorite)-1);
        $connect = NULL;
        return $strClubFavorite;
    }
    
    
    function getLiveScore()
    {
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_code_1,m.club_code_2
        ,m.club_name_1,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,m.match_time,c.create_date,m.club_redcard_1,m.club_redcard_2,m.had_video 
        FROM fb_match m LEFT JOIN fb_cup c ON m.cup_id = c.id  
        WHERE  m.match_time < NOW() AND m.match_time > DATE_SUB(NOW(),INTERVAL 1 DAY) AND m.status = 'Live' 
        ORDER BY m.match_time DESC   "; 
       
       // echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
               if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    function getTranDau_TuongThuatChiTiet($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT * FROM fb_match_live WHERE match_id = ".$match_id." ORDER BY id DESC"; 
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['img'] = baseUrl().$row['img']; 
            // $arr[$i]['video'] = "";
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
     function getFormationMatch($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT team_1,team_2,formation_1,formation_2 FROM fb_match_team WHERE match_id = ".$match_id; 
       
        # creating the statement
        $connect = connectFBDB();
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
    
    
    function getInfoBXH($cup_id,$club_id)
    {
        $cup_id = intval($cup_id);
        $club_id = intval($club_id);
        $sql = "SELECT * FROM fb_charts WHERE club_id = ".$club_id." AND cup_id =".$cup_id." Order by id DESC limit 1 "; 
       
        # creating the statement
        $connect = connectFBDB();
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
    
    function getInfoBXHByCup($cup_id)
    {
        $cup_id = intval($cup_id);
        
        $sql = "SELECT * FROM fb_charts WHERE cup_id =".$cup_id." Order by id DESC limit 1 "; 
      ;
        # creating the statement
        $connect = connectFBDB();
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
    
    
    function getBXHByCupSeasonAndGroup($cup_id,$season,$group_name_1,$group_name_2)
    {
        $cup_id = intval($cup_id);
      
        if(!empty($group_name))
        $sql = "SELECT * FROM fb_charts WHERE cup_id = ".$cup_id." AND season ='".$season."' AND cup_group = '".$group_name."' Order by rate  "; 
        else 
       $sql = "SELECT * FROM fb_charts WHERE cup_id = ".$cup_id." AND season ='".$season."'  Order by rate  "; 
       
        # creating the statement
        $connect = connectFBDB();
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
    
    function getBXHLoai1($cup_id,$season)
    {
        $cup_id = intval($cup_id);
        $season = cleanQuery($season);
       
       $sql = "SELECT * FROM fb_charts WHERE cup_id = ".$cup_id." AND season ='".$season."'  Order by rate  "; 
       
        # creating the statement
        $connect = connectFBDB();
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
    
    function getListGroupBXH($cup_id,$season)
    {
        $cup_id = intval($cup_id);
        $season = cleanQuery($season);
       
        $sql = "SELECT distinct cup_group FROM fb_charts WHERE cup_id = ".$cup_id." AND season ='".$season."' Order by cup_group "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i = 0;
        while($row = $connect->fetch()) {
             $arr[$i] =  $row["cup_group"];
             $i++;
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function getListGroupBXHByClub($cup_id,$season,$club_id_1,$club_id_2)
    {
        $cup_id = intval($cup_id);
        $season = cleanQuery($season);
       
        $sql = "SELECT distinct cup_group FROM fb_charts WHERE cup_id = ".$cup_id." AND season ='".$season."' AND (club_id=".$club_id_1." OR club_id=".$club_id_2.") Order by cup_group "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i = 0;
        while($row = $connect->fetch()) {
             $arr[$i] =  $row["cup_group"];
             $i++;
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function getBXHLoai2($cup_id,$season,$groups)
    {
        $cup_id = intval($cup_id);
        $season = cleanQuery($season);
       
        $arr = array();   
      
        
       foreach($groups as $group_name){
            $connect = connectFBDB();
             $sql = "SELECT * FROM fb_charts WHERE cup_id = ".$cup_id." AND season ='".$season."' AND cup_group = '".$group_name."' Order by rate  "; 
            
            # creating the statement
            $connect = $connect->query($sql);
             
            # setting the fetch mode
            $connect->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
           
            $i = 0;$arr[$group_name] = array();   
            while($row = $connect->fetch()) {
                 $arr[$group_name][$i] =  $row;
                 $i++;
            }
            $connect = NULL;
       }
     
        $connect = NULL;
        return $arr;
    }
    
    function getClubInfo($club_id)
    {
        $club_id = intval($club_id);
        $sql = "SELECT c.id,c.code,c.name,c.name_en,c.city,c.country,c.country,c.country_en,c.logo,c.stadium,c.stadium_capacity,c.address,c.website,c.fan_page,c.email,c.established_date,c.coach_id,c.map,c.avgage,c.create_date,co.name AS coach_name FROM fb_club c LEFT JOIN fb_coach co ON c.coach_id = co.id WHERE c.id = ".$club_id; 
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo'];
             
           
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getKetQuaClub($club_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT c.name as cup,c.logo,m.id, m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_code_1,m.club_code_2,m.club_name_1,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.result_1,m.status,m.match_minute,m.match_time FROM fb_match m  LEFT JOIN fb_cup c ON m.cup_id = c.id WHERE (m.club_id_1 = ".$club_id." OR m.club_id_2 = ".$club_id." ) 
      And  m.match_time < NOW()  ORDER BY m.match_time DESC  LIMIT " . $startRecord . ", " . $limit; 
       
       // echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    function getLichThiDauClub($club_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_name_1,m.club_name_2,m.club_code_1,m.club_code_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,m.match_time FROM fb_match m LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE (club_id_1 = ".$club_id." OR club_id_2 = ".$club_id." ) AND m.match_time > NOW() ORDER BY m.match_time  LIMIT " . $startRecord . ", " . $limit;  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
              if(!empty($row['club_logo_1']))
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club".$row['club_logo_1']; 
             if(!empty($row['club_logo_2']))
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
    
    function getFootballerByPosition($club_id,$postion)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT id,name,avatar,country,birthday,height,weight,club_id,POSITION,join_date,transfer_free,former_club,
        one_club,conveniently_foot,clubshirtno,create_date FROM fb_footballer WHERE club_id = ".$club_id." AND POSITION = ".$postion; 
       
       // echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['avatar'] = baseUrl()."upload/bongda/footballer/".date("Y/md",strtotime($row['create_date']))."/".$row['avatar'];    
          
             $i++;
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function getFootballerByPositionClub($club_id,$postion)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT f.id,f.name,f.avatar,f.country,f.birthday,f.height,f.weight,f.club_id,f.position,f.join_date,f.transfer_free,f.former_club,f.one_club,f.conveniently_foot,c.clubshirtno,f.create_date FROM fb_footballer f INNER JOIN fb_footballer_club c ON f.id = c.footballer_id WHERE c.status = 1 AND  c.club_id = ".$club_id." AND f.position = ".$postion; 
       
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['avatar'] = baseUrl()."upload/bongda/footballer/".date("Y/md",strtotime($row['create_date']))."/".$row['avatar'];    
          
             $i++;
        }
        
        $connect = NULL;
        return $arr;
    }
    
     function getFootballerDetail($footballer_id)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT f.id,f.name,f.avatar,f.country,f.birthday,f.height,f.weight,f.club_id,f.position,f.join_date,f.transfer_free,f.former_club,f.one_club,f.conveniently_foot,f.clubshirtno,f.create_date,c.name as club_name FROM fb_footballer f LEFT JOIN fb_club  c ON f.club_id = c.id WHERE f.id = ".$footballer_id; 
       
       // echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['avatar'] = baseUrl()."upload/bongda/footballer/".date("Y/md",strtotime($row['create_date']))."/".$row['avatar'];    
         }
        
        $connect = NULL;
        return $arr;
    }
    
    
    function getCoachDetail($coach_id)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT  c.id,c.name,c.name_en,c.birthday,c.height,c.weight,c.joindate,c.avatar_source,c.avatar,c.country,c.formerclub,c.onceclub,c.create_date,cl.name AS club_name FROM vtc_bongda.fb_coach c LEFT JOIN fb_club cl ON c.id = cl.coach_id WHERE c.id = ".$coach_id; 
       
       // echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['avatar'] = baseUrl()."upload/bongda/coach/".date("Y/md",strtotime($row['create_date']))."/".$row['avatar'];    
         }
        
        $connect = NULL;
        return $arr;
    }
    
     function getFootballerByClub($club_id)
    {
        // Tien dao
        $arrKetQua = array();
        $arrKetQua["tiendao"]= getFootballerByPositionClub($club_id,0);
        $arrKetQua["tienve"]= getFootballerByPositionClub($club_id,1);
        $arrKetQua["hauve"]= getFootballerByPositionClub($club_id,2);
        $arrKetQua["thumon"]= getFootballerByPositionClub($club_id,3);
        
        return $arrKetQua;
    }
    
    function getMatchSummary($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT match_id,club_id,m_minute,event 
        FROM vtc_bongda.fb_match_summary Where match_id =  ".$match_id." ORDER BY i_minute DESC"; 
       
        # creating the statement
        $connect = connectFBDB();
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
    
    
    function getMatchDetail($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT cup_id,ROUND,club_id_1,club_id_2,club_code_1,club_code_2,club_name_1,
club_name_2,stadium,referee,coach_name_1,coach_name_2,result,result_1,STATUS,match_time,match_minute,sopcast_link From fb_match Where id =  ".$match_id." "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        $i=0;
        if($row = $connect->fetch()) {
             $arr =  $row;
            
        }
        $connect = NULL;
        return $arr;
    }
    
    function getVideoByMatch($match_id)
    {
        $match_id = intval($match_id);
        $sql = "SELECT id,image,video,create_date From fb_video Where status = 1 AND match_id =  ".$match_id." "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array("id"=>0,"image"=>"","video"=>"","create_date"=>"");   
       
        $i=0;
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['image'] = baseUrl()."upload/bongda/video/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];
            
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getPhongDoDoiBong($club_id)
    {
        $club_id = intval($club_id);
        $sql = "SELECT result From fb_match Where club_id_1 =  ".$club_id." AND STATUS = 'FT' ORDER BY match_time DESC Limit 5 "; 
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $i=0;$strPhongdo="";
        while($row = $connect->fetch()) {
             $arrKq = explode("-",$row["result"]);
             $kq1 = intval(trim($arrKq[0]));
             $kq2 = intval(trim($arrKq[1]));
             if($kq1>$kq2) $strPhongdo.="W,";
             else if($kq1<$kq2) $strPhongdo.="L,";
             else $strPhongdo.="D,";
            
        }
        $connect = NULL;
        return $strPhongdo;
    }
    
    
    function getLichSuDoiDau($club_id_1,$club_id_2)
    {
        $club_id_1 = intval($club_id_1);
        $club_id_2 = intval($club_id_2);
        $sql = "SELECT m.cup_id, c.name AS cup , m.club_id_1, m.club_id_2, m.club_code_1, m.club_code_2, m.club_name_1,
                m.club_name_2, m.result, m.match_time  FROM fb_match m LEFT JOIN fb_cup c ON m.cup_id = c.id 
                    WHERE ((m.club_id_1 = ".$club_id_1." AND m.club_id_2= ".$club_id_2.") OR  (m.club_id_2 = ".$club_id_2." AND m.club_id_1= ".$club_id_1.")) AND m.status = 'FT'"; 
       
        # creating the statement
        $connect = connectFBDB();
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
    
     function getClubDetail($club_id)
    {
        $club_id = intval($club_id);
        $sql = "SELECT id,code,name,city,country,logo,stadium,stadium_capacity,address,website,fan_page,email,established_date,coach_id,avgage,create_date From fb_club Where id =  ".$club_id." "; 
        
        
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
       
        $i=0;
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             
        }
        $connect = NULL;
        return $arr;
    }
    
    
    function getListNewsByClub($club_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT id,title,image,description,author,tags,cup_id,cup_name, 
    club_id,club_name,country,lang_id,count_view,count_like,create_date,create_user FROM fb_news WHERE STATUS = 1 AND club_id = ".$club_id." Order by id DESC LIMIT " . $startRecord . ", " . $limit;
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['image'] = baseUrl()."upload/bongda/news/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];
             $i++;
        }
        
        $sl = countNewsByClub($club_id);
         
        $arrOut = array();
        $arrOut["video"] = $arr;
        $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = NULL;
        return $arrOut;
    }
    
     function getListNewsByCup($cup_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        if($cup_id==0)
        $sql = "SELECT id,title,image,description,author,tags,cup_id,cup_name, 
    club_id,club_name,country,lang_id,count_view,count_like,create_date,create_user FROM fb_news WHERE STATUS = 1  Order by id DESC LIMIT " . $startRecord . ", " . $limit;
        else 
        $sql = "SELECT id,title,image,description,author,tags,cup_id,cup_name, 
    club_id,club_name,country,lang_id,count_view,count_like,create_date,create_user FROM fb_news WHERE STATUS = 1 AND cup_id = ".$cup_id."  Order by id DESC LIMIT " . $startRecord . ", " . $limit;
    
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['image'] = baseUrl()."upload/bongda/news/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];
             $i++;
        }
        
        $sl = countNewsByCup($cup_id);
         
        $arrOut = array();
        $arrOut["list"] = $arr;
        $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = NULL;
        return $arrOut;
    }
    
     function countNewsByCup($cup_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $cup_id = intval($cup_id);
        
        if($cup_id==0)
        $sql = "SELECT count(*) as sl FROM vtc_bongda.fb_news WHERE STATUS = 1 ";
        else
        $sql = "SELECT count(*) as sl FROM vtc_bongda.fb_news WHERE STATUS = 1 AND cup_id = ".$cup_id;  
             
        $querykey = "KEY" . md5($sql);
       
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectFBDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    }  
    
    function countNewsByClub($club_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $club_id = intval($club_id);
        $sql = "SELECT count(*) as sl FROM vtc_bongda.fb_news WHERE STATUS = 1 AND club_id = ".$club_id;  
             
        $querykey = "KEY" . md5($sql);
       
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectFBDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    }  
    
    
     function getNewsDetail($news_id)
    {
        $news_id = intval($news_id);
        $sql = "SELECT id,title,image,description,content,author,tags,cup_id,cup_name, 
    club_id,club_name,country,lang_id,count_view,count_like,create_date,create_user FROM fb_news WHERE id =  ".$news_id;
    
       # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
    
        if($row = $connect->fetch()) {
             $arr =  $row;
             $arr['image'] = baseUrl()."upload/bongda/news/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];
          
        }
        
        $connect = NULL;
        return $arr;
    }
    
    function getListVideoByCup($cup_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        
        if($cup_id==0)  
        $sql = "SELECT id,title,image,video,cup_id,club_id, 
    cup_name,club_name,create_date FROM vtc_bongda.fb_video  WHERE STATUS = 1  Order by id DESC LIMIT " . $startRecord . ", " . $limit;
        else
        $sql = "SELECT id,title,image,video,cup_id,club_id, 
    cup_name,club_name,create_date FROM vtc_bongda.fb_video  WHERE STATUS = 1 AND cup_id = ".$cup_id." Order by id DESC LIMIT " . $startRecord . ", " . $limit;
    
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
              $arr[$i]['image'] = baseUrl()."upload/bongda/video/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];
             
             $i++;
        }
        
        $sl = countVideoByCup($cup_id);
         
        $arrOut = array();
        /*$arrOut["list"] = $arr;
        $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);    */
        
        $arrOut["list"] = array();
        $arrOut["page"] = 1;
        
         
         $connect = NULL;
         
         return $arrOut;
    }
    
     function countVideoByCup($cup_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $cup_id = intval($cup_id);
        
        if($cup_id==0)
        $sql = "SELECT count(*) as sl FROM vtc_bongda.fb_video WHERE STATUS = 1 ";
        else
        $sql = "SELECT count(*) as sl FROM vtc_bongda.fb_video WHERE STATUS = 1 AND cup_id = ".$cup_id;  
             
        $querykey = "KEY" . md5($sql);
       
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectFBDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    }  
    
    
    function countVideoByClub($club_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $club_id = intval($club_id);
        $sql = "SELECT count(*) as sl FROM vtc_bongda.fb_video WHERE STATUS = 1 AND club_id = ".$club_id;  
             
        $querykey = "KEY" . md5($sql);
       
        $sl = $meminstance->get($querykey);
        
        if (!$sl) {
            # creating the statement
            $connect = connectFBDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    }  
    
    function getListVideoByClub($club_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT id,title,image,video,cup_id,club_id, 
    cup_name,club_name,create_date FROM vtc_bongda.fb_video  WHERE STATUS = 1 AND club_id = ".$club_id." Order by id DESC LIMIT " . $startRecord . ", " . $limit;
       
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['image'] = baseUrl()."upload/bongda/video/".date("Y/md",strtotime($row['create_date']))."/".$row['image'];
             
             $i++;
        }
        
        
        $sl = countVideoByClub($club_id);
        $arrOut = array();
        $arrOut["video"] = $arr;
        $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = NULL;
        return $arrOut;
    }
   
    function getVideoDetail($video_id)
    {
        $video_id = intval($video_id);
        $sql = "SELECT id,title,image,video,cup_id,club_id, 
    cup_name,club_name,create_date FROM vtc_bongda.fb_video  WHERE id =  ".$video_id;
    
       # creating the statement
        $connect = connectFBDB();
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
    
     function getAppHeaderBongDa($app_header,$app_client_id,$os_version,$imei){
       $app_header = mysql_escape_string($app_header);
       $app_client_id = mysql_escape_string($app_client_id);
       $os_version = mysql_escape_string($os_version);
       $imei = mysql_escape_string(trim($imei));
       
       $arrKq = array();
       //get app header config 
       $arrAppHeader =  checkAppHeaderBongDa($app_header);
       
       if(empty($arrAppHeader)) return "";
       
       $arrKq["app_header"] = $arrAppHeader;  
       $app_header_id =  $arrAppHeader["id"];
       $os =    $arrAppHeader["os"];     
       // check by app_client_id
       $checkByAppClientID = 0;
       $checkByImei = 0;
       
       if(!empty($app_client_id)&&intval($app_client_id)>0){
           $app_client_id = checkAppClientIdBongDaExist($app_client_id);
       }
       
       if(!empty($imei)&&intval($app_client_id)== 0){
           $app_client_id = checkImeiBongDaExist($imei);
       }
       
       if($app_client_id==0){
           $app_client_id = createAppClientIdBongDa($app_header_id,$arrAppHeader["os"],$os_version,$imei);
           
           if($app_client_id>0)insertDefaultCupFavorite($app_client_id);
          
       }
       
       $arrKq["app_client_id"] = $app_client_id;
       
       return    $arrKq;
   }
   
   
    function checkAppHeaderBongDa($app_header)
    {
        $app_header= cleanQuery($app_header);
        $sql = "SELECT id,app_header,type_payment,os,isFree,sms_mcv,VERSION,link_update,sms,admob_id,admob_id_tg FROM fb_app_header  WHERE app_header = '$app_header'" ;
       
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arrAppHeader = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arrAppHeader =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arrAppHeader;
    }  
    
    function checkAppClientIdBongDaExist($app_client_id)
    {
        $app_client_id= cleanQuery($app_client_id);
        $sql = "SELECT * FROM fb_app_client  WHERE id= '$app_client_id'";
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
       
        $i=0; $kq=0; 
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             $i++;
        }
       
        $connect = NULL;
        return $kq;
    }  
    
    function checkImeiBongDaExist($imei)
    {
        $imei= cleanQuery($imei);
        $sql = "SELECT * FROM fb_app_client  WHERE imei= '$imei'";
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
       
        $i=0; $kq=0; 
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             $i++;
        }
       
        $connect = NULL;
        return $kq;
    } 
    
    
    function createAppClientIdBongDa($app_header_id,$os,$os_version,$imei){
      
       if(empty($imei))
            $sql = "INSERT INTO fb_app_client (os,os_version,app_header_id) VALUES ($os,'$os_version',$app_header_id);";
       else
            $sql = "INSERT INTO fb_app_client (os,os_version,app_header_id,imei) VALUES ($os,'$os_version',$app_header_id,'$imei');";

        $connect = connectFBDB(); 
        $q = $connect->prepare($sql);
        $arrV = array();
      
        $count = $q->execute($arrV);
        $insertId = $connect->lastInsertId();
        $connect = null;
      
        return $insertId;
   }
   
   function insertAppTrackingBongDa($app_header,$app_client_id,$LOGS,$ip)
    {   
        $connect = connectFBDB();
        $sql = "INSERT INTO fb_app_tracking (app_header,app_client_id,LOGS,ip,create_date) VALUES (?,?,?,?,NOW())";
         
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($app_header,$app_client_id,$LOGS,$ip);
        $count = $q->execute($arrV);
       
        $connect = NULL;
        return $count;   
    }
    
     function insertDefaultCupFavorite($app_client_id)
    {   
        $count = 0;
        try{
            $connect = connectFBDB();
            $sql = "INSERT INTO vtc_bongda.fb_cup_favorite (app_client_id,cup_id) VALUES(?,1),(?,2),(?,3),(?,4),(?,5),(?,6)
            ,(?,7),(?,8);";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$app_client_id,$app_client_id,$app_client_id,$app_client_id,$app_client_id,$app_client_id);
            $count = $q->execute($arrV);
           
            $connect = NULL;
        }catch(Exception $e) {
            
        }
        return $count;   
    }
    
    
    
    function registerMemberFB($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$sso_id){
        $insertId = 0;
        try{
            // init user info
            $avatar=baseUrlUpload()."audio/avatar_d.png";
            $username = "fb".$app_client_id.substr(time(),-3);
            $PASSWORD=md5(md5(time()));
           
            $fMobile ="";$vMobile="";
             if(!empty($mobile))
            {
                $fMobile=",mobile";
                $vMobile=",'".$mobile."'";
            }
            
            $fBirthday ="";$vBirthday="";
            if(!IsNullOrEmptyString($birthday))
            {
                $fBirthday =",birthday";
                $vBirthday=",'".$birthday."'";
            }
            
            $sql = "INSERT INTO fb_user (app_client_id, username, PASSWORD, fullname, avatar_url, email,sso_id,create_date,create_user".$fBirthday.$fMobile.")VALUES('$app_client_id','$username','$PASSWORD','$fullname','$avatar','$email','$sso_id',NOW(),'$fullname'".$vBirthday.$vMobile.");";
            
            $connect = connectFBDB(); 
            $q = $connect->prepare($sql);
            $arrV = array();
          
            $count = $q->execute($arrV);
            $insertId = $connect->lastInsertId();
            $connect = null;
            
            //echo $sql;
           

        }catch (Exception $e) {
        }
        return $insertId;  
    }
    
    
    function getUserFBByEmail($email)
    {
       
        $sql ="SELECT * FROM fb_user WHERE email='".$email."'";
        # creating the statement
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arr =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arr;
           
    }
    
    function getUserFBBySSOID($sso_id)
    {
        
        $sql ="SELECT * FROM fb_user WHERE sso_id='".$sso_id."'";
        # creating the statement
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arr =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arr;
           
    }
    
    function getUserFBById($id)
    {
        $id= intval($id);
        $sql = "SELECT * FROM fb_user  WHERE id = '$id'" ;
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arrUser = array();   
        $i=0;  
        if($row = $connect->fetch()) {
             $arrUser =  $row;
             $i++;
        }
       
        $connect = NULL;
        return $arrUser;
    }  
    
    
    function uploadAvatarFB($user_id){
         $uploaddir = '/upload/bongdaavatar/';
         $userInfo = getUserFBById($user_id);
         $avatar_url =$userInfo["avatar_url"];
         
         $arrKQ = array();
        try {
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['upfile']['error']) ||
                is_array($_FILES['upfile']['error']||empty($user_id))
            ) {
                //throw new RuntimeException('Invalid parameters.');
               // throw new RuntimeException('1.');
                $arrKQ["result"]=1;
                $arrKQ["avatar"]=$avatar_url;
                echo json_encode($arrKQ);return;
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    //throw new RuntimeException('No file sent.');
                    $arrKQ["result"]=2;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
                    throw new RuntimeException($exception);
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    //throw new RuntimeException('Exceeded filesize limit.');
                    $arrKQ["result"]=3;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
                    throw new RuntimeException($exception);
                default:
                    //throw new RuntimeException('Unknown errors.');
                    $arrKQ["result"]=100;
                    $arrKQ["avatar"]=$avatar_url;
                    $exception = json_encode($arrKQ);
                    throw new RuntimeException($exception);
            }

            // You should also check filesize here. 
            if ($_FILES['upfile']['size'] > 10000000) {
                $arrKQ["result"]=3;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
                throw new RuntimeException($exception);
            }

            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($_FILES['upfile']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
                //throw new RuntimeException('Invalid file format.');
                $arrKQ["result"]=5;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
                throw new RuntimeException($exception);
            }

            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
             $pathdate = date("Y/md/");
             $file = basename($_FILES['upfile']['name']);
             $file = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $file);
             $file = basename($file, ".".$ext)."-".$user_id.".".$ext;
             $file = sanitize($file,true);
             $pathUrl= $uploaddir.$pathdate;
             $uploaddir = $_SERVER['DOCUMENT_ROOT'].$uploaddir.$pathdate;
             makeFolder($uploaddir);
             $uploadfile =$uploaddir . $file;
           
             if (!move_uploaded_file($_FILES['upfile']['tmp_name'],$uploadfile)) {
                //throw new RuntimeException('Failed to move uploaded file.');
                $arrKQ["result"]=4;
                $arrKQ["avatar"]=$avatar_url;
                $exception = json_encode($arrKQ);
                throw new RuntimeException($exception);
            }else{
                $avatar_url="http://".$_SERVER['SERVER_NAME'].$pathUrl . $file;
                updateAvatarUserFB($user_id,$avatar_url);
            }
            
          
            
            $arrKQ["result"]=0;
            $arrKQ["avatar"]=$avatar_url;
            echo json_encode($arrKQ);

        } catch (RuntimeException $e) {

            $arrKQ["result"]=100;
            $arrKQ["avatar"]=$avatar_url;
            $exception = json_encode($arrKQ);
            throw new RuntimeException($exception);

        }
    }
    
     function updateAvatarUserFB($id,$avatar){
      
        $sql = "Update fb_user SET avatar_url = ? Where id = ?";
      
        $connect = connectFBDB(); 
        $q = $connect->prepare($sql);
        $arrV = array($avatar,$id);
      
        $count = $q->execute($arrV);
        $connect = null;
      
        return $count;
   }
   
   
    function getCommentByMatch($match_id,$page,$limit)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT c.id,c.user_id,c.match_id,c.comment,c.status,c.create_date,u.fullname,u.avatar_url FROM fb_match_comment c INNER JOIN fb_user u ON c.user_id = u.id  WHERE c.match_id = ".$match_id ." ORDER BY c.id  DESC LIMIT " . $startRecord . ", " . $limit;
        $querykey = "KEY.getCommentByMatch.".$audio_id.".".$page;
        $result = $meminstance->get($querykey);
     
        if(1>0){
        //if (!$result) {
            # creating the statement
            $connect = connectFBDB(); 
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
            $meminstance->set($querykey, $arr, 0, TIME_30);
            
            $sl = countCommentByMatch($audio_id);
         
            $arrOut = array();
            $arrOut["comment"] = $arr;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
             
             return $arrOut;
        }else{
           $sl = countCommentByMatch($audio_id);
         
            $arrOut = array();
            $arrOut["comment"] = $result;
            $arrOut["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
            
            return $arrOut;
        }
           
    }
    
    
    function countCommentByMatch($match_id)
    {
        $meminstance = new Memcache();
        $meminstance->pconnect('localhost', 11211);
        $match_id = intval($match_id);
        
        $sql = "SELECT COUNT(*) as sl FROM fb_match_comment WHERE match_id = ".$match_id;
        $querykey = "KEY.countCommentByMatch." . $match_id;
       
        $sl = $meminstance->get($querykey);
        //echo $sql;
        if(1>0){
        //if (!$sl) {
            # creating the statement
            $connect = connectFBDB();
            $q = $connect->prepare($sql);
            $q->execute();
           
            # setting the fetch mode
            $q->setFetchMode(PDO::FETCH_ASSOC);
             
            # showing the results
            $sl = 0;    
            if($row = $q->fetch()) {
                 $sl =  $row["sl"];
                   
            } 
           
             $meminstance->set($querykey, $sl, 0, TIME_15);
             $connect = null;
             return $sl;  
        }else{
            return intval($sl);
        } 
    } 
    
    
    function postCommentMatch($user_id,$match_id,$comment,$create_user)
    {   
        $connect = connectFBDB();
        $sql = "INSERT INTO fb_match_comment (user_id,match_id,COMMENT,create_date,create_user)
    VALUES(?,?,?,NOW(),?);";
        $comment = cleanQuery($comment);
        $create_user = cleanQuery($create_user);
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($user_id,$match_id,$comment,$create_user);
        $count = $q->execute($arrV);
       
        $connect = null;
        return $count;   
    } 
    
     function insertMatchVote($match_id,$club_1_win,$club_2_win,$draws)
    {   
        $connect = connectFBDB();
        $sql = "INSERT INTO vtc_bongda.fb_match_vote (match_id,club_1_win,club_2_win,draws) VALUES (?,?,?,?)";
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($match_id,$club_1_win,$club_2_win,$draws);
        $count = $q->execute($arrV);
        $connect = NULL;
        return $count;   
    }
    
     function updateMatchVoteClub1($match_id,$club_1_win)
    {   
        $count = 0;  
        try{
           $connect = connectFBDB();
            $sql = "UPDATE vtc_bongda.fb_match_vote SET  club_1_win = (SELECT COUNT(*) FROM fb_match_vote_detail WHERE match_id=? AND vote=?)  WHERE match_id = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($match_id,$club_1_win,$match_id);
            $count = $q->execute($arrV);
            $connect = NULL;  
        }catch(Exception $e) {
             $count = 0;
        }
        return $count;   
    }
    
     function updateMatchVoteClub2($match_id,$club_2_win)
    {   
        $count = 0;  
        try{
            $connect = connectFBDB();
            $sql = "UPDATE vtc_bongda.fb_match_vote SET  club_2_win = (SELECT COUNT(*) FROM fb_match_vote_detail WHERE match_id=? AND vote=?)  WHERE match_id = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($match_id,$club_2_win,$match_id);
            $count = $q->execute($arrV);
            $connect = NULL;
         }catch(Exception $e) {
             $count = 0;
        }
        return $count;   
    }
    
    function updateMatchVoteDraws($match_id)
    {   
        $count = 0;  
        try{
            $connect = connectFBDB();
            $sql = "UPDATE vtc_bongda.fb_match_vote SET  draws = (SELECT COUNT(*) FROM fb_match_vote_detail WHERE match_id=? AND vote=0)  WHERE match_id = ?";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($match_id,$match_id);
            $count = $q->execute($arrV);
            $connect = NULL;
        }catch(Exception $e) {
             $count = 0;
        }
        return $count;   
    }
    
    
    function insertMatchVoteDetail($match_id,$user_id,$vote)
    {   
        $count = 0; 
        try{
            $connect = connectFBDB();
            $sql = "INSERT INTO vtc_bongda.fb_match_vote_detail (match_id,user_id,vote) VALUES (?,?,?);";
             
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($match_id,$user_id,$vote);
            $count = $q->execute($arrV);
           
            $connect = NULL;
            
        }catch(Exception $e) {
             $count = 0;
        }
        
        return $count;    
       
    }
    
    
    function getMatchVoteDetail($match_id)
    {
       
        $match_id = intval($match_id);
        $sql = "SELECT * FROM fb_match_vote WHERE match_id = ".$match_id;
        # creating the statement
        $connect = connectFBDB();
        $q = $connect->prepare($sql);
        $q->execute();
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $vote = array("id"=>0,"match_id"=>$match_id,"club_1_win"=>0,"club_2_win"=>0,"draws"=>0);    
        if($row = $q->fetch()) {
             $vote =  $row;
         } 
       
         $connect = null;
         return $vote;  
       
    } 
    
    
     function countTotalVote($match_id)
    {
       
        $match_id = intval($match_id);
        $sql = "SELECT COUNT(*) as sl FROM fb_match_vote_detail WHERE match_id = ".$match_id;
       
       
        # creating the statement
        $connect = connectFBDB();
        $q = $connect->prepare($sql);
        $q->execute();
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $sl = 0;    
        if($row = $q->fetch()) {
             $sl =  $row["sl"];
               
        } 
       
     
         $connect = null;
         return $sl;  
       
    } 
    
    
    function countVoteByclub($match_id,$club_id)
    {
       
        $match_id = intval($match_id);
        $sql = "SELECT COUNT(*) as sl FROM fb_match_vote_detail WHERE  match_id= ".$match_id ." AND vote=".$club_id;
       
       
        # creating the statement
        $connect = connectFBDB();
        $q = $connect->prepare($sql);
        $q->execute();
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $sl = 0;    
        if($row = $q->fetch()) {
             $sl =  $row["sl"];
               
        } 
       
     
         $connect = null;
         return $sl;  
       
    } 
    
    function checkMatchVoteExist($match_id)
    {
        $app_client_id= cleanQuery($app_client_id);
        $sql = "SELECT * FROM fb_match_vote  WHERE match_id= '$match_id'";
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
       
        $i=0; $kq=0; 
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             $i++;
        }
       
        $connect = NULL;
        return $kq;
    }
    
     function checkHadVoteMatch($match_id,$user_id)
    {
        $app_client_id= cleanQuery($app_client_id);
        $sql = "SELECT * FROM fb_match_vote_detail  WHERE match_id= '$match_id' AND user_id=".$user_id;
        $connect = connectFBDB(); 
        $connect = $connect->query($sql); 
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
       
        $i=0; $kq=0; 
        if($row = $connect->fetch()) {
             $kq =  $row["id"];
             $i++;
        }
       
        $connect = NULL;
        return $kq;
    }
    
     function getLichThiDauCup($cup_id)
    {
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_name_1,m.club_name_2,m.club_code_1,m.club_code_2,m.club_name_1,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,m.match_time,c.create_date FROM fb_match m LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE m.cup_id = ".$cup_id." AND m.match_time > DATE_SUB(NOW(),INTERVAL 1 DAY) ORDER BY m.match_time  ";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club/".$row['club_logo_1']; 
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club/".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    
     function getKetQuaCup($cup_id,$page,$limit)
    {
        $startRecord = ($page - 1) * $limit; 
        $sql = "SELECT c.name as cup,c.logo,m.id,m.cup_id,m.round,m.club_id_1,m.club_id_2,m.club_name_1,m.club_name_2,m.club_code_1,m.club_code_2,m.club_name_1,m.club_name_2,m.club_logo_1,m.club_logo_2,m.result,m.status,m.match_minute,m.match_time,c.create_date FROM fb_match m LEFT JOIN fb_cup c ON m.cup_id = c.id  WHERE m.cup_id = ".$cup_id." AND m.match_time < NOW() ORDER BY m.match_time DESC LIMIT " . $startRecord . ", " . $limit; 
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             $arr[$i]['club_logo_1'] = baseUrl()."upload/bongda/club/".$row['club_logo_1']; 
             $arr[$i]['club_logo_2'] = baseUrl()."upload/bongda/club/".$row['club_logo_2']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    function getClubFavortie($app_client_id)
    {
        $app_client_id = intval($app_client_id); 
        $sql = "SELECT c.id,c.code,c.name,c.logo,c.create_date FROM fb_club c INNER JOIN fb_club_favorite f ON c.id = f.club_id Where app_client_id = ".$app_client_id." LIMIT 100;";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo']; 
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
     function getCupFavortie($app_client_id)
    {
        $app_client_id = intval($app_client_id); 
        $sql = "SELECT c.id,c.code,c.name,c.logo,c.country,c.create_date FROM fb_cup c INNER JOIN fb_cup_favorite f ON c.id = f.cup_id WHERE app_client_id =  ".$app_client_id." LIMIT 100;";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo'];   
             $i++;
        }
        $connect = NULL;
        return $arr;
    }
    
    function postClubFavorite($app_client_id,$club_id)
    {   
        $count = 0;
        try{
            $connect = connectFBDB();
            $sql = "INSERT INTO vtc_bongda.fb_club_favorite (app_client_id,club_id) VALUES (?,?);";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$club_id);
            $count = $q->execute($arrV);
            $connect = NULL;
         }catch(Exception $e) {
             $count = 0;
        }
         return $count;   
       
    }
    
     function removeClubFavorite($app_client_id,$club_id)
    {   
        $count = 0;
        try{
            $connect = connectFBDB();
            $sql = "DELETE  FROM vtc_bongda.fb_club_favorite WHERE app_client_id=? AND club_id= ?;";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$club_id);
            $count = $q->execute($arrV);
            $connect = NULL;
         }catch(Exception $e) {
             $count = 0;
        }
         return $count;   
       
    }
    
    function postCupFavorite($app_client_id,$cup_id)
    {   
        $count = 0;
        try{
             $connect = connectFBDB();
            $sql = "INSERT INTO vtc_bongda.fb_cup_favorite (app_client_id,cup_id) VALUES (?,?);";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$cup_id);
            $count = $q->execute($arrV);
            $connect = NULL;
        }catch(Exception $e) {
             $count = 0;
        }
       
        return $count;   
    }
    
    function postMatchFavorite($app_client_id,$match_id)
    {   
        $count = 0;
        try{
             $connect = connectFBDB();
            $sql = "INSERT INTO vtc_bongda.fb_match_favorite (app_client_id,match_id) VALUES (?,?);";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$match_id);
            $count = $q->execute($arrV);
            $connect = NULL;
        }catch(Exception $e) {
             $count = 0;
        }
       
        return $count;   
    }
    
    function removeCupFavorite($app_client_id,$cup_id)
    {   
        $count = 0;
        try{
            $connect = connectFBDB();
            $sql = "DELETE  FROM vtc_bongda.fb_cup_favorite WHERE app_client_id=? AND cup_id= ?;";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$cup_id);
            $count = $q->execute($arrV);
            $connect = NULL;
         }catch(Exception $e) {
             $count = 0;
        }
         return $count;   
       
    }
    
     function removeMatchFavorite($app_client_id,$match_id)
    {   
        $count = 0;
        try{
            $connect = connectFBDB();
            $sql = "DELETE  FROM vtc_bongda.fb_match_favorite WHERE app_client_id=? AND match_id= ?;";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($app_client_id,$match_id);
            $count = $q->execute($arrV);
            $connect = NULL;
         }catch(Exception $e) {
             $count = 0;
        }
         return $count;   
       
    }
    
    
    function checkKeyNotifyFBByAppClient($app_client_id)
    {
        $sql = "SELECT id FROM fb_notice_user WHERE app_client_id = ?" ;
        
        # creating the statement
        $connect = connectFBDB();
        $q = $connect->prepare($sql);
        $q->execute(array($app_client_id));
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $kq = 0;    
        if($row = $q->fetch()) {
             $kq =  1;
               
        } 
       
        $connect = null;
        return $kq;  
       
    } 
    
     function insertNoticeUserFB($app_client_id,$user_id,$device_token,$os_type)
    {
        $count = 0;
        try{
            $connect = connectFBDB();
            $sql = "INSERT INTO fb_notice_user (app_client_id,user_id,device_token,os_type,create_date) 
                     VALUES (:app_client_id,:user_id,:device_token,:os_type,NOW())";
             
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array(':app_client_id'=>$app_client_id,':user_id'=>$user_id,':device_token'=>$device_token,':os_type'=>$os_type));
           
            $connect = null;
        }catch (Exception $e){
            $count = 0;
            
        }
        
        return $count;   
    } 
    
    
    function updateNoticeUserFB($app_client_id,$device_token)
    {
        $count = 0;
        try{
             $connect = connectFBDB();
            $sql = "Update  fb_notice_user Set device_token = ? where  app_client_id = ?  ";
            # creating the statement
            $q = $connect->prepare($sql);
            $count = $q->execute(array($device_token,$app_client_id));
            $connect = null;
        }catch (Exception $e){
            $count = 0;
        }
        
        return $count;   
    } 
    
    function getClubByCountryEn($country_en)
    {
        $country_en = mysql_escape_string($country_en);
        $sql = "SELECT id,code,name,name_en,logo,create_date FROM fb_club WHERE country_en = '".$country_en."' ORDER BY name_en";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             if(!empty($row['logo']))
             $arr[$i]['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo'];  
             else $arr[$i]['logo'] ="";
             $i++;
        }
        $connect = NULL;
        return   $arr;
    } 
    
    
    function getCupByCountryEn($country_en)
    {
        $sql = "SELECT id,code,name,name_en,create_date,logo FROM fb_cup WHERE country_en = '".$country_en."' ORDER BY name_en";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             if(!empty($row['logo']))
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo'];  
             else $arr[$i]['logo'] ="";
             $i++;
        }
        $connect = NULL;
        return   $arr;
    } 
    
     function getFlagCountry($country_en)
    {
         $country_en = mysql_escape_string($country_en);
        $sql = "SELECT flag,create_date FROM fb_country WHERE name_en = '".$country_en."'";  
        
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $flag ="";
        if($row = $connect->fetch()) {
             if(!empty($row["flag"]))
             $flag =  baseUrl()."upload/bongda/country/".date("Y/md",strtotime($row['create_date']))."/".$row["flag"];
        }
       
        $connect = NULL;
        return   $flag;
    } 
    
    function taoFileJSonClub()
    {
        $app_client_id = intval($app_client_id); 
        $sql = "SELECT id,code,name,name_en,logo,create_date FROM fb_club WHERE (name_en !='' AND name_en IS NOT NULL)   ORDER BY name_en";  
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/club/".date("Y/md",strtotime($row['create_date']))."/".$row['logo'];   
             $i++;
        }
        $connect = NULL;
          
        $file = dirname(__FILE__).'/ClubJSON.txt';
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        // Write the contents back to the file
        file_put_contents($file, json_encode ( $arr ),LOCK_EX);
    
        
        return   $arr;
    }
    
    function taoFileJSonCup()
    {
        $app_client_id = intval($app_client_id); 
        $sql = "SELECT id,code,name,name_en,logo,create_date FROM fb_cup WHERE (name_en !='' AND name_en IS NOT NULL)   ORDER BY name_en";  
        # creating the statement
        $connect = connectFBDB();
        $connect = $connect->query($sql);
         
        # setting the fetch mode
        $connect->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $connect->fetch()) {
             $arr[$i] =  $row;
             $arr[$i]['logo'] = baseUrl()."upload/bongda/cup/".date("Y/md",strtotime($row['create_date']))."/".$row['logo'];   
             $i++;
        }
        $connect = NULL;
          
        $file = dirname(__FILE__).'/CupJSON.txt';
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        // Write the contents back to the file
        file_put_contents($file, json_encode ( $arr ),LOCK_EX);
    
        
        return   $arr;
    }  
    
    function getCountryClubSortAlphabet()
    {
        $app_client_id = intval($app_client_id); 
        $sql = "SELECT DISTINCT country_en,SUBSTR(country_en,1,1) AS ccd FROM fb_club WHERE country_en !=''  ORDER BY ccd";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
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
        
        $arrCCD = array();
        $arrCountry  = array(); 
        $ccd = $arr[0]["ccd"];  

        $arrClubTesst = getClubByCountryEn("Africa");
        $arrGroupClub  = array();   
        foreach($arr as $country) {
            if(strcmp($ccd,$country["ccd"])==0) {
                  $arrCountry["club"][$country["country_en"]]= getClubByCountryEn($country["country_en"]); 
                  $flag =  getFlagCountry($country["country_en"]);
                  $arrCountry["flag"][$country["country_en"]]= $flag;
                  $arrCCD[$ccd]  =   $arrCountry;
               
            } else{
                   $ccd = $country["ccd"];
                  $arrCountry  = array(); 
                  $arrCountry["club"][$country["country_en"]]= getClubByCountryEn($country["country_en"]);
                  $flag =  getFlagCountry($country["country_en"]);
                  $arrCountry["flag"][$country["country_en"]]= $flag;
                  $arrCCD[$ccd]  =   $arrCountry;
                
            }
        } 
      
        //var_dump($arrCCD);die;
        $file = dirname(__FILE__).'/ClubGroupByCountryJSON.txt';
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        // Write the contents back to the file
        file_put_contents($file, json_encode ( $arrCCD ),LOCK_EX);
    
        return $arrCCD;
    }
    
    
    function getCountryCupSortAlphabet()
    {
        $app_client_id = intval($app_client_id); 
        $sql = "SELECT DISTINCT country_en,SUBSTR(country_en,1,1) AS ccd FROM fb_cup WHERE country_en !=''  ORDER BY ccd";  
        //echo $sql;
        # creating the statement
        $connect = connectFBDB();
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
        
        $arrCCD = array();
        $arrCountry  = array(); 
        $ccd = $arr[0]["ccd"];  

        $arrClubTesst = array();
        $arrGroupClub  = array();   
        foreach($arr as $country) {
            if(strcmp($ccd,$country["ccd"])==0) {
                  $arrCountry["cup"][$country["country_en"]]= getCupByCountryEn($country["country_en"]); 
                  $flag =  getFlagCountry($country["country_en"]);
                 
                  $arrCountry["flag"][$country["country_en"]]= $flag;
                  
                  $arrCCD[$ccd]  =   $arrCountry;
            } else{
                   $ccd = $country["ccd"];
                  $arrCountry  = array(); 
                  $arrCountry["cup"][$country["country_en"]]= getCupByCountryEn($country["country_en"]); 
                  $flag =  getFlagCountry($country["country_en"]);
                
                  $arrCountry["flag"][$country["country_en"]]= $flag;
                  
                  $arrCCD[$ccd]  =   $arrCountry;
            }
        }
        
        $file = dirname(__FILE__).'/CupGroupByCountryJSON.txt';
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        // Write the contents back to the file
        file_put_contents($file, json_encode ( $arrCCD ),LOCK_EX);
    
        return $arrCCD;
    }
    
    
    function searchClub($keyword,$page,$limitItem) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.FBClubSearch","/home/search/football/club/");
        $topDocs = $searcher->query($keyword,$page, $limitItem); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
        
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["name"] = java_values($docs[$i]->name);
          $arrGame[$i]["country"] = java_values($docs[$i]->country);
          $arrGame[$i]["city"] = java_values($docs[$i]->city);
          $arrGame[$i]["logo"] = java_values($docs[$i]->logo);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          
          $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
          if($arrGame[$i]['logo']!="")
             $arrGame[$i]['logo'] = baseUrlUpload()."bongda/club/".$time."/".$arrGame[$i]['logo'];
              
        }
        
        $total = java_values($searcher->getTotalHit());
        $arrGameKQ["club"]=$arrGame;
        $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
        $arrGameKQ["page"] = $page;
        
        return $arrGameKQ;
  }
  
   function searchCup($keyword,$page,$limitItem) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.FBCupSearch","/home/search/football/cup/");
        $topDocs = $searcher->query($keyword,$page, $limitItem); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
        
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["name"] = java_values($docs[$i]->name);
          $arrGame[$i]["country"] = java_values($docs[$i]->country);
          $arrGame[$i]["code"] = java_values($docs[$i]->code);
          $arrGame[$i]["logo"] = java_values($docs[$i]->logo);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
          if($arrGame[$i]['logo']!="")
             $arrGame[$i]['logo'] = baseUrlUpload()."bongda/cup/".$time."/".$arrGame[$i]['logo'];
              
        }
        $total = java_values($searcher->getTotalHit());
        $arrGameKQ["cup"]=$arrGame;
        $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
        $arrGameKQ["page"] = $page;
        
        return $arrGameKQ;
  }
  
  function searchCoach($keyword,$page,$limitItem) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.FBCoachSearch","/home/search/football/coach/");
        $topDocs = $searcher->query($keyword,$page, $limitItem); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
       
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["name"] = java_values($docs[$i]->name);
          $arrGame[$i]["country"] = java_values($docs[$i]->country);
          $arrGame[$i]["avatar"] = java_values($docs[$i]->avatar);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          
          $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
          if($arrGame[$i]['avatar']!="")
             $arrGame[$i]['avatar'] = baseUrlUpload()."bongda/coach/".$time."/".$arrGame[$i]['avatar'];
              
        }
        
        $total = java_values($searcher->getTotalHit());
        $arrGameKQ["coach"]=$arrGame;
        $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
        $arrGameKQ["page"] = $page;
        
        return $arrGameKQ;
  }
  
  function searchFootballer($keyword,$page,$limitItem) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.FBCoachSearch","/home/search/football/footballer/");
        $topDocs = $searcher->query($keyword,$page, $limitItem); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
       
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["name"] = java_values($docs[$i]->name);
          $arrGame[$i]["country"] = java_values($docs[$i]->country);
          $arrGame[$i]["avatar"] = java_values($docs[$i]->avatar);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          
          $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
          if($arrGame[$i]['avatar']!="")
             $arrGame[$i]['avatar'] = baseUrlUpload()."bongda/footballer/".$time."/".$arrGame[$i]['avatar'];
              
        }
        
        $total = java_values($searcher->getTotalHit());
        $arrGameKQ["footballer"]=$arrGame;
        $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
        $arrGameKQ["page"] = $page;
        
        return $arrGameKQ;
  }
  
   function searchNews($keyword,$page,$limitItem) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.FBNewsSearch","/home/search/football/news/");
        $topDocs = $searcher->query($keyword,$page, $limitItem); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
       
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["title"] = java_values($docs[$i]->title);
          $arrGame[$i]["description"] = java_values($docs[$i]->description);
          $arrGame[$i]["image"] = java_values($docs[$i]->image);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          $arrGame[$i]["club_id"] = java_values($docs[$i]->club_id);
          $arrGame[$i]["cup_id"] = java_values($docs[$i]->cup_id);
          $arrGame[$i]["club_name"] = java_values($docs[$i]->club_name);
          $arrGame[$i]["cup_name"] = java_values($docs[$i]->cup_name);
          $arrGame[$i]["country"] = java_values($docs[$i]->country);
          
          $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
          if($arrGame[$i]['image']!="")
             $arrGame[$i]['image'] = baseUrlUpload()."bongda/news/".$time."/".$arrGame[$i]['image'];
              
        }
        
        $total = java_values($searcher->getTotalHit());
        $arrGameKQ["news"]=$arrGame;
        $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
        $arrGameKQ["page"] = $page;
        
        return $arrGameKQ;
  }
  
  function searchVideo($keyword,$page,$limitItem) {
        require_once("http://127.0.0.1:8181/JavaBridge/java/Java.inc");
        $searcher = new java("com.ttv.search.FBVideoSearch","/home/search/football/video/");
        $topDocs = $searcher->query($keyword,$page, $limitItem); ;
        $docs = java_values($topDocs) ;
        $num_row=count($docs);
       
        $arrGame = array();
        $arrGameKQ = array();
        for($i=0;$i<$num_row;$i++)
        {
          
          $arrGame[$i]["id"] = java_values($docs[$i]->id);   
          $arrGame[$i]["title"] = java_values($docs[$i]->title);
          $arrGame[$i]["description"] = java_values($docs[$i]->description);
          $arrGame[$i]["image"] = java_values($docs[$i]->image);
          $arrGame[$i]["create_date"] = java_values($docs[$i]->create_date);
          $arrGame[$i]["club_id"] = java_values($docs[$i]->club_id);
          $arrGame[$i]["cup_id"] = java_values($docs[$i]->cup_id);
          $arrGame[$i]["club_name"] = java_values($docs[$i]->club_name);
          $arrGame[$i]["cup_name"] = java_values($docs[$i]->cup_name);
          $arrGame[$i]["video"] = java_values($docs[$i]->video);
          $time =    date("Y/md",strtotime($arrGame[$i]["create_date"]));
          if($arrGame[$i]['image']!="")
             $arrGame[$i]['image'] = baseUrlUpload()."bongda/video/".$time."/".$arrGame[$i]['image'];
              
        }
        
        $total = java_values($searcher->getTotalHit());
        $arrGameKQ["video"]=$arrGame;
        $page = intval($total/$limitItem)+($total%$limitItem>0?1:0);
        $arrGameKQ["page"] = $page;
        
        return $arrGameKQ;
  }
  
  
    function deleteCacheBongDaByKey($key){
         $meminstance = new Memcache();
         $meminstance->pconnect('localhost', 11211);
         $meminstance->delete($key);
     }
     
   
    
?>

<?php
  header ( 'Content-type: text/html; charset=utf-8' );
  require_once ("BongDaDAO.php");
  require_once ("../function/utils.php");
  
  $action = "KQ";
  $cup_code = "";
  $club_code = "";
  $sttBXH=0;
  $ktXuongDong ="\n";
  $status =1;

   
// Cup code
    $arrCupCodeMAP = array("ANH"=>"ANHA","ANHA"=>"ANHA","AN"=>"ANHA","ANA"=>"ANHA","ANHB"=>"ANHA","ANH2"=>"ANHA"
        ,"PHAP"=>"PHA","PHAPA"=>"PHA","PHA"=>"PHA","PH"=>"PHA","PHB"=>"PHB","PHAPB"=>"PHB","PHAP2"=>"PHB"
        ,"TBNA"=>"TBNA","TBN"=>"TBNA","TB"=>"TBNA","TBA"=>"TBNA","TBNB"=>"TBNB","TBN2"=>"TBNB","TB2"=>"TBNB"
        ,"DUA"=>"DUA","DUC"=>"DUA","DU"=>"DUA","DUB"=>"DUB","DU2"=>"DUB","DUC2"=>"DUB"
        ,"ITA"=>"ITA","ITALIA"=>"ITA","ITAA"=>"ITA","ITAL"=>"ITA","ITALI"=>"ITA","Y"=>"ITA","ITB"=>"ITB","IT2"=>"ITB","Y2"=>"ITB","YB"=>"ITB","HYLA"=>"GREA","FINAL"=>"fina","PHAN"=>"fina","PHANLAN"=>"fina"         
        ,"C1"=>"C1","C2"=>"C2","UEFA"=>"C2","GH"=>"GHCLB","MY"=>"USA","BRAZIL"=>"BRA","u23"=>"SEA"
        ,"VNA"=>"VNA","VIETNAM"=>"VNA","VIET"=>"VNA","VN"=>"VNA"
        ,"U20"=>"W20","20"=>"W20","fifau20worldcup"=>"W20","fifau20worldcup"=>"W20","U2O"=>"W20"
        ,"seagem"=>"SEA","seagame"=>"SEA","CAM23"=>"SEA","SGEM"=>"SEA"
         ,"CAM"=>"SEA","PHI"=>"SEA","BRU23"=>"SEA","BRU"=>"SEA","Timo"=>"SEA","TLS23"=>"SEA","TIMO23"=>"SEA"
         ,"dong"=>"SEA","thai"=>"SEA","thailan"=>"SEA","indo"=>"SEA","Singapore"=>"SEA","sing"=>"SEA"
         ,"sin"=>"SEA","lao"=>"SEA","Myanmar"=>"SEA","Mya"=>"SEA","Brunei"=>"SEA","Bru"=>"SEA","segem"=>"SEA","XG"=>"SEA"
         ,"SG"=>"SEA","seagames"=>"SEA","XINGEN"=>"SEA","GEN"=>"SEA","XIN"=>"SEA"
          ,"NHAT"=>"NHATA","NHA"=>"NHATA","JPN"=>"NHATA","japan"=>"NHATA","UC"=>"AUSA");
        
     $arrClubCodeMAP = array("vn23"=>"vie23","vietnam"=>"vie23","vn"=>"vie23","viet"=>"vie23","viet23"=>"vie23");
        
// Get Paras
        $req_id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "";
        $phone = isset ( $_GET ['phone'] ) ? $_GET ['phone'] : "";
        $shortcode = isset ( $_GET ['shortcode'] ) ? $_GET ['shortcode'] : "";
        $sms = isset ( $_GET ['sms'] ) ? $_GET ['sms'] : "";
        $checksum = isset ( $_GET ['checksum'] ) ? $_GET ['checksum'] : "";
        $sms = strtoupper(preg_replace ("/\s{2,}/", " ", $sms));
        $mahoa = isset ( $_GET ['mahoa'] ) ? $_GET ['mahoa'] : "1";
        
  
        
// Tach Action Tu SMS    
       // $sms ="BD KQ BAR";
        //echo "SMSfdf:".$sms."<br>";
        //echo "SMS:".strToHex($sms)."<br>";
        //echo "SMS:".hexToStr(strToHex($sms))."<br>";
        
        if(intval($mahoa)==1) 
        $sms =strtoupper(hexToStr($sms));
        
        if(intval($mahoa)==0) $ktXuongDong ="<br/>";
        
        $sms = strtoupper(preg_replace ("/\s{2,}/", " ", $sms));
        $sms = unicode_str_filter($sms);
        $sms = trim($sms);
       
        $huongdan = "Ko co thong tin".$ktXuongDong
        ."KQ Soan:BD MaGiai".$ktXuongDong
        ."TyLe:TL MaGiai".$ktXuongDong
        ."LichTD:LTD MaGiai".$ktXuongDong
        ."BangXH:BXH MaGiai".$ktXuongDong
        ."MaGiai: ANHA,PHA,ITA,DUA,TBA,C1,C2,VNA".$ktXuongDong." Ho tro 0975752838";
        
        $huongdanTl = "Chua co Ty Le tran nay".$ktXuongDong
        ."KQ Soan:BD MaGiai".$ktXuongDong
        ."TyLe:TL MaGiai".$ktXuongDong
        ."LichThiDau:LTD MaGiai".$ktXuongDong
        ."BangXepHang:BXH MaGiai".$ktXuongDong
        ."MaGiai: ANHA,PHA,ITA,DUA,TBA,C1,C2,VNA".$ktXuongDong." Ho tro 0975752838";
   
      
        $arrSMS = array();
        if(!empty($sms)) $arrSMS = explode(" ",$sms);
          

        if(count($arrSMS)>2) {
            // BD CUP_CODE
            foreach($arrCupCodeMAP as $key => $value ){
                 if(strcasecmp($key,$arrSMS[2])==0){
                 $action = "KQ";$cup_code = $value;
                 break;
                 } 
            }
            if(strcasecmp("KQ",$arrSMS[1])==0) $action = "KQ";
            if(strcasecmp("KP",$arrSMS[0])==0) $action = "KQ";
            if(strcasecmp("KQ0",$arrSMS[1])==0) {$action = "KQ";$sttBXH=0;}
            if(strcasecmp("KQ1",$arrSMS[1])==0) {$action = "KQ";$sttBXH=1;}
            if(strcasecmp("KQ2",$arrSMS[1])==0) {$action = "KQ";$sttBXH=2;}
            if(strcasecmp("KQ3",$arrSMS[1])==0) {$action = "KQ";$sttBXH=3;}
            
            if(strcasecmp("LTD",$arrSMS[1])==0) $action = "LTD";
            
            if(strcasecmp("TL",$arrSMS[1])==0) $action = "TL";
            if(strcasecmp("TL0",$arrSMS[1])==0) {$action = "TL";$sttBXH=0;}
            if(strcasecmp("TL1",$arrSMS[1])==0) {$action = "TL";$sttBXH=1;}
            if(strcasecmp("TL2",$arrSMS[1])==0) {$action = "TL";$sttBXH=2;}
            if(strcasecmp("TL3",$arrSMS[1])==0) {$action = "TL";$sttBXH=3;}
            
            if(strcasecmp("BXH",$arrSMS[1])==0) $action = "BXH";
            if(strcasecmp("BXH0",$arrSMS[1])==0) {$action = "BXH";$sttBXH=0;}
            if(strcasecmp("BXH1",$arrSMS[1])==0) {$action = "BXH";$sttBXH=1;}
            if(strcasecmp("BXH2",$arrSMS[1])==0) {$action = "BXH";$sttBXH=2;}
            if(strcasecmp("BXH3",$arrSMS[1])==0) {$action = "BXH";$sttBXH=3;}
            
         
                // Khong co trong map
                if(empty($cup_code)){
                    $cup = getCupByCode($arrSMS[2]);
                    if(!empty($cup)) $cup_code = $cup["code"];
                }
                
                  // Lay cau lac bo
                if(empty($cup_code)){
                     $club = getClubByCode($arrSMS[2]);
                     if(!empty($club)){
                         $action = "KQ_CLUB";
                         $club_code = $club["code"];
                     } 
                }
          
            
           
            
        }else if(count($arrSMS)==2){
            
            $action = "KQ";
            if(strcasecmp("KQ",$arrSMS[0])==0) $action = "KQ";
            if(strcasecmp("KP",$arrSMS[0])==0) $action = "KQ";
            if(strcasecmp("BDKQ",$arrSMS[0])==0) $action = "KQ";
            if(strcasecmp("LTD",$arrSMS[0])==0) $action = "LTD";
            
            if(strcasecmp("TL",$arrSMS[0])==0) $action = "TL";
            if(strcasecmp("TL0",$arrSMS[0])==0) {$action = "TL";$sttBXH=0;}
            if(strcasecmp("TL1",$arrSMS[0])==0) {$action = "TL";$sttBXH=1;}
            if(strcasecmp("TL2",$arrSMS[0])==0) {$action = "TL";$sttBXH=2;}
            if(strcasecmp("TL3",$arrSMS[0])==0) {$action = "TL";$sttBXH=3;}
            
            if(strcasecmp("BXH",$arrSMS[0])==0) $action = "BXH";
            if(strcasecmp("BXH0",$arrSMS[0])==0) {$action = "BXH";$sttBXH=0;}
            if(strcasecmp("BXH1",$arrSMS[0])==0) {$action = "BXH";$sttBXH=1;}
            if(strcasecmp("BXH2",$arrSMS[0])==0) {$action = "BXH";$sttBXH=2;}
            if(strcasecmp("BXH3",$arrSMS[0])==0) {$action = "BXH";$sttBXH=3;}
            
           
            // Get Cup Code
            foreach($arrCupCodeMAP as $key => $value ){
                 if(strcasecmp($key,$arrSMS[1])==0){
                     $cup_code = $value;
                 break;} 
            }
            // Khong co trong map
            if(empty($cup_code)){
                $cup = getCupByCode($arrSMS[1]);
                if(!empty($cup)) $cup_code = $cup["code"];
            }
           
            // Get club Code
            /*foreach($arrClubCodeMAP as $key => $value ){
                
                 if(strcasecmp($key,$arrSMS[1])==0){
                     $action = "KQ_CLUB";
                     $club_code = $value;
                 break;
                 } 
            }*/
           
            // Lay cau lac bo
            if(empty($cup_code)){
                 $club = getClubByCode($arrSMS[1]);
                 if(!empty($club)){
                     $action = "KQ_CLUB";
                     $club_code = $club["code"];
                 } 
            }// ;
        }
       
        $outputContent="";
       // echo "action:".$action."<br>";
     //  echo $cup_code;
        switch ($action) {
            case "LTD" :
                {
                    $cup = getCupByCode($cup_code);
                    
                    if(!empty($cup)){
                        $arrLTD = getLTDByCup($cup["id"]);
                        $arrLTD = filterLTDByCup($arrLTD);
                        $outputContent  = outSMSContentLTD($arrLTD,$ktXuongDong);
                    }
                    if(empty($outputContent)){$status =0;$outputContent = $huongdan;} 
                   echo $outputContent;
                   
                    if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".trlen($outputContent)."<br/>";
                    
                    break;
                }
            case "KQ" :
                {
                   $cup = getCupByCode($cup_code);
                    if(!empty($cup)){
                        $arrKQ = getKQByCup($cup["id"]);
                        $arrKQ = filterKQByCup($arrKQ);
                        $outputContent  = outSMSContentKQ2($arrKQ,$cup_code,$sttBXH,$ktXuongDong);
                    }
                   
                   if(empty($outputContent)){$status =0;$outputContent = $huongdan;} 
                   echo $outputContent;
                   
                   if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                   break;
                }
             case "KQ_CLUB" :
                {   // Get match latest
                   $club = getClubByCode($club_code);
                   if(!empty($club)){
                       $match = getMatchLatestBy($club["code"]);
                       $tyle = array();
                       $thongke = array();
                       
                        if(!empty($match)){
                            // Get tyle match
                            $tyle = getTyLeByMatchId($match["id"]);
                            // Get thong ke tran dau
                            $thongke = getThongKeByMatchId($match["id"]);
                            
                        }
                        $outputContent  = outSMSContentKQClub($match,$tyle,$thongke,$ktXuongDong);
                        
                   }
                   
                   if(empty($outputContent)) {$status =0;$outputContent = $huongdan;} 
                   echo $outputContent;
                   
                   if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                   
                   break;
                }
            case "TL" :
                {
                    $cup = getCupByCode($cup_code);
                    $str_date = date("Y-m-d");
                    // Lay danh sach ty le theo danh sach id tran dau
                    $arrTyle = getTyleByCupIDAndDate($cup["id"],$str_date);
                    $outputContent = outSMSContentTyle($arrTyle,$sttBXH,$cup_code,$ktXuongDong);
                    // Echo info
                   if(empty($outputContent)){$status =0;$outputContent = $huongdanTl;} 
                   echo $outputContent;
                   
                    if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                    
                    break;
                }
            case "BXH" :{
                    $cup = getCupByCode($cup_code);
                    $season = "2014-2015";
                  
                    // Lay danh sach ty le theo danh sach id tran dau
                    $arrBXH = getBXHByCupAndSeason($cup["id"],$season);
                    $outputContent = outSMSContentBXH($arrBXH,$sttBXH,$cup_code,$ktXuongDong);
                    
                    // Echo info
                   if(empty($outputContent)) {$status =0;$outputContent = $huongdan;} 
                   echo $outputContent;
                
                    
                    if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                    break;
                }
                case "HD" :{
                    echo $huongdan;
                //    echo strlen($outputContent)."<br/>";
                    break;
                }
        }
        
        if(checkSMSLog($req_id)>0)
            updateSmsLog($req_id,$phone,$shortcode,$sms,$outputContent,$status);
        else
            saveSmsLog($req_id,$phone,$shortcode,$sms,$outputContent,$status);
    
?>

<?php

?>
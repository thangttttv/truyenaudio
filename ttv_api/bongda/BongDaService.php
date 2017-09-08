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
        
// Get Paras
        $req_id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "";
        $phone = isset ( $_GET ['phone'] ) ? $_GET ['phone'] : "";
        $shortcode = isset ( $_GET ['shortcode'] ) ? $_GET ['shortcode'] : "";
        $sms = isset ( $_GET ['sms'] ) ? $_GET ['sms'] : "";
        $checksum = isset ( $_GET ['checksum'] ) ? $_GET ['checksum'] : "";
        $sms = strtoupper(preg_replace ("/\s{2,}/", " ", $sms));
        $mahoa = isset ( $_GET ['mahoa'] ) ? $_GET ['mahoa'] : "1";
            
        
// Tach Action Tu SMS    
        if(intval($mahoa)==1) 
        $sms =strtoupper(hexToStr($sms));
        
        if(intval($mahoa)==0) $ktXuongDong ="<br/>";
        
        $sms = strtoupper(preg_replace ("/\s{2,}/", " ", $sms));
        $sms = unicode_str_filter($sms);
        $sms = trim($sms);
        
        // Lay content tu webservice khac
        $mobi = getRamdonMobile();  
        $outputContent  = getContentByWebservice($shortcode,$mobi,$sms);
         echo  $outputContent; 
         if(checkSMSLog($req_id)>0)
            updateSmsLog($req_id,$phone,$shortcode,$sms,$outputContent,$status);
        else
            saveSmsLog($req_id,$phone,$shortcode,$sms,$outputContent,$status);
        
        die;
       
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
         
         // Xac dinh Action
         switch($arrSMS[0]){
             case "BD":
                      if(count($arrSMS)>1){
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
                      }
                break;
                
             case "KQBD":
                    $action = "KQ";
                break;
                
             case "TL":
                    $action = "TL";
                break;
                
             case "LTD":
                    $action = "LTD";
                break;
                
             case "BXH":
                    $action = "BXH";
                break;
         } 
         
         // Xac dinh CODE
         $cup = null;
         $club = null;
         if(count($arrSMS)>2) {
                // Get CUP By CODE
                $cup = getCupLikeCode($arrSMS[2]);
                if(!empty($cup)) $cup_code = $cup["code"];
                // Get Club By Code
                if(empty($cup)){$club = getClubLikeCode($arrSMS[2]);}
        }else if(count($arrSMS)==2){
                $cup = getCupLikeCode($arrSMS[1]);
                if(!empty($cup)) $cup_code = $cup["code"];
                // Get Club By Code
                if(empty($cup)){$club = getClubLikeCode($arrSMS[1]);}
        }
       //var_dump($cup);
        $outputContent="";
       // echo "action:".$action."<br>";
     //  echo $cup_code;
        switch ($action) {
            case "LTD" :
                {
                    // Lay LTD Theo CUP
                    if(!empty($cup)){
                        $arrLTD = getLTDByCup($cup["id"]);
                        $arrLTD = filterLTDByCup($arrLTD);
                        $outputContent  = outSMSContentLTD($arrLTD,$ktXuongDong);
                    }else if(!empty($club)){
                        // Lay LTD Theo CLUB
                        $arrLTD = getLTDByClub($club["id"]);
                        $outputContent  = outSMSContentLTD($arrLTD,$ktXuongDong);
                    }
                    
                    if(empty($outputContent)){$status =0;$outputContent = $huongdan;} 
                  
                    echo $outputContent;
                   
                    if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                    
                    break;
                }
            case "KQ" :
                {
                    // Lay KQ Theo CUP
                    if(!empty($cup)){
                        $arrKQ = getKQByCup($cup["id"]);
                        $arrKQ = filterKQByCup($arrKQ);
                        $outputContent  = outSMSContentKQ2($arrKQ,$cup_code,$sttBXH,$ktXuongDong);
                    }else if(!empty($club)){
                        // Lay KQ Theo CLUB
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
                   
                   if(empty($outputContent)){$status =0;$outputContent = $huongdan;} 
                   
                   echo $outputContent;
                   
                   if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                   break;
                }
            case "TL" :
                {
                    // Lay TL Theo CUP
                    if(!empty($cup)){
                         $str_date = date("Y-m");
                        // Lay danh sach ty le theo danh sach id tran dau
                        $arrTyle = getTyleByCupIDAndDate($cup["id"],$str_date);
                        $outputContent = outSMSContentTyle($arrTyle,$sttBXH,$cup_code,$ktXuongDong);
                    }else if(!empty($club)){
                        // Lay KQ Theo CLUB
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
                   
                   if(empty($outputContent)){$status =0;$outputContent = $huongdanTl;} 
                   
                    echo $outputContent;
                   
                    if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                    
                    break;
                }
            case "BXH" :{
                    $season = "2014-2015";
                     if(!empty($cup)){
                         // Lay danh sach bang xep hang
                         $arrBXH = getBXHByCupAndSeason($cup["id"],$season);
                         $outputContent = outSMSContentBXH($arrBXH,$sttBXH,$cup_code,$ktXuongDong);
                     }    
                    
                    
                   if(empty($outputContent)) {$status =0;$outputContent = $huongdan;} 
                  
                     echo $outputContent;
                    
                    if(intval($mahoa)==0) 
                    echo "<br/>Do Dai:".strlen($outputContent)."<br/>";
                    break;
                }
                case "HD" :{
                    echo $huongdan;
                    break;
                }
        }
        
        if(checkSMSLog($req_id)>0)
            updateSmsLog($req_id,$phone,$shortcode,$sms,$outputContent,$status);
        else
            saveSmsLog($req_id,$phone,$shortcode,$sms,$outputContent,$status);
    
?>

<?php
     function getContentByWebservice($sms_no,$phone_no,$sms_Content)
     {
            $mobi = "0975752838";
            $content = "Gui BD MAGIAI -> xem KQ LTD MAGIAI -> xem ltd BXH MAGIAI -> xem bxh TL MAGIAI -> xem ty le truc tiep DT ho tro ".$mobi;
            $atservices_wsdl = "http://115.146.123.108/CPK_Content/Sms.asmx?wsdl";   
            $sms_date = date("Y/m/d H:i:s");
            $data     =  array('sms_no' => $sms_no,
            'phone_no' => $phone_no,'sms_Content' => $sms_Content,'sms_date' => $sms_date);

            $trace = true;
            $exceptions = false;
            try
            {
                $client = new SoapClient($atservices_wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
                $response = $client->CPK_Content($data);
            }

            catch (Exception $e)
            {
                echo "Error!";
                echo $e -> getMessage ();
                echo 'Last response: '. $client->__getLastResponse();
            }
            $content =  $response->CPK_ContentResult;
            if(!empty($content))
            $content =  str_replace("0912091344",$mobi,$content);
            return    $content;
     }
     
     
     function getRamdonMobile(){
         $mobile ="84982050482";     
        try {
            $file = dirname(__FILE__).'/mobile.txt';
            $myfile = fopen($file, "r") ;
            $sbk = rand(0,5975);  $i=0;
            while(!feof($myfile)) {
                if($i==$sbk){
                     $mobile = fgets($myfile);   
                     break; 
                }
                $i++;
            }
            fclose($myfile);
        } catch (Exception $e) {
        } 
        return   $mobile;
    }
?>
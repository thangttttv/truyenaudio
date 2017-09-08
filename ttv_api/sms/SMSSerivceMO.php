<?php
    header('Content-type: text/html; charset=utf-8');     
    require_once("SMSDAO.php");
    require_once("../function/utils.php");
    date_default_timezone_set('Asia/Saigon');   
    
    $user_id = isset ( $_GET ['User_ID'] ) ? $_GET ['User_ID'] : "";// so dien thoai
    $service_id = isset ( $_GET ['Service_ID'] ) ? $_GET ['Service_ID'] : "";// dau so dich vu
    $command_code = isset ( $_GET ['Command_Code'] ) ? $_GET ['Command_Code'] : "";
    $message = isset ( $_GET ['Message'] ) ? $_GET ['Message'] : ""; 
    $request_id = isset ( $_GET ['Request_ID'] ) ? $_GET ['Request_ID'] : ""; 
    
    //var_dump($_GET);
    // echo "Request_ID". $_GET ['Request_ID'];
    
    $datalog = "User_ID:".$user_id.",Service_ID:".$service_id.",Command_Code:".$command_code.",Message:".$message;
    $datalog .=",Request_ID".$request_id;
    $result = "0";
    
    if(!empty($user_id)||!empty($service_id)||!empty($command_code)||!empty($message)||!empty($request_id)){
        $phone = formatMobile($user_id);
       
        $mt="";$status=0;
        $payment=1;
        $mobile_operator= getMobileOperator($phone);
        $content_type=0;
        $channel = "BLUESEA";
        $message = trim(strtoupper(preg_replace ("/\s{2,}/", " ", $message)));
        $arrMO = explode(" ",$message);
        
        // check la dich vu bt: insert vao bang sms_mo
        if(!(strcasecmp("8977",$service_id)==0))
        {
            $kq  = saveSmsMO($request_id,$service_id,$phone,$command_code,$message,"",$status,$payment,$mobile_operator,$content_type,$channel);
          
        }else{ // check la dich vu sub: insert vao bang user_sub
            if(strcasecmp("DK",$arrMO[0])==0){
                // DK SUB
                $kq  = saveUserSub($phone,$arrMO[1],$channel,$mobile_operator);
            }else  if(strcasecmp("HUY",$arrMO[0])==0){
                // Huy SUB
                $kq  = inActiveUserSub($phone,$arrMO[1],$channel);
            }
            
        }
          $result = "0";
          if($kq>0) {$result = "0";echo $result;} // Success
               else {$result = "-1";echo $result;} 
          $datalog .=",Ketqua:".$result;
          writeToLogSMS($datalog);
    }else{
        if(empty($request_id)) {$result = "5";echo $result;} 
        else  if(empty($command_code)) {$result = "3";echo $result;}
         else  if(empty($service_id)) {$result = "2";echo $result;}
            else  if(empty($user_id)) {$result = "1";echo $result;}
            else{$result = "-1";echo $result;}
         
          $datalog .=",Ketqua:".$result;
          writeToLogSMS($datalog);
    }
?>

<?php
    function writeToLogSMS($message)
{
    $fileLog = "/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/sms/log/SMSMOBluesea.txt";
    if ($fp = fopen($fileLog, 'at'))
    {
        fwrite($fp, date('c') . ' ' . $message . PHP_EOL);
        fclose($fp);
    }
}

    
?>

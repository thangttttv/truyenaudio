<?php
  try
    {
        require_once('SMSConfig.php');
        require_once('SMSDAO.php');
        ini_set('display_errors', 'on');

        $mode="development";
        $config = $config[$mode];

        writeToLog("Send SMS started ($mode mode)");

        $obj = new SMSSendFormQueue($config);
        $obj->start();
    }
    catch (Exception $e)
    {
        fatalError($e);
    }

function writeToLog($message)
{
    global $config;
    if ($fp = fopen($config['logfile'], 'at'))
    {
        fwrite($fp, date('c') . ' ' . $message . PHP_EOL);
        fclose($fp);
    }
}

function fatalError($message)
{
    writeToLog('Exiting with fatal error: ' . $message);
    exit;
}

?>


<?php 
////////////////////////////////////////////////////////////////////////////////

class SMSSendFormQueue
{
    private $fp = NULL;
    private $server;
    
    function __construct($config)
    {
        $this->server = $config['server'];
    }

    // This is the main loop for this script. It polls the database for new
    // messages, sends them to APNS, sleeps for a few seconds, and repeats this
    // forever (or until a fatal error occurs and the script exits).
    function start()
    {
       
           while (true)
            {
                $arrSMSQueue = getAllSMSFormQueue();
                
                foreach ($arrSMSQueue as $mt)
                {
                   $phone = $mt["phone"];$command_Code = $mt["command_code"];$message = $mt["mt"];
                   $request_ID = $mt["request_id"];$mobileOperator = $mt["mobile_operator"];
                   $conntent_Type = $mt["content_type"];$title = $mt["title_wapbpush"];
                   $channel =  $mt["channel"];$mo_id = $mt["mo_id"];
                   
                   switch($channel){
                       case "BLUESEA":{
                           $kq =$this->sent_SMS_To_Bluesea($phone,$command_Code,$message,$request_ID,$mobileOperator,$conntent_Type,$title) ;
                           if ($kq==0)
                            {
                                deleteSMSFormQueue($mt["id"]) ;
                                saveSMSMT($mo_id,$phone,$message,0,1);
                                
                                $log = $channel." Sent  ".$mo_id." success";
                                writeToLog($log);
                                
                                echo $log." \n";
                                 
                               
                            }else{
                                $log = $channel." Sent  ".$mo_id." fail:".$kq;
                                writeToLog($log);
                                echo $log." \n";
                               
                            }
                       }
                   }
                }
                
                
                
                echo "-------------------\n";

                unset($arrSMSQueue);            
                sleep(5);
            }
    }

    
    //Sending SMS To Bluesea
   function sent_SMS_To_Bluesea($phone,$command_Code, $message,$request_ID,$mobileOperator,$conntent_Type,$title) {
        $username = "vintel";
        $pass = "*123";
        $message = base64_encode($message);
        $result = 0;
        echo "request_ID".$request_ID."\n";
        try{
             $soap = new SoapClient('http://sms.bluesea.vn:8888/ServiceSubMT/SendMT?wsdl');
             $resultSoap = $soap->__soapCall('SendMT', array('UserName' => $username,
            'Pass' => $pass,'UserID' => $phone,'Command_Code' => $command_Code,'Message' => $message,
            'Request_ID' => $request_ID,'MobileOperator' => $mobileOperator,'Conntent_Type' => $conntent_Type
            ,'Title' => $title));
            
            $result = $resultSoap->return;
            
            
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            fatalError($e->getMessage());
            $result = -1;
        }
      
        return $result;
    }
    
}


?>
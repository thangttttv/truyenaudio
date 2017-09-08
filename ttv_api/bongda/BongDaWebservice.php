<?php
    $atservices_wsdl = "http://115.146.123.108/CPK_Content/Sms.asmx?wsdl";   
    $sms_no = "7039";
    $phone_no = "84974838181";    
    $sms_Content = "BD";    $sms_date = date("Y/m/d H:i:s");
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

     echo    $response->CPK_ContentResult;
?>
    
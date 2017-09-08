<?php
   function connectSMSDB(){
        include('SMSConfig.php');
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
   
   
   function saveSmsMO($request_id,$service_id,$phone,$command_code,$sms,$mt,$status,$payment,$mobile_operator,$content_type,$channel)
    {   
        $insertId = 0;
        try{
            $connect = connectSMSDB();
            $sql = "INSERT INTO vtc_sms.sms_mo (request_id,service_id,phone,command_code,sms,mt,payment,STATUS,mobile_operator,content_type,channel,create_date) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,NOW());";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($request_id,$service_id,$phone,$command_code,$sms,$mt,$payment,$status,$mobile_operator,
            $content_type,$channel);
            $count = $q->execute($arrV);
            $insertId = $connect->lastInsertId();
            $connect = null;
        }catch (Exception $e) {
          $insertId = 0;
        }
        
         return $insertId;   
    }  
    
    
    function saveSmsSendQueue($mo_id,$request_id,$phone,$channel,$command_code,$mt,$mobile_operator,$content_type,$title_wapbpush)
    {   
        $count = 0;
        try{
            $connect = connectSMSDB();
            $sql = "INSERT INTO vtc_sms.sms_send_queue(mo_id,request_id,phone,channel,command_code,mt
            ,mobile_operator,content_type,title_wapbpush,create_date)
            VALUES (?,?,?,?,?,?,?,?,?,NOW());";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($mo_id,$request_id,$phone,$channel,$command_code,$mt,$mobile_operator,$content_type,$title_wapbpush);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }  
    
    function saveSMSMT($mo_id,$phone,$mt,$status,$payment)
    {   
        $count = 0;
        try{
            $connect = connectSMSDB();
            $sql = "INSERT INTO vtc_sms.sms_mt (mo_id,phone,mt,STATUS,payment,create_date)
        VALUES (?,?,?,?,?,NOW())";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($mo_id,$phone,$mt,$status,$payment);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }  
    
    
    function saveUserSub($phone,$command_code,$channel,$mobile_operator)
    {   
        $count = 0;
        try{
            $connect = connectSMSDB();
            $sql = "INSERT INTO vtc_sms.sms_user_sub (phone,command_code, 
    channel,mobile_operator,STATUS,create_date) 
    VALUES (?,?,?,?,NOW());";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($phone,$command_code,$channel,$mobile_operator,1);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
        
         return $count;   
    }  
    
    
    function deleteSMSFormQueue($id)
    {   
        $count = 0;
        try{
            $connect = connectSMSDB();
            $sql = "DELETE FROM vtc_sms.sms_send_queue  WHERE id = ? ";
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($id);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
         return $count;   
    }  
    
    
     function inActiveUserSub($phone,$command_code,$channel)
    {   
        $count = 0;
        try{
            $connect = connectSMSDB();
            $sql = "Update vtc_sms.sms_user_sub  SET status = 0, update_date = NOW()  WHERE phone = ? AND command_code = ? AND channel = ?  ";
          
            # creating the statement
            $q = $connect->prepare($sql);
            $arrV = array($phone,$command_code,$channel);
            $count = $q->execute($arrV);
            $connect = null;
        }catch (Exception $e) {
          $count = 0;
        }
         return $count;   
    }  
    
    
    function getAllSMSFormQueue()
    {
      
        $sql = "SELECT id,mo_id,request_id,phone,channel,command_code,mt,mobile_operator, 
    content_type,title_wapbpush,create_date  FROM  vtc_sms.sms_send_queue LIMIT 0, 50"; 
       
       // echo $sql;
        # creating the statement
        $connect = connectSMSDB();
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
    
    
?>

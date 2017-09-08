<?php
    //ffdfd
    function connectAdvFacebookDB(){
        $var12121 = 1;
        include('AdvFacebookConfig.php');
        $mode="development";
        $config = $config[$mode];
        //var_dump($cf)    ;
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
   
   
   function insertCampaignInvite($fb_app_id,$title,$account_id)
    {   
        $connect = connectAdvFacebookDB();
        $sql = "INSERT INTO vtc_adv_facebook.campaign_invited (fb_app_id,title,account_id) VALUES (?,?,?);";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($fb_app_id,$title,$account_id);
        //var_dump($arrV);
        $count = $q->execute($arrV);
        $insertId = $connect->lastInsertId();
        $connect = null;
        return $insertId;   
    }   
    
    function insertUserInvite($facebook_user_id,$account_id)
    {   
        $connect = connectAdvFacebookDB();
        $sql = "INSERT INTO facebook_user_invittable (facebook_user_id,account_id) VALUES (?,?);";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($facebook_user_id,$account_id);
        echo $facebook_user_id;
        //var_dump($arrV);
        $count = $q->execute($arrV);
        $insertId = $connect->lastInsertId();
        $connect = null;
        return $insertId;   
    }   
    
    function addCountCampaignInvite($campaign_id,$count)
    {   
        $connect = connectAdvFacebookDB();
        $sql = "UPDATE vtc_adv_facebook.campaign_invited SET  count_sent = count_sent + ? WHERE id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($count,$campaign_id);
        //var_dump($arrV);
        $count = $q->execute($arrV);
        $connect = null;
        return $count;   
    }   
    
    function insertInviteLog($campaign_id,$facebook_user_id)
    {   
        $connect = connectAdvFacebookDB();
        $sql = "INSERT INTO vtc_adv_facebook.campaign_invited_log (campaign_id,facebook_user_id) VALUES (?,?);
";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($campaign_id,$facebook_user_id);
        //var_dump($arrV);
        $count = $q->execute($arrV);
        $insertId = $connect->lastInsertId();
        $connect = null;
        return $insertId;   
    }   
    
    function countCampaignByGame($fb_app_id)
    {
        $sql = "SELECT count(id) as sl FROM  vtc_adv_facebook.campaign_invited Where fb_app_id = ".intval($fb_app_id);
       
        # creating the statement
        $connect = connectAdvFacebookDB();
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
    
    
    function countFacebookUserInvitable($account_id)
    {
        $sql = "SELECT count(facebook_user_id) as sl FROM  vtc_adv_facebook.facebook_user_invittable Where account_id = ".intval($account_id);
       
        # creating the statement
        $connect = connectAdvFacebookDB();
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
    
    function getCampaignInvite($account_id,$fb_app_id)
    {
        
        $sql = "SELECT id,fb_app_id,title,count_sent,create_date FROM vtc_adv_facebook.campaign_invited Where account_id  = ? And  fb_app_id = ? ORDER By  id DESC"; 
      
        # creating the statement
        $connect = connectAdvFacebookDB();
        $arrV = array($account_id,$fb_app_id);
        $q = $connect->prepare($sql);
        $q->execute($arrV);
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
         //echo $sql;
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $q->fetch()) {
             $arr[$i] =  $row;
             $i++;
        }
        $connect = NULL;
      
        return $arr;
    } 
    
    function getFacebookAccountByEmail($email)
    {
        
        $sql = "SELECT id,username,password,count_friend FROM vtc_adv_facebook.facebook_account Where username ='".$email."'"; 
      
        # creating the statement
        $connect = connectAdvFacebookDB();
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
    
    function getFacebookUserIdInvitable($account_id,$campaign_id)
    {
        
        $sql = "SELECT  facebook_user_id FROM vtc_adv_facebook.facebook_user_invittable WHERE account_id = ? AND facebook_user_id NOT IN (SELECT facebook_user_id FROM campaign_invited_log WHERE campaign_id = ?) LIMIT  50;
"; 
        # creating the statement
        $connect = connectAdvFacebookDB();
        $arrV = array($account_id,$campaign_id);
        
        $q = $connect->prepare($sql);
        $q->execute($arrV);
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  
        while($row = $q->fetch()) {
             $arr[$i] =  $row["facebook_user_id"];
             $i++;
        }
        $connect = NULL;
      
        return $arr;
    } 
    
     function getFacebookUserIdInvitableFromLastID($account_id,$last_id)
    {
        
        $sql = "SELECT  id,facebook_user_id FROM vtc_adv_facebook.facebook_user_invittable WHERE account_id = ?   Order By id   LIMIT ".$last_id." , 50;
"; 

        # creating the statement
        $connect = connectAdvFacebookDB();
        $arrV = array($account_id);
        
        $q = $connect->prepare($sql);
        $q->execute($arrV);
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $arr = array();   
        $i=0;  $last_id =  0;
        while($row = $q->fetch()) {
             $arr[$i] =  $row["facebook_user_id"];
             $last_id =  $row["id"];
             $i++;
        }
        $connect = NULL;
        
       
        $arrKQ = array();   
        $arrKQ["facebook_user_id"] =$arr;
        $arrKQ["last_id"] =$last_id;
        
        return $arrKQ;
    } 
    
      function getAccountFacebook($limit, $page)
    {
         
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT id,username,PASSWORD, note, link FROM  vtc_adv_facebook.facebook_account Where  status = 0 AND count_friend > 300  ORDER BY id DESC LIMIT " . $startRecord . ", " . $limit;
        
        $connect = connectAdvFacebookDB();
        # creating the statement
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
     
    
        $arrResult = array();
        $arrResult["account"] = $arr;
        
        $sl = countAccountFacebook();
        
       
        $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = null;
        return $arrResult;     
        
    }
    
    
    function getAccountFacebookDontSend($app_id,$limit, $page)
    {
         
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT ac.id,ac.username,ac.password, ac.note, ac.link FROM  vtc_adv_facebook.facebook_account ac Inner Join facebook_app_account ap On ac.id = ap.account_id  
         Where  ac.status = 0 And ap.app_id = ".$app_id." And ap.status = 0 ORDER BY ac.id DESC LIMIT " . $startRecord . ", " . $limit;
         
       //  echo $sql;
        
        $connect = connectAdvFacebookDB();
        # creating the statement
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
     
    
        $arrResult = array();
        $arrResult["account"] = $arr;
        
        $sl = countAccountFacebookSend($app_id,0);
        
       
        $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = null;
        return $arrResult;     
        
    }
    
    function getAccountFacebookSending($app_id,$limit, $page)
    {
         
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT ac.id,ac.username,ac.password, ac.note, ac.link FROM  vtc_adv_facebook.facebook_account ac Inner Join facebook_app_account ap On ac.id = ap.account_id  
         Where  ac.status = 0 And ap.app_id = ".$app_id." And ap.status = 1 ORDER BY ac.id DESC LIMIT " . $startRecord . ", " . $limit;
        
        $connect = connectAdvFacebookDB();
        # creating the statement
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
     
    
        $arrResult = array();
        $arrResult["account"] = $arr;
        
        $sl = countAccountFacebookSend($app_id,1);
        
       
        $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = null;
        return $arrResult;     
        
    }
    
    
    function getAccountFacebookSented($app_id,$limit, $page)
    {
         
        $startRecord = ($page - 1) * $limit;    
        $sql = "SELECT ac.id,ac.username,ac.password, ac.note, ac.link FROM  vtc_adv_facebook.facebook_account ac Inner Join facebook_app_account ap On ac.id = ap.account_id  
         Where  ac.status = 0 And ap.app_id = ".$app_id." And ap.status = 2 ORDER BY ac.id DESC LIMIT " . $startRecord . ", " . $limit;
        
        $connect = connectAdvFacebookDB();
        # creating the statement
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
     
    
        $arrResult = array();
        $arrResult["account"] = $arr;
        
        $sl = countAccountFacebookSend($app_id,2);
        
       
        $arrResult["page"] = ceil(intval($sl/$limit))+($sl%$limit>0?1:0);
        
        $connect = null;
        return $arrResult;     
        
    }
    
    function countAccountFacebook()
    {
        $sql = "SELECT count(id) as sl FROM  vtc_adv_facebook.facebook_account  " ;
        
        # creating the statement
        $connect = connectAdvFacebookDB();
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
    
    function countAccountFacebookSend($app_id,$status)
    {
        $sql = "SELECT count(*) as sl FROM  vtc_adv_facebook.facebook_app_account Where status = ? And app_id = ?  " ;
        
       // echo $sql;
        
        # creating the statement
        $connect = connectAdvFacebookDB();
        $q = $connect->prepare($sql);
        $q->execute(array($status,$app_id));
       
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
    
    function getCampaignById($camId)
    {
        $sql = "SELECT id,fb_app_id,account_id,title,count_sent,create_date  FROM vtc_adv_facebook.campaign_invited WHERE id  = ".intval($camId) ;
        
        # creating the statement
        $connect = connectAdvFacebookDB();
        $q = $connect->prepare($sql);
        $q->execute();
       
        # setting the fetch mode
        $q->setFetchMode(PDO::FETCH_ASSOC);
         
        # showing the results
        $sl = 0;$campaign = null;   
         
        if($row = $q->fetch()) {
               $campaign = $row;
        } 
       
         $connect = null;
         return $campaign;  
        
    } 
    
     function updateStatusAccountSend($accountId,$appId,$status)
    {   
        $connect = connectAdvFacebookDB();
        $sql = "UPDATE vtc_adv_facebook.facebook_app_account SET status = ? WHERE app_id = ? And account_id = ? ";
        
        # creating the statement
        $q = $connect->prepare($sql);
        $arrV = array($status,$appId,$accountId);
        //var_dump($arrV);
        $count = $q->execute($arrV);
        $connect = null;
        return $count;   
    }    
   
?>

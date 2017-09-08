<?php
    header('Content-type: text/html; charset=utf-8');     
    require_once("XoSoDOC.php");
    require_once("XoSoDAO.php");
    require_once("../function/utils.php");
    require_once ("configXS.php");
    date_default_timezone_set('Asia/Saigon');   
 
    $output = array();
    $action = isset($_GET['action']) ?$_GET['action'] :"" ;
   
    switch($action){
        
        case "registerMember" :{
            // Get Paramerters
            $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
            $app_client_id = intval ( $app_client_id );
            $fullname = isset ( $_POST ['fullname'] ) ? $_POST ['fullname'] : "";
            $email = isset ( $_POST ['email'] ) ? $_POST ['email'] : "";
            $sex = isset ( $_POST ['sex'] ) ? $_POST ['sex'] : "0";
            $sex = intval($sex);
            
            $birthday = isset ($_POST ['birthday'] ) ? $_POST ['birthday'] : "";
            $sso_id = isset ( $_POST ['sso_id'] ) ? $_POST ['sso_id'] : "";   
            $mobile = isset ( $_POST ['mobile'] ) ? $_POST ['mobile'] : "";   
            $mobile =  formatMobile($mobile);
             // Validate Paramater
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$birthday))
            {
                $birthday = convertStrdmyyToyymd($birthday,"/");
            }
            $kq = 0;
            $arrayKq = array();
            $userDetail = array();
            if(empty($email)) $email =  $app_client_id."@10h.vn";
            if(empty($app_client_id)){$kq=1;} // thieu tham so
            if(!isValidEmail($email)&&!empty($email)){$kq = 3;}// email khong dung dinh dang
            $user_id  =  0;
            $isNewUser =  0;
            $userDetail =  array();
            // get user info
            if($kq == 0){
                $userDetail =  getUserByEmail($email);
                if(empty($userDetail)) $userDetail = getUserBySSOId($sso_id);
                if(empty($userDetail)){
                     $user_token =  md5(md5($app_client_id."_"."hienttv@#$%"));
                    
                     $user_id = registerMemberXoSo($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$sso_id);
                     if($user_id > 0)
                        {
                            $userDetail = getUserByIdXoSo($user_id);
                            $kq = 0;
                            $isNewUser = 1;
                        }else{
                             $kq = 2;
                        } 
                }
            }
            $arrayKq["result"] = $kq;
            $arrayKq["isNewUser"] = $isNewUser;
            $arrayKq["user"] = $userDetail;
            echo json_encode ($arrayKq);
            break;
        }
               
        case "getTTKQXS" :{
                   $region = isset($_GET['region'])?$_GET['region'] :"1";
                   if($region == 1)  {
                        $output = getTTKQXSMienBac();
                   }else if($region==2)  {
                         $output = getTTKQXSMienTrung();
                    } else{
                          $output = getTTKQXSMienNam();
                   }      
                   echo json_encode($output);
                   break;
        }
        case "getKTXS" :{  
            $region = isset($_GET['region'])?$_GET['region'] :"1"; 
            $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
            $date = isset($_GET['date'])?$_GET['date'] :date("m/d/YY")  ; 
            $date = convertStrdmyyToyymd($date,"/");
            
            if($region == 1)  {
                  $output = getKQXSMienBac($date);
            }else if($region==2)  {
                  $output = getKQXSMienTrung($date,$provinceId);
             } else{
                   $output = getKQXSMienNam($date,$provinceId);
            }      
            echo json_encode($output);
            break;
          }
        case "getKTXSByRegion" :{  
            $region = isset($_GET['region'])?$_GET['region'] :"1"; 
            $fdate = isset($_GET['fDate'])?$_GET['fDate'] :date("d/m/YY")  ; 
            $tdate = isset($_GET['tDate'])?$_GET['tDate'] :date("d/m/YY")  ; 
            
            $fdate = convertStrdmyyToyymd($fdate,"/");
            $tdate = convertStrdmyyToyymd($tdate,"/");
            
            if($region == 1)  {
                  $output = getKQXSMienBacByTime($fdate,$tdate);
            }else if($region==2)  {
                  $output = getKQXSMienTrungByTime($fdate,$tdate);
             } else{
                   $output = getKQXSMienNamByTime($fdate,$tdate);
            }      
            echo json_encode($output);
            break;
          }
        case "getKTXSRegionNewest" :{  
            $region = isset($_GET['region'])?$_GET['region'] :"1"; 
            
            if($region == 1)  {
                  $output = getKQXSMienBacNewest();
            }else if($region==2)  {
                  $output = getKQXSMienTrungNewest();
             } else{
                   $output = getKQXSMienNamNewest();
            }      
            echo json_encode($output);
            break;
          }
        case "getDream": {
              $title = isset($_GET['title'])?$_GET['title'] :""; 
              $output = getDream($title); 
              echo json_encode($output);   
              break;      
        }
        case "getTKDauSoDangBang": {
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
            
              $output = getTKDauSoDangBang($provinceId,$fromDate,$toDate); 
              echo json_encode($output);  
             break;   
         }
         
         case "getTKDuoiSoDangBang": {
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
            
              $output = getTKDuoiSoDangBang($provinceId,$fromDate,$toDate); 
              echo json_encode($output);  
             break;   
         }
         
        case "getTKDauSo": {
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
            
              $output = getTKDauSo($provinceId,$fromDate,$toDate); 
              echo json_encode($output);    
              break;     
        }
        case "getTKDuoiSo": {
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $output = getTKDuoiSo($provinceId,$fromDate,$toDate); 
              echo json_encode($output); 
              break;        
        }
        case "getTKBoKep": {
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKBoKep($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output); 
              break;   
        }
        case "getTKBoSatKep": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKBoSatKep($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
        
         case "getTKTongChan": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
               
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKTongChan($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
        
        case "getTKTongLe": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKTongLe($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
        
        case "getTKBoChanLe": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKBoChanLe($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
        
        case "getTKBoLeChan": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKBoLeChan($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
          
        case "getProvince": {   
              getProvince(); 
              break;        
        }
        
        case "getDreamFile": {   
              getDreamFile(); 
              break;        
        }
        
        case "getTKBoChanChan": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKBoChanChan($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
        
        case "getTKBoLeLe": {   
              $provinceId = isset($_GET['provinceId'])?$_GET['provinceId'] :"1"; 
              $fromDate = isset($_GET['fromDate'])?$_GET['fromDate'] :date("m/d/YY")  ; 
              $fromDate = convertStrdmyyToyymd($fromDate,"/");
              $toDate = isset($_GET['toDate'])?$_GET['toDate'] :date("m/d/YY")  ; 
              $toDate = convertStrdmyyToyymd($toDate,"/");
              
              $isDacBiet = isset($_GET['isDacBiet'])?$_GET['isDacBiet'] :"0"; 
              $output = getTKBoLeLe($provinceId,$fromDate,$toDate,$isDacBiet); 
              echo json_encode($output);   
              break;        
        }
        
        
        case "getThreadHot": { 
              $arrOut = getThreadHot(); 
              echo json_encode($arrOut);   
              break;        
        }
        
       case "getThreadHotComment": {
              $page = isset($_GET['page'])?$_GET['page'] :"1"; 
              $id_thread = isset($_GET['id_thread'])?$_GET['id_thread'] :"1";  
              $limit = isset($_GET['limit'])?$_GET['limit'] :"10";  
          
              $arrComment = getThreadHotComment($id_thread,$page,$limit); 
              $count = countCommentThread($id_thread);
              $arrOut = array();
              $arrOut["count"]  = $count;
              $arrOut["comment"]  = $arrComment;
              updateThreadCountView($id_thread);
              echo json_encode($arrOut);   
              break;        
        }
        
        case "getThreadHotCommentFromId": {
              $id = isset($_GET['id'])?$_GET['id'] :"1"; 
              $id_thread = isset($_GET['id_thread'])?$_GET['id_thread'] :"1";  
              $limit = isset($_GET['limit'])?$_GET['limit'] :"10";  
            
              $arrComment = getThreadHotCommentFromId($id_thread,$id,$limit); 
              $arrOut = array();
              $count = countCommentThread($id_thread);
              $arrOut["count"]  = $count;
              $arrOut["comment"]  = $arrComment;
              
              echo json_encode($arrOut);   
              break;        
        }
        
        case "postComment": { 
            $id_thread = isset($_POST['id_thread'])?$_POST['id_thread'] :"";  
            $id_user = isset($_POST['id_user'])?$_POST['id_user'] :"";  
            $comment = isset($_POST['comment'])?$_POST['comment'] :"";  
            $username = isset($_POST['fullname'])?$_POST['fullname'] :"";
            
           /* $id_thread = isset($_GET['id_thread'])?$_GET['id_thread'] :"";  
            $app_client_id = isset($_GET['id_user'])?$_GET['id_user'] :"";  
            $comment = isset($_GET['comment'])?$_GET['comment'] :"";  
            $username = isset($_GET['username'])?$_GET['username'] :"";    
           */
            if(empty($id_thread)||empty($id_user)||empty($comment)||empty($username)){
                 $arrOut = array();
                 $arrOut["result"]=1;
                 echo json_encode($arrOut);   
                 return;
            }
            
            if($id_user==0){
                 $arrOut = array();
                 $arrOut["result"]=3;
                 echo json_encode($arrOut);   
                 return;
            }
            
            $result = saveComment($id_thread,$id_user,$comment,$username); 
             
            if(!$result){
                  $arrOut = array();
                  $arrOut["result"]=2;
            }else{
                  updateThreadCountComment($id_thread);
                  $arrComment = getThreadHotComment($id_thread,1,10); 
                  $count = countCommentThread($id_thread);
                  $arrOut = array();
                  $arrOut["result"]=0;
                  $arrOut["count"]  = $count;
                  $arrOut["comment"]  = $arrComment;
                 
            }
             echo json_encode($arrOut);   
            break;        
        }
        // Dich vu VIP
        case "getTKLotoGanCucDai": { 
              $arrOut = getTKLotoGanCucDai(); 
              echo json_encode($arrOut);   
              break;        
        }
        
        case "getTKLotoDenKySoVoiKyGanNhat": { 
              $arrOut = getTKLotoDenKySoVoiKyGanNhat(); 
              echo json_encode($arrOut);   
              break;        
        }
        
        case "getTKLotoDenKySoVoiKyCucDai": { 
              $arrOut = getTKLotoDenKySoVoiKyCucDai(); 
              echo json_encode($arrOut);   
              break;        
        }
        
        case "getTKChuKyLoTo": {
              $boso = $_GET["boso"]; 
              $arrOut = getTKChuKyLoTo($boso,0); 
              echo json_encode($arrOut);   
              break;        
        }
        
        case "getTK12BoSoRaNhieu": {
              $songay = 30; 
              $arrOut = getTK12BoSoRaNhieu($songay); 
              $totalboso = countTongBoSoMoThuong($songay);
              $arrKQ = array();  
              foreach($arrOut as $row){
                    $row["percent"] = round( $row["sl"]/ $totalboso*100,2  );
                    $arrKQ[]   =  $row;
              }
              echo json_encode($arrKQ);   
              break;        
        }
        
         case "getTK12BoSoRaIt": {
              $songay = 30; 
              $arrOut = getTK12BoSoRaIt($songay); 
              $totalboso = countTongBoSoMoThuong($songay);
              $arrKQ = array();  
              foreach($arrOut as $row){
                    $row["percent"] = round( $row["sl"]/ $totalboso*100,2  );
                    $arrKQ[]   =  $row;
              }
              echo json_encode($arrKQ);   
              break;        
        }
        
         case "getTKBoSoRaLienTiep": {
              $arrOut = getTKBoSoRaLienTiep(); 
              echo json_encode($arrOut);   
              break;        
        }
       case "getTKDauSoMoThuong": {
              $songay = 30; 
              $arrOut = getTKDauSoMoThuong($songay); 
              $totalboso = countTongDauSoMoThuong($songay);
              $arrKQ = array();  
              foreach($arrOut as $row){
                    $row["percent"] = round( $row["sl"]/ $totalboso*100,2  );
                    $arrKQ[]   =  $row;
              }
              echo json_encode($arrKQ);   
              break;        
        }
        
        case "getTKDuoiSoMoThuong": {
              $songay = 30; 
              $arrOut = getTKDuoiSoMoThuong($songay); 
              $totalboso = countTongDuoiSoMoThuong($songay);
              $arrKQ = array();  
              foreach($arrOut as $row){
                    $row["percent"] = round( $row["sl"]/ $totalboso*100,2  );
                    $arrKQ[]   =  $row;
              }
              echo json_encode($arrKQ);   
              break;        
        } 
        
        case "getTKBoSoMBGanTren10Ngay": {
              $arrOut = getTKBoSoMBGanTren10Ngay(10); 
              echo json_encode($arrOut);   
              break;        
        }
        case "getTKGiaiDacBietTheoNgay": {
             $ngay_quay = date("d-m");
             $arrOut = getTKGiaiDacBietTheoNgay($ngay_quay); 
             echo json_encode($arrOut);   
             break;        
        }
         // App Header User
         case "getAppHeaderXoSo": {
              $app_header = isset($_GET['app_header'])?$_GET['app_header'] :"";
              $app_client_id = isset($_GET['app_client_id'])?$_GET['app_client_id'] :"0";
              $os_version = isset($_GET['os_version'])?$_GET['os_version'] :"";
              $imei = isset($_GET['imei'])?$_GET['imei'] :"";
            
              if(empty($app_header)) echo ""; 
              else {
                
                  $arrOut = getAppHeaderXoSo($app_header,$app_client_id,$os_version,$imei); 
                  echo json_encode($arrOut);   
              }
              
              break;        
        }
        case "getUserXoSo": {
            $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";  
            if(empty($user_id)||$user_id==0) {echo "";break; }
            $arrOut = getUserXoSo($user_id); 
            echo json_encode($arrOut);   
            break;        
        }
        
         case "getTaiKhoanChinh": {
            $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"";  
            if(empty($user_id)) {echo "";break; }
            $arrOut = getTaiKhoanChinh($user_id); 
            echo json_encode($arrOut);   
            break;        
        }
        
        case "getProvinceOpen": {
            $arrOut = getProvinceOpen($app_client_id); 
            echo json_encode($arrOut);   
            break;        
        }
        
        case "updateUser": {
            // get parameters
            $user_id =   isset($_POST['user_id'])?$_POST['user_id'] :"";
            $fullname =   isset($_POST['fullname'])?$_POST['fullname'] :"";
            // check paras
             $kq = 0;
            if(empty($fullname)||empty($user_id)) {$kq = 1;}
          
            $arrKQ = array();
            $kqupdate = updateUser($user_id,$fullname); 
            $userInfo = getUserByIdXoSo($user_id);
            if(!$kqupdate) {$kq = 2;} else $kq = 0;
            
            $arrKQ["result"]=$kq;
            $arrKQ["user"]=$userInfo;
            echo json_encode($arrKQ);
 
             break;        
        }
         case "uploadAvatar": {
            $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";
            uploadAvatar($user_id); 
            break;        
        }
         case "addKenByAppClient": {
            $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"";
            $ken =   isset($_GET['ken'])?$_GET['ken'] :"";
            if(empty($user_id)) {echo 1;return;}
            $result = addKenByAppClient($user_id,$ken); 
            if($result) {echo 0; } else { echo 2;}
            break;        
        }
        
         case "addKenByUsername": {
            $username =   isset($_GET['username'])?$_GET['username'] :"";
            $ken =   isset($_GET['ken'])?$_GET['ken'] :"";
            if(empty($app_client_id)) {echo 1;return;}
            $result = addKenByUsername($username,$ken); 
            if($result) {echo 0; } else { echo 2;}
            break;        
        }
        
        case "postChat": {
            $user_id =   isset($_POST['user_id'])?$_POST['user_id'] :"";
			$user_id = intval($user_id);
            $content =   isset($_POST['content'])?$_POST['content'] :"";
            $deviceName =   isset($_POST['deviceName'])?$_POST['deviceName'] :"";
            $region =   isset($_POST['region'])?$_POST['region'] :"0";
            $chatContent = "user_id:".$user_id." content:".$content." deviceName:".$deviceName." region:".$region;
            
			$checkContent = 0;
			if(strpos($content,"01676.46.6666")>0) {
                $checkContent = 1;
            }
            
            $arrUsers = array(30625,31268,29040,33446,33605,33644);
            $checkUser= 0;
            foreach($arrUsers as $idu){
                if($idu==$user_id)   $checkUser = 1;
            }
            
            if(empty($user_id)||empty($content)||empty($deviceName)||$checkUser==1||$checkContent==1) {
                 $arrOut = array();
                 $arrOut["result"]  = 1;
                 echo json_encode($arrOut);
                 return;
            }
         
            $arrUser = getUserByIdXoSo($user_id);
            if(empty($arrUser)){
                 $arrOut = array();
                 $arrOut["result"]  = 3;
                 echo json_encode($arrOut);
                 return;
            }
            
            
            $username=$arrUser["username"];
            $avatar_url =$arrUser["avatar_url"];
            $id_user = $arrUser["id"];
            $result = postChat($id_user,$username,$avatar_url,$content,$deviceName,$region);
            
            if(!$result){
                  $arrOut = array();
                  $arrOut["result"]  = 2;
                  echo json_encode($arrOut);
            }else {
                  $outputCount = countChat($region); 
                  $outputChat  = getChatBox($region,1,50) ;
                  $arrOut = array();
                  $arrOut["result"]  = 0;
                  $arrOut["count"]  = $outputCount;
                  $arrOut["chat"]  = $outputChat;  
                  echo json_encode($arrOut);    
            }
            
            break;        
        }
        
         case "getChatBox": { 
              $page = isset($_GET['page'])?$_GET['page'] :"1"; 
              $limit = isset($_GET['limit'])?$_GET['limit'] :"10"; 
              $region = isset($_GET['region'])?$_GET['region'] :"0"; 
              $outputChat  = getChatBox($region,$page,$limit) ;
              $arrOut = array();
              $arrOut["count"]  = 0;
              $arrOut["chat"]  = $outputChat;  
              echo json_encode($arrOut);   
              break;        
        }
        
         case "getChatBoxFromID": { 
              $id = isset($_GET['id'])?$_GET['id'] :"10"; 
              $limit = isset($_GET['limit'])?$_GET['limit'] :"10"; 
              $region = isset($_GET['region'])?$_GET['region'] :"0"; 
              $outputChat  = getChatBoxFromID($id,$region,$limit) ;
              $arrOut = array();
              $arrOut["count"]  = 0;
              $arrOut["chat"]  = $outputChat;  
              echo json_encode($arrOut);   
              break;        
        }
        
        case "registryNotice": { 
              $device_token = isset($_GET['device_token'])?$_GET['device_token'] :""; 
              $os_type = isset($_GET['os_type'])?$_GET['os_type'] :"0"; 
              $os_type = intval($os_type);
              $user_id = isset($_GET['user_id'])?$_GET['user_id'] :"0"; 
              $user_id = intval($user_id);
              $app_client_id = isset($_GET['app_client_id'])?$_GET['app_client_id'] :""; 
             
              if($os_type==0||empty($device_token)||strcmp("(null)",$device_token)==0) {echo 1;return;}
            
              if(checkKeyNotifyByAppClient($app_client_id)==0){
                  $kq = insertNoticeUser($app_client_id,$user_id,$device_token,intval($os_type),"");
              }else{
                  updateNoticeUser($user_id,$app_client_id,$device_token);
              }
              
              $kq = 1;
              if($kq == 1) echo 0;
              else echo 2; // insert không thành công

              break;        
        }
        default:  {
            $function = isset ( $_GET ['function'] ) ? $_GET ['function'] : "";
			if (!empty( $function )) {
				$XoSoDoc = new XoSoDOC($function);
				$XoSoDoc->outLine ();
			} else {
                echo "<style> li{padding-top:10px;list-style-type:decimal;} table, td, th {border: 1px solid black;}";
				echo "a:link {text-decoration: none;} a:visited {text-decoration: none;} a:hover {text-decoration: underline;} a:active {text-decoration:underline}</style>";
				echo "<H2>Danh sách Function:</H2>";
				echo "<table style='border: 1px solid black;border-collapse: collapse;'><tr><td>";
				echo "<UL>";
                                 echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getAppHeaderXoSo' target='_blank'>getAppHeaderXoSo</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTTKQXS' target='_blank'>getTTKQXS</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getKTXS' target='_blank'>getKTXS</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getKTXSByRegion' target='_blank'>getKTXSByRegion</a></li>"; 
                                
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getKTXSRegionNewest' target='_blank'>getKTXSRegionNewest</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getDream' target='_blank'>getDream</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKDauSo' target='_blank'>getTKDauSo</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKDuoiSo' target='_blank'>getTKDuoiSo</a></li>";
                                
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoKep' target='_blank'>getTKBoKep</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKTongChan' target='_blank'>getTKTongChan</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKTongLe' target='_blank'>getTKTongLe</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoChanLe' target='_blank'>getTKBoChanLe</a></li>";
                                
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoChanChan' target='_blank'>getTKBoChanChan</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoLeLe' target='_blank'>getTKBoLeLe</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKLotoGanCucDai' target='_blank'>getTKLotoGanCucDai</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKLotoDenKySoVoiKyGanNhat' target='_blank'>getTKLotoDenKySoVoiKyGanNhat</a></li>";
                                  
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKLotoDenKySoVoiKyCucDai' target='_blank'>getTKLotoDenKySoVoiKyCucDai</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKChuKyLoTo' target='_blank'>getTKChuKyLoTo</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTK12BoSoRaNhieu' target='_blank'>getTK12BoSoRaNhieu</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTK12BoSoRaIt' target='_blank'>getTK12BoSoRaIt</a></li>";
                                  echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoSoRaLienTiep' target='_blank'>getTKBoSoRaLienTiep</a></li>";
                                echo "</UL></td><td style='vertical-align:text-top;'>";
                                echo "<UL>";   
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKDauSoMoThuong' target='_blank'>getTKDauSoMoThuong</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKDuoiSoMoThuong' target='_blank'>getTKDuoiSoMoThuong</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoSoRaLienTiep' target='_blank'>getTKBoSoRaLienTiep</a></li>";
                                
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKDauSoMoThuong' target='_blank'>getTKDauSoMoThuong</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKDuoiSoMoThuong' target='_blank'>getTKDuoiSoMoThuong</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKBoSoMBGanTren10Ngay' target='_blank'>getTKBoSoMBGanTren10Ngay</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTKGiaiDacBietTheoNgay' target='_blank'>getTKGiaiDacBietTheoNgay</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getUserXoSo' target='_blank'>getUserXoSo</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getTaiKhoanChinh' target='_blank'>getTaiKhoanChinh</a></li>";
                                 echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=registerMember' target='_blank'>registerMember</a></li>";
                                 echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=updateUser' target='_blank'>updateUser</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=uploadAvatar' target='_blank'>uploadAvatar</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=postChat' target='_blank'>postChat</a></li>";             
                                 echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=registryNotice' target='_blank'>registryNotice</a></li>";             
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=postComment' target='_blank'>postComment</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getChatBox' target='_blank'>getChatBox</a></li>";
                                echo "<li><a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?function=getChatBoxFromID' target='_blank'>getChatBoxFromID</a></li>";
                                echo "</td>";
                                
             } 
        } 
    }
?>

<?php
 function writeLog($mo){
    $date = date('Y-m-d H:i:s');
    $file = dirname(__FILE__).'/logXoSo.txt';
    // Open the file to get existing content
    //$current = file_get_contents($file);
    // Append a new person to the file
    $current =$date."  :  ". $mo."\n";
    // Write the contents back to the file
    file_put_contents($file, $current,FILE_APPEND | LOCK_EX);
 }

?>
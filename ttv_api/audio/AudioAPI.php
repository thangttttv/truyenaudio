<?php
    header('Content-type: text/html; charset=utf-8');     
    require_once("AudioDOC.php");
    require_once("AudioDAO.php");
    require_once("../function/utils.php");
    date_default_timezone_set('Asia/Saigon');   
    
$action = isset ( $_GET ['action'] ) ? $_GET ['action'] : "";    
$token = isset ( $_GET ['token'] ) ? $_GET ['token'] : "";    
$app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
$arr_app_secret = array("8"=>"54a52e51ac510e87ccb431b4c6dfac23", "16"=>"8aa8d43be81a90853749cacbf0930935168");


$limit = 30;
$app_client_id = 0;
    if((strcmp("getAppHeaderAudio",$action)!=0)&&!empty($action)){
            $app_client_id = isset ($_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "";
            
            $ck_token = base64_encode(base64_encode($arr_app_secret[strval($app_id)].$app_id.$app_client_id));
            if(!(strcasecmp($ck_token,$token)==0)) {
                echo "403";return;
            }
                   
}
 // check token
   
    
switch ($action) {
        case "getCategory" :
            {
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
                $app_id = intval ( $app_id );
                
                $output = getCategoryAudio ($app_id);
                echo json_encode ( $output );
                
                $arrPara = array ("app_id"=>$app_id,"token"=>$token);
                $dataLog = createDataLog ( "getCategory", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
        case "getAudioNew" :
            {
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
                $app_id = intval ( $app_id );
                
                $output = getAudioNew($app_id);
                echo json_encode ( $output );
                
               $arrPara = array ("app_id"=>$app_id);
                $dataLog = createDataLog ( "getAudioNew", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
        case "getAudioHot" :
            {
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
                $app_id = intval ( $app_id );
                
                $output = getAudioHot($app_id);
                echo json_encode ( $output );
                
                $arrPara = array ("app_id"=>$app_id);
                $dataLog = createDataLog ("getAudioHot", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
         case "getAudioNewByCat" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ( $page );
                $cat_id = isset ( $_GET ['cat_id'] ) ? $_GET ['cat_id'] : "0";
                $cat_id = intval ( $cat_id );
                
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
                $app_id = intval ( $app_id );
                
                $output = getAudioNewByCat($app_id,$cat_id,$page,$limit);
                echo json_encode ( $output );
                
                $arrPara = array ("app_id"=>$app_id,"cat_id"=>$cat_id,"page"=>$page);
                $dataLog = createDataLog ("getAudioNewByCat", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
         case "getAudioHotByCat" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ( $page );
                $cat_id = isset ( $_GET ['cat_id'] ) ? $_GET ['cat_id'] : "0";
                $cat_id = intval ( $cat_id );
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
                $app_id = intval ( $app_id );
                
                $output = getAudioHotByCat($app_id,$cat_id,$page,$limit);
                echo json_encode ( $output );
                
                $arrPara = array ("app_id"=>$app_id,"cat_id"=>$cat_id,"page"=>$page);
                $dataLog = createDataLog ("getAudioHotByCat", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
          case "getAudioHotDownByCat" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ( $page );
                $cat_id = isset ( $_GET ['cat_id'] ) ? $_GET ['cat_id'] : "0";
                $cat_id = intval ( $cat_id );
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "16";
                $app_id = intval ( $app_id );
                
                $output = getAudioHotDownByCat($app_id,$cat_id,$page,$limit);
                echo json_encode ( $output );
                
                $arrPara = array ("app_id"=>$app_id,"cat_id"=>$cat_id,"page"=>$page);
                $dataLog = createDataLog ("getAudioHotDownByCat", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
          case "getAudioFile" :
            {
                $audio_id = isset ( $_GET ['audio_id'] ) ? $_GET ['audio_id'] : "0";
                $audio_id = intval ( $audio_id );
                
                $output = getAudioFile($audio_id);
                echo json_encode ( $output );
                
                $arrPara = array ("audio_id"=>$audio_id);
                $dataLog = createDataLog ("getAudioFile", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
           case "getAudioDetail" :
            {
                $audio_id = isset ( $_GET ['audio_id'] ) ? $_GET ['audio_id'] : "0";
                $audio_id = intval ( $audio_id );
                
                $output = getAudioDetail($audio_id);
                echo json_encode ( $output );
                
                $arrPara = array ("audio_id"=>$audio_id);
                $dataLog = createDataLog ("getAudioDetail", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
            }
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
            if(empty($email)) $email =  $app_client_id."@truyenaudio.mobi";
            if(empty($app_client_id)){$kq=1;} // thieu tham so
            if(!isValidEmail($email)&&!empty($email)){$kq = 3;}// email khong dung dinh dang
            $user_id  =  0;
            $isNewUser =  0;
            $userDetail =  array();
            // get user info
            if($kq == 0){
                $userDetail =  getUserAudioByEmail($email);
                if(empty($userDetail)) $userDetail = getUserAudioBySSOID($sso_id);
                if(empty($userDetail)){
                     $user_id = registerMemberAudio($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$sso_id);
                     if($user_id > 0)
                        {
                            $userDetail = getUserAudioByID($user_id);
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
            
            $arrPara = array ("app_client_id"=>$app_client_id,"fullname"=>$fullname
            ,"email"=>$email,"sex"=>$sex,"birthday"=>$birthday,"sso_id"=>$sso_id,"mobile"=>$mobile);
            $dataLog = createDataLog ("registerMember", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
            break;
        }
         case "uploadAvatar": {
            $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";
            if(empty($user_id))
             $user_id =   isset($_POST['user_id'])?$_POST['user_id'] :"0";
             
            uploadAvatarAudio($user_id); 
            
            $arrPara = array ("user_id"=>$user_id);
            $dataLog = createDataLog ("uploadAvatar", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
            
            break;        
        }
        case "getAppHeaderAudio":{
              $app_header = isset($_GET['app_header'])?$_GET['app_header'] :"";
              $app_client_id = isset($_GET['app_client_id'])?$_GET['app_client_id'] :"0";
              $os_version = isset($_GET['os_version'])?$_GET['os_version'] :"";
              $imei = isset($_GET['imei'])?$_GET['imei'] :""; 
              if(empty($app_header)) echo ""; 
              else {
                
                  $arrOut = getAppHeaderAudio($app_header,$app_client_id,$os_version,$imei); 
                  echo json_encode($arrOut);   
              }
              
              
            $arrPara = array ("app_client_id"=>$app_client_id,"app_header"=>$app_header
            ,"os_version"=>$os_version,"imei"=>$imei,"token"=>$token);
            $dataLog = createDataLog ("getAppHeaderAudio", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
            
              break;        
        }
        case "getCommentByAudio" :{
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ( $page );
                $audio_id = isset ( $_GET ['audio_id'] ) ? $_GET ['audio_id'] : "0";
                $audio_id = intval ( $audio_id );
                
                $output = getCommentByAudio($audio_id,$page,$limit);
                echo json_encode ( $output );
                
                $arrPara = array ("audio_id"=>$audio_id,"page"=>$page);
                $dataLog = createDataLog ("getCommentByAudio", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
        case "postCommentAudio" :
        {
            $audio_id = isset ( $_POST ['audio_id'] ) ? $_POST ['audio_id'] : "0";
            $audio_id = intval ( $audio_id );
            $user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
            $user_id = intval ( $user_id );
            $comment = isset ( $_POST ['comment'] ) ? $_POST ['comment'] : "";
            $create_user = isset ( $_POST ['create_user'] ) ? $_POST ['create_user'] : "";
          
            $kq = 0;
            // check parameter
            if (empty ( $audio_id ) || empty ( $user_id ) || empty ( $create_user ) || empty ( $comment )) {
                echo "1";$kq = 1;
            }else{
                if($kq==0){
                        $output = postCommentAudio ( $user_id, $audio_id, $comment, $create_user, $create_user );
                        if (intval ( $output ) >= 1) {
                            // clear cache
                               $i = 1;
                               $keyCount = "KEY.countCommentByAudio." . $audio_id;
                               deleteCacheAudioByKey($keyCount);
                                while ( $i <= 100 ) {
                                    $querykey = "KEY.getCommentByAudio.".$audio_id.".".$i;
                                    deleteCacheAudioByKey($querykey);
                                    $i ++;
                                }
                            echo 0;
                            $kq = 0; // success
                        } else {
                            echo 2;
                            $kq = 2; // fail
                        }
                }
            }
            
            
            $arrPara = array ("audio_id" => $audio_id,"user_id" => $user_id,"comment" => $comment,"create_user" => $create_user);
            $ip = getRealIpAddr ();
            $dataLog = createDataLog ( "postCommentAudio", $arrPara, $kq );
            insertAppTrackingAudio ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
         case "searchAudio" :{
                $page = isset ( $_POST ['page'] ) ? $_POST ['page'] : "1";
                $page = intval ( $page );
                $keyword = isset ( $_POST ['keyword'] ) ? $_POST ['keyword'] : "";
                
                if(empty($keyword)) echo "";
                else{
                      $output = searchAudio($keyword,$page,$limit);
                      echo json_encode ($output);
                }
                break;
        }
        case "updateCountListen" :{
                $audio_id = isset ( $_GET ['audio_id'] ) ? $_GET ['audio_id'] : "0";
                $audio_id = intval ( $audio_id );
                
                if(empty($audio_id)) echo "1";
                else{
                      $output = updateCountListen($audio_id);
                      if(intval($output)>0)
                        echo 0;
                      else echo 2;
                     
                }
                break;
        }
        case "updateCountDownload" :{
                $audio_id = isset ( $_GET ['audio_id'] ) ? $_GET ['audio_id'] : "0";
                $audio_id = intval ( $audio_id );
                
                if(empty($audio_id)) echo "1";
                else{
                      $output = updateCountDownload($audio_id);
                      if(intval($output)>0)
                        echo 0;
                      else echo 2;
                     
                }
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
            
              if(checkKeyNotifyAudioByAppClient($app_client_id)==0){
                  $kq = insertNoticeUserAudio($app_client_id,$user_id,$device_token,intval($os_type));
              }else{
                  updateNoticeUserAudio($app_client_id,$device_token);
              }
              
              $kq = 1;
              if($kq == 1) echo 0;
              else echo 2; // insert không thành công

              break;        
        }
         case "getNotices": { 
            $output = getNotices(); 
            echo json_encode ( $output );
                
            $arrPara = array ();
            $dataLog = createDataLog ( "getNotices", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingAudio(0, $app_client_id, $dataLog, $ip );
            break;
         }    
         default :
        {
            $function = isset ( $_GET ['function'] ) ? $_GET ['function'] : "";
            if (! empty ( $function )) {
                $gameStoreDoc = new AudioDOC( $function );
                $gameStoreDoc->outLine ();
            } else {
                $url_api = "http://truyenaudio.mobi/ttv_api/audio/AudioAPI.php";
                
                echo "<style> li{padding-top:10px;list-style-type:decimal;} table, td, th {border: 1px solid black;}";
                echo "a:link {text-decoration: none;} a:visited {text-decoration: none;} a:hover {text-decoration: underline;} a:active {text-decoration:underline}</style>";
                echo "<H1>Danh sách Function Audio:</H1>";
                echo "<table style='border: 1px solid black;border-collapse: collapse;'><tr><td>";
                echo "<UL>";
                echo "<li><a href='".$url_api."?function=getCategory&app_id=16' target='_blank'>getCategory</a></li>";
                echo "<li><a href='".$url_api."?function=getAudioNew&app_id=16' target='_blank'>getAudioNew</a></li>";
                echo "<li><a href='".$url_api."?function=getAudioHot&app_id=16' target='_blank'>getAudioHot</a></li>";
                echo "<li><a href='".$url_api."?function=getAudioNewByCat&app_id=16' target='_blank'>getAudioNewByCat</a></li>";
                echo "<li><a href='".$url_api."?function=getAudioHotByCat&app_id=16' target='_blank'>getAudioHotByCat</a></li>";               
                echo "<li><a href='".$url_api."?function=getAudioHotDownByCat&app_id=16' target='_blank'>getAudioHotDownByCat</a></li>";
                
                echo "<li><a href='".$url_api."?function=getAudioFile' target='_blank'>getAudioFile</a></li>";
                echo "<li><a href='".$url_api."?function=getAudioDetail' target='_blank'>getAudioDetail</a></li>";
                echo "<li><a href='".$url_api."?function=registerMember' target='_blank'>registerMember</a></li>";
                echo "<li><a href='".$url_api."?function=uploadAvatar' target='_blank'>uploadAvatar</a></li>";
                echo "<li><a href='".$url_api."?function=getAppHeaderAudio' target='_blank'>getAppHeaderAudio</a></li>";
                echo "<li><a href='".$url_api."?function=getCommentByAudio' target='_blank'>getCommentByAudio</a></li>";
                echo "<li><a href='".$url_api."?function=postCommentAudio' target='_blank'>postCommentAudio</a></li>";
                echo "<li><a href='".$url_api."?function=searchAudio' target='_blank'>searchAudio</a></li>";
                echo "<li><a href='".$url_api."?function=updateCountListen' target='_blank'>updateCountListen</a></li>";
                echo "<li><a href='".$url_api."?function=updateCountDownload' target='_blank'>updateCountDownload</a></li>";
                echo "<li><a href='".$url_api."?function=registryNotice' target='_blank'>registryNotice</a></li>";
                echo "<li><a href='".$url_api."?function=getNotices' target='_blank'>getNotices</a></li>";
                echo "<UL></td></tr><table>";
                echo "";
            }
        }
}
?>

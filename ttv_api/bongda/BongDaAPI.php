<?php
    date_default_timezone_set('Asia/Saigon');   
    header('Content-type: text/html; charset=utf-8');     
    require_once("BongDaDAO.php");
    require_once("BongDaDOC.php");
    require_once("../function/utils.php");
    
        
    $action = isset ( $_GET ['action'] ) ? $_GET ['action'] : "";    
    $token = isset ( $_GET ['token'] ) ? $_GET ['token'] : "";    

    $limit = 30;
    $app_client_id = 0;
    $arrCateNews  = array("0"=>"Tin tức Tổng hợp","1"=>"Tin Ngoại Hạng Anh","2"=>"Tin Tây Ban Nha","3"=>"Tin Đức","4"=>"Tin Ý","5"=>"Tin Pháp","6"=>"Tin C1","7"=>"Tin C2","8"=>"Tin Việt Nam");  
    $arrCateVideo  = array("0"=>"Video Tổng hợp","1"=>"Video Ngoại Hạng Anh","2"=>"Video Tây Ban Nha","3"=>"Video Đức","4"=>"Video Ý","5"=>"Video Pháp","6"=>"Video C1","7"=>"Video C2","8"=>"Video Việt Nam");       
         
    if((strcmp("getAppHeaderBongDa",$action)!=0)&&!empty($action)){
            $app_client_id = isset ($_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "";
            
            $ck_token = base64_encode(base64_encode("d1ad4c5abed7b4e75e61ea4890b42d28".$app_client_id));
            
            if(!(strcasecmp($ck_token,$token)==0)) {
                echo "403";return;
            }
                   
}

  switch ($action) {
        case "getKetQuaTranDau" : // get kết quả trận đấu
            {
                $match_date = isset ( $_GET ['match_date'] ) ? $_GET ['match_date'] : "";
                $output = getMatchByDate ($match_date);
                echo json_encode ( $output );
                
                $arrPara = array ("match_date"=>$match_date);
                $dataLog = createDataLog ( "getMatchByDate", $arrPara, "" );
                $ip = getRealIpAddr ();
               
                break;
            }
        case "getKetQuaTranDau_DoiBongYeuThich" : // get kết quả trận đấu
            {
                $match_date = isset ( $_GET ['match_date'] ) ? $_GET ['match_date'] : "";
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $clubs = getClubFavorite($app_client_id);
                               
                $output = getMatchFavoriteByClub($match_date,$clubs);
                echo json_encode ( $output );
                
                $arrPara = array ("match_date"=>$match_date,"app_client_id"=>$app_client_id);
                $dataLog = createDataLog ( "getMatchFavoriteByClub", $arrPara, "" );
                $ip = getRealIpAddr ();
               
                break;
            }
        case "getKetQuaTranDau_GiaiDauYeuThich" : // get kết quả trận đấu
            {
                $match_date = isset ( $_GET ['match_date'] ) ? $_GET ['match_date'] : "";
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $cups = getCupFavorite($app_client_id);
                               
                $output = getMatchFavoriteByCup($match_date,$cups);
                echo json_encode ( $output );
                
                $arrPara = array ("match_date"=>$match_date,"app_client_id"=>$app_client_id);
                $dataLog = createDataLog ( "getMatchFavoriteByCup", $arrPara, "" );
                $ip = getRealIpAddr ();
               
                break;
            }
         case "getKetQuaTranDau_YeuThich" : // get kết quả trận đấu
            {
                $match_date = isset ( $_GET ['match_date'] ) ? $_GET ['match_date'] : "";
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $cups = getMatchFavorite($app_client_id);
                               
                $output = getMatchFavoriteByMatch($match_date,$cups);
                echo json_encode ( $output );
                
                $arrPara = array ("match_date"=>$match_date,"app_client_id"=>$app_client_id);
                $dataLog = createDataLog ( "getMatchFavoriteByMatch", $arrPara, "" );
                $ip = getRealIpAddr ();
               
                break;
            }
         case "getLiveScore" : // Lay các trận đấu đang diễn ra
            {
                 $output = getLiveScore();
                 echo json_encode ( $output );
                 break;
            }
          case "getTranDau_ChiTiet" :
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
            
                $output = getMatchDetail($match_id);
                $club_1=getClubDetail($output["club_id_1"]);
                $club_2=getClubDetail($output["club_id_2"]);
                $arrOUT = array();
                $arrOUT["match"]=$output;
                $arrOUT["club_1"]=$club_1;
                $arrOUT["club_2"]=$club_2;
                echo json_encode ( $arrOUT );
                
                $arrPara = array ("match_id"=>$match_id);
                $dataLog = createDataLog ("getMatchDetail", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
            
                break;
            }
           case "getTranDau_TuongThuat" : 
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
             
                $output_ct = getMatchSummary($match_id);
                $output_match = getMatchDetail($match_id);
                $output_video = getVideoByMatch($match_id);
                
                $output = array();
                $output["Match"]=$output_match;
                $output["Detail"]=$output_ct;
                $output["Video"]=$output_video;
                
                echo json_encode ( $output );
                break;
            }
            case "getTranDau_TuongThuatChiTiet" : 
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
                
                $output_ct = getTranDau_TuongThuatChiTiet($match_id);
                $output_match = getMatchDetail($match_id);
                $output = array();
                $output["Match"]=$output_match;
                $output["Detail"]=$output_ct;
                
                 echo json_encode ( $output );
                 
                break;
            }
            case "getTranDau_TuongThuat_IOS" : 
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
             
                $output_ct = getMatchSummary($match_id);
                $output_match = getMatchDetail($match_id);
                
                $output = array();
                $output["Match"]=$output_match;
                $output["Detail"]=$output_ct;
                
                echo json_encode ( $output );
                break;
            }
            case "getTranDau_TuongThuatChiTiet_IOS" : 
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
                
                $output_ct = getTranDau_TuongThuatChiTiet($match_id);
                $output_match = getMatchDetail($match_id);
                $output = array();
                $output["Match"]=$output_match;
                $output["Detail"]=$output_ct;
             
                echo json_encode ( $output );
                break;
            }
            case "getTranDau_PhongDoLichSu" :
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
               
                $output = getMatchDetail($match_id);
                // Get Phong Độ
                $str_phongdo_1=getPhongDoDoiBong($output["club_id_1"]);
                $str_phongdo_2=getPhongDoDoiBong($output["club_id_2"]);
                // Get lịch sử đối đầu
                $arrLichSuDoiDau = getLichSuDoiDau($output["club_id_1"],$output["club_id_2"]);
                $arrayOut = array();
                $arrayOut["phongdo_club_1"]=$str_phongdo_1;
                $arrayOut["phongdo_club_2"]=$str_phongdo_2;
                $arrayOut["lichsu_doidau"]=$arrLichSuDoiDau;
                
                echo json_encode ( $arrayOut );
                break;
            }
          case "getTranDau_TyLe" :
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
               
                $output = array();
                $tyle = getTyLeByMatchId($match_id);
                $vote = getMatchVoteDetail($match_id);
                $output["tyle"]=  $tyle;
                $output["vote"]=  $vote;
                echo json_encode ( $output );
                break;
            }
          case "getTranDau_ThongKe" : 
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
               
               
                $output = getThongKeByMatchId($match_id);
                echo json_encode ( $output );
                break;
            }
          case "getTranDau_DoiHinh" :
            {
                // can chinh sua de lay ra anh va id của cầu thủ
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
               
                $output = getFormationMatch($match_id);
                echo json_encode ( $output );
                break;
            }
          case "getBangXepHang1" :
            {
                // Lay ma giai va nhom dau
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "0";
                $cup_id = intval($cup_id);
                
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "0";
                $club_id = intval($club_id);
                $rowBXH = getInfoBXH($cup_id,$club_id);
                
                $output = "";
                if(!empty($rowBXH))
                $output = getBXHByCupSeasonAndGroup($cup_id,$rowBXH["season"],$rowBXH["cup_group"]);
                echo json_encode ( $output );
                break;
            }
           case "getBangXepHang" :
            {
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "0";
                $cup_id = intval($cup_id);
                
                $club_id_1 = isset ( $_GET ['club_id_1'] ) ? $_GET ['club_id_1'] : "0";
                $club_id_1 = intval($club_id_1);
                $club_id_2 = isset ( $_GET ['club_id_2'] ) ? $_GET ['club_id_2'] : "0";
                $club_id_2 = intval($club_id_2);
              
                $typeBXH = 0;
                // Lay thong tin bang xep hang
                $rowBXH = getInfoBXHByCup($cup_id);
                $arrBXH = array();
                
                if(!empty($rowBXH)){
                    if(!empty($rowBXH["cup_group"])){
                        $typeBXH = 2;
                        // Lay danh sach group
                        $groupBXH = getListGroupBXHByClub($cup_id,$rowBXH["season"],$club_id_1,$club_id_2);
                        // Lay bang xep hang theo group
                        $arrBXH = getBXHLoai2($cup_id,$rowBXH["season"],$groupBXH);
                    }else{
                        $typeBXH = 1;
                        /// Lay bang xephang theo mua giai
                        $arrBXH = getBXHLoai1($cup_id,$rowBXH["season"]);
                    }
                }
              
                
                $output = array();
                if(!empty($arrBXH)){
                    $output["type"]=$typeBXH;
                    $output["BXH"]=$arrBXH;
                    if(  $typeBXH == 2 )
                    $output["GROUP"]=$groupBXH; 
                }
               
                echo json_encode ( $output );
                break;
            }
          case "getBangXepHangGiaiDau" : 
            {
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "0";
                $cup_id = intval($cup_id);
              
                $typeBXH = 0;
                // Lay thong tin bang xep hang
                $rowBXH = getInfoBXHByCup($cup_id);
                $arrBXH = array();
                
                if(!empty($rowBXH)){
                    if(!empty($rowBXH["cup_group"])){
                        $typeBXH = 2;
                        // Lay danh sach group
                        $groupBXH = getListGroupBXH($cup_id,$rowBXH["season"]);
                        // Lay bang xep hang theo group
                        $arrBXH = getBXHLoai2($cup_id,$rowBXH["season"],$groupBXH);
                    }else{
                        $typeBXH = 1;
                        /// Lay bang xephang theo mua giai
                        $arrBXH = getBXHLoai1($cup_id,$rowBXH["season"]);
                    }
                }
              
                
                $output = array();
                if(!empty($arrBXH)){
                    $output["type"]=$typeBXH;
                    $output["BXH"]=$arrBXH;
                    if(  $typeBXH == 2 )
                    $output["GROUP"]=$groupBXH; 
                }
               
                echo json_encode ( $output );
                break;
            }
           case "getCup_LichThiDau" : 
            {
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "1";
                $cup_id = intval($cup_id);
              
                $output = getLichThiDauCup($cup_id);
                echo json_encode ( $output );
                break;
            }
            case "getCup_KetQua" : 
            {
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "1";
                $cup_id = intval($cup_id);
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval($page);
               
                $output = getKetQuaCup($cup_id,$page,$limit);
                echo json_encode ( $output );
                break;
            }
          case "getTranDau_YKienChuyenGia" : 
            {
                
            }
          case "getClub_Info" : 
            {
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "1";
                $club_id = intval($club_id);
               
                $output = getClubInfo($club_id);
                echo json_encode ( $output );
                break;
            }
          case "getClub_KetQua" : 
            {
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "33";
                $club_id = intval($club_id);
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval($page);
               
                $output = getKetQuaClub($club_id,$page,$limit);
                echo json_encode ( $output );
                break;
            }
          case "getClub_LichThiDau" : 
            {
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "33";
                $club_id = intval($club_id);
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval($page);
               
                $output = getLichThiDauClub($club_id,$page,$limit);
                echo json_encode ( $output );
                break;
            }
          case "getClub_CauThu" : 
            {
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "33";
                $club_id = intval($club_id);
                
                $output = getFootballerByClub($club_id);
                echo json_encode ( $output );
                break;
            }
           case "getCauThu_ChiTiet" : 
            {
                $footballer_id = isset ( $_GET ['footballer_id'] ) ? $_GET ['footballer_id'] : "117";
                $footballer_id = intval($footballer_id);
                
                $output = getFootballerDetail($footballer_id);
                echo json_encode ( $output );
                break;
            }
            case "getCoachDetail" : 
            {
                $coach_id = isset ( $_GET ['coach_id'] ) ? $_GET ['coach_id'] : "1";
                $coach_id = intval($coach_id);
                
                $output = getCoachDetail($coach_id);
                echo json_encode ( $output );
                break;
            }
           case "getListVideoByCup" :
            {
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "1";
                $cup_id = intval($cup_id);
                $page = isset ($_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ($page );
                
                $outputVideo = getListVideoByCup($cup_id,$page,$limit);
                $output = array();
                $output["cate"] = $arrCateVideo;
                $output["video"] = $outputVideo;
                
                echo json_encode ( $output );
                break;
            }
            case "getListVideoByClub" : 
            {
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "21";
                $club_id = intval($club_id);
                $page = isset ($_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ($page );
                
                $output = getListVideoByClub($club_id,$page,$limit);
                echo json_encode ( $output );
                break;
            }
           case "getListNewsByClub" : 
            {
                $club_id = isset ( $_GET ['club_id'] ) ? $_GET ['club_id'] : "33";
                $club_id = intval($club_id);
                $page = isset ($_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ($page );
                
                $output = getListNewsByClub($club_id,$page,$limit);
                echo json_encode ( $output );
                break;
            }
            case "getListNewsByCup" : 
            {
                $cup_id = isset ( $_GET ['cup_id'] ) ? $_GET ['cup_id'] : "1";
                $cup_id = intval($cup_id);
                $page = isset ($_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ($page );
                
                $outputNews = getListNewsByCup($cup_id,$page,$limit);
                $output =  array();
                $output["cate"] = $arrCateNews;
                $output["news"] = $outputNews;
                
                echo json_encode ( $output );
                break;
            }
           case "getNewsDetail" : 
            {
                $news_id = isset ( $_GET ['news_id'] ) ? $_GET ['news_id'] : "6";
                $news_id = intval($news_id);
                
                $output = getNewsDetail($news_id);
                echo json_encode ( $output );
                break;
            }
            case "getVideoDetail" : 
            {
                $video_id = isset ( $_GET ['video_id'] ) ? $_GET ['video_id'] : "1";
                $video_id = intval($video_id);
                
                $output = getVideoDetail($video_id);
                echo json_encode ( $output );
                break;
            }
            case "checkHadVoteMatch" : 
            {
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval($match_id);
                
                $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
                $user_id = intval($user_id);
                if($match_id==0||$user_id==0){$kq=0;} else
                {
                    $kq = checkHadVoteMatch($match_id,$user_id);
                }
                echo $kq;
            }
             case "postMatchVote" :
            {
                $match_id = isset ( $_POST ['match_id'] ) ? $_POST ['match_id'] : "0";
                $match_id = intval($match_id);
                
                $user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
                $user_id = intval($user_id);
                
                $vote = isset ( $_POST ['vote'] ) ? $_POST ['vote'] : "0";
                $vote = intval($vote);
                $kq=0;
                if($match_id==0||$user_id==0){$kq=1;} // thieu tham so
                else  
                if(checkMatchVoteExist($match_id)==0){
                    // if chưa có ai vote
                    $match = getMatchDetail($match_id);
                    $club_1_win = 0;$club_2_win = 0;$draws=0;
                    
                    if(!empty($match)&&($match["club_id_1"]==$vote||$match["club_id_2"]==$vote||0==$vote)){
                         if($vote==0){
                            $draws=1;
                        }else if($match["club_id_1"]==$vote) $club_1_win = 1;
                        else if($match["club_id_2"]==$vote) $club_2_win = 1;
                        
                        insertMatchVoteDetail($match_id,$user_id,$vote);
                        insertMatchVote($match_id,$club_1_win,$club_2_win,$draws);
                    }else $kq=3; // khong thanh cong
                   
                }else{
                    // da co nguoi vote
                    $match = getMatchDetail($match_id);$kq = 0;
                    
                    if($match["club_id_1"]==$vote||$match["club_id_2"]==$vote||0==$vote)
                    $kq = insertMatchVoteDetail($match_id,$user_id,$vote);
                    
                    if(!empty($match)&&$kq>0){
                         if($vote==0){
                           updateMatchVoteDraws($match_id);
                        }else if($match["club_id_1"]==$vote){updateMatchVoteClub1($match_id,$vote);} 
                        else if($match["club_id_2"]==$vote){updateMatchVoteClub2($match_id,$vote);}
                     }else $kq=3;// khong thanh cong
                }
                 echo $kq;
                 $arrPara = array ("app_client_id"=>$app_client_id,"app_header"=>$app_header
                ,"match_id"=>$match_id,"user_id"=>$user_id,"vote"=>$vote);
                $dataLog = createDataLog ("postMatchVote", $arrPara, $kq);
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                break;
            }
            case "getAppHeaderBongDa":{
              $app_header = isset($_GET['app_header'])?$_GET['app_header'] :"";
              $app_client_id = isset($_GET['app_client_id'])?$_GET['app_client_id'] :"0";
              $os_version = isset($_GET['os_version'])?$_GET['os_version'] :"";
              $imei = isset($_GET['imei'])?$_GET['imei'] :""; 
              if(empty($app_header)) echo ""; 
              else {
                
                  $arrOut = getAppHeaderBongDa($app_header,$app_client_id,$os_version,$imei); 
                  echo json_encode($arrOut);   
              }
              
              
            $arrPara = array ("app_client_id"=>$app_client_id,"app_header"=>$app_header
            ,"os_version"=>$os_version,"imei"=>$imei,"token"=>$token);
            $dataLog = createDataLog ("getAppHeaderBongDa", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
            
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
                $userDetail =  getUserFBByEmail($email);
                if(empty($userDetail)) $userDetail = getUserFBBySSOID($sso_id);
                if(empty($userDetail)){
                     $user_id = registerMemberFB($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$sso_id);
                     if($user_id > 0)
                        {
                            $userDetail = getUserFBById($user_id);
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
            $dataLog = createDataLog ("registerMember", $arrPara, $kq );
            $ip = getRealIpAddr ();
            insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
            break;
        }
         case "uploadAvatar": {
            $user_id =   isset($_POST['user_id'])?$_POST['user_id'] :"0";
            uploadAvatarFB($user_id); 
            
            $arrPara = array ("user_id"=>$user_id);
            $dataLog = createDataLog ("uploadAvatar", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
            
            break;        
        }
        
         case "getCommentByMatch" :{
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $page = intval ( $page );
                $match_id = isset ( $_GET ['match_id'] ) ? $_GET ['match_id'] : "0";
                $match_id = intval ( $match_id );
                
                $output = getCommentByMatch($match_id,$page,$limit);
                echo json_encode ( $output );
                
                $arrPara = array ("match_id"=>$match_id,"page"=>$page);
                $dataLog = createDataLog ("getCommentByMatch", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
        case "postCommentMatch" :
        {
            $match_id = isset ( $_POST ['match_id'] ) ? $_POST ['match_id'] : "0";
            $match_id = intval ( $match_id );
            $user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
            $user_id = intval ( $user_id );
            $comment = isset ( $_POST ['comment'] ) ? $_POST ['comment'] : "";
            $create_user = isset ( $_POST ['create_user'] ) ? $_POST ['create_user'] : "";
          
            $kq = 0;
            // check parameter
            if (empty ( $match_id ) || empty ( $user_id ) || empty ( $create_user ) || empty ( $comment )) {
                echo "1";$kq = 1;
            }else{
                if($kq==0){
                        $output = postCommentMatch ( $user_id, $match_id, $comment, $create_user );
                        if (intval ( $output ) >= 1) {
                            // clear cache
                               $i = 1;
                               $keyCount = "KEY.countCommentByMatch." . $audio_id;
                               deleteCacheBongDaByKey($keyCount);
                                while ( $i <= 100 ) {
                                    $querykey = "KEY.getCommentByMatch.".$audio_id.".".$i;
                                    deleteCacheBongDaByKey($querykey);
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
            
            
            $arrPara = array ("match_id" => $match_id,"user_id" => $user_id,"comment" => $comment,"create_user" => $create_user);
            $ip = getRealIpAddr ();
            $dataLog = createDataLog ( "postCommentMatch", $arrPara, $kq );
            insertAppTrackingBongDa ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
        case "getClubFavortie" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                
                $output = getClubFavortie($app_client_id);
                echo json_encode ( $output );
                
                $arrPara = array ("app_client_id"=>$app_client_id);
                $dataLog = createDataLog ("getClubFavortie", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
        case "getCupFavortie" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                
                $output = getCupFavortie($app_client_id);
                echo json_encode ( $output );
                
                $arrPara = array ("app_client_id"=>$app_client_id);
                $dataLog = createDataLog ("getCupFavortie", $arrPara, "" );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
        case "postClubFavorite" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                $club_id = isset ( $_POST ['club_id'] ) ? $_POST ['club_id'] : "0";
                $club_id = intval ( $club_id );
                
                $kq = 0;
                if($app_client_id==0||$club_id==0) $kq=1;
                else{
                     $output = postClubFavorite($app_client_id,$club_id);
                     //if(intval($output)>0)$kq=0; else $kq=2;
                     $kq=0;
                }
               
                
                echo $kq;
                
                $arrPara = array ("app_client_id"=>$app_client_id,"club_id"=>$club_id);
                $dataLog = createDataLog ("postClubFavorite", $arrPara, $kq );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
        case "removeClubFavorite" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                $club_id = isset ( $_POST ['club_id'] ) ? $_POST ['club_id'] : "0";
                $club_id = intval ( $club_id );
                
                $kq = 0;
                if($app_client_id==0||$club_id==0) $kq=1;
                else{
                     $output = removeClubFavorite($app_client_id,$club_id);
                     //if(intval($output)>0)$kq=0; else $kq=2;
                     $kq=0;
                }
               
                
                echo $kq;
                
                $arrPara = array ("app_client_id"=>$app_client_id,"club_id"=>$club_id);
                $dataLog = createDataLog ("removeClubFavorite", $arrPara, $kq );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
        case "postCupFavorite" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                $cup_id = isset ( $_POST ['cup_id'] ) ? $_POST ['cup_id'] : "0";
                $cup_id = intval ( $cup_id );
                
                $kq = 0;
                if($app_client_id==0||$cup_id==0) $kq=1;
                else{
                     $output = postCupFavorite($app_client_id,$cup_id);
                     //if(intval($output)>0)$kq=0; else $kq=0;
                     $kq=0;
                }
               
                
                echo $kq;
                
                $arrPara = array ("app_client_id"=>$app_client_id,"cup_id"=>$cup_id);
                $dataLog = createDataLog ("postCupFavorite", $arrPara, $kq );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
         case "postMatchFavorite" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                $match_id = isset ( $_POST ['match_id'] ) ? $_POST ['match_id'] : "0";
                $match_id = intval ( $match_id );
                
                $kq = 0;
                if($app_client_id==0||$match_id==0) $kq=1;
                else{
                     $output = postMatchFavorite($app_client_id,$match_id);
                     //if(intval($output)>0)$kq=0; else $kq=0;
                     $kq=0;
                }
               
                
                echo $kq;
                
                $arrPara = array ("app_client_id"=>$app_client_id,"match_id"=>$match_id);
                $dataLog = createDataLog ("postMatchFavorite", $arrPara, $kq );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
         case "removeCupFavorite" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                $cup_id = isset ( $_POST ['cup_id'] ) ? $_POST ['cup_id'] : "0";
                $cup_id = intval ( $cup_id );
                
                $kq = 0;
                if($app_client_id==0||$cup_id==0) $kq=1;
                else{
                     $output = removeCupFavorite($app_client_id,$cup_id);
                     //if(intval($output)>0)$kq=0; else $kq=0;
                     $kq=0;
                }
               
                
                echo $kq;
                
                $arrPara = array ("app_client_id"=>$app_client_id,"cup_id"=>$cup_id);
                $dataLog = createDataLog ("removeCupFavorite", $arrPara, $kq );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
                break;
        }
          case "removeMatchFavorite" :{
                $app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
                $app_client_id = intval ( $app_client_id );
                $match_id = isset ( $_POST ['match_id'] ) ? $_POST ['match_id'] : "0";
                $match_id = intval ( $match_id );
                
                $kq = 0;
                if($app_client_id==0||$match_id==0) $kq=1;
                else{
                     $output = removeMatchFavorite($app_client_id,$match_id);
                     //if(intval($output)>0)$kq=0; else $kq=2;
                     $kq=0;
                }
               
                
                echo $kq;
                
                $arrPara = array ("app_client_id"=>$app_client_id,"match_id"=>$match_id);
                $dataLog = createDataLog ("removeMatchFavorite", $arrPara, $kq );
                $ip = getRealIpAddr ();
                insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );
                
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
            
              if(checkKeyNotifyFBByAppClient($app_client_id)==0){
                  $kq = insertNoticeUserFB($app_client_id,$user_id,$device_token,intval($os_type));
              }else{
                  updateNoticeUserFB($app_client_id,$device_token);
              }
              
              $kq = 1;
              if($kq == 1) echo 0;
              else echo 2; // insert không thành công
              
              $arrPara = array ("app_client_id"=>$app_client_id,"user_id"=>$user_id
              ,"os_type"=>$os_type,"device_token"=>$device_token);
              $dataLog = createDataLog ("registryNotice", $arrPara, $kq );
              $ip = getRealIpAddr ();
              insertAppTrackingBongDa(0, $app_client_id, $dataLog, $ip );

              break;        
        }  
        case "taoFileCountryClub": {
              $output = getCountryClubSortAlphabet();
              echo json_encode ( $output ); 
              break;
        }
        case "taoFileJSonClub": {
              $output = taoFileJSonClub();
              echo json_encode ( $output ); 
              break;
        } 
        case "taoFileCountryCup": {
              $output = getCountryCupSortAlphabet();
              echo json_encode ( $output ); 
              break;
        }
        case "taoFileJSonCup": {
              $output = taoFileJSonCup();
              echo json_encode ( $output ); 
              break;
        } 
        case "searchClub": {
              $keyword = isset($_POST['keyword'])?$_POST['keyword'] :"arsenal"; 
              $page =   isset($_POST['page'])?$_POST['page'] :"1";
              $page = intval($page);
               if(empty($keyword)) {echo "";return;}
        
              $output = searchClub($keyword,$page,30);
              echo json_encode ( $output ); 
              break;
        }
        case "searchCup": {
              $keyword = isset($_POST['keyword'])?$_POST['keyword'] :"Ngoại Hạng Anh"; 
              $page =   isset($_POST['page'])?$_POST['page'] :"1";
              $page = intval($page);
               if(empty($keyword)) {echo "";return;}
        
              $output = searchCup($keyword,$page,30);
              echo json_encode ( $output ); 
              break;
        } 
        case "searchCoach": {
              $keyword = isset($_POST['keyword'])?$_POST['keyword'] :"Arsene Wenger"; 
              $page =   isset($_POST['page'])?$_POST['page'] :"1";
              $page = intval($page);
               if(empty($keyword)) {echo "";return;}
        
              $output = searchCoach($keyword,$page,30);
              echo json_encode ( $output ); 
              break;
        }
        case "searchFootballer": {
              $keyword = isset($_POST['keyword'])?$_POST['keyword'] :"Peter Odemwingie"; 
              $page =   isset($_POST['page'])?$_POST['page'] :"1";
              $page = intval($page);
               if(empty($keyword)) {echo "";return;}
        
              $output = searchFootballer($keyword,$page,30);
              echo json_encode ( $output ); 
              break;
        }
        case "searchNews": {
              $keyword = isset($_POST['keyword'])?$_POST['keyword'] :"HLV Graechen"; 
              $page =   isset($_POST['page'])?$_POST['page'] :"1";
              $page = intval($page);
               if(empty($keyword)) {echo "";return;}
        
              $output = searchNews($keyword,$page,30);
              echo json_encode ( $output ); 
              break;
        } 
        case "searchVideo": {
              $keyword = isset($_POST['keyword'])?$_POST['keyword'] :"MU"; 
              $page =   isset($_POST['page'])?$_POST['page'] :"1";
              $page = intval($page);
               if(empty($keyword)) {echo "";return;}
        
              $output = searchVideo($keyword,$page,30);
              echo json_encode ( $output ); 
              break;
        }                                                                                                                                                                                                                                       
             default :
        {
            $function = isset ( $_GET ['function'] ) ? $_GET ['function'] : "";
            if (! empty ( $function )) {
                $gameStoreDoc = new BongDaDOC( $function );
                $gameStoreDoc->outLine ();
            } else {
                $url_api = "http://truyenaudio.mobi/ttv_api/bongda/BongDaAPI.php";
                
                echo "<style> li{padding-top:10px;list-style-type:decimal;} table, td, th {border: 1px solid black;}";
                echo "a:link {text-decoration: none;} a:visited {text-decoration: none;} a:hover {text-decoration: underline;} a:active {text-decoration:underline}</style>";
                echo "<H1>Danh sách Function Bong Da:</H1>";
                echo "<table style='border: 1px solid black;border-collapse: collapse;'><tr><td>";
                echo "<UL>";
                echo "<li><a href='".$url_api."?function=getKetQuaTranDau' target='_blank'>getKetQuaTranDau</a></li>";
                echo "<li><a href='".$url_api."?function=getLiveScore' target='_blank'>getLiveScore</a></li>";
                
                echo "<li><a href='".$url_api."?function=getTranDau_ChiTiet' target='_blank'>getTranDau_ChiTiet</a></li>";
                echo "<li><a href='".$url_api."?function=getTranDau_TuongThuat' target='_blank'>getTranDau_TuongThuat</a></li>";
                 echo "<li><a href='".$url_api."?function=getTranDau_TuongThuatChiTiet' target='_blank'>getTranDau_TuongThuatChiTiet</a></li>";
                echo "<li><a href='".$url_api."?function=getTranDau_PhongDoLichSu' target='_blank'>getTranDau_PhongDoLichSu</a></li>";
                echo "<li><a href='".$url_api."?function=getTranDau_TyLe' target='_blank'>getTranDau_TyLe</a></li>";
                echo "<li><a href='".$url_api."?function=getTranDau_ThongKe' target='_blank'>getTranDau_ThongKe</a></li>";
                echo "<li><a href='".$url_api."?function=getTranDau_DoiHinh' target='_blank'>getTranDau_DoiHinh</a></li>";
                 
                echo "<li><a href='".$url_api."?function=getBangXepHang' target='_blank'>getBangXepHang</a></li>";
                echo "<li><a href='".$url_api."?function=getBangXepHangGiaiDau' target='_blank'>getBangXepHangGiaiDau</a></li>";
                echo "<li><a href='".$url_api."?function=getCup_LichThiDau' target='_blank'>getCup_LichThiDau</a></li>";
                echo "<li><a href='".$url_api."?function=getCup_KetQua' target='_blank'>getCup_KetQua</a></li>";
               
                echo "<li><a href='".$url_api."?function=getClub_Info' target='_blank'>getClub_Info</a></li>";
                echo "<li><a href='".$url_api."?function=getClub_KetQua' target='_blank'>getClub_KetQua</a></li>";
                echo "<li><a href='".$url_api."?function=getClub_LichThiDau' target='_blank'>getClub_LichThiDau</a></li>";
                echo "<li><a href='".$url_api."?function=getClub_CauThu' target='_blank'>getClub_CauThu</a></li>";
                echo "<li><a href='".$url_api."?function=getCauThu_ChiTiet' target='_blank'>getCauThu_ChiTiet</a></li>";
              
                echo "<li><a href='".$url_api."?function=getListNewsByClub' target='_blank'>getListNewsByClub</a></li>";
               
                
              /*   
                echo "<li><a href='".$url_api."?function=postCommentTranDau' target='_blank'>postCommentTranDau</a></li>";
                echo "<li><a href='".$url_api."?function=postMatchNotify' target='_blank'>postMatchNotify</a></li>";*/
                echo "</UL></TD><TD valign=top><UL>";
                echo "<li><a href='".$url_api."?function=getListNewsByCup' target='_blank'>getListNewsByCup</a></li>";
                echo "<li><a href='".$url_api."?function=getNewsDetail' target='_blank'>getNewsDetail</a></li>";
                echo "<li><a href='".$url_api."?function=getListVideoByClub' target='_blank'>getListVideoByClub</a></li>";
                echo "<li><a href='".$url_api."?function=getListVideoByCup' target='_blank'>getListVideoByCup</a></li>";
                echo "<li><a href='".$url_api."?function=getVideoDetail' target='_blank'>getVideoDetail</a></li>";
                echo "<li><a href='".$url_api."?function=getAppHeaderBongDa' target='_blank'>getAppHeaderBongDa</a></li>";
                echo "<li><a href='".$url_api."?function=registerMember' target='_blank'>registerMember</a></li>";
                echo "<li><a href='".$url_api."?function=uploadAvatar' target='_blank'>uploadAvatar</a></li>";
                echo "<li><a href='".$url_api."?function=getCommentByMatch' target='_blank'>getCommentByMatch</a></li>";
                echo "<li><a href='".$url_api."?function=postCommentMatch' target='_blank'>postCommentMatch</a></li>";
                
                echo "<li><a href='".$url_api."?function=checkHadVoteMatch' target='_blank'>checkHadVoteMatch</a></li>";
                echo "<li><a href='".$url_api."?function=postMatchVote' target='_blank'>postMatchVote</a></li>";
                echo "<li><a href='".$url_api."?function=getClubFavortie' target='_blank'>getClubFavortie</a></li>";
                echo "<li><a href='".$url_api."?function=getCupFavortie' target='_blank'>getCupFavortie</a></li>";
                echo "<li><a href='".$url_api."?function=postClubFavorite' target='_blank'>postClubFavorite</a></li>";
                echo "<li><a href='".$url_api."?function=postCupFavorite' target='_blank'>postCupFavorite</a></li>";
                echo "<li><a href='".$url_api."?function=postMatchFavorite' target='_blank'>postMatchFavorite</a></li>";
                echo "<li><a href='".$url_api."?function=removeClubFavorite' target='_blank'>removeClubFavorite</a></li>";
                echo "<li><a href='".$url_api."?function=removeCupFavorite' target='_blank'>removeCupFavorite</a></li>";
              
                
                echo "</UL></TD><TD valign=top><UL>"; 
                echo "<li><a href='".$url_api."?function=removeMatchFavorite' target='_blank'>removeMatchFavorite</a></li>";
                echo "<li><a href='".$url_api."?function=registryNotice' target='_blank'>registryNotice</a></li>"; 
                echo "<li><a href='".$url_api."?function=taoFileCountryClub' target='_blank'>taoFileCountryClub</a></li>";
                echo "<li><a href='".$url_api."?function=taoFileJSonClub' target='_blank'>taoFileJSonClub</a></li>";  
                echo "<li><a href='".$url_api."?function=taoFileCountryCup' target='_blank'>taoFileCountryCup</a></li>";
                echo "<li><a href='".$url_api."?function=taoFileJSonCup' target='_blank'>taoFileJSonCup</a></li>"; 
                echo "<li><a href='".$url_api."?function=getKetQuaTranDau_DoiBongYeuThich' target='_blank'>getKetQuaTranDau_DoiBongYeuThich</a></li>";  
                echo "<li><a href='".$url_api."?function=getKetQuaTranDau_GiaiDauYeuThich' target='_blank'>getKetQuaTranDau_GiaiDauYeuThich</a></li>";  
                echo "<li><a href='".$url_api."?function=getKetQuaTranDau_YeuThich' target='_blank'>getKetQuaTranDau_YeuThich</a></li>";
               
                echo "<li><a href='".$url_api."?function=searchClub' target='_blank'>searchClub</a></li>";   
                echo "<li><a href='".$url_api."?function=searchCup' target='_blank'>searchCup</a></li>";   
                echo "<li><a href='".$url_api."?function=searchCoach' target='_blank'>searchCoach</a></li>";   
                echo "<li><a href='".$url_api."?function=searchFootballer' target='_blank'>searchFootballer</a></li>";   
                echo "<li><a href='".$url_api."?function=searchNews' target='_blank'>searchNews</a></li>";   
                echo "<li><a href='".$url_api."?function=searchVideo' target='_blank'>searchVideo</a></li>";
                echo "<li><a href='".$url_api."?function=getCoachDetail' target='_blank'>getCoachDetail</a></li>";            
                echo "</UL></td></tr><table>";
                echo "";
            }
        }
               
  }
            
?>

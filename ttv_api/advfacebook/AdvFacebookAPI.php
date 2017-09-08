<?php
    header ( 'Content-type: text/html; charset=utf-8' );
    require_once ("AdvFacebookDAO.php");
    require_once ("AdvFacebookDOC.php");
    require_once ("../function/utils.php");
    date_default_timezone_set ( 'Asia/Saigon' );

    $output = array ();
    $action = isset ( $_GET ['action'] ) ? $_GET ['action'] : "";
    $limitItem = 10;

    switch ($action) {
        case "getAccountFacebook" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $result = getAccountFacebook(10,intval($page));
                echo json_encode($result);
                break;
            }
        case "getAccountFacebookSending" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "0"; // app_id key facebook_app
                $result = getAccountFacebookSending($app_id,10,intval($page));
                echo json_encode($result);
                break;
            }
         case "getAccountFacebookSented" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "0"; // app_id key facebook_app
                $result = getAccountFacebookSented($app_id,10,intval($page));
                echo json_encode($result);
                break;
            }
         case "getAccountFacebookDontSend" :
            {
                $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
                $app_id = isset ( $_GET ['app_id'] ) ? $_GET ['app_id'] : "0"; // app_id key facebook_app
                $result = getAccountFacebookDontSend($app_id,10,intval($page));
                echo json_encode($result);
                break;
            }
        case "insertCampaignInvite" :
            {
                $app_id = isset ( $_POST ['fb_app_id'] ) ? $_POST ['fb_app_id'] : ""; // facebook_app_id key facebook_app
                $title = isset ( $_POST ['title'] ) ? $_POST ['title'] : "";
                $account_id = isset ( $_POST ['account_id'] ) ? $_POST ['account_id'] : "";
                
                if(empty($app_id)||empty($title)||empty($account_id)){
                    echo 1;return;
                }else{
                    $id = insertCampaignInvite ($app_id,$title,$account_id);
                    echo 0; return;
                }
                break;
            }
        case "addCountCampaignInvite" :
            {
                $campaign_id = isset ( $_POST ['campaign_id'] ) ? $_POST ['campaign_id'] : "0";
                $count = isset ( $_POST ['count'] ) ? $_POST ['count'] : "0";
                
                if(empty($campaign_id)||empty($count)){
                    echo 1;return;
                }else{
                    $id = addCountCampaignInvite ($campaign_id,$count);
                    echo 0; return;
                }
                break;
            }
         case "addCountCampaignInvite2" :
            {
                // app_id auto incr
                $campaign_id = isset ( $_POST ['campaign_id'] ) ? $_POST ['campaign_id'] : "0";
                $count = isset ( $_POST ['count_sent'] ) ? $_POST ['count_sent'] : "0";
                $total_countSend = isset ( $_POST ['total_countSend'] ) ? $_POST ['total_countSend'] : "0";
                $count_friend = isset ( $_POST ['count_friend'] ) ? $_POST ['count_friend'] : "0";
                
                if(empty($campaign_id)||empty($count)){
                    echo 1;return;
                }else{
                    $id = addCountCampaignInvite ($campaign_id,$count);
                  //  $campaign = getCampaignById($campaign_id);
                  //  $countKeyInvite = countFacebookUserInvitable($account_id);
                    //if(!empty($campaign)){
                        if($total_countSend<$count_friend&&$total_countSend>0){
                            updateStatusAccountSend($account_id,$app_id,1);
                        }else if($total_countSend>=$count_friend&&$total_countSend>0){
                            updateStatusAccountSend($account_id,$app_id,2);
                        }
                    //s}
                    echo 0; return;
                }
                break;
            }
        case "insertInviteLog" :
            {
                $campaign_id = isset ( $_POST ['campaign_id'] ) ? $_POST ['campaign_id'] : "0";
                $facebook_user_id = isset ( $_POST ['facebook_user_id'] ) ? $_POST ['facebook_user_id'] : "";
                
                if(empty($campaign_id)||empty($facebook_user_id)){
                    echo 1;return;
                }else{
                    $id = insertInviteLog ($campaign_id,$facebook_user_id);
                    echo 0; return;
                }
                break;
            }
        case "countCampaignByGame" :
            {
                $app_id = isset ( $_GET ['fb_app_id'] ) ? $_GET ['fb_app_id'] : ""; // facebook_app_id
                
                if(empty($app_id)){
                    echo "";return;
                }else{
                    $count = countCampaignByGame ($app_id);
                    echo $count; return;
                }
                break;
            }
        case "countFacebookUserInvitable" :
            {
                $account_id = isset ( $_GET ['account_id'] ) ? $_GET ['account_id'] : "";
                
                if(empty($account_id)){
                    echo "";return;
                }else{
                    $count = countFacebookUserInvitable ($account_id);
                    echo $count; return;
                }
                break;
            }
        case "getCampaignInvite" :
            {
                $account_id = isset ( $_GET ['account_id'] ) ? $_GET ['account_id'] : "";
                $app_id = isset ( $_GET ['fb_app_id'] ) ? $_GET ['fb_app_id'] : ""; // facebook_app_id
                   $arrOut = getCampaignInvite($account_id,$app_id);
                   echo json_encode ($arrOut);
                   break;
            }
         case "getFacebookAccountByEmail" :
            {
             $email = isset ( $_GET ['email'] ) ? $_GET ['email'] : "";
                   $arrOut = getFacebookAccountByEmail($email);
                   echo json_encode ($arrOut);
                   break;
            }
        case "getFacebookUserIdInvitable" :
            {
                $account_id = isset ( $_GET ['account_id'] ) ? $_GET ['account_id'] : "";
                //$campaign_id = isset ( $_GET ['campaign_id'] ) ? $_GET ['campaign_id'] : "";
                $last_id = isset ( $_GET ['last_id'] ) ? $_GET ['last_id'] : "0";
                
                   $arrOut = getFacebookUserIdInvitableFromLastID($account_id,$last_id);
                   echo json_encode ($arrOut);
                   break;
            }
         default:{
             $function = isset ( $_GET ['function'] ) ? $_GET ['function'] : "";
            if (! empty ( $function )) {
                $gameStoreDoc = new ADVFacebookDOC ( $function );
                $gameStoreDoc->outLine ();
            } else {
                echo "<style> li{padding-top:10px;list-style-type:decimal;} table, td, th {border: 1px solid black;}";
                echo "a:link {text-decoration: none;} a:visited {text-decoration: none;} a:hover {text-decoration: underline;} a:active {text-decoration:underline}</style>";
                echo "<H1>Danh sách Function:</H1>";
                echo "<table style='border: 1px solid black;border-collapse: collapse;'><tr><td>";
                echo "<UL>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=insertCampaignInvite' target='_blank'>insertCampaignInvite</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=addCountCampaignInvite' target='_blank'>addCountCampaignInvite</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=insertInviteLog' target='_blank'>insertInviteLog</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=countFacebookUserInvitable' target='_blank'>countFacebookUserInvitable</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getCampaignInvite' target='_blank'>getCampaignInvite</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=countCampaignByGame' target='_blank'>countCampaignByGame</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getFacebookUserIdInvitable' target='_blank'>getFacebookUserIdInvitable</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getFacebookAccountByEmail' target='_blank'>getFacebookAccountByEmail</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getAccountFacebook' target='_blank'>getAccountFacebook</a></li>";
                 
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getAccountFacebookSending' target='_blank'>getAccountFacebookSending</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getAccountFacebookSented' target='_blank'>getAccountFacebookSented</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=getAccountFacebookDontSend' target='_blank'>getAccountFacebookDontSend</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?function=addCountCampaignInvite2' target='_blank'>addCountCampaignInvite2</a></li>";
                echo "</UL>";
            }
             break; 
         }
        
    }
?>

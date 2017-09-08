<?php
header ( 'Content-type: text/html; charset=utf-8' );
require_once ("GameStoreDAO.php");
require_once ("GameStoreMarketDAO.php");
require_once ("GameStoreHomeDAO.php");
require_once ("GameStoreDOC.php");

require_once ("../../function/utils.php");
require_once ("GameStoreNotify.php");

date_default_timezone_set ( 'Asia/Saigon' );

$output = array ();
$action = isset ( $_GET ['action'] ) ? $_GET ['action'] : "";
$limitItem = 10;
$pageCacheClear = 100;
$arr_bg_user  =  array();
$arr_bg_user[0] =  "http://kenhkiemtien.com/upload/gamestore/background_user/background_User_1.png";
$arr_bg_user[1] =  "http://kenhkiemtien.com/upload/gamestore/background_user/background_User_2.png";
$arr_bg_user[2] =  "http://kenhkiemtien.com/upload/gamestore/background_user/background_User_3.jpg";

// check Token

if((strcmp("getAppHeader",$action)!=0)&&!empty($action)){
            $app_client_id = isset ($_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "";
            $token = isset ( $_GET ['token'] ) ? $_GET ['token'] : "";
            $checkToken = checkToken($app_client_id,$token);
            if($checkToken==0) {echo "403";return;}
}
            
switch ($action) {
    case "getBackgroundUser" :
        {
            $stt = rand(0,2);
            $output = $arr_bg_user[$stt];
            echo $output;
            break;
        }
	case "getCategory" :
		{
           $output = getCategory ();
			echo json_encode ( $output );
			break;
		}
	case "getPublisher" :
		{
			$output = getPublisher ();
			echo json_encode ( $output );
			break;
		}
	case "getGameAPKHomeHot" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $is_play = isset ( $_GET ['is_play'] ) ? $_GET ['is_play'] : "0";
            $is_play = intval ( $is_play );
            
			$output = getGameAPKHomeHot($limitItem, $page,$is_play );
            $outputUserDown = getUserDownloadView($output["game"],2);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
			echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page 
			);
			$dataLog = createDataLog ( "getGameAPKHomeHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	case "getGameAPKHomeNew" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
            $is_play = isset ( $_GET ['is_play'] ) ? $_GET ['is_play'] : "0";
            $is_play = intval ( $is_play );
            
			$output = getGameAPKHomeNew ( $limitItem, $page,$is_play );
            $outputUserDown = getUserDownloadView($output["game"],2);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page 
			);
			$dataLog = createDataLog ( "getGameAPKHomeNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	case "getGameAPKByCategoryHot" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
			$category_id = intval ( $category_id );
		    $is_play = isset ( $_GET ['is_play'] ) ? $_GET ['is_play'] : "0";
            $is_play = intval ( $is_play );
            
			$output = getGameAPKByCategoryHot ( $category_id, $limitItem, $page,$is_play);
			$outputUserDown = getUserDownloadView($output["game"],2);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"category_id" => $category_id 
			);
			$dataLog = createDataLog ( "getGameAPKByCategoryHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameAPKByCategoryNew" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
			$category_id = intval ( $category_id );
			$is_play = isset ( $_GET ['is_play'] ) ? $_GET ['is_play'] : "0";
            $is_play = intval ( $is_play );
            
			$output = getGameAPKByCategoryNew ( $category_id, $limitItem, $page ,$is_play);
			$outputUserDown = getUserDownloadView($output["game"],2);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"category_id" => $category_id 
			);
			$dataLog = createDataLog ( "getGameAPKByCategoryNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameAPKByPublisherNew" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
			$publisher_id = intval ( $publisher_id );
            $is_play = isset ( $_GET ['is_play'] ) ? $_GET ['is_play'] : "0";
            $is_play = intval ( $is_play );
			
			$output = getGameAPKByPublisherNew ( $publisher_id, $limitItem, $page,$is_play );
			$outputUserDown = getUserDownloadView($output["game"],2);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"publisher_id" => $publisher_id 
			);
			$dataLog = createDataLog ( "getGameAPKByPublisherNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameAPKByPublisherHot" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
			$publisher_id = intval ( $publisher_id );
			$is_play = isset ( $_GET ['is_play'] ) ? $_GET ['is_play'] : "0";
            $is_play = intval ( $is_play );
            
			$output = getGameAPKByPublisherHot( $publisher_id, $limitItem, $page,$is_play );
			$outputUserDown = getUserDownloadView($output["game"],2);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"publisher_id" => $publisher_id 
			);
			$dataLog = createDataLog ( "getGameAPKByPublisherHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameIOSHomeHot" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$output = getGameIOSHomeHot ( $limitItem, $page );
			$outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page 
			);
			$dataLog = createDataLog ( "getGameIOSHomeHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
    case "getGameIOSHomeHotItune" :
        {
            $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $output = getGameIOSHomeHotItune ( $limitItem, $page );
            $outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
            
            $arrPara = array (
                    "page" => $page 
            );
            $dataLog = createDataLog ( "getGameIOSHomeHotItune", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
	case "getGameIOSHomeNew" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$output = getGameIOSHomeNew ( $limitItem, $page );
			$outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page 
			);
			$dataLog = createDataLog ( "getGameIOSHomeNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	case "getGameIOSHomeNewItune" :
        {
            $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $output = getGameIOSHomeNewItune ( $limitItem, $page );
            $outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
            
            $arrPara = array (
                    "page" => $page 
            );
            $dataLog = createDataLog ( "getGameIOSHomeNewItune", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
	case "getGameIOSByPublisherHot" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
			$publisher_id = intval ( $publisher_id );
			
			$output = getGameIOSByPublisherHot ( $publisher_id, $limitItem, $page );
			$outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"publisher_id" => $publisher_id 
			);
			$dataLog = createDataLog ( "getGameIOSByPublisherHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
    case "getGameIOSByPublisherHotItune" :
        {
            $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
            $publisher_id = intval ( $publisher_id );
            
            $output = getGameIOSByPublisherHotItune ( $publisher_id, $limitItem, $page );
            $outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
            
            $arrPara = array (
                    "page" => $page,
                    "publisher_id" => $publisher_id 
            );
            $dataLog = createDataLog ( "getGameIOSByPublisherHotItune", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
	case "getGameIOSByPublisherNew" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
			$publisher_id = intval ( $publisher_id );
			
			$output = getGameIOSByPublisherNew ( $publisher_id, $limitItem, $page );
			$outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"publisher_id" => $publisher_id 
			);
			$dataLog = createDataLog ( "getGameIOSByPublisherNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	case "getGameIOSByPublisherNewItune" :
        {
            $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
            $publisher_id = intval ( $publisher_id );
            
            $output = getGameIOSByPublisherNewItune ( $publisher_id, $limitItem, $page );
            $outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
            
            $arrPara = array (
                    "page" => $page,
                    "publisher_id" => $publisher_id 
            );
            $dataLog = createDataLog ( "getGameIOSByPublisherNewItune", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
    case "getGameIOSByCategoryNew" :
        {
            $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
            $category_id = intval ( $category_id );
            
            $output = getGameIOSByCategoryNew ( $category_id, $limitItem, $page );
            $outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
            
            $arrPara = array (
                    "page" => $page,
                    "category_id" => $category_id 
            );
            $dataLog = createDataLog ( "getGameIOSByCategoryNewItune", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
	case "getGameIOSByCategoryNewItune" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
			$category_id = intval ( $category_id );
			
			$output = getGameIOSByCategoryNewItune ( $category_id, $limitItem, $page );
			$outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"category_id" => $category_id 
			);
			$dataLog = createDataLog ( "getGameIOSByCategoryNewItune", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameIOSByCategoryHot" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
			$category_id = intval ( $category_id );
			
			$output = getGameIOSByCategoryHot ( $category_id, $limitItem, $page );
			$outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
			
			$arrPara = array (
					"page" => $page,
					"category_id" => $category_id 
			);
			$dataLog = createDataLog ( "getGameIOSByCategoryHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	case "getGameIOSByCategoryHotItune" :
        {
            $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
            $page = intval ( $page );
            $category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
            $category_id = intval ( $category_id );
            
            $output = getGameIOSByCategoryHotItune ( $category_id, $limitItem, $page );
            $outputUserDown = getUserDownloadView($output["game"],3);
            
            $arrOut = array();
            $arrOut["game_data"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            echo json_encode ($arrOut);
            
            $arrPara = array (
                    "page" => $page,
                    "category_id" => $category_id 
            );
            $dataLog = createDataLog ( "getGameIOSByCategoryHotItune", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
	case "getGameAPKDetail" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
			$id = intval ( $id );
			
			$output = getGameAPKDetail ( $id );
			echo json_encode ( $output );
			
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ( "getGameAPKDetail", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameIOSDetail" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
			$id = intval ( $id );
			
			$output = getGameIOSDetail ( $id );
			echo json_encode ($output);
			
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ( "getGameIOSDetail", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getContactGame" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
			$id = intval ( $id );
			
			$output = getContactGame ( $id );
			echo json_encode ( $output );
			
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ( "getContactGame", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getNewsHome" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			
			$output = getNewsHome ( $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page 
			);
			$dataLog = createDataLog ( "getNewsHome", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getNewsByCategory" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
			$category_id = intval ( $category_id );
			
			$output = getNewsByCategory ( $category_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"category_id" => $category_id 
			);
			$dataLog = createDataLog ( "getNewsByCategory", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getNewsByPublisher" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "0";
			$publisher_id = intval ( $publisher_id );
			
			$output = getNewsByPublisher ( $publisher_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"publisher_id" => $publisher_id 
			);
			$dataLog = createDataLog ( "getNewsByPublisher", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getNewsByGame" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "1";
			$game_id = intval ( $game_id );
			
			$output = getNewsByGame ( $game_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"game_id" => $game_id 
			);
			$dataLog = createDataLog ( "getNewsByGame", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getNewsDetail" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "1";
			$id = intval ( $id );
			
			$output = getNewsDetail ( $id );
			echo json_encode ( $output );
			
			addCountViewNews ( $id );
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ( "getNewsDetail", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeHome" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$output = getGiftCodeHome ( $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page 
			);
			$dataLog = createDataLog ( "getGiftCodeHome", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeByCategory" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			
			$category_id = isset ( $_GET ['category_id'] ) ? $_GET ['category_id'] : "1";
			$category_id = intval ( $category_id );
			
			$output = getGiftCodeByCategory ( $category_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"category_id" => $category_id 
			);
			$dataLog = createDataLog ( "getGiftCodeByCategory", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeByPublisher" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			
			$publisher_id = isset ( $_GET ['publisher_id'] ) ? $_GET ['publisher_id'] : "1";
			$publisher_id = intval ( $publisher_id );
			
			$output = getGiftCodeByPublisher ( $publisher_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"publisher_id" => $publisher_id 
			);
			$dataLog = createDataLog ( "getGiftCodeByPublisher", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeByGameId" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			
			$game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "1";
			$game_id = intval ( $game_id );
			
			$output = getGiftCodeByGameId ( $game_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"game_id" => $game_id 
			);
			$dataLog = createDataLog ( "getGiftCodeByGameId", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeDetailIOS" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "1";
			$id = intval ( $id );
			
			$output = getGiftCodeDetailIOS ( $id );
			echo json_encode ( $output );
			
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ("getGiftCodeDetailIOS", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeDetailAPK" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "1";
			$id = intval ( $id );
			
			$output = getGiftCodeDetailAPK ( $id );
			echo json_encode ( $output );
			
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ( "getGiftCodeDetailAPK", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getCommentByNewsId" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$news_id = isset ( $_GET ['news_id'] ) ? $_GET ['news_id'] : "0";
			$news_id = intval ( $news_id );
			
			$output = getCommentByNewsId ( $news_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"news_id" => $news_id 
			);
			$dataLog = createDataLog ( "getCommentByNewsId", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getDiscussionByGameId" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
			$game_id = intval ( $game_id );
			
			$output = getDiscussionByGameId ( $game_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"game_id" => $game_id 
			);
			$dataLog = createDataLog ( "getDiscussionByGameId", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getDiscussionDetail" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
			$id = intval ( $id );
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			
			$output = getDiscussionDetail ( $id, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"id" => $id,
					"page" => $page 
			);
			$dataLog = createDataLog ( "getDiscussionDetail", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getDiscussionComment" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$discussion_id = isset ( $_GET ['discussion_id'] ) ? $_GET ['discussion_id'] : "0";
			$discussion_id = intval ( $discussion_id );
			
			$output = getDiscussionComment ( $discussion_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"discussion_id" => $discussion_id 
			);
			$dataLog = createDataLog ( "getDiscussionComment", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGameReview" :
		{
			$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : "1";
			$page = intval ( $page );
			$game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
			$game_id = intval ( $game_id );
			
			$output = getGameReview ( $game_id, $limitItem, $page );
			echo json_encode ( $output );
			
			$arrPara = array (
					"page" => $page,
					"game_id" => $game_id 
			);
			$dataLog = createDataLog ( "getGameReview", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getBannerIOSTopHot" :
		{
			// 1 Top Hot
			$output = getBannerIOSByPosition ( 1 );
			echo json_encode ( $output );
			
			$arrPara = array (
					"position" => 1,
					"os" => "3" 
			);
			$dataLog = createDataLog ( "getBannerIOSTopHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getBannerIOSTopNew" :
		{
			// 2 Top New
			$output = getBannerIOSByPosition ( 2 );
			echo json_encode ( $output );
			
			$arrPara = array (
					"position" => 2,
					"os" => "3" 
			);
			$dataLog = createDataLog ( "getBannerIOSTopNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getBannerAndroidTopHot" :
		{
			// 1 Top Hot
			$output = getBannerAndroidByPosition ( 1 );
			echo json_encode ( $output );
			
			$arrPara = array (
					"position" => 1,
					"os" => "2" 
			);
			$dataLog = createDataLog ( "getBannerAndroidTopHot", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getBannerAndroidTopNew" :
		{
			// 1 Top New
			$output = getBannerAndroidByPosition ( 2 );
			echo json_encode ( $output );
			
			$arrPara = array (
					"position" => 2,
					"os" => "2" 
			);
			$dataLog = createDataLog ( "getBannerAndroidTopNew", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getGiftCodeStoreAvailable" :
		{
			$giftcode_id = isset ( $_GET ['giftcode_id'] ) ? $_GET ['giftcode_id'] : "0";
			$giftcode_id = intval ( $giftcode_id );
            $user_id = isset ($_GET ['user_id'] )?$_GET ['user_id'] : "0";
            $user_id = intval ($user_id);
            
            $arrCode = array();
            $arrKQ = array();
            if($giftcode_id==0||$user_id==0)
            {
                $kq = 1;
                $arrKQ["result"]=$kq;
                $arrKQ["giftcode"]=$arrCode;
                echo json_encode($arrKQ);
                return; 
            }
            
			$arrCode = getGiftCodeStoreAvailable ($giftcode_id);
            $kt = ktGiftcodePhat($giftcode_id,$user_id);
            
            if(!empty($arrCode)&&$kt==0){
                updateUserReceiveGiftCode($arrCode["id"], $user_id );
                updateAvailableGiftCode($giftcode_id );
                $kq = 0;
                // clear cache
                 $giftcodeDetail = getGiftCodeDetail($giftcode_id);
                 $i = 1;$category_id = $giftcodeDetail["category_id"];
                 $publisher_id = $giftcodeDetail["publisher_id"];$game_id = $giftcodeDetail["game_id"];
                 
                 $querykeyGameId = "KEY.getGiftCodeByGameId." . $game_id;
                 deleteCacheByKey($querykeyGameId);
                 $querykeyAPK = "KEY.getGiftCodeDetailAPK." .$giftcode_id;
                 deleteCacheByKey($querykeyAPK);
                 $querykeyIOS = "KEY.getGiftCodeDetailIOS." .$giftcode_id;
                 deleteCacheByKey($querykeyIOS);
                 
                 while ( $i <= $pageCacheClear ) {
                    $querykeyHome = "KEY.getGiftCodeHome" . $i;
                    $querykeyCategory = "KEY.getGiftCodeByCategory.".$category_id.".". $i;
                    $querykeyPublisher = "KEY.getGiftCodeByPublisher.".$publisher_id.".". $i;

                    deleteCacheByKey($querykeyHome);
                    deleteCacheByKey($querykeyCategory);
                    deleteCacheByKey($querykeyPublisher);
                    $i ++;
                }
            }else{
                $kq = 2;
            }
            
            $arrKQ["result"]=$kq;
            $arrKQ["giftcode"]=$arrCode;
		    echo json_encode($arrKQ);
            
			$arrPara = array (
					"giftcode_id" => $giftcode_id ,
                    "user_id" => $user_id,
			);
			$dataLog = createDataLog("getGiftCodeStoreAvailable", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "sendGiftCodeStoreToMember" :
		{
			$code_id = isset ( $_GET ['code_id'] ) ? $_GET ['code_id'] : "0";
			$code_id = intval ( $code_id );
			$user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
			$user_id = intval ( $user_id );
			$giftcode_id = isset ( $_GET ['giftcode_id'] ) ? $_GET ['giftcode_id'] : "0";
			$giftcode_id = intval ( $giftcode_id );
			
			$kq = checkGiftCodeStoreAvailable ( $code_id );
			
			if (intval ( $kq ) > 0) {
				updateUserReceiveGiftCode ( $code_id, $user_id );
				subAvailableGiftCode ( $giftcode_id );
				$kq = 0;
			} else {
				$kq = 1; // Co the giftcode da dc cap khong con ton tai, hay refresh de nhan lại ma moi
			}
			
			echo $kq;
			
			$arrPara = array (
					"giftcode_id" => $giftcode_id,
					"code_id" => $code_id,
					"user_id" => $user_id 
			);
			$dataLog = createDataLog ( "sendGiftCodeStoreToMember", $arrPara, "" );
			$ip = getRealIpAddr ();
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "postReviewGame" :
		{
            $game_id = isset ( $_POST ['game_id'] ) ? $_POST ['game_id'] : "0";
			$game_id = intval ( $game_id );
			$user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
			$user_id = intval ( $user_id );
			$mark = isset ( $_POST ['mark'] ) ? $_POST ['mark'] : "1";
			$mark = intval ( $mark );
			$content = isset ( $_POST ['content'] ) ? $_POST ['content'] : "";
			$create_user = isset ( $_POST ['create_user'] ) ? $_POST ['create_user'] : "";
			$kq = 0;
		   
            $mark = $mark > 5 ? 5 : $mark;
        	// check parameter
			if (empty ( $game_id ) || empty ( $user_id ) || empty ( $mark ) || empty ( $content ) || empty ( $create_user )) {
				echo "1";$kq = 1;
				
			}else{
                $output = postReviewGame ( $game_id, $user_id, $content, $mark, $create_user );
                if(intval($output)==0){
                   $output = postUpdateReviewGame($game_id, $user_id, $content, $mark);
                }
               
                if (intval ( $output ) >= 1) {
                    updateCountReviewGame($game_id );
                    updateMarkReviewGame($game_id);
                    
                    // clear cache
                    $keyGameDetail = "KEY.getGameIOSDetail." . $game_id;
                    deleteCacheByKey($keyGameDetail);
                    $keyGameDetail = "KEY.getGameAPKDetail." . $game_id;
                    deleteCacheByKey($keyGameDetail);
                    $keyCount = "KEY.countGameReview." .$game_id;
                    deleteCacheByKey($keyCount);
                    $i = 1;
                    while ( $i <= $pageCacheClear ) {
                        deleteReviewGameCache ( $game_id, $i );
                        $i ++;
                    }
                    // end cache
                    
                    $kq = 0;
                    echo 0; // success
                    
                } else {
                    $kq = 2;
                    echo 2; // fail
                }
            
            }
			
			$arrPara = array ("game_id" => $game_id,"user_id" => $user_id,"mark" => $mark,
                    "content" => $content,"create_user" => $create_user );
                    $ip = getRealIpAddr ();
			$dataLog = createDataLog ( "postReviewGame", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "postCommentNews" :
		{
			$news_id = isset ( $_POST ['news_id'] ) ? $_POST ['news_id'] : "0";
			$news_id = intval ( $news_id );
			$user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
			$user_id = intval ( $user_id );
	        $comment = isset ( $_POST ['comment'] ) ? $_POST ['comment'] : "";
			$create_user = isset ( $_POST ['create_user'] ) ? $_POST ['create_user'] : "";
			
			$kq = 0;
			// check parameter
			if (empty ( $news_id ) || empty ( $user_id ) || empty ( $create_user ) || empty ( $comment )) {
				echo "1";$kq = 1;
			}else{
                $userDetail = getUserById($user_id);
                if($userDetail["is_ban_comment_new"]==1) { $kq = 10;echo $kq;}
                
                if($kq==0){
                        $output = postCommentNews ( $user_id, $news_id, $comment, $create_user, $create_user );
            
                        if (intval ( $output ) >= 1) {
                            updateCountCommentNews ( $news_id );
                            
                            // clear cache
                               $i = 1;
                               $newsDetail  = getNewsDetail($news_id);
                               $keyNewsDetail = "KEY.getNewsDetail." . $news_id;
                               deleteCacheByKey($keyNewsDetail);
                              
                               $category_id =$newsDetail["category_id"];
                               $publisher_id =$newsDetail["publisher_id"];
                               $game_id =$newsDetail["game_id"];
                               
                               $keyCount = "KEY.countCommentNews." .$news_id;
                               deleteCacheByKey($keyCount);
                               
                                while ( $i <= $pageCacheClear ) {
                                    deleteCommentsNewsCache ( $news_id, $i );
                                    
                                    $querykey = "KEY.getNewsHome.".$i;
                                    deleteCacheByKey($querykey);
                                    
                                    $querykey = "KEY.getNewsByCategory.".$category_id.".".$i;
                                    deleteCacheByKey($querykey);
                                    
                                    $querykey = "KEY.getNewsByPublisher.".$publisher_id.".".$i;
                                    deleteCacheByKey($querykey);
                                    
                                    $querykey = "KEY.getNewsByGame.".$game_id.".".$i;
                                    deleteCacheByKey($querykey);
                                    
                                    $i ++;
                                }
                            // end cache
                        
                            echo 0;
                            $kq = 0; // success
                        } else {
                            echo 2;
                            $kq = 2; // fail
                        }
                }
            }
			
			
			$arrPara = array ("news_id" => $news_id,"user_id" => $user_id,"comment" => $comment,"create_user" => $create_user);
            $ip = getRealIpAddr ();
			$dataLog = createDataLog ( "postCommentNews", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
        
    case "postCommentApp" :
        {
            $type = isset ( $_POST ['type'] ) ? $_POST ['type'] : "0";
            $type = intval ( $type );
            
            $user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
            $user_id = intval ( $user_id );
            
            $comment = isset ( $_POST ['comment'] ) ? $_POST ['comment'] : "";
            $email = isset ( $_POST ['email'] ) ? $_POST ['email'] : "";
            
            $kq = 0;
            // check parameter
            if (empty ( $comment ) || $type == 0) {
                echo "1";$kq = 1;
            }else{
                if($kq==0){
                        $output = postCommentApp($user_id,$type,$comment,$email);
            
                        if (intval ( $output ) >= 1) {
                            echo 0;
                            $kq = 0; // success
                        } else {
                            echo 2;
                            $kq = 2; // fail
                        }
                }
            }
            
            
            $arrPara = array ("user_id" => $user_id,"type" => $type,"comment" => $comment,"email" => $email);
            $ip = getRealIpAddr ();
            $dataLog = createDataLog ( "postCommentApp", $arrPara, $kq );
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
    case "downloadGameAndroid":{
        $game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
        $game_id = intval ( $game_id );
        $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
        $user_id = intval ( $user_id );
        
        $linkAPK ="";
        $kq=0;
        
        if(empty($game_id)){
            $kq=1;
        }else{
            $gameInfo = getGameFile($game_id,2,0);
            if(!empty($gameInfo)){
                $linkAPK = $gameInfo["file_path"];
                $kq=0;
                
                insertUserDowload($user_id, $game_id, 2); 
                updateCountAndroidDownloadGame($game_id);
                
               
            }
        }
        
        $arrKQ = array();
        $arrKQ["result"]=$kq;
        $arrKQ["file_path"]=$linkAPK;
        echo json_encode($arrKQ);
        
        $arrPara = array (
                    "id" => $game_id,
                    "user_id" => $user_id
            );
        $ip = getRealIpAddr ();
        $dataLog = createDataLog ("downloadGameAndroid", $arrPara, $kq );
        insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
        break;
    }
    
    case "getFileGameAndroid":{
        $game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
        $game_id = intval ( $game_id );
        $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
        $user_id = intval ( $user_id );
        
        $linkAPK ="";
        $kq=0;
        
        if(empty($game_id)){
            $kq=1;
        }else{
            $gameInfo = getGameFile($game_id,2,0);
            if(!empty($gameInfo)){
                $linkAPK = $gameInfo["file_path"];
                $kq=0;
            }
        }
        
        $arrKQ = array();
        $arrKQ["result"]=$kq;
        $arrKQ["file_path"]=$linkAPK;
        echo json_encode($arrKQ);
        
        $arrPara = array (
                    "id" => $game_id,
                    "user_id" => $user_id
            );
        $ip = getRealIpAddr ();
        $dataLog = createDataLog ("getFileGameAndroid", $arrPara, $kq );
        insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
        break;
    }
    case "downloadGameIOS":{
        $game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
        $game_id = intval ( $game_id );
        $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
        $user_id = intval ( $user_id );
        $app_header = isset ( $_GET ['app_header'] ) ? $_GET ['app_header'] : "";
        $app_header = $app_header;
        
        $linkIPA ="";
        $file_plist ="";
        $kq=0;
        
        if(empty($game_id)){
            $kq=1;
        }else{
            $gameInfo = getGameFile($game_id,3,0);
            if(!empty($gameInfo)){
                $linkIPA = $gameInfo["file_path"];
                $file_plist = $gameInfo["file_plist"];
                $kq=0;
               
                insertUserDowload($user_id, $game_id, 3); 
                updateCountIOSDownloadGame($game_id);
            }
        }
      
        $arrKQ = array();
        $arrKQ["result"]=$kq;
        $arrKQ["file_path"]=$linkIPA;
        $arrKQ["file_plist"]=$file_plist;
      
        echo json_encode($arrKQ);
        
        $arrPara = array (
                    "id" => $game_id,
                    "user_id" => $user_id
            );
        $ip = getRealIpAddr ();
        $dataLog = createDataLog ( "downloadGameIOS", $arrPara, $kq );
        insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
        break;
    }
    
    case "getLinkItuneGameIOS":{
        $game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
        $game_id = intval ( $game_id );
        $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
        $user_id = intval ( $user_id );
        $app_header = isset ( $_GET ['app_header'] ) ? $_GET ['app_header'] : "";
        $app_header = $app_header;
        
        $linkIPA ="";
        $file_plist ="";
        $kq=0;
        
        if(empty($game_id)){
            $kq=1;
        }else{
            $gameInfo = getGameFile($game_id,3,1);
            if(!empty($gameInfo)){
                $linkIPA = $gameInfo["file_path"];
                $file_plist = $gameInfo["file_plist"];
                $kq=0;
               
               
            }
        }
      
        $arrKQ = array();
        $arrKQ["result"]=$kq;
        $arrKQ["file_path"]=$linkIPA;
        $arrKQ["file_plist"]=$file_plist;
      
        echo json_encode($arrKQ);
        
        $arrPara = array (
                    "id" => $game_id,
                    "user_id" => $user_id
            );
        $ip = getRealIpAddr ();
        $dataLog = createDataLog ( "getLinkItuneGameIOS", $arrPara, $kq );
        insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
        break;
    }
    case "getLinkPlayGame":{
        $game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "0";
        $game_id = intval ( $game_id );
        $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
        $user_id = intval ( $user_id );
        $app_header = isset ( $_GET ['app_header'] ) ? $_GET ['app_header'] : "";
        $app_header = $app_header;
        
        $linkPlay ="";
   
        $kq=0;
        
        if(empty($game_id)){
            $kq=1;
        }else{
            $gameInfo = getGameFile($game_id,2,1);
            if(!empty($gameInfo)){
                $linkPlay = $gameInfo["file_path"];
                
                $kq=0;
               
               
            }
        }
      
        $arrKQ = array();
        $arrKQ["result"]=$kq;
        $arrKQ["file_path"]=$linkPlay;
      
      
        echo json_encode($arrKQ);
        
        $arrPara = array (
                    "id" => $game_id,
                    "user_id" => $user_id
            );
        $ip = getRealIpAddr ();
        $dataLog = createDataLog ( "getLinkPlayGame", $arrPara, $kq );
        insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
        break;
    }
	case "addCountIOSDownloadGame" :
		{
			$game_id = isset ( $_POST ['id'] ) ? $_POST ['id'] : "0";
			$game_id = intval ( $game_id );
			$user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
            $user_id = intval ( $user_id );
            
			$kq = 0;
			$arrPara = array (
					"id" => $game_id,
                    "user_id" => $user_id
			);
			$ip = getRealIpAddr ();
			
			// check parameter
			if (empty ( $game_id )) {
				echo "1";
				$kq = 1;
				$dataLog = createDataLog ( "addCountIOSDownloadGame", $arrPara, $kq );
				insertAppTrackingGS ( 0, 0, $dataLog, $ip );
				return;
			}
			
			$output = addCountIOSDownloadGame ( $game_id );
			
			if (intval ( $output ) >= 1) {
				insertUserDowload ( $user_id, $game_id, 3 );
				echo 0;
				$kq = 0; // success
			} else {
				echo 2;
				$kq = 2; // fail
			}
			
			$dataLog = createDataLog ( "addCountIOSDownloadGame", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "addCountAndroidDownloadGame" :
		{
			$game_id = isset ( $_POST ['id'] ) ? $_POST ['id'] : "0";
			$game_id = intval ( $game_id );
			
			$user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
			$user_id = intval ( $user_id );
			
			$kq = 0;
			$arrPara = array (
					"id" => $game_id,
                    "user_id" => $user_id
			);
			$ip = getRealIpAddr ();
			
			// check parameter
			if (empty ( $game_id )) {
				echo "1";
				$kq = 1;
				$dataLog = createDataLog ( "addCountAndroidDownloadGame", $arrPara, $kq );
				insertAppTrackingGS ( 0, 0, $dataLog, $ip );
				return;
			}
			
			$output = addCountAndroidDownloadGame ( $game_id );
			
			if (intval ( $output ) >= 1) {
				insertUserDowload ( $user_id, $game_id, 2 );
				echo 0;
				$kq = 0; // success
			} else {
				echo 2;
				$kq = 2; // fail
			}
			
			$dataLog = createDataLog ( "addCountAndroidDownloadGame", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "postCommentDiscussion" :
		{
			$discussion_id = isset ( $_POST ['discussion_id'] ) ? $_POST ['discussion_id'] : "0";
			$discussion_id = intval ( $discussion_id );
			$user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
			$user_id = intval ( $user_id );
			
			$comment = isset ( $_POST ['comment'] ) ? $_POST ['comment'] : "";
			$image = isset ( $_POST ['image'] ) ? $_POST ['image'] : "";
			$create_user = isset ( $_POST ['create_user'] ) ? $_POST ['create_user'] : "";
			
			$kq = 0;
		  // check parameter
          if (empty ( $discussion_id ) || empty ( $user_id ) || empty ( $create_user ) || empty ( $comment )) {
				echo "1";
				$kq = 1;
				
			}else{
                $userDetail = getUserById($user_id);
                if($userDetail["is_ban_comment_new"]==1) { $kq = 10;echo $kq;}
                
                if($kq==0){
                    $output = postCommentDiscussion ( $discussion_id, $user_id, $comment, $image, $userDetail["fullname"] );
                    if (intval ( $output ) >= 1) {
                        updateCountCommentDiscussion ( $discussion_id );
                        $discussion = getDiscussionDetail2($discussion_id);
                        $poster_id = $discussion["user_id"];
                         // push notify
                        if($poster_id==$user_id){
                            pushNotifyDiscussionMessage3($discussion_id);
                        }else{
                            pushNotifyDiscussionMessage1($discussion_id,$user_id,$userDetail["fullname"] );
                            pushNotifyDiscussionMessage2($discussion_id,$user_id,$userDetail["fullname"] );
                        }
                        
                        
                        // clear cache
                        $discussionDetail  = getDiscussionDetail2($discussion_id);
                        $game_id =$discussionDetail["game_id"];
                        $keyworDisDetail = "KEY.getDiscussionDetail.".$discussion_id;
                        deleteCacheByKey($keyworDisDetail);
                        $poster_id = $discussionDetail["user_id"];
                        $keyCount = "KEY.countCommentDiscussion." .$discussion_id;
                        deleteCacheByKey($keyCount);
                        
                        $i = 1;
                         while ( $i <= $pageCacheClear ) {
                            deleteCommentDiscussionsCache ($discussion_id, $i);
                            $keyListDiscussion = "KEY.discussion.list." .$game_id.".".$i;
                            deleteCacheByKey($keyListDiscussion);
                            $i ++;
                        }
                       
                         // end clear cache
                        echo 0; // success
                        $kq = 0;
                        
                    } else {
                        echo 2; // fail
                        $kq = 2;
                    }
                }
                
            }
			
			
			$arrPara = array ("discussion_id" => $discussion_id,"user_id" => $user_id,"comment" => $comment,
                    "image" => $image,"create_user" => $create_user 
            );
            $ip = getRealIpAddr ();
			$dataLog = createDataLog ( "postCommentDiscussion", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "postDiscussion" :
		{
			$game_id = isset ( $_POST ['game_id'] ) ? $_POST ['game_id'] : "0";
			$game_id = intval ( $game_id );
			$user_id = isset ( $_POST ['user_id'] ) ? $_POST ['user_id'] : "0";
			$user_id = intval ( $user_id );
			
			$content = isset ( $_POST ['content'] ) ? $_POST ['content'] : "";
			$image = "";
			$create_user = isset ( $_POST ['create_user'] ) ? $_POST ['create_user'] : "";
			
			$kq = 0;
			
			// check parameter
			if (empty ( $game_id ) || empty ( $user_id ) || empty ( $create_user ) || empty ( $content )) {
				echo "1";$kq = 1;
				
			}else{
                $image = "";$image_width = 0;$image_height = 0;
                $userDetail = getUserById($user_id);
                if($userDetail["is_ban_comment_new"]==1) { $kq = 10;echo $kq;}
                
                if($kq==0){
                        uploadImageDiscussion ( $app_client_id, &$image, &$image_width, &$image_height );
                        $output = postDiscussion ( $user_id, $game_id, $content, $image, $create_user, $image_width, $image_height );
                        
                        if (intval ( $output ) >= 1) {
                            // clear cache
                            $i = 1;
                            while ( $i <= $pageCacheClear ) {
                                deleteDiscussionsCache ( $game_id, $i );
                                $i ++;
                            }
                            echo 0;
                            $kq = 0;// success
                        }else {
                            echo 2;
                            $kq = 2; // fail
                        }
                }
               
            }
			
			
			$arrPara = array ("game_id" => $game_id,"user_id" => $user_id,"content" => $content,
                    "image" => $image,"create_user" => $create_user );
            $ip = getRealIpAddr ();
			$dataLog = createDataLog ( "postDiscussion", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	case "deleteDiscussion" :
        {
            $discussion_id = isset ( $_POST ['discussion_id'] ) ? $_POST ['discussion_id'] : "0";
            $discussion_id = intval ( $discussion_id );
            $user_token = isset ( $_POST ['user_token'] ) ? $_POST ['user_token'] : "";
           //$user_id = intval ( $user_id );
            
            if(empty($user_token)||$discussion_id==0) { echo 1; return;}
            $discussion = getDiscussionDetail2($discussion_id);
            
            if(!empty($discussion))
            {
                $userDetail = getUserToken($user_token);
                $result = 0;
                if(!empty($userDetail))
                $result = deleteDiscussion($discussion_id,$userDetail["id"]);
                
                if($result>0){
                    deleteDiscussionComment($discussion_id);
                    deleteDiscussionLike($discussion_id);
                    
                    $i = 1;$game_id=$discussion["game_id"];
                    while ( $i <= $pageCacheClear ) {
                        deleteDiscussionsCache ( $game_id, $i );
                        $i ++;
                    }
                    echo 0;
                }else{
                    echo 2;
                }
            }else {
                echo 2;
            }
            
            
        }
	case "getAppHeader" :
		{
			$app_client_id = isset ( $_GET ['app_client_id'] ) ? $_GET ['app_client_id'] : "0";
			$app_client_id = intval ( $app_client_id );
			$app_header = isset ( $_GET ['app_header'] ) ? $_GET ['app_header'] : "";
			$imei = isset ( $_GET ['imei'] ) ? $_GET ['imei'] : "";
			$os_version = isset ( $_GET ['os_version'] ) ? $_GET ['os_version'] : "";
			$ip = getRealIpAddr ();
		
			$output = getAppHeaderStore ( $app_header, $app_client_id, $os_version, $imei );
			
			echo json_encode ( $output );
			
			$kq = 0;
			$arrPara = array (
					"app_header" => $app_header,
					"app_client_id" => $app_client_id,
					"os_version" => $os_version,
					"imei" => $imei 
			);
			$dataLog = createDataLog ( "getAppHeader", $arrPara, $kq );
			insertAppTrackingGS ( $app_header, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "getUserById" :
		{
			$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
			$id = intval ( $id );
			
			$ip = getRealIpAddr ();
			
			$output = getUserById ( $id );
			
			echo json_encode ( $output );
			
			$kq = 0;
			$arrPara = array (
					"id" => $id 
			);
			$dataLog = createDataLog ( "getUserById", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
        
    case "getUsernameById" :
        {
            $id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
            $id = intval ( $id );
            
            $output = getUsernameById($id);
            
            echo json_encode ( $output );
            
            break;
        }
        
    case "getFullnameById" :
        {
            $id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
            $id = intval ( $id );
            
            $output = getFullnameById($id);
            
            echo json_encode ( $output );
            
            break;
        }
	case "getFullnameByIds" :
        {
            $ids = isset ( $_GET ['ids'] ) ? $_GET ['ids'] : "";
            
            $output = getFullnameByIds($ids);
            
            echo json_encode ( $output );
            
            break;
        }
    
	case "getUserByUserName" :
		{
			$username = isset ( $_GET ['username'] ) ? $_GET ['username'] : "";
			
			$ip = getRealIpAddr ();
			
			$output = getUserByUserName ( $username );
			
			echo json_encode ( $output );
			
			$kq = 0;
			$arrPara = array (
					"username" => $username 
			);
			$dataLog = createDataLog ( "getUserByUserName", $arrPara, $kq );
			insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
			
			break;
		}
	
	case "updateUserInfo" :
		{
			$username = isset ( $_POST ['fullname'] ) ? $_POST ['fullname'] : "";
			$sex = isset ( $_POST ['sex'] ) ? $_POST ['sex'] : "";
			$sex = intval($sex);
			
			$email = isset ( $_POST ['email'] ) ? $_POST ['email'] : "";
			$facebook_id = isset ( $_POST ['facebook_id'] ) ? $_POST ['facebook_id'] : "";
			
			$mobile = isset ( $_POST ['mobile'] ) ? $_POST ['mobile'] : "";
			$mobile = formatMobileVn(trim($mobile));
			
			$birthday = isset ( $_POST ['birthday'] ) ? $_POST ['birthday'] : "";
            
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$birthday))
            {
                $birthday = convertStrdmyyToyymd($birthday,"/");
            }
			
			
			$id = isset ($_POST ['user_id'] ) ? $_POST ['user_id'] : "";
			$id = intval($id);
			
			$kq ="0";
			$userInfo = null;
            $arrKQ = array();
			
			if($id<=0){$kq ="1";	}// Thieu tham so
			
           // if(validUsername($username)==0) {$kq =  4;} // Ten vi pham noi quy
            
           // if(checkUserNameUpdateInfo($username,$id)==1) {$kq =  2;} // Ten da ton tai
			
            if(!isValidEmail($email)&&!empty($email)){$kq = 3;}// email khong dung dinh dang
			
            $ip = getRealIpAddr ();
            $arrPara = array (
                    "user_id" => $id,
                    "username" => $username,
                    "sex" => $sex,
                    "email" => $email,
                    "mobile" => $mobile,
                    "birthday" => $birthday,
                    "facebook_id" => $facebook_id
            );
          
			if($kq==0) {
				$count = updateUserInfo($id, $username, $sex, $mobile, $birthday,$email,$facebook_id);
				if($count<=0) $kq ="100"; else {
                    $querykey = md5("KEY.ttv.g_user.getUserById.".$id);
                    deleteCacheByKey($querykey);
                    $querykey = md5("KEY.ttv.g_user.getUserByUserName.".$username);
                    deleteCacheByKey($querykey);
                    $querykey = md5("KEY.ttv.g_user.getUserByAppClientId.".$app_client_id);
                    deleteCacheByKey($querykey);
                    $querykey = md5("KEY.ttv.g_user.getUsernameById.".$id);
                    deleteCacheByKey($querykey);
                    $querykey = md5("KEY.ttv.g_user.getFullnameById.".$id);
                    deleteCacheByKey($querykey);
                }
			}
			
            
            $userInfo = getUserById ($id);
            $arrKQ["result"]=$kq;
            $arrKQ["user"]=$userInfo;
			echo json_encode($arrKQ);
			
			$dataLog = createDataLog ( "updateUserInfo", $arrPara, 0 );
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
				
			break;
		}
	
	case "uploadAvatar": {
		$user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"";
		uploadAvatar($user_id);
        
        $querykey = md5("KEY.ttv.g_user.getUserById.".$user_id);
        deleteCacheByKey($querykey);
            
		break;
	}
   /* case "uploadAvatarB": {
        $i=0;
        while($i<1000){
            $folderId = $i%1000;
            $uploaddir = '/upload/gamestore/avatar/'.$folderId."/";
            makeFolder("../".$uploaddir);
            $avatar_url="http://kenhkiemtien.com".$uploaddir.$i.".png";
            copy("../upload/gamestore/avatar/avatar_d.png","../".$uploaddir."/".$i.".png");
            updateAvatar($i, $avatar_url);
            $i++;
        }
            
        break;
    }*/
    case "searchKeywordIOS": {
        $keyword =   isset($_POST['keyword'])?$_POST['keyword'] :"";
        $page =   isset($_POST['page'])?$_POST['page'] :"1";
        $page = intval($page);
        if(empty($keyword)) {echo "";return;}
        $arrKQ = searchKeywordIOS($keyword,$page,$limitItem);
       
        $outputUserDown = getUserDownloadView($arrKQ["game"],3);
            
        $arrOut = array();
        $arrOut["game_data"]=$arrKQ;
        $arrOut["user_download"]=$outputUserDown;
        echo json_encode ($arrOut);
            
        break;
    }
    
    case "searchKeywordRecommentIOS": {
        $keyword =   isset($_POST['keyword'])?$_POST['keyword'] :"";
        if(empty($keyword)) {echo "";return;}
        $arrKQ = searchKeywordRecommentIOS($keyword);
        
        echo json_encode($arrKQ)   ;
        break;
    }
    
    case "searchKeywordAndroid": {
        $keyword =   isset($_POST['keyword'])?$_POST['keyword'] :"";
        $page =   isset($_POST['page'])?$_POST['page'] :"1";
        $page = intval($page);
        if(empty($keyword)) {echo "";return;}
        $arrKQ = searchKeywordAndroid($keyword,$page,$limitItem);
        $outputUserDown = getUserDownloadView($arrKQ["game"],2);
            
        $arrOut = array();
        $arrOut["game_data"]=$arrKQ;
        $arrOut["user_download"]=$outputUserDown;
        echo json_encode ($arrOut);
     
        break;
    }
    
    case "searchKeywordRecommentAndroid": {
        $keyword =   isset($_POST['keyword'])?$_POST['keyword'] :"";
        if(empty($keyword)) {echo "";return;}
        $arrKQ = searchKeywordRecommentAndroid($keyword);
        
        echo json_encode($arrKQ)   ;
        break;
    }
    
    case "searchKeywordAndroidG": {
        $keyword =   isset($_GET['keyword'])?$_GET['keyword'] :"";
        $page =   isset($_POST['page'])?$_POST['page'] :"1";
        $page = intval($page);
        if(empty($keyword)) {echo "";return;}
        
        $arrKQ = searchKeywordAndroid($keyword,$page,$limitItem);
        $outputUserDown = getUserDownloadView($arrKQ["game"],2);
            
        $arrOut = array();
        $arrOut["game_data"]=$arrKQ;
        $arrOut["user_download"]=$outputUserDown;
        echo json_encode ($arrOut);
        break;
    }
    
    case "searchKeywordRecommentAndroidG": {
        $keyword =   isset($_GET['keyword'])?$_GET['keyword'] :"";
       
        if(empty($keyword)) {echo "";return;}
      
        $arrKQ = searchKeywordRecommentAndroid($keyword);
        
        echo json_encode($arrKQ)   ;
        break;
    }
    
    case "getKeywordAndroidRecommend": {
        $arrKQ = getKeywordAndroidRecommend();
        echo json_encode($arrKQ)   ;
        break;
    }
    
     case "getKeywordIOSRecommend": {
        $arrKQ = getKeywordIOSRecommend();
        echo json_encode($arrKQ)   ;
        break;
    }
    
    case "getUserDownload": {
        $game_id =   isset($_GET['game_id'])?$_GET['game_id'] :"0";
        $page =   isset($_GET['page'])?$_GET['page'] :"1";
        $arrKQ = getUserDownload($game_id,30,$page);
        echo json_encode($arrKQ)   ;
        break;
    }
    case "likeDiscussion": {
        $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";
        $discussion_id =   isset($_GET['discussion_id'])?$_GET['discussion_id'] :"0";
        $user_id = intval($user_id);  $discussion_id = intval($discussion_id);
        
        if($user_id>0&&$discussion_id>0){
           $kq =  insertLikeDiscussion($user_id,$discussion_id);
           updateCountLikeDiscussion2($discussion_id);
           $count_like = getCountLikeDiscussion($discussion_id);
           
           // clear cache
                $discussionDetail  = getDiscussionDetail2($discussion_id);
                $game_id =$discussionDetail["game_id"];
                $poster_id =$discussionDetail["user_id"];
                $keyworDisDetail = "KEY.getDiscussionDetail.".$discussion_id;
                deleteCacheByKey($keyworDisDetail);
                
                $i = 1;
                 while ( $i <= $pageCacheClear ) {
                    $keyListDiscussion = "KEY.discussion.list." .$game_id.".".$i;
                    deleteCacheByKey($keyListDiscussion);
                    $i ++;
                }
           // end clear cache
           
           $arrKQ = array();
           $arrKQ["result"] = 0;
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
           
           // push notify 
           if($user_id!=$poster_id){
               $user = getUserById($user_id);
               pushNotifyDiscussionMessage4($discussion_id,$user_id,$user["fullname"]);
           }
        }else{
           $arrKQ = array();
           $arrKQ["result"] = 1;
           
           $count_like = 0;
           if($discussion_id>0)
           $count_like = getCountLikeDiscussion($discussion_id);
           
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
        }
        break;
    }
    case "disLikeDiscussion": {
        $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";
        $discussion_id =   isset($_GET['discussion_id'])?$_GET['discussion_id'] :"0";
        $user_id = intval($user_id);  $discussion_id = intval($discussion_id);
        
        if($user_id>0&&$discussion_id>0){
           $kq =  deleteLikeDiscussion($user_id,$discussion_id);
           $count_like =  countLikeDiscussion($discussion_id);
           updateCountLikeDiscussion($discussion_id,$count_like);
           
           // clear cache
                $discussionDetail  = getDiscussionDetail2($discussion_id);
                $game_id =$discussionDetail["game_id"];
                $keyworDisDetail = "KEY.getDiscussionDetail.".$discussion_id;
                deleteCacheByKey($keyworDisDetail);
                
                $i = 1;
                 while ( $i <= $pageCacheClear ) {
                    $keyListDiscussion = "KEY.discussion.list." .$game_id.".".$i;
                    deleteCacheByKey($keyListDiscussion);
                    $i ++;
                }
           // end clear cache
           
           $arrKQ = array();
           $arrKQ["result"] = 0;
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
        }else{
           $arrKQ = array();
           $arrKQ["result"] = 1;
           
           $count_like = 0;
           if($discussion_id>0)
           $count_like = getCountLikeDiscussion($discussion_id);
           
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
        }
        break;
    }
     case "likeNews": {
        $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";
        $news_id =   isset($_GET['news_id'])?$_GET['news_id'] :"0";
        $user_id = intval($user_id);  $news_id = intval($news_id);
        
        if($user_id>0&&$news_id>0){
           $kq =  insertLikeNews($user_id,$news_id);
           if($kq>0){
               updateCountLikeNews2($news_id);
           }
           $count_like = getCountLikeNews($news_id);
           // clear cache
            $newsDetail  = getNewsDetail($news_id);
            $category_id =$newsDetail["category_id"];
            $publisher_id =$newsDetail["publisher_id"];
            $game_id =$newsDetail["game_id"];
               
            $keyNewsDetail = "KEY.getNewsDetail." . $news_id;
            deleteCacheByKey($keyNewsDetail);
            $i = 1;  
            while ( $i <= $pageCacheClear ) {
                    $querykey = "KEY.getNewsHome.".$i;
                    deleteCacheByKey($querykey);
                    
                    $querykey = "KEY.getNewsByCategory.".$category_id.".".$i;
                    deleteCacheByKey($querykey);
                    
                    $querykey = "KEY.getNewsByPublisher.".$publisher_id.".".$i;
                    deleteCacheByKey($querykey);
                    
                    $querykey = "KEY.getNewsByGame.".$game_id.".".$i;
                    deleteCacheByKey($querykey);
                    
                    $i ++;
            }
            // End clear cache
                  
           $arrKQ = array();
           $arrKQ["result"] = 0;
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
        }else{
           $arrKQ = array();
           $arrKQ["result"] = 1;
           
           $count_like = 0;
           if($news_id>0)
           $count_like = getCountLikeNews($news_id);
           
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
            
        }
        break;
    }
    
    case "disLikeNews": {
        $user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"0";
        $news_id =   isset($_GET['news_id'])?$_GET['news_id'] :"0";
        $user_id = intval($user_id);  $news_id = intval($news_id);
        
        if($user_id>0&&$news_id>0){
           $kq =  deleteLikeNews($user_id,$news_id);
           $count_like =  countLikeNews($news_id);
           updateCountLikeNews($news_id,$count_like);
           
           // clear cache
            $newsDetail  = getNewsDetail($news_id);
            $category_id =$newsDetail["category_id"];
            $publisher_id =$newsDetail["publisher_id"];
            $game_id =$newsDetail["game_id"];
               
            $keyNewsDetail = "KEY.getNewsDetail." . $news_id;
            deleteCacheByKey($keyNewsDetail);
            while ( $i <= $pageCacheClear ) {
                    $querykey = "KEY.getNewsHome.".$i;
                    deleteCacheByKey($querykey);
                    
                    $querykey = "KEY.getNewsByCategory.".$category_id.".".$i;
                    deleteCacheByKey($querykey);
                    
                    $querykey = "KEY.getNewsByPublisher.".$publisher_id.".".$i;
                    deleteCacheByKey($querykey);
                    
                    $querykey = "KEY.getNewsByGame.".$game_id.".".$i;
                    deleteCacheByKey($querykey);
                    
                    $i ++;
            }
            // End clear cache
            
           $arrKQ = array();
           $arrKQ["result"] = 0;
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
        }else{
           $arrKQ = array();
           $arrKQ["result"] = 1;
           
           $count_like = 0;
           if($news_id>0)
           $count_like = getCountLikeNews($news_id);
           
           $arrKQ["count_like"] = $count_like;
           echo json_encode($arrKQ);
            
        }
        break;
    }
    
    case "getRoomInfo" :
        {
            $id = isset ( $_GET ['id'] ) ? $_GET ['id'] : "0";
            $id = intval ( $id );
            
            $output = getRoomInfo ( $id );
            echo json_encode ( $output );
            
            $arrPara = array (
                    "id" => $id 
            );
            $dataLog = createDataLog ( "getRoomInfo", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
    case "getVersionStore" :
        {
            $app_header = isset ( $_GET ['app_header'] ) ? $_GET ['app_header'] : "";
           
            $output = getVersionStore ( $app_header );
            echo json_encode ( $output );
            
            $arrPara = array (
                    "app_header" => $app_header 
            );
            $dataLog = createDataLog ( "getVersionStore", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
    case "getGameDownloadByUser" :
        {
            $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "";
           
            $output = getGameDownloadByUser ( $user_id );
            echo json_encode ( $output );
            
            $arrPara = array (
                    "user_id" => $user_id 
            );
            $dataLog = createDataLog ( "getGameDownloadByUser", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }   
    case "registryNoticeIOS": { 
              $app_client_id = isset($_GET['app_client_id'])?$_GET['app_client_id'] :"0"; 
              $device_token = isset($_GET['device_token'])?$_GET['device_token'] :""; 
              $app_header = isset($_GET['app_header'])?$_GET['app_header'] :"";
              $user_id = isset($_GET['user_id'])?$_GET['user_id'] :"";  
              $username = "";
              $ip_address =  getRealIpAddr ();
             
              if(empty($user_id)||empty($device_token)||empty($ip_address)||strcmp("(null)",$device_token)==0) {echo 1;return;}
              
              $kq = insertNoticeIOSUser(intval($app_client_id),$device_token,$user_id,$username,$ip_address,$app_header);
              
              if($kq == 1) echo 0;
              else echo 2; // insert không thành công
              
             
              
              break;        
        }
    case "registryNotice": { 
              $device_token = isset($_GET['device_token'])?$_GET['device_token'] :""; 
              $os_type = isset($_GET['os_type'])?$_GET['os_type'] :"0"; 
              $os_type = intval($os_type);
              $user_id = isset($_GET['user_id'])?$_GET['user_id'] :"0"; 
              $user_id = intval($user_id);
              $app_client_id = isset($_GET['app_client_id'])?$_GET['app_client_id'] :""; 
              
              $channel = isset($_GET['channel'])?$_GET['channel'] :"1"; 
              $channel = intval($channel);
             
              if($os_type==0||empty($device_token)||strcmp("(null)",$device_token)==0) {echo 1;return;}
              
              // Tam thoi xoa theo app_client_id
              deleteTokenByAppClientID($app_client_id);
              
              if(checkKeyNotifyByAppClientID($app_client_id)==0){
                  $kq = insertNoticeUser($app_client_id,$user_id,$device_token,intval($os_type),"",$channel);
              }else{
                  updateNoticeUser($user_id,$app_client_id,$device_token);
              }
              
              $kq = 1;
              if($kq == 1) echo 0;
              else echo 2; // insert không thành công

              break;        
        }
    case "pushNotifyDiscussionMessage1": { 
              $discussion_id = isset($_GET['dis_id '])?$_GET['dis_id '] :"0"; 
              echo "discussion_id".$discussion_id;
              echo $_GET['dis_id '];
            //  $kq = pushNotifyDiscussionMessage1(1,"thangtt");
              
              $body = "Noidung";
              $action_loc_key = "Play";
              $type = 5;
              $oid = 0;
              $payload = createPayLoadNotify($body,$action_loc_key,$type,$oid);
              echo $payload;
              break;        
        }
    case "pushNotifyChatOffline": { 
              $from_user_id = isset($_POST['from_userId'])?$_POST['from_userId'] :"0"; 
              $from_user_id = intval($from_user_id);
              $to_user_id = isset($_POST['to_userId'])?$_POST['to_userId'] :"0"; 
              $to_user_id = intval($to_user_id);
              
              $userSend  = getUserById($from_user_id);
              
              if($to_user_id==0||$from_user_id==0||$to_user_id==$from_user_id) {echo 1; return;};
              
              if(!empty($userSend))
              {
                  $sender_name = $userSend["fullname"];
                  $message = "";
                 $result = pushNotifyChatMessage5($to_user_id,$from_user_id,$sender_name,$message);
                  if($result>0) echo 0; else echo 2;
              }
              
              break;        
        }
   case "getGameHadEvent": {
      $output = getGameHadEvent();
      echo json_encode($output);
      break;
   }
   case "getDateExpireBan": {
        $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "0";
        $user_id = intval ( $user_id );
        $type = isset ( $_GET ['type'] ) ? $_GET ['type'] : "0"; // 1:chat; 2: comment
        $type = intval ( $type );
        
        $date_expire = getDateExpireBan($user_id,$type);
        echo json_encode($date_expire);
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
            
            $birthday = isset ( $_POST ['birthday'] ) ? $_POST ['birthday'] : "";
            $facebook_id = isset ( $_POST ['facebook_id'] ) ? $_POST ['facebook_id'] : "";   
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
            if(empty($email)) $email =  $app_client_id."@storegiftvn.com";
            if(empty($email)||empty($app_client_id)){$kq=1;} // thieu tham so
            if(!isValidEmail($email)&&!empty($email)){$kq = 3;}// email khong dung dinh dang
            
       // Get User Info
            $user_id  =  0;
            $isNewUser =  0;
            $userDetail =  array();
            if($kq == 0){
                $userDetail =  getUserByEmailNoCache($email);
                if(empty($userDetail)) $userDetail = getUserByFacebookID($facebook_id);
              
                if(empty($userDetail)){
                    // $user_token = md5(md5($user["id"].time()."gamestore!@#"));
                     $user_token =  md5(md5($app_client_id."_"."ttvgamestorii@#$%")); 
                     $user_id = registerMember($app_client_id,$fullname,$sex,$birthday,$email,$mobile,$facebook_id,$user_token);
                     if($user_id>0)
                        {
                            $userDetail = getUserById($user_id);
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
            echo json_encode ( $arrayKq );
            
            $ip = getRealIpAddr ();
            $arrPara = array ("app_client_id" => $app_client_id,
                    "fullname" => $fullname,"email" => $email,"sex" => $sex,"birthday" => $birthday
                    ,"facebook_id" => $facebook_id,"mobile" => $mobile);
            $dataLog = createDataLog ( "registerMember", $arrPara, $kq );
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
   case "testRegular": {
       $username = isset($_GET['username'])?$_GET['username'] :""; 
       $i = validUsername($username);
       
       if ($i==0){
           echo "vi pham";
        }else{
            echo "ok";
        }
        break;
   } 
   
   case "getGameAPKHomeView" :
        {
            // Box Hot
            $output_hot = getGameAPKHomeView (1);
            $outputUserDown_hot = getUserDownloadView($output_hot["game"],2);
            
            // Box New
            $output_new = getGameAPKHomeView (2);
            $outputUserDown_new = getUserDownloadView($output_new["game"],2);
            
            // Box Mini Game
            $output_mini = getGameAPKHomeView (3);
            $outputUserDown_mini = getUserDownloadView($output_mini["game"],2);
            
            $arrOut = array();
            $arrOut["game_hot"]=$output_hot;
            $arrOut["user_download_hot"]=$outputUserDown_hot;
            
            $arrOut["game_new"]=$output_new;
            $arrOut["user_download_new"]=$outputUserDown_new;
            
            $arrOut["game_mini"]=$output_mini;
            $arrOut["user_download_mini"]=$outputUserDown_mini;
            
            
            echo json_encode ($arrOut);
            
            $arrPara = array ();
            $dataLog = createDataLog ( "getGameAPKHomeView", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
    case "getGameIOSHomeView" :
        {
            // Box Hot
            $output_hot = getGameIOSHomeView (1);
            $outputUserDown_hot = getUserDownloadView($output_hot["game"],2);
            
            // Box New
            $output_new = getGameIOSHomeView (2);
            $outputUserDown_new = getUserDownloadView($output_new["game"],2);
            
            // Box Mini Game
            $output_mini = getGameIOSHomeView (3);
            $outputUserDown_mini = getUserDownloadView($output_mini["game"],2);
            
            $arrOut = array();
            $arrOut["game_hot"]=$output_hot;
            $arrOut["user_download_hot"]=$outputUserDown_hot;
            
            $arrOut["game_new"]=$output_new;
            $arrOut["user_download_new"]=$outputUserDown_new;
            
            $arrOut["game_mini"]=$output_mini;
            $arrOut["user_download_mini"]=$outputUserDown_mini;
            
            
            echo json_encode ($arrOut);
            
            $arrPara = array ();
            $dataLog = createDataLog ( "getGameAPKHomeView", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
         case "getGameAPKHomeViewMore" :
        {
             $type = isset($_GET['type'])?$_GET['type'] :"1";
             if($type==1){
                // Box Hot
                $output = getGameAPKHomeViewMore (1);
                $outputUserDown = getUserDownloadView($output["game"],2);
             
             }else if($type==2){
                 // Box New
                $output = getGameAPKHomeViewMore (2);
                $outputUserDown = getUserDownloadView($output["game"],2);
             }else{
                 // Box Mini Game
                $output = getGameAPKHomeViewMore (3);
                $outputUserDown = getUserDownloadView($output["game"],2);
             
             }
            
            $arrOut = array();
            $arrOut["game"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            
            echo json_encode ($arrOut);
            
            $arrPara = array ("type"=>1);
            $dataLog = createDataLog ( "getGameAPKHomeViewMore", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
        
        case "getGameIOSHomeViewMore" :
        {
            $type = isset($_GET['type'])?$_GET['type'] :"1";
            if($type==1){
                 // Box Hot
                $output = getGameIOSHomeViewMore (1);
                $outputUserDown = getUserDownloadView($output["game"],2);
             
            }elseif($type==2){
                 // Box New
                $output = getGameIOSHomeViewMore (2);
                $outputUserDown = getUserDownloadView($output["game"],2);
            
            }else{
                 // Box Mini Game
                $output = getGameIOSHomeViewMore (3);
                $outputUserDown = getUserDownloadView($output["game"],2);
                
            }
           
            $arrOut = array();
            $arrOut["game"]=$output;
            $arrOut["user_download"]=$outputUserDown;
            
            echo json_encode ($arrOut);
            
            $arrPara = array ("type"=>1);
            $dataLog = createDataLog ( "getGameIOSHomeViewMore", $arrPara, "" );
            $ip = getRealIpAddr ();
            insertAppTrackingGS ( 0, $app_client_id, $dataLog, $ip );
            
            break;
        }
            
   default :
		{
			$function = isset ( $_GET ['function'] ) ? $_GET ['function'] : "";
			if (! empty ( $function )) {
				$gameStoreDoc = new GameStoreDOC ( $function );
				$gameStoreDoc->outLine ();
			} else {
				echo "<style> li{padding-top:10px;list-style-type:decimal;} table, td, th {border: 1px solid black;}";
				echo "a:link {text-decoration: none;} a:visited {text-decoration: none;} a:hover {text-decoration: underline;} a:active {text-decoration:underline}</style>";
				echo "<H1>Danh sách Function:</H1>";
				echo "<table style='border: 1px solid black;border-collapse: collapse;'><tr><td>";
				echo "<UL>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getCategory' target='_blank'>getCategory</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getPublisher' target='_blank'>getPublisher</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKHomeHot' target='_blank'>getGameAPKHomeHot</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKHomeNew' target='_blank'>getGameAPKHomeNew</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKByCategoryHot' target='_blank'>getGameAPKByCategoryHot</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKByCategoryNew' target='_blank'>getGameAPKByCategoryNew</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKByPublisherNew' target='_blank'>getGameAPKByPublisherNew</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKByPublisherHot' target='_blank'>getGameAPKByPublisherHot</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSHomeHot' target='_blank'>getGameIOSHomeHot</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSHomeHotItune' target='_blank'>getGameIOSHomeHotItune</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSHomeNew' target='_blank'>getGameIOSHomeNew</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSHomeNewItune' target='_blank'>getGameIOSHomeNewItune</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByCategoryHot' target='_blank'>getGameIOSByCategoryHot</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByCategoryHotItune' target='_blank'>getGameIOSByCategoryHotItune</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByCategoryNew' target='_blank'>getGameIOSByCategoryNew</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByCategoryNewItune' target='_blank'>getGameIOSByCategoryNewItune</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByPublisherHot' target='_blank'>getGameIOSByPublisherHot</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByPublisherHotItune' target='_blank'>getGameIOSByPublisherHotItune</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByPublisherNew' target='_blank'>getGameIOSByPublisherNew</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSByPublisherNewItune' target='_blank'>getGameIOSByPublisherNewItune</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKDetail' target='_blank'>getGameAPKDetail</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSDetail' target='_blank'>getGameIOSDetail</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getNewsHome' target='_blank'>getNewsHome</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getNewsByCategory' target='_blank'>getNewsByCategory</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getNewsByPublisher' target='_blank'>getNewsByPublisher</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getNewsByGame' target='_blank'>getNewsByGame</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getNewsDetail' target='_blank'>getNewsDetail</a></li>";
				
				echo "</UL></td><td style='vertical-align:text-top;'>";
				echo "<UL>";
				
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeHome' target='_blank'>getGiftCodeHome</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeByCategory' target='_blank'>getGiftCodeByCategory</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeByPublisher' target='_blank'>getGiftCodeByPublisher</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeByGameId' target='_blank'>getGiftCodeByGameId</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeDetailIOS' target='_blank'>getGiftCodeDetailIOS</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeDetailAPK' target='_blank'>getGiftCodeDetailAPK</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getCommentByNewsId' target='_blank'>getCommentByNewsId</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getDiscussionByGameId' target='_blank'>getDiscussionByGameId</a></li>";
				
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getDiscussionDetail' target='_blank'>getDiscussionDetail</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getDiscussionComment' target='_blank'>getDiscussionComment</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameReview' target='_blank'>getGameReview</a></li>";
				
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=postReviewGame' target='_blank'>postReviewGame</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=postCommentNews' target='_blank'>postCommentNews</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=postCommentDiscussion' target='_blank'>postCommentDiscussion</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=postDiscussion' target='_blank'>postDiscussion</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getBannerIOSTopHot' target='_blank'>getBannerIOSTopHot</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getBannerIOSTopNew' target='_blank'>getBannerIOSTopNew</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getBannerAndroidTopHot' target='_blank'>getBannerAndroidTopHot</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getBannerAndroidTopNew' target='_blank'>getBannerAndroidTopNew</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=addCountAndroidDownloadGame' target='_blank'>addCountAndroidDownloadGame</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=addCountIOSDownloadGame' target='_blank'>addCountIOSDownloadGame</a></li>";
                echo "</UL></td><td style='vertical-align:text-top;'>";
				echo "<UL>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGiftCodeStoreAvailable' target='_blank'>getGiftCodeStoreAvailable</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=sendGiftCodeStoreToMember' target='_blank'>sendGiftCodeStoreToMember</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getContactGame' target='_blank'>getContactGame</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getAppHeader' target='_blank'>getAppHeader</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getUserById' target='_blank'>getUserById</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getUserByUserName' target='_blank'>getUserByUserName</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=updateUserInfo' target='_blank'>updateUserInfo</a></li>";
				echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=uploadAvatar' target='_blank'>uploadAvatar</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=searchKeywordAndroid' target='_blank'>searchKeywordAndroid</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=searchKeywordIOS' target='_blank'>searchKeywordIOS</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getKeywordAndroidRecommend' target='_blank'>getKeywordAndroidRecommend</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getKeywordIOSRecommend' target='_blank'>getKeywordIOSRecommend</a></li>";
                
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=searchKeywordRecommentAndroid' target='_blank'>searchKeywordRecommentAndroid</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=searchKeywordRecommentIOS' target='_blank'>searchKeywordRecommentIOS</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=downloadGameAndroid' target='_blank'>downloadGameAndroid</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getFileGameAndroid' target='_blank'>getFileGameAndroid</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getLinkPlayGame' target='_blank'>getLinkPlayGame</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=downloadGameIOS' target='_blank'>downloadGameIOS</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getLinkItuneGameIOS' target='_blank'>getLinkItuneGameIOS</a></li>";
                
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getUserDownload' target='_blank'>getUserDownload</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=likeDiscussion' target='_blank'>likeDiscussion</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=likeNews' target='_blank'>likeNews</a></li>";
                 
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=disLikeNews' target='_blank'>disLikeNews</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=disLikeDiscussion' target='_blank'>disLikeDiscussion</a></li>";
                echo "</UL></td>";
                echo "<td style='vertical-align:text-top;'><UL>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getRoomInfo' target='_blank'>getRoomInfo</a></li>"; 
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getVersionStore' target='_blank'>getVersionStore</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=registryNoticeIOS' target='_blank'>registryNoticeIOS</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameDownloadByUser' target='_blank'>getGameDownloadByUser</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getUsernameById' target='_blank'>getUsernameById</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getBackgroundUser' target='_blank'>getBackgroundUser</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=registryNotice' target='_blank'>registryNotice</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=pushNotifyChatOffline' target='_blank'>pushNotifyChatOffline</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=deleteDiscussion' target='_blank'>deleteDiscussion</a></li>";
                echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameHadEvent' target='_blank'>getGameHadEvent</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=registerMember' target='_blank'>registerMember</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getDateExpireBan' target='_blank'>getDateExpireBan</a></li>";
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getFullnameById' target='_blank'>getFullnameById</a></li>"; 
                 echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getFullnameByIds' target='_blank'>getFullnameByIds</a></li>";
                  echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=postCommentApp' target='_blank'>postCommentApp</a></li>";
                  echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKHomeView' target='_blank'>getGameAPKHomeView</a></li>";
                  echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameAPKHomeViewMore' target='_blank'>getGameAPKHomeViewMore</a></li>";
                  echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSHomeView' target='_blank'>getGameIOSHomeView</a></li>";
                  echo "<li><a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?function=getGameIOSHomeViewMore' target='_blank'>getGameIOSHomeViewMore</a></li>";
                echo "<UL></td></tr><table>";
                echo "";
			}
		}
}
?>

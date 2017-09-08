<?php
  class GameStoreDOC
{
    private $functionName;

    function __construct($functionName)
    {
       $this->functionName = $functionName;
       
    }
    
    function outLine(){
         switch ($this->functionName){
            case "getCategory":{
                $this->outLineGetCategory();
                break;
            }
          case "getPublisher":{
                $this->outLineGetPublisher();
                break;
            }
          case "getGameAPKHomeHot":{
                $this->outLineGetGameAPKHomeHot();
                break;
            }
          case "getGameAPKHomeNew":{
                $this->outLineGetGameAPKHomeNew();
                break;
            } 
          case "getGameAPKByCategoryHot":{
                $this->outLineGameAPKByCategoryHot();
                break;
          }
          case "getGameAPKByCategoryNew":{
                $this->outLineGetGameAPKByCategoryNew();
                break;
          }   
          
          case "getGameAPKByPublisherHot":{
                $this->outLineGetGameAPKByPublisherHot();
                break;
          }   
          
          case "getGameAPKByPublisherNew":{
                $this->outLineGetGameAPKByPublisherNew();
                break;
          }  
         case "getGameIOSHomeNew":{
                $this->outLineGetGameIOSHomeNew();
                break;
          } 
         case "getGameIOSHomeNewItune":{
                $this->outLineGetGameIOSHomeNewItune();
                break;
          }   
         case "getGameIOSHomeHot":{
                $this->outLineGetGameIOSHomeHot();
                break;
          }  
         case "getGameIOSHomeHotItune":{
                $this->outLineGetGameIOSHomeHotItune();
                break;
          }    
          case "getGameIOSByCategoryHot":{
                $this->outLineGetGameIOSByCategoryHot();
                break;
          }
          case "getGameIOSByCategoryHotItune":{
                $this->outLineGetGameIOSByCategoryHotItune();
                break;
          }
         
          case "getGameIOSByCategoryNew":{
                $this->outLineGetGameIOSByCategoryNew();
                break;
          }
          
          case "getGameIOSByCategoryNewItune":{
                $this->outLineGetGameIOSByCategoryNewItune();
                break;
          }
          
          case "getGameIOSByPublisherNew":{
                $this->outLineGetGameIOSByPublisherNew();
                break;
          }
          
           case "getGameIOSByPublisherNewItune":{
                $this->outLineGetGameIOSByPublisherNewItune();
                break;
          }
          
          case "getGameIOSByPublisherHot":{
                $this->outLineGetGameIOSByPublisherHot();
                break;
          }
          
           case "getGameIOSByPublisherHotItune":{
                $this->outLineGetGameIOSByPublisherHotItune();
                break;
          }
          
           case "getGameIOSDetail":{
                $this->outLineGetGameIOSDetail();
                break;
          }
          case "getGameAPKDetail":{
                $this->outLineGetGameAPKDetail();
                break;
          }
           case "getNewsHome":{
                $this->outLineGetNewsHome();
                break;
          }
          case "getNewsByCategory":{
                $this->outLineGetNewsByCategory();
                break;
          }
           case "getNewsByPublisher":{
                $this->outLineGetNewsByPublisher();
                break;
          }
          case "getNewsByGame":{
                $this->outLineGetNewsByGame();
                break;
          }
          case "getNewsDetail":{
                $this->outLineGetNewsDetail();
                break;
          }
          case "getGiftCodeHome":{
                $this->outLineGetGiftCodeHome();
                break;
          }
          case "getGiftCodeByCategory":{
                $this->outLineGetGiftCodeByCategory();
                break;
          }
          case "getGiftCodeByPublisher":{
                $this->outLineGetGiftCodeByPublisher();
                break;
          }
          case "getGiftCodeByGameId":{
                $this->outLineGetGiftCodeByGameId();
                break;
          }
          case "getCommentByNewsId":{
                $this->outLineGetCommentByNewsId();
                break;
          }
          case "getDiscussionByGameId":{
                $this->outLineGetDiscussionByGameId();
                break;
          }
          case "getDiscussionDetail":{
                $this->outLineGetDiscussionDetail();
                break;
          }
          case "getDiscussionComment":{
                $this->outLineGetDiscussionComment();
                break;
          }
          case "getGameReview":{
                $this->outLineGetGameReview();
                break;
          }
          case "postReviewGame":{
                $this->outLinePostReviewGame();
                break;
          }
          case "postCommentNews":{
                $this->outLinePostCommentNews();
                break;
          }
          case "postCommentDiscussion":{
                $this->outLinePostCommentDiscussion();
                break;
          }
          case "postDiscussion":{
                $this->outLinePostDiscussion();
                break;
          }
          
          case "getBannerIOSTopHot":{
                $this->outLineGetBannerIOSTopHot();
                break;
          }
          
          case "getBannerIOSTopNew":{
                $this->outLineGetBannerIOSTopNew();
                break;
          }
          
          case "getBannerAndroidTopHot":{
                $this->outLineGetBannerAndroidTopHot();
                break;
          }
          
          case "getBannerAndroidTopNew":{
                $this->outLineGetBannerAndroidTopNew();
                break;
          }
          
          case "getGiftCodeDetailIOS":{
                $this->outLineGetGiftCodeDetailIOS();
                break;
          }
           case "getGiftCodeDetailAPK":{
                $this->outLineGetGiftCodeDetailAPK();
                break;
          }
          
          case "addCountIOSDownloadGame":{
                $this->outLineAddCountIOSDownloadGame();
                break;
          }
          
          case "addCountAndroidDownloadGame":{
                $this->outLineAddCountAndroidDownloadGame();
                break;
          }
          
           case "getGiftCodeStoreAvailable":{
                $this->outLineGetGiftCodeStoreAvailable();
                break;
          }
           case "sendGiftCodeStoreToMember":{
                $this->outLineSendGiftCodeStoreToMember();
                break;
          }
           case "getContactGame":{
                $this->outLineGetContactGame();
                break;
          }
          
          case "getAppHeader":{
                $this->outLineGetAppHeader();
                break;
          }
          case "getUserById":{
                $this->outLineGetUserById();
                break;
          }
          case "getUserByUserName":{
                $this->outLineGetUserByUserName();
                break;
          }
          case "updateUserInfo":{
	          	$this->outLineUpdateUserInfo();
	          	break;
          }
          case "uploadAvatar":{
	          	$this->outLineUploadAvatar();
	          	break;
          }
           case "searchKeywordAndroid":{
                  $this->outLineSearchKeywordAndroid();
                  break;
          }
           case "searchKeywordIOS":{
                  $this->outLineSearchKeywordIOS();
                  break;
          }
          
          case "getKeywordAndroidRecommend":{
                  $this->outLineGetKeywordAndroidRecommend();
                  break;
          }
          
          case "getKeywordIOSRecommend":{
                  $this->outLineGetKeywordIOSRecommend();
                  break;
          }
          
          case "searchKeywordRecommentAndroid":{
                  $this->outLineSearchKeywordRecommentAndroid();
                  break;
          }
          case "searchKeywordRecommentIOS":{
                  $this->outLineSearchKeywordRecommentIOS();
                  break;
          }
          case "downloadGameIOS":{
                  $this->outLineDownloadGameIOS();
                  break;
          }
          
          case "getLinkItuneGameIOS":{
                  $this->outLineGetLinkItuneGameIOS();
                  break;
          }
          
          case "downloadGameAndroid":{
                  $this->outLineDownloadGameAndroid();
                  break;
          }
          
          case "getFileGameAndroid":{
                  $this->outLineGetFileGameAndroid();
                  break;
          }
          case "getLinkPlayGame":{
                  $this->outLineGetLinkPlayGame();
                  break;
          }
          case "getUserDownload":{
                  $this->outLineGetUserDownload();
                  break;
          }
          case "likeDiscussion":{
                  $this->outLineInsertLikeDiscussion();
                  break;
          }
          case "likeNews":{
                  $this->outLineInsertLikeNews();
                  break;
          }
          case "disLikeDiscussion":{
                  $this->outLineDisLikeDiscussion();
                  break;
          }
          case "disLikeNews":{
                  $this->outLineDisLikeNews();
                  break;
          }
           case "getRoomInfo":{
                  $this->outLineGetRoomInfo();
                  break;
          }
          case "getVersionStore":{
                  $this->outLineGetVersionStore();
                  break;
          }
          case "registryNoticeIOS":{
                  $this->outLineRegistryNoticeIOS();
                  break;
          }
          case "registryNotice":{
                  $this->outLineRegistryNotice();
                  break;
          }
          case "getGameDownloadByUser":{
                  $this->outLineGetGameDownloadByUser();
                  break;
          }
          case "getUsernameById":{
                  $this->outLineGetUsernameById();
                  break;
          }
          case "getFullnameByIds":{
                  $this->outLineGetFullnameByIds();
                  break;
          }
          case "getFullnameById":{
                  $this->outLineGetFullnameById();
                  break;
          }
          case "getBackgroundUser":{
                  $this->outLineGetBackgroundUser();
                  break;
          }
          case "pushNotifyChatOffline":{
                  $this->outLinePushNotifyChatOffline();
                  break;
          }
           case "deleteDiscussion":{
                  $this->outLineDeleteDiscussion();
                  break;
          }
           case "getGameHadEvent":{
                  $this->outLineGetGameHadEvent();
                  break;
          }
           case "registerMember":{
                  $this->outLineRegisterMember();
                  break;
          }
          case "getDateExpireBan":{
                  $this->outLineGetDateExpireBan();
                  break;
          }
          case "postCommentApp":{
                  $this->outLinePostCommentApp();
                  break;
          }
          case "getGameAPKHomeView":{
                  $this->outLineGetGameAPKHomeView();
                  break;
          }
          case "getGameAPKHomeViewMore":{
                  $this->outLineGetGameAPKHomeViewMore();
                  break;
          }
          case "getGameIOSHomeView":{
                  $this->outLineGetGameIOSHomeView();
                  break;
          }
          case "getGameIOSHomeViewMore":{
                  $this->outLineGetGameIOSHomeViewMore();
                  break;
          }
        }
    }
    
    function outLineGetCategory(){
        echo "<h1>Function: getCategory</h1>";
        echo "<i>Lấy danh sách danh mục game</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCategory</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getCategory' target='_blank'>getCategory</a></span>";
        
    }
    
     function outLineGetPublisher(){
        echo "<h1>Function: getPublisher</h1>";
        echo "<i>Lấy danh sách nhà phân phối</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getPublisher</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getPublisher' target='_blank'>getPublisher</a></span>";
        
    }
    
     function outLineGetGameAPKHomeHot(){
        echo "<h1>Function: getGameAPKHomeHot</h1>";
        echo "<i>Lấy danh sách game APK Hot ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKHomeHot</LI>";
        echo "<LI>page: số page</LI>";
        echo "<LI>is_play: 1: game co tren play</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKHomeHot&page=1' target='_blank'>getGameAPKHomeHot</a></span>";
        
    }
    
    function outLineGetGameAPKHomeNew(){
        echo "<h1>Function: getGameAPKHomeNew</h1>";
        echo "<i>Lấy danh sách game APK New ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKHomeNew</LI>";
        echo "<LI>page: số page</LI>";
        echo "<LI>is_play: 1: game co tren play</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKHomeNew&page=1' target='_blank'>getGameAPKHomeNew</a></span>";
        
    }
    
    function outLineGameAPKByCategoryHot(){
        echo "<h1>Function: getGameAPKByCategoryHot</h1>";
        echo "<i>Lấy danh sách game APK Hot ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKByCategoryHot</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số page</LI>";
        echo "<LI>is_play: 1: game co tren play</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKByCategoryHot&category_id=1&page=1' target='_blank'>getGameAPKByCategoryHot</a></span>";
        
    }
    
     function outLineGetGameAPKByCategoryNew(){
        echo "<h1>Function: getGameAPKByCategoryNew</h1>";
        echo "<i>Lấy danh sách game APK New ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKByCategoryNew</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số page</LI>";
        echo "<LI>is_play: 1: game co tren play</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKByCategoryNew&category_id=1&page=1' target='_blank'>getGameAPKByCategoryNew</a></span>";
        
    }
    
    function outLineGetGameAPKByPublisherHot(){
        echo "<h1>Function: getGameAPKByPublisherHot</h1>";
        echo "<i>Lấy danh sách game APK Hot theo nhà phát hành</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKByPublisherHot</LI>";
        echo "<LI>publisher_id: id nhà phát hành</LI>";
        echo "<LI>page: số page</LI>";
        echo "<LI>is_play: 1: game co tren play</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKByPublisherHot&publisher_id=1&page=1' target='_blank'>getGameAPKByPublisherHot</a></span>";
     }
     
     function outLineGetGameAPKByPublisherNew(){
        echo "<h1>Function: getGameAPKByPublisherNew</h1>";
        echo "<i>Lấy danh sách game APK New theo nhà phát hành</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKByPublisherNew</LI>";
        echo "<LI>publisher_id: id nhà phát hành</LI>";
        echo "<LI>page: số page</LI>";
        echo "<LI>is_play: 1: game co tren play</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKByPublisherNew&publisher_id=1&page=1' target='_blank'>getGameAPKByPublisherNew</a></span>";
     }
     
     function outLineGetGameIOSHomeNew(){
        echo "<h1>Function: getGameIOSHomeNew</h1>";
        echo "<i>Lấy danh sách game IOS New ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSHomeNew</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSHomeNew&page=1' target='_blank'>getGameIOSHomeNew</a></span>";
    }
    
    function outLineGetGameIOSHomeNewItune(){
        echo "<h1>Function: getGameIOSHomeNewItune</h1>";
        echo "<i>Lấy danh sách game IOS New ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSHomeNewItune</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSHomeNewItune&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSHomeNewItune</a></span>";
    }
    
     function outLineGetGameIOSHomeHot(){
        echo "<h1>Function: getGameIOSHomeHot</h1>";
        echo "<i>Lấy danh sách game IOS Hot ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSHomeHot</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSHomeHot&page=1' target='_blank'>getGameIOSHomeHot</a></span>";
    }
    
    function outLineGetGameIOSHomeHotItune(){
        echo "<h1>Function: getGameIOSHomeHotItune</h1>";
        echo "<i>Lấy danh sách game IOS Hot ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSHomeHotItune</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSHomeHotItune&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSHomeHotItune</a></span>";
    }
    
    function outLineGetGameIOSByCategoryHot(){
        echo "<h1>Function: getGameIOSByCategoryHot</h1>";
        echo "<i>Lấy danh sách game IOS Hot ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByCategoryHot</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByCategoryHot&category_id=1&page=1' target='_blank'>getGameIOSByCategoryHot</a></span>";
    }
    
    function outLineGetGameIOSByCategoryHotItune(){
        echo "<h1>Function: getGameIOSByCategoryHotItune</h1>";
        echo "<i>Lấy danh sách game IOS Hot ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByCategoryHotItune</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByCategoryHotItune&category_id=7&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByCategoryHotItune</a></span>";
    }
    
    function outLineGetGameIOSByCategoryNew(){
        echo "<h1>Function: getGameIOSByCategoryNew</h1>";
        echo "<i>Lấy danh sách game IOS New ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByCategoryNew</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByCategoryNew&category_id=1&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByCategoryNew</a></span>";
    }
    
    function outLineGetGameIOSByCategoryNewItune(){
        echo "<h1>Function: getGameIOSByCategoryNewItune</h1>";
        echo "<i>Lấy danh sách game IOS New ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByCategoryNewItune</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByCategoryNewItune&category_id=7&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByCategoryNewItune</a></span>";
    }
    
    function outLineGetGameIOSByPublisherNew(){
        echo "<h1>Function: getGameIOSByPublisherNew</h1>";
        echo "<i>Lấy danh sách game IOS New theo nhà phát hành</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByPublisherNew</LI>";
        echo "<LI>publisher_id: id publisher</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByPublisherNew&publisher_id=1&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByPublisherNew</a></span>";
    }
    
     function outLineGetGameIOSByPublisherNewItune(){
        echo "<h1>Function: getGameIOSByPublisherNewItune</h1>";
        echo "<i>Lấy danh sách game IOS New theo nhà phát hành</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByPublisherNewItune</LI>";
        echo "<LI>publisher_id: id publisher</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByPublisherNewItune&publisher_id=22&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByPublisherNewItune</a></span>";
    }
    
    function outLineGetGameIOSByPublisherHot(){
        echo "<h1>Function: getGameIOSByPublisherHot</h1>";
        echo "<i>Lấy danh sách game IOS Hot theo nhà phát hành</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByPublisherHot</LI>";
        echo "<LI>publisher_id: id publisher</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByPublisherHot&publisher_id=1&page=1&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByPublisherHot</a></span>";
    }
    
     function outLineGetGameIOSByPublisherHotItune(){
        echo "<h1>Function: getGameIOSByPublisherHotItune</h1>";
        echo "<i>Lấy danh sách game IOS Hot theo nhà phát hành</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSByPublisherHotItune</LI>";
        echo "<LI>publisher_id: id publisher</LI>";
        echo "<LI>page: số page</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSByPublisherHotItune&publisher_id=22&page=1&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSByPublisherHotItune</a></span>";
    }
    
    function outLineGetGameAPKDetail(){
        echo "<h1>Function: getGameAPKDetail</h1>";
        echo "<i>Lấy thông tin game APK chi tiết</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKDetail</LI>";
        echo "<LI>id: id game</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKDetail&id=1' target='_blank'>getGameAPKDetail</a></span>";
    }
    
    function outLineGetGameIOSDetail(){
        echo "<h1>Function: getGameIOSDetail</h1>";
        echo "<i>Lấy thông tin game IOS chi tiết</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSDetail</LI>";
        echo "<LI>id: id game</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSDetail&id=100&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSDetail</a></span>";
    }
    
     function outLineGetNewsHome(){
        echo "<h1>Function: getNewsHome</h1>";
        echo "<i>Lấy danh sách tin tức ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNewsHome</LI>";
        echo "<LI>page: số thứ tự trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getNewsHome&page=1' target='_blank'>getNewsHome</a></span>";
    }
    
    function outLineGetNewsByCategory(){
        echo "<h1>Function: getNewsByCategory</h1>";
        echo "<i>Lấy danh sách tin tức ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNewsByCategory</LI>";
        echo "<LI>category_id: id danh mục</LI>";
        echo "<LI>page: số thứ tự trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getNewsByCategory&category_id=1&page=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getNewsByCategory</a></span>";
    }
    
    function outLineGetNewsByPublisher(){
        echo "<h1>Function: getNewsByPublisher</h1>";
        echo "<i>Lấy danh sách tin tức ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNewsByPublisher</LI>";
        echo "<LI>publisher_id: id nhà phát hành</LI>";
        echo "<LI>page: số thứ tự trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getNewsByPublisher&publisher_id=1&page=1' target='_blank'>getNewsByPublisher</a></span>";
    }
    
    function outLineGetNewsByGame(){
        echo "<h1>Function: getNewsByGame</h1>";
        echo "<i>Lấy danh sách tin tức ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNewsByGame</LI>";
        echo "<LI>game_id: id của game</LI>";
        echo "<LI>page: số thứ tự trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getNewsByGame&game_id=1&page=1' target='_blank'>getNewsByGame</a></span>";
    }
    
    function outLineGetNewsDetail(){
        echo "<h1>Function: getNewsDetail</h1>";
        echo "<i>Lấy thông tin game chi tiết</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNewsDetail</LI>";
        echo "<LI>id: id của bài tin</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getNewsDetail&id=1' target='_blank'>getNewsDetail</a></span>";
    }
    
    function outLineGetGiftCodeHome(){
        echo "<h1>Function: getGiftCodeHome</h1>";
        echo "<i>Lấy ds giftcode ở trang chủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGiftCodeHome</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeHome&page=1' target='_blank'>getGiftCodeHome</a></span>";
    }
    
    function outLineGetGiftCodeByCategory(){
        echo "<h1>Function: getGiftCodeByCategory</h1>";
        echo "<i>Lấy ds giftcode ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGiftCodeByCategory</LI>";
        echo "<LI>category_id: id của danh mục</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeByCategory&category_id=1&page=1' target='_blank'>getGiftCodeByCategory</a></span>";
    }
    
    function outLineGetGiftCodeByPublisher(){
        echo "<h1>Function: getGiftCodeByPublisher</h1>";
        echo "<i>Lấy ds giftcode ở danh mục</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGiftCodeByPublisher</LI>";
        echo "<LI>publisher_id: id của danh mục</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeByPublisher&publisher_id=1&page=1' target='_blank'>getGiftCodeByPublisher</a></span>";
    }
    
    function outLineGetGiftCodeByGameId(){
        echo "<h1>Function: getGiftCodeByGameId</h1>";
        echo "<i>Lấy ds giftcode của game</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGiftCodeByGameId</LI>";
        echo "<LI>game_id: id của danh mục</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeByGameId&game_id=1&page=1' target='_blank'>getGiftCodeByGameId</a></span>";
    }
    
    function outLineGetCommentByNewsId(){
        echo "<h1>Function: getCommentByNewsId</h1>";
        echo "<i>Lấy ds comment theo news id</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCommentByNewsId</LI>";
        echo "<LI>news_id: id của bài tin</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getCommentByNewsId&news_id=1&page=1' target='_blank'>getCommentByNewsId</a></span>";
    }
    
    function outLineGetDiscussionByGameId(){
        echo "<h1>Function: getDiscussionByGameId</h1>";
        echo "<i>Lấy ds thảo luật theo game id</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getDiscussionByGameId</LI>";
        echo "<LI>game_id: id của bài tin</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getDiscussionByGameId&game_id=1&page=1' target='_blank'>getDiscussionByGameId</a></span>";
    }
    
     function outLineGetDiscussionDetail(){
        echo "<h1>Function: getDiscussionDetail</h1>";
        echo "<i>Lấy ds thảo luật theo game id</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getDiscussionDetail</LI>";
        echo "<LI>id: id của thảo luật</LI>";
        echo "<LI>page: số trang comment của thảo luận</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getDiscussionDetail&id=1&page=1' target='_blank'>getDiscussionDetail</a></span>";
    }
    
     function outLineGetDiscussionComment(){
        echo "<h1>Function: getDiscussionComment</h1>";
        echo "<i>Lấy ds thảo luật theo game id</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getDiscussionComment</LI>";
        echo "<LI>id: id của thảo luật</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getDiscussionComment&discussion_id=1&page=1' target='_blank'>getDiscussionComment</a></span>";
    }
    
     function outLineGetGameReview(){
        echo "<h1>Function: getGameReview</h1>";
        echo "<i>Lấy ds thảo luật theo game id</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameReview</LI>";
        echo "<LI>game_id: id của game</LI>";
        echo "<LI>page: số trang</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameReview&game_id=1&page=1' target='_blank'>getGameReview</a></span>";
    }
    
    function outLinePostReviewGame(){
        echo "<h1>Function: postReviewGame</h1>";
        echo "<i>Post thông tin review game</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postReviewGame</LI>";
        echo "<LI>game_id: id của game</LI>";
        echo "<LI>user_id: id của user</LI>";
        echo "<LI>mark: số điểm <6 </LI>";
        echo "<LI>content: nội dung review</LI>";
        echo "<LI>create_user: Tên người review</LI>";
        echo "<LI><strong>Kết quả</strong>: 0: Thành công, 1: Thiếu tham số, 2: Post không thành công</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=postReviewGame&game_id=1&user_id=1&mark=5&content=Game hay&create_user=thangtt' target='_blank'>postReviewGame</a></span>";
    }
    
    function outLinePostCommentNews(){
        echo "<h1>Function: postCommentNews</h1>";
        echo "<i>Post thông tin comment news</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postCommentNews</LI>";
        echo "<LI>news_id: id của news</LI>";
        echo "<LI>user_id: id của user</LI>";
        echo "<LI>comment: nội dung review</LI>";
        echo "<LI>create_user: Tên người review</LI>";
        echo "<LI><strong>Kết quả</strong>: 0: Thành công, 1: Thiếu tham số, 2: Post không thành công, 10: Post không thành công do bị BAN</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=postCommentNews&news_id=1&user_id=1&comment=Game hay&create_user=thangtt' target='_blank'>postCommentNews</a></span>";
    }
    
     function outLinePostCommentDiscussion(){
        echo "<h1>Function: postCommentDiscussion</h1>";
        echo "<i>Post comment chủ đề</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postCommentDiscussion</LI>";
        echo "<LI>discussion_id: id của chủ đề</LI>";
        echo "<LI>user_id: id của user</LI>";
        echo "<LI>comment: nội dung review</LI>";
        echo "<LI>image: tên của hình ảnh</LI>";
        echo "<LI>create_user: Tên người review</LI>";
        echo "<LI><strong>Kết quả</strong>: 0: Thành công, 1: Thiếu tham số, 2: Post không thành công,10: Post không thành công do bị ban</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=postCommentDiscussion&discussion_id=1&user_id=1&comment=Game hay&image=abc.jpg&create_user=thangtt' target='_blank'>postCommentDiscussion</a></span>";
    }
    
     function outLinePostDiscussion(){
        echo "<h1>Function: postDiscussion</h1>";
        echo "<i>Post chủ đề</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postDiscussion</LI>";
        echo "<LI>game_id: id của chủ đề</LI>";
        echo "<LI>user_id: id của user</LI>";
        echo "<LI>content: nội dung review</LI>";
        echo "<LI>image: tên của hình ảnh</LI>";
        echo "<LI>create_user: Tên người review</LI>";
        echo "<LI><strong>Kết quả</strong>: 0: Thành công, 1: Thiếu tham số, 2: Post không thành công,10: Post không thành công do bị BAN</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=postDiscussion&game_id=1&user_id=1&content=Game hay&image=abc.jpg&create_user=thangtt' target='_blank'>postDiscussion</a></span>";
    }
    
    function outLineGetBannerIOSTopHot(){
        echo "<h1>Function: getBannerIOSTopHot</h1>";
        echo "<i>Lấy danh sách banner IOS Top Hot</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBannerIOSTopHot</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getBannerIOSTopHot' target='_blank'>getBannerIOSTopHot</a></span>";
    }
    
    function outLineGetBannerIOSTopNew(){
        echo "<h1>Function: getBannerIOSTopNew</h1>";
        echo "<i>Lấy danh sách banner IOS Top New</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBannerIOSTopNew</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getBannerIOSTopNew' target='_blank'>getBannerIOSTopNew</a></span>";
    }
    
    function outLineGetBannerAndroidTopHot(){
        echo "<h1>Function: getBannerAndroidTopHot</h1>";
        echo "<i>Lấy danh sách banner Android Top Hot</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBannerAndroidTopHot</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getBannerAndroidTopHot' target='_blank'>getBannerAndroidTopHot</a></span>";
    }
    
    function outLineGetBannerAndroidTopNew(){
        echo "<h1>Function: getBannerAndroidTopNew</h1>";
        echo "<i>Lấy danh sách banner IOS Top New</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBannerAndroidTopNew</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getBannerAndroidTopNew' target='_blank'>getBannerAndroidTopHot</a></span>";
    }
    
    function outLineGetGiftCodeDetailIOS(){
        echo "<h1>Function: getGiftCodeDetailIOS</h1>";
        echo "<i>Lấy thong tin giftcode chi tiet</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGiftCodeDetailIOS</LI>";
        echo "<LI>id: id gift code</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeDetailIOS&id=1' target='_blank'>getGiftCodeDetailIOS</a></span>";
    }
    
    function outLineGetGiftCodeDetailAPK(){
        echo "<h1>Function: getGiftCodeDetailAPK</h1>";
        echo "<i>Lấy thong tin giftcode chi tiet</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGiftCodeDetailAPK</LI>";
        echo "<LI>id: id gift code</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeDetailAPK&id=1' target='_blank'>getGiftCodeDetailAPK</a></span>";
    }
    
    function outLineAddCountAndroidDownloadGame(){
            echo "<h1>Function: addCountAndroidDownloadGame</h1>";
            echo "<i>Thêm số lượng lượt tải game android</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: addCountAndroidDownloadGame</LI>";
            echo "<LI>id: id của game</LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=addCountAndroidDownloadGame&id=1' target='_blank'>addCountAndroidDownloadGame</a></span>";
    }
    
    function outLineAddCountIOSDownloadGame(){
            echo "<h1>Function: addCountIOSDownloadGame</h1>";
            echo "<i>Thêm số lượng lượt tải game IOS</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: addCountIOSDownloadGame</LI>";
            echo "<LI>id: id của game</LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=addCountIOSDownloadGame&id=1' target='_blank'>addCountIOSDownloadGame</a></span>";
    }
    
    function outLineGetGiftCodeStoreAvailable(){
            echo "<h1>Function: getGiftCodeStoreAvailable</h1>";
            echo "<i>Lấy giftcode avaiable</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: getGiftCodeStoreAvailable</LI>";
            echo "<LI>giftcode_id: id của giftcode</LI>";
            echo "<LI>user_id: id của người nhận giftcode</LI>";
            echo "<LI>Kết quả trả về gồm 2 thông số:<br> result: 0 Success, 1: Thieu tham số, 2: Hết giftcode<br>giftcode: mảng chứa giftcode </LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGiftCodeStoreAvailable&giftcode_id=1&user_id=1' target='_blank'>getGiftCodeStoreAvailable</a></span>";
    }
    
    function outLineSendGiftCodeStoreToMember(){
            echo "<h1>Function: sendGiftCodeStoreToMember</h1>";
            echo "<i>Thực hiện dấu việc đã send giftcode cho member</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: sendGiftCodeStoreToMember</LI>";
            echo "<LI>giftcode_id: id của nhóm giftcode</LI>";
            echo "<LI>code_id: id của mã giftcode cụ thể</LI>";
            echo "<LI>user_id: id của người nhận giftcode</LI>";
            echo "<LI>Kết quả: 0 Cấp thành công; 1: Cấp không thành công có thể giftcode đã được cấp, khuyến cáo khách hàng refresh để lấy lại giftcode<br/> Flow lấy giftcode:<br> 1. Lấy code<br> 2. Send Giftcode<br/> 3. Check thông tin send giftcode <br> 4. Nếu thông tin send giftcode là 0 thì lưu trên client giftcode đã lấy ngược lại thì thông báo để khác hàng lấy giftcode khác, hoặc số lượng giftcode đã hết. </LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=sendGiftCodeStoreToMember&giftcode_id=1&user_id=1&code_id=121' target='_blank'>sendGiftCodeStoreToMember</a></span>";
    }
    
    function outLineGetContactGame(){
            echo "<h1>Function: getContactGame</h1>";
            echo "<i>Lấy thông tin liên hệ của game</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: getContactGame</LI>";
            echo "<LI>id: id của game</LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getContactGame&id=1' target='_blank'>getContactGame</a></span>";
    }
    
    function outLineGetAppHeader(){
            echo "<h1>Function: getAppHeader</h1>";
            echo "<i>Lấy thông tin App header</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: getAppHeader</LI>";
            echo "<LI>app_header: app header cho trước</LI>";
            echo "<LI>app_client_id: app client id không có bằng 0</LI>";
            echo "<LI>imei: Imei máy mặc định rỗng</LI>";
            echo "<LI>os_version: Thông tin hệ điều hành của máy</LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getAppHeader&app_header=APPSTORE_IOS&app_client_id=14911&imei=&os_version=7.0' target='_blank'>getAppHeader</a></span>";
    }
    
    function outLineGetUserById(){
            echo "<h1>Function: getUserById</h1>";
            echo "<i>Lấy thông tin của user</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: getUserById</LI>";
            echo "<LI>id: id của user</LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getUserById&id=1' target='_blank'>getUserById</a></span>";
    }
    
    function outLineGetUserByUserName(){
            echo "<h1>Function: getUserByUserName</h1>";
            echo "<i>Lấy thông tin của user</i>";
            echo "<h3>Danh sách tham số:</h3>";
            echo "<UL>";
            echo "<LI>action: getUserByUserName</LI>";
            echo "<LI>username: ten dang nhap của user</LI>";
            echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getUserByUserName&username=thangtt' target='_blank'>getUserByUserName</a></span>";
    }
    
    function outLineUpdateUserInfo(){
    	echo "<h1>Function: updateUserInfo</h1>";
    	echo "<i>Update thông tin của user</i>";
    	echo "<h3>Danh sách tham số:</h3>";
    	echo "<UL>";
    	echo "<LI>action: updateUserInfo</LI>";
    	echo "<LI>fullname: Tên hiển thị của user method: POST</LI>";
    	echo "<LI>sex: giới tính 0: Nữ; 1 Nam: POST</LI>";
    	echo "<LI>mobile: Mobile của user method: POST</LI>";
    	echo "<LI>birthday: Ngay sinh nhat kiêu dd/mm/yyyy: POST</LI>";
    	echo "<LI>email: dia chi email cua member: POST</LI>";
    	echo "<LI>facebook_id: id facebook: POST</LI>";
    	echo "<LI>user_id: id của member: POST</LI>";
    	echo "<LI>Kết quả dạng {\"result:0\",\"user:{\"id\":\"1\",\"app_client_id\":\"1\",\"username\":\"thangtt\"}\"}<br> Trong do result: 0: success, 1: thiếu tham số; 2: Tên đã tồn tại, 3: Email không đúng định dạng;4: Từ khóa username vi phạm chính sách nội dung, yêu cầu username không dấu, và các kí tự đặc biệt ngoại trừ _ và .; 100: cập nhật không thành công</LI>";
    	echo "</UL>";
    	echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=updateUserInfo' target='_blank'>updateUserInfo</a></span>";
    }
    
    function outLineUploadAvatar(){
    	echo "<h1>Function: uploadAvatar</h1>";
    	echo "<i>Update thông tin avatar của user</i>";
    	echo "<h3>Danh sách tham số:</h3>";
    	echo "<UL>";
    	echo "<LI>action: uploadAvatar</LI>";
    	echo "<LI>user_id: Tên dang nhap của user </LI>";
    	echo "<LI>Kết quả dang {\"result:0\",\"avatar:http://10h.vn/avatar.png\"} <br> Trong do result: 0: success, 1: thiếu tham số; 2: file không được gửi, 3:File vượt quá dung lượng, 4: File upload lỗi, 5: File không đúng định dạng jpg,png,gif;100: Lỗi không xác định</LI>";
    	echo "</UL>";
    	echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=uploadAvatar' target='_blank'>uploadAvatar</a></span>";
    }
    
    function outLineSearchKeywordIOS(){
        echo "<h1>Function: searchKeywordIOS</h1>";
        echo "<i>Tìm kiếm game IOS theo từ khóa</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchKeywordIOS</LI>";
        echo "<LI>keyword: từ khóa tìm kiếm : POST</LI>";
        echo "<LI>page: sô thứ tự trang : POST </LI>";
        echo "<LI>Kết quả: Danh sánh games và Tổng số game tìm thấy</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=searchKeywordIOS&keyword=ban sung' target='_blank'>searchKeywordIOS</a></span>";
    }
    
    function outLineSearchKeywordAndroid(){
        echo "<h1>Function: searchKeywordAndroid</h1>";
        echo "<i>Tìm kiếm game Android theo từ khóa</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchKeywordAndroid</LI>";
        echo "<LI>keyword: từ khóa tìm kiếm : POST </LI>";
        echo "<LI>page: sô thứ tự trang : POST </LI>";
        echo "<LI>Kết quả: Danh sánh games và Tổng số game tìm thấy</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=searchKeywordAndroid&keyword=tam quoc&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4'  target='_blank'>searchKeywordAndroid</a></span>";
    }
    
    function outLineGetKeywordAndroidRecommend(){
        echo "<h1>Function: getKeywordAndroidRecommend</h1>";
        echo "<i>Lấy danh sách từ khóa game đề cử</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchKeywordAndroid</LI>";
       
        echo "<LI>Kết quả: Danh sánh từ khóa đề cử</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getKeywordAndroidRecommend' target='_blank'>getKeywordAndroidRecommend</a></span>";
    }
    
    function outLineGetKeywordIOSRecommend(){
        echo "<h1>Function: getKeywordIOSRecommend</h1>";
        echo "<i>Lấy danh sách từ khóa game đề cử</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getKeywordIOSRecommend</LI>";
       
        echo "<LI>Kết quả: Danh sánh từ khóa đề cử</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getKeywordIOSRecommend' target='_blank'>getKeywordIOSRecommend</a></span>";
    }
    
    function outLineSearchKeywordRecommentAndroid(){
        echo "<h1>Function: searchKeywordRecommentAndroid</h1>";
        echo "<i>Lấy danh sách game đề cử từ keyword</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchKeywordRecommentAndroid</LI>";
        echo "<LI>keyword: từ khóa tìm kiếm : POST </LI>";
        echo "<LI>Kết quả: Danh sánh game</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=searchKeywordRecommentAndroid&keyword=ban sun' target='_blank'>searchKeywordRecommentAndroid</a></span>";
    }
    
    function outLineSearchKeywordRecommentIOS(){
        echo "<h1>Function: searchKeywordRecommentIOS</h1>";
        echo "<i>Lấy danh sách game đề cử từ keyword</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchKeywordRecommentIOS</LI>";
        echo "<LI>keyword: từ khóa tìm kiếm : POST </LI>";
        echo "<LI>Kết quả: Danh sánh game</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=searchKeywordRecommentIOS&keyword=ban sun' target='_blank'>searchKeywordRecommentIOS</a></span>";
    }
    
    function outLineDownloadGameIOS(){
        echo "<h1>Function: downloadGameIOS</h1>";
        echo "<i>Lấy link tải game IOS</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: downloadGameIOS</LI>";
        echo "<LI>game_id: id game </LI>";
        echo "<LI>user_id: id usser </LI>";
        echo "<LI>Kết quả: trả về gồm 2 phần result và link tải<br>Result:1 Thiếu tham số, 0: success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=downloadGameIOS&game_id=1&user_id=1' target='_blank'>downloadGameIOS</a></span>";
    }
    
     function outLineGetLinkItuneGameIOS(){
        echo "<h1>Function: getLinkItuneGameIOS</h1>";
        echo "<i>Lấy link tải Itune game IOS</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getLinkItuneGameIOS</LI>";
        echo "<LI>game_id: id game </LI>";
        echo "<LI>user_id: id usser </LI>";
        echo "<LI>Kết quả: trả về gồm 2 phần result và link tải tren Itune <br>Result:1 Thiếu tham số, 0: success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getLinkItuneGameIOS&game_id=121&user_id=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getLinkItuneGameIOS</a></span>";
    }
    
    function outLineDownloadGameAndroid(){
        echo "<h1>Function: downloadGameAndroid</h1>";
        echo "<i>Lấy link tải game Android</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: downloadGameAndroid</LI>";
        echo "<LI>game_id: id game </LI>";
        echo "<LI>user_id: id usser </LI>";
        echo "<LI>Kết quả: trả về gồm 2 phần result và link tải<br>Result:1 Thiếu tham số, 0: success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=downloadGameAndroid&game_id=1&user_id=1' target='_blank'>downloadGameAndroid</a></span>";
    }
    
    function outLineGetFileGameAndroid(){
        echo "<h1>Function: getFileGameAndroid</h1>";
        echo "<i>Lấy link tải game Android</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getFileGameAndroid</LI>";
        echo "<LI>game_id: id game </LI>";
        echo "<LI>user_id: id usser </LI>";
        echo "<LI>Kết quả: trả về gồm 2 phần result và link tải<br>Result:1 Thiếu tham số, 0: success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getFileGameAndroid&game_id=1&user_id=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getFileGameAndroid</a></span>";
    }
    
    function outLineGetLinkPlayGame(){
        echo "<h1>Function: getLinkPlayGame</h1>";
        echo "<i>Lấy link tải game Android Tren Play Store</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getLinkPlayGame</LI>";
        echo "<LI>game_id: id game </LI>";
        echo "<LI>user_id: id usser </LI>";
        echo "<LI>Kết quả: trả về gồm 2 phần result và link tải<br>Result:1 Thiếu tham số, 0: success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getLinkPlayGame&game_id=1&user_id=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getLinkPlayGame</a></span>";
    }
    
    
    
    function outLineGetUserDownload(){
        echo "<h1>Function: getUserDownload</h1>";
        echo "<i>Lấy danh sách user tải game</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getUserDownload</LI>";
        echo "<LI>game_id: id game </LI>";
        echo "<LI>Kết quả: danh sách user tải game</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getUserDownload&game_id=1' target='_blank'>getUserDownload</a></span>";
    }
    
    function outLineInsertLikeNews(){
        echo "<h1>Function: likeNews</h1>";
        echo "<i>Thêm user like news</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: likeNews</LI>";
        echo "<LI>user_id: id user </LI>";
        echo "<LI>news_id: id news </LI>";
        echo "<LI>Kết quả: 1: Thieu tham so; 0: Success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=likeNews&user_id=1&news_id=1' target='_blank'>likeNews</a></span>";
    }
    
     function outLineDisLikeNews(){
        echo "<h1>Function: disLikeNews</h1>";
        echo "<i>Bỏ user like news</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: disLikeNews</LI>";
        echo "<LI>user_id: id user </LI>";
        echo "<LI>news_id: id news </LI>";
        echo "<LI>Kết quả: 1: Thieu tham so; 0: Success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=disLikeNews&user_id=1&news_id=1' target='_blank'>disLikeNews</a></span>";
    }
    
    function outLineInsertLikeDiscussion(){
        echo "<h1>Function: likeDiscussion</h1>";
        echo "<i>Thêm user like discussion</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: likeDiscussion</LI>";
        echo "<LI>user_id: id user </LI>";
        echo "<LI>discussion_id: id news </LI>";
        echo "<LI>Kết quả: 1: Thieu tham so; 0: Success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=likeDiscussion&user_id=1&discussion_id=1' target='_blank'>insertLikeDiscussion</a></span>";
    }
    
    function outLineDisLikeDiscussion(){
        echo "<h1>Function: disLikeDiscussion</h1>";
        echo "<i>Bỏ user like discussion</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: disLikeDiscussion</LI>";
        echo "<LI>user_id: id user </LI>";
        echo "<LI>discussion_id: id news </LI>";
        echo "<LI>Kết quả: 1: Thieu tham so; 0: Success</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=disLikeDiscussion&user_id=1&discussion_id=1' target='_blank'>disLikeDiscussion</a></span>";
    }
    
    function outLineGetRoomInfo(){
        echo "<h1>Function: getRoomInfo</h1>";
        echo "<i>lấy thông tin room chat</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getRoomInfo</LI>";
        echo "<LI>id: id của game </LI>";
        echo "<LI>Kết quả: Thông tin room</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getRoomInfo&id=1' target='_blank'>getRoomInfo</a></span>";
    }
    
    function outLineGetVersionStore(){
        echo "<h1>Function: getVersionStore</h1>";
        echo "<i>Lấy thông tin version của appstore</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getVersionStore</LI>";
        echo "<LI>app_hear: app header cua appstore </LI>";
        echo "<LI>Kết quả: Thông tin version</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getVersionStore&app_header=APPSTORE_IOS' target='_blank'>getVersionStore</a></span>";
    }
    
    function outLineRegistryNoticeIOS(){
        echo "<h1>Function: registryNoticeIOS</h1>";
        echo "<i>Lấy thông tin version của appstore</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registryNoticeIOS</LI>";
        echo "<LI>app_hear: app header cua appstore </LI>";
        echo "<LI>app_client_id: id client app </LI>";
        echo "<LI>device_token: token sinh ra từ apple </LI>";
        echo "<LI>user_id: id của người gửi token </LI>";
        echo "<LI>Kết quả: 0: thành công, 1 : thiếu tham số, 2 : có lỗi insert</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=registryNoticeIOS&app_header=APPSTORE_IOS&app_client_id=123&device_token=123&user_id=1' target='_blank'>registryNoticeIOS</a></span>";
    }
    
    function outLineRegistryNotice(){
        echo "<h1>Function: registryNotice</h1>";
        echo "<i>Lấy thông tin version của appstore</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registryNotice</LI>";
        echo "<LI>device_token: token sinh ra từ apple google</LI>";
        echo "<LI>os_type: Loai he dieu hanh </LI>";
        echo "<LI>user_id: Id của user </LI>";
        echo "<LI>app_client_id: id app client </LI>";
        echo "<LI>channel: kênh phát sinh token</LI>";
        echo "<LI>Kết quả: 0: thành công, 1 : thiếu tham số, 2 : có lỗi insert</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=registryNotice&app_header=APPSTORE_ANDROID&device_token=123&os_type=2&user_id=1&channel=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>registryNotice</a></span>";
    }
    
     function outLineGetGameDownloadByUser(){
        echo "<h1>Function: getGameDownloadByUser</h1>";
        echo "<i>Lấy danh sach game user tai</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameDownloadByUser</LI>";
        echo "<LI>user_id: id cua user</LI>";
        echo "<LI>Kết quả: danh sach game</LI>";
        echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameDownloadByUser&user_id=1' target='_blank'>getGameDownloadByUser</a></span>";
    }
    
    function outLineGetUsernameById(){
        echo "<h1>Function: getUsernameById</h1>";
        echo "<i>Lấy username</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getUsernameById</LI>";
        echo "<LI>id: id cua user</LI>";
        echo "<LI>Kết quả: username</LI>";
        echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getUsernameById&id=1' target='_blank'>getUsernameById</a></span>";
    }
    
    function outLineGetFullnameById(){
        echo "<h1>Function: getFullnameById</h1>";
        echo "<i>Lấy fullname</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getFullnameById</LI>";
        echo "<LI>id: id cua user</LI>";
        echo "<LI>Kết quả: fullname</LI>";
        echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getFullnameById&id=1' target='_blank'>getFullnameById</a></span>";
    }
    
    function outLineGetFullnameByIds(){
        echo "<h1>Function: getFullnameByIds</h1>";
        echo "<i>Lấy danh sách fullname</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getFullnameByIds</LI>";
        echo "<LI>ids: danh sách id của user cách nhau dau , </LI>";
        echo "<LI>Kết quả: danh sách mang user:id, fullname</LI>";
        echo "</UL>";
            echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getFullnameByIds&id=1' target='_blank'>getFullnameByIds</a></span>";
    }
    
     function outLineGetBackgroundUser(){
        echo "<h1>Function: getBackgroundUser</h1>";
        echo "<i>Lấy backgroup user</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBackgroundUser</LI>";
        echo "<LI>Kết quả: background</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getBackgroundUser' target='_blank'>getBackgroundUser</a></span>";
    }
    
    function outLinePushNotifyChatOffline(){
        echo "<h1>Function: pushNotifyChatOffline</h1>";
        echo "<i>Push nofiy chat khi offline lan dau tien</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: pushNotifyChatOffline</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>to_userId: id cua user dc gui toi</LI>";
        echo "<LI>from_userId: id cua nguoi gui di</LI>";
        echo "<LI>Kết quả: 0: thanh cong, 1 thieu tham so, 2 khong thanh cong</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=pushNotifyChatOffline&to_userId=1&from_userId=2' target='_blank'>pushNotifyChatOffline</a></span>";
    }
    
    
     function outLineDeleteDiscussion(){
        echo "<h1>Function: deleteDiscussion</h1>";
        echo "<i>Xóa thảo luận</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: deleteDiscussion</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>user_token: user_token cua user gui thảo luận</LI>";
        echo "<LI>discussion_id: id cua thảo luận</LI>";
        echo "<LI>Kết quả: 0: thanh cong, 1 thieu tham so, 2 khong thanh cong</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=deleteDiscussion&user_token=1weeew&discussion_id=2' target='_blank'>deleteDiscussion</a></span>";
    }
    
     function outLineGetGameHadEvent(){
        echo "<h1>Function: getGameHadEvent</h1>";
        echo "<i>Lấy danh sách Game có event</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameHadEvent</LI>";
        echo "<LI>method: get</LI>";
      
        echo "<LI>Kết quả: Mảng game id có event</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameHadEvent' target='_blank'>getGameHadEvent</a></span>";
    }
    
     function outLineRegisterMember(){
        echo "<h1>Function: registerMember</h1>";
        echo "<i>Đăng kí member qua facebook hoặc google plus</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registerMember</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>fullname: Tên hiên thị</LI>";
        echo "<LI>email: email</LI>";
        echo "<LI>mobile: so dien thoai</LI>";
        echo "<LI>sex: giới tính nam:1; nữ 0</LI>";
        echo "<LI>birthday: Ngày sinh</LI>";
        echo "<LI>facebook_id: Id facebook</LI>";
        
        echo "<LI>Kết quả: trả về 3 info: result: 0 Thành công - 1 Thieu tham so - 2 Them user that bai - 3 Email sai dinh dạng.<br/> isNewUser: 1 là user mới.<br/> user: mảng chứa info user</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=registerMember' target='_blank'>getGameHadEvent</a></span>";
    }
    
    function outLineGetDateExpireBan(){
        echo "<h1>Function: getDateExpireBan</h1>";
        echo "<i>Xóa thảo luận</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getDateExpireBan</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>user_id: id của user</LI>";
        echo "<LI>type: 1: chat, 2 comment</LI>";
        echo "<LI>Kết quả: date expire ban, và reason </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getDateExpireBan&user_id=1&type=1' target='_blank'>getDateExpireBan</a></span>";
    }
    
     function outLinePostCommentApp(){
        echo "<h1>Function: postCommentApp</h1>";
        echo "<i>Góp ý báo lỗi app</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postCommentApp</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>user_id: id của user , nếu chưa đăng nhập là 0</LI>";
        echo "<LI>type: Loại lỗi - 1: Lỗi Tải game; 2: Lỗi Giftcode; 3: Lỗi Chat; 4: Lỗi Thảo luận; 5 Lỗi giao diện; 6: Lỗi Đăng nhập; 7 Lỗi xung đột; 8: Lỗi khác . Bắt buột phải chọn 1 loại </LI>";
        echo "<LI>email: email của người góp ý, nếu đăng nhập rồi chọn luôn email của người đăng nhập</LI>";
        echo "<LI>comment: Nội dung của comment, Bắt buộc nhập</LI>";
        echo "<LI>Kết quả: 0 Gửi thành công; 1: thiếu tham số type hoặc nội dung comment, 2: post thông tin bị lỗi</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=postCommentApp' target='_blank'>postCommentApp</a></span>";
    }
    
    function outLineGetGameAPKHomeView(){
        echo "<h1>Function: getGameAPKHomeView</h1>";
        echo "<i>Danh sách game APK view tại trang home </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKHomeView</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: Danh sách game view tai 3 box Hot, New, Mini Game tai trang Home</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKHomeView&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameAPKHomeView</a></span>";
    }
    
    function outLineGetGameAPKHomeViewMore(){
        echo "<h1>Function: getGameAPKHomeViewMore</h1>";
        echo "<i>Danh sách game lấy thêm tại  Home </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameAPKHomeViewMore</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>type: 1: hot, 2: new; 3: Mini game</LI>";
        echo "<LI>Kết quả: Danh sách game lấy thêm tại  Home</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameAPKHomeViewMore&type=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameAPKHomeView</a></span>";
    }
    
    
     function outLineGetGameIOSHomeView(){
        echo "<h1>Function: getGameIOSHomeView</h1>";
        echo "<i>Danh sách game IOS view tại trang home </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSHomeView</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: Danh sách game view tai 3 box Hot, New, Mini Game tai trang Home</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSHomeView
&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSHomeView
</a></span>";
    }
    
    function outLineGetGameIOSHomeViewMore(){
        echo "<h1>Function: getGameIOSHomeViewMore</h1>";
        echo "<i>Danh sách game lấy thêm tại  Home </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getGameIOSHomeViewMore</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>type: 1: hot, 2: new; 3: Mini game</LI>";
        echo "<LI>Kết quả: Danh sách game lấy thêm tại  Home</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/gamestore/v10/GameStoreAPI.php?action=getGameIOSHomeViewMore&type=1&app_client_id=7092&token=0bf8c2c3f5322b10c15e14b1f7efc9d4' target='_blank'>getGameIOSHomeViewMore</a></span>";
    }
}
?>
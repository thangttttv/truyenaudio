<?php
  class ADVFacebookDOC
{
    private $functionName;

    function __construct($functionName)
    {
       $this->functionName = $functionName;
       
    }
    
    function outLine(){
         switch ($this->functionName){
            case "insertCampaignInvite":{
                $this->outLineInsertCampaignInvite();
                break;
            }
          case "addCountCampaignInvite":{
                $this->outLineAddCountCampaignInvite();
                break;
            }
          case "insertInviteLog":{
                $this->outLineInsertInviteLog();
                break;
            }
          case "countCampaignByGame":{
                $this->outLineCountCampaignByGame();
                break;
            } 
          case "countFacebookUserInvitable":{
                $this->outLineCountFacebookUserInvitable();
                break;
            }
          case "getCampaignInvite":{
                $this->outLineGetCampaignInvite();
                break;
            }
          case "getFacebookUserIdInvitable":{
                $this->outLineGetFacebookUserIdInvitable();
                break;
            }   
          case "getFacebookAccountByEmail":{
                $this->outLineGetFacebookAccountByEmail();
                break;
            }
          case "getAccountFacebook":{
                $this->outLineGetAccountFacebook();
                break;
            }
          case "getAccountFacebookSending":{
                $this->outLineGetAccountFacebookSending();
                break;
            }
          case "getAccountFacebookSented":{
                $this->outLineGetAccountFacebookSented();
                break;
            }
          case "getAccountFacebookDontSend":{
                $this->outLineGetAccountFacebookDontSend();
                break;
            }
          case "addCountCampaignInvite2":{
                $this->outLineAddCountCampaignInvite2();
                break;
            }
    }}
    
    function outLineGetFacebookAccountByEmail(){
        echo "<h1>Function: getFacebookAccountByEmail</h1>";
        echo "<i>Lấy thông tin tài khoản facebook</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getFacebookAccountByEmail</LI>";
        echo "<LI>email: email tài khoản facebook</LI>";
       
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getFacebookAccountByEmail&email=thang24011983@gmail.com' target='_blank'>getFacebookAccountByEmail</a></span>";
        
    }
    
    function outLineGetFacebookUserIdInvitable(){
        echo "<h1>Function: getFacebookUserIdInvitable</h1>";
        echo "<i>Lấy danh sách facebook user id có thể invite</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getFacebookUserIdInvitable</LI>";
        echo "<LI>account_id: facebook user id của account công ty quản lý</LI>";
        echo "<LI>last_id: Id của facebook user id cuối</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getFacebookUserIdInvitable&account_id=5&last_id=1' target='_blank'>getFacebookUserIdInvitable</a></span>";
        
    }
    
    function outLineGetCampaignInvite(){
        echo "<h1>Function: getCampaignInvite</h1>";
        echo "<i>Lấy danh sách chiến dịch invite</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCampaignInvite</LI>";
        echo "<LI>account_id: account_id của tải khoản facebook đăng nhập</LI>";
        echo "<LI>fb_app_id: app_id facebook</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getCampaignInvite&
        fb_app_id=385694194918112&account_id=3' target='_blank'>getCampaignInvite</a></span>";
        
    }
    
    function outLineCountFacebookUserInvitable(){
        echo "<h1>Function: countFacebookUserInvitable</h1>";
        echo "<i>Đếm số user có thể gửi request invitable</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: countFacebookUserInvitable</LI>";
        echo "<LI>account_id: Id của tài khoản facebook do công ty lập</LI>";
       
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=countFacebookUserInvitable&account_id=1' target='_blank'>countFacebookUserInvitable</a></span>";
        
    }
    
    function outLineCountCampaignByGame(){
        echo "<h1>Function: countCampaignByGame</h1>";
        echo "<i>Đếm số chiến dịch đã tạo với từng game</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: countCampaignByGame</LI>";
        echo "<LI>fb_app_id: Id của app_id facebook</LI>";
       
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=countCampaignByGame&fb_app_id=1' target='_blank'>countCampaignByGame</a></span>";
        
    }
    
    function outLineInsertInviteLog(){
        echo "<h1>Function: insertInviteLog</h1>";
        echo "<i>Tạo mới chiến dịch Invite</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: insertInviteLog</LI>";
        echo "<LI>campaign_id: Id của chiến dịch</LI>";
        echo "<LI>facebook_user_id: Id của facebook user có thể send invite</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=insertInviteLog&campaign_id=1&facebook_user_id=121dsffgfee' target='_blank'>insertInviteLog</a></span>";
        
    }
    
    
    function outLineInsertCampaignInvite(){
        echo "<h1>Function: insertCampaignInvite</h1>";
        echo "<i>Tạo mới chiến dịch Invite</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: insertCampaignInvite</LI>";
        echo "<LI>fb_app_id: Id của app facebook đã tạo ứng với mỗi game</LI>";
        echo "<LI>title: Tiêu đề của chiến dịch, mặc định là Tên game và số thứ tự</LI>";
        echo "<LI>account_id: account_id của tải khoản facebook đăng nhập</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=insertCampaignInvite&fb_app_id=1&title=Sat than 1' target='_blank'>insertCampaignInvite</a></span>";
        
    }
    
    function outLineAddCountCampaignInvite(){
        echo "<h1>Function: addCountCampaignInvite</h1>";
        echo "<i>Thêm số lần gửi của 1 chiến dịch Invite</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: addCountCampaignInvite</LI>";
        echo "<LI>campaign_id: Id của chiến dịch</LI>";
        echo "<LI>count: Số lần gửi</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=addCountCampaignInvite&campaign_id=1&count=100' target='_blank'>addCountCampaignInvite</a></span>";
        
    }
    
    
    function outLineGetAccountFacebook(){
        echo "<h1>Function: getAccountFacebook</h1>";
        echo "<i>Lấy danh sách account</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAccountFacebook</LI>";
        echo "<LI>page: số trang</LI>";
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getAccountFacebook&page=1' target='_blank'>getAccountFacebook</a></span>";
        
    }
    
     function outLineGetAccountFacebookSending(){
        echo "<h1>Function: getAccountFacebookSending</h1>";
        echo "<i>Lấy danh sách account đang gửi</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAccountFacebookSending</LI>";
        echo "<LI>page: số trang</LI>";
        echo "<LI>app_id: id của ứng dụng</LI>";
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getAccountFacebookSending&page=1&app_id=1' target='_blank'>getAccountFacebookSending</a></span>";
        
    }
    
    function outLineGetAccountFacebookSented(){
        echo "<h1>Function: getAccountFacebookSented</h1>";
        echo "<i>Lấy danh sách account đã gửi</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAccountFacebookSented</LI>";
        echo "<LI>page: số trang</LI>";
        echo "<LI>app_id: id của ứng dụng</LI>";
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getAccountFacebookSented&page=1&app_id=1' target='_blank'>getAccountFacebookSented</a></span>";
        
    }
    
    
    function outLineGetAccountFacebookDontSend(){
        echo "<h1>Function: getAccountFacebookDontSend</h1>";
        echo "<i>Lấy danh sách account chưa gửi</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAccountFacebookDontSend</LI>";
        echo "<LI>page: số trang</LI>";
        echo "<LI>app_id: id của ứng dụng</LI>";
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=getAccountFacebookDontSend&page=1&app_id=1' target='_blank'>getAccountFacebookDontSend</a></span>";
        
    }
    
    function outLineAddCountCampaignInvite2(){
        echo "<h1>Function: addCountCampaignInvite2</h1>";
        echo "<i>Lấy danh sách account chưa gửi</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: addCountCampaignInvite2</LI>";
        echo "<LI>campaign_id: Id chiến dịch</LI>";
        echo "<LI>count_sent: Số tin gửi</LI>";
        echo "<LI>total_countSend: tổng số tin đã gửi của chiến dịch</LI>";
        echo "<LI>count_friend: số friend của tài khoản</LI>";
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='http://kenhkiemtien.com/kkt_api/advfacebook/AdvFacebookAPI.php?action=addCountCampaignInvite2&campaign_id=1&count_sent=1&total_countSend=1&count_friend=1' target='_blank'>addCountCampaignInvite2</a></span>";
        
    }
}
?>

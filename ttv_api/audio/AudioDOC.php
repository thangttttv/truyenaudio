<?php
  class AudioDOC
{
    private $functionName;
    public $url_api = "http://kenhkiemtien.com/kkt_api/audio/AudioAPI.php";

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
          case "getAudioNew":{
                $this->outLineGetAudioNew();
                break;
            }
          case "getAudioHot":{
                $this->outLineGetAudioHot();
                break;
            }
           case "getAudioNewByCat":{
                $this->outLineGetAudioNewByCat();
                break;
            }
            case "getAudioHotByCat":{
                $this->outLineGetAudioHotByCat();
                break;
            }
             case "getAudioFile":{
                $this->outLineGetAudioFile();
                break;
            }
            case "getAudioDetail":{
                $this->outLineGetAudioDetail();
                break;
            }
             case "registerMember":{
                $this->outLineRegisterMember();
                break;
            }
             case "uploadAvatar":{
                $this->outLineUploadAvatar();
                break;
            }
             case "getAppHeaderAudio":{
                $this->outLineGetAppHeaderAudio();
                break;
            }
            case "registerMember":{
                $this->outLineRegisterMember();
                break;
            }
            case "uploadAvatar":{
                $this->outLineUploadAvatar();
                break;
            }
            case "getCommentByAudio":{
                $this->outLineGetCommentByAudio();
                break;
            }
            case "postCommentAudio":{
                $this->outLinePostCommentAudio();
                break;
            }
            case "searchAudio":{
                $this->outLineSearchAudio();
                break;
            }
             case "updateCountListen":{
                $this->outLineUpdateCountListen();
                break;
            }
             case "updateCountDownload":{
                $this->outLineUpdateCountDownload();
                break;
            }
             case "getAudioHotDownByCat":{
                $this->outLineGetAudioHotDownByCat();
                break;
            }
             case "registryNotice":{
                     $this->registryNotice();
                     break;
             }
             case "getNotices":{
                     $this->outlineGetNotices();
                     break;
             }
        }
    }
    
    function outLineGetCategory(){
        echo "<h1>Function: getCategory</h1>";
        echo "<i>Lấy danh sách danh mục Audio</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCategory</LI>";
        echo "<LI>Tham số:<br/> app_id: ID App Sách nói 16, Truyện Audio 8;<br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getCategory&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getCategory</a></span>";
        
    }
    
    
    function outLineGetAudioNew(){
        echo "<h1>Function: getAudioNew</h1>";
        echo "<i>Danh sách Audio mới ở trang chủ </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioNew</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: Danh sách audio mới ở trang chủ</LI>";
        echo "<LI>Tham số:<br/> app_id: ID App Sách nói 16, Truyện Audio 8;<br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioNew&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioNew</a></span>";
    }
    
    function outLineGetAudioHot(){
        echo "<h1>Function: getAudioHot</h1>";
        echo "<i>Danh sách Audio hot ở trang chủ </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioHot</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> app_id: ID App Sách nói 16, Truyện Audio 8;<br/>"; 
        echo "<LI>Kết quả: Danh sách audio hot ở trang chủ</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioHot&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioHot</a></span>";
    }
    
    function outLineGetAudioNewByCat(){
        echo "<h1>Function: getAudioNewByCat</h1>";
        echo "<i>Danh sách Audio new ở danh mục </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioHot</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số: cat_id: id danh mục, page: số trang</LI>";
        echo "<LI>app_id: ID App Sách nói 16, Truyện Audio 8;<br/>"; 
        echo "<LI>Kết quả: Danh sách Audio new ở danh mục </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioNewByCat&cat_id=41&page=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioNewByCat</a></span>";
    }
    
    
    function outLineGetAudioHotByCat(){
        echo "<h1>Function: getAudioHotByCat</h1>";
        echo "<i>Danh sách Audio hot ở danh mục </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioHotByCat</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>app_id: ID App Sách nói 16, Truyện Audio 8;<br/>"; 
        echo "<LI>Tham số: cat_id: id danh mục, page: số trang</LI>";
        echo "<LI>Kết quả: Danh sách audio hot ở danh mục</LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioHotByCat&cat_id=41&page=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioHotByCat</a></span>";
    }
    
     function outLineGetAudioHotDownByCat(){
        echo "<h1>Function: getAudioHotDownByCat</h1>";
        echo "<i>Danh sách Audio top tải ở danh mục </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioHotDownByCat</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số: cat_id: id danh mục, page: số trang</LI>";
        echo "<LI>Kết quả: Danh sách audio top tải ở danh mục</LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioHotDownByCat&cat_id=41&page=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioHotDownByCat</a></span>";
    }
    
    function outLineGetAudioFile(){
        echo "<h1>Function: getAudioFile</h1>";
        echo "<i>Danh sách Audio File của một truyện</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioFile</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số: audio_id: id truyện</LI>";
        echo "<LI>Kết quả: Danh sách Audio File của một truyện</LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioFile&audio_id=41&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioFile</a></span>";
    }
    
    function outLineGetAudioDetail(){
        echo "<h1>Function: getAudioDetail</h1>";
        echo "<i>Thông tin chi tiết của truyện</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAudioDetail</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số: audio_id: id truyện</LI>";
        echo "<LI>Kết quả: Thông tin chi tiết của truyện</LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=getAudioDetail&audio_id=41&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAudioDetail</a></span>";
    }
    
     function outLineGetAppHeaderAudio(){
        echo "<h1>Function: getAppHeaderAudio</h1>";
        echo "<i>Lấy app header của ứng dụng</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAppHeaderAudio</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số: app_header: Mã app header;<br/> app_client_id: id app clien, lần đầu vào app là 0, sau lây app_client_id API trả về;<br/> os_version: version hệ điều hành;<br/>imei: số imei máy client</LI>";
        echo "<LI>Kết quả: Lấy app header của ứng dụng</LI>";
        echo "</UL>";
        echo "<span>Ví dụ IOS: <a href='".$url_api."?action=getAppHeaderAudio&app_header=AUDIO-TTV-IOS&app_client_id=21418&os_version=8&imei=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAppHeaderAudio</a></span>";
        echo "<span>Ví dụ APK: <a href='".$url_api."?action=getAppHeaderAudio&app_header=AUDIO-TTV-APK&app_client_id=21418&os_version=3&imei=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getAppHeaderAudio</a></span>";
    }
    
    
    function outLineRegisterMember(){
        echo "<h1>Function: registerMember</h1>";
        echo "<i>Đăng kí thành viên </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registerMember</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>Tham số:<br/> app_client_id: ID app client;<br/> 
        fullname: Họ và Tên thành viên;<br/> 
        email: Địa chỉ email;<br/>
        sex: Giới tính 1: Nam, 0: Nữ;<br/>
        birthday: Ngày sinh dạng dd/mm/yyyy;<br/>
        sso_id: ID Facebook hoặc ID Google Plus;<br/>
        mobile: Số điện thoại;<br/>
        </LI>";
        echo "<LI>Kết quả:<br/> Kết quả đăng kí thành viên gồm 3 thuộc tính result: 0: thành công; 1: thiếu tham số, 2: đăng kí không thành công, 3: sai định dạng email <br/> isNewUser: 1: thành viên mới upload avatar lên; 0: không phải thành viên mới; <br/>
        user: Mảng thông tin user </LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=registerMember&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>registerMember</a></span>";
    }
    
    function outLineUploadAvatar(){
        echo "<h1>Function: uploadAvatar</h1>";
        echo "<i>Upload Avatar thành viên mới </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: uploadAvatar</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>Tham số:<br/> user_id: ID user;<br/> 
        upfile: File up load;<br/> 
        </LI>";
        echo "<LI>Kết quả: Kết quả upload gồm 2 thuộc tính<br/> result: 0: thành công, 1: thiếu tham số, 2: Upload lỗi, 3: File quá dung lượng,  4: Lỗi chuyển file, 5: Lỗi định dạng, 100: Lỗi không xác đinh. <br/>
        avatar: Link avatar </LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=uploadAvatar&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>uploadAvatar</a></span>";
    }
    
    function outLineGetCommentByAudio(){
        echo "<h1>Function: getCommentByAudio</h1>";
        echo "<i>Lấy danh sách comment by audio id </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCommentByAudio</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> audio_id: ID audio;<br/> 
        </LI>";
        echo "<LI>Kết quả: Danh sách comment<br/> </LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=getCommentByAudio&audio_id=609&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getCommentByAudio</a></span>";
    }
    
    
    function outLinePostCommentAudio(){
        echo "<h1>Function: postCommentAudio</h1>";
        echo "<i>Comment 1 truyện audio </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postCommentAudio</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>Tham số:<br/> 
        user_id: ID user;<br/> 
        audio_id: ID truyện audio;<br/> 
        comment: Nội dung comment;<br/> 
        create_user: Tên người gửi comment;<br/> 
        </LI>";
        echo "<LI>Kết quả: : 0: thành công, 1: thiếu tham số, 2: Lỗi insert. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=postCommentAudio&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>postCommentAudio</a></span>";
    }
    
    function outLineSearchAudio(){
        echo "<h1>Function: searchAudio</h1>";
        echo "<i>Tìm kiếm thông tin audio</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchAudio</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        page: Số trang;<br/> 
        </LI>";
        echo "<LI>Kết quả: : Danh sách audio. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchAudio&keyword=vo lam&page=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>searchAudio</a></span>";
    }
    
    function outLineUpdateCountListen(){
        echo "<h1>Function: updateCountListen</h1>";
        echo "<i>Cộng số lượt nghe</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: updateCountListen</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        audio_id: Id audio;<br/> 
        </LI>";
        echo "<LI>Kết quả: : 0: Thành công; 1: thiếu tham số; 2: không thành công. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=updateCountListen&audio_id=609&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>updateCountListen</a></span>";
    }
    
     function outLineUpdateCountDownload(){
        echo "<h1>Function: updateCountDownload</h1>";
        echo "<i>Cộng số lượt tải</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: updateCountDownload</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        audio_id: Id audio;<br/> 
        </LI>";
        echo "<LI>Kết quả: : 0: Thành công; 1: thiếu tham số; 2: không thành công. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=updateCountDownload&audio_id=609&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>updateCountDownload</a></span>";
    }
    
    function registryNotice(){
        echo "<h1>Function: registryNotice</h1>";
        echo "<i>Đăng kí toke notify </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registryNotice</LI>";
        echo "<LI>device_token: token sinh ra từ apple google</LI>";
        echo "<LI>os_type: Loai he dieu hanh </LI>";
        echo "<LI>user_id: Id của user </LI>";
        echo "<LI>Kết quả: 0: thành công, 1 : thiếu tham số, 2 : có lỗi insert</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=registryNotice&device_token=update12131&os_type=2&user_id=1&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>registryNotice</a></span>";
    }
    
     function outlineGetNotices(){
        echo "<h1>Function: getNotices</h1>";
        echo "<i>Danh sách 50 notice mới nhất</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNotices</LI>";
        echo "<LI>Kết quả: Danh sách 50 notice mới nhất</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getNotices&app_id=16&app_client_id=8&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpnPQ==' target='_blank'>getNotices</a></span>";
    }
}
?>
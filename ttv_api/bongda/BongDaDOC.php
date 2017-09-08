<?php
  class BongDaDOC
{
    private $functionName;
    public $url_api = "http://truyenaudio.mobi/ttv_api/bongda/BongDaAPI.php";
    public $token = "WkRGaFpEUmpOV0ZpWldRM1lqUmxOelZsTmpGbFlUUTRPVEJpTkRKa01qZ3g=";

    function __construct($functionName)
    {
       $this->functionName = $functionName;
       
    }
    
    function outLine(){
         switch ($this->functionName){
            case "getKetQuaTranDau":{
                $this->outLineGetKetQuaTranDau();
                break;
            }
          case "getLiveScore":{
                $this->outLineGetLiveScore();
                break;
            }
          case "getTranDau_ChiTiet":{
                $this->outLineGetTranDau_ChiTiet();
                break;
            }
           case "getTranDau_TuongThuat":{
                $this->outLineGetTranDau_TuongThuat();
                break;
            }
            case "getTranDau_PhongDoLichSu":{
                $this->outLineGetTranDau_PhongDoLichSu();
                break;
            }
             case "getTranDau_TyLe":{
                $this->outLineGetTranDau_TyLe();
                break;
            }
            case "getTranDau_ThongKe":{
                $this->outLineGetTranDau_ThongKe();
                break;
            }
            
             case "getTranDau_DoiHinh":{
                $this->outLineGetTranDau_DoiHinh();
                break;
            }
            
            case "getBangXepHang":{
                $this->outLineGetBangXepHang();
                break;
            }
            
            case "getBangXepHangGiaiDau":{
                $this->outLineGetBangXepHangGiaiDau();
                break;
            }
            
            
            case "getClub_Info":{
                $this->outLineGetClub_Info();
                break;
            }
            
             case "getClub_KetQua":{
                $this->outLinGetClub_KetQua();
                break;
            }
            
             case "getCup_KetQua":{
                $this->outLinGetCup_KetQua();
                break;
            }
            
            
             case "getClub_LichThiDau":{
                $this->outLineGetClub_LichThiDau();
                break;
            }
            
             case "getClub_CauThu":{
                $this->outLineGetClub_CauThu();
                break;
            }
            
             case "getCauThu_ChiTiet":{
                $this->outLineGetCauThu_ChiTiet();
                break;
            }
            
             case "getListNewsByClub":{
                $this->outLineGetListNewsByClub();
                break;
            }
            
             case "getListNewsByCup":{
                $this->outLineGetListNewsByCup();
                break;
            }
            
              case "getNewsDetail":{
                $this->outLineGetNewsDetail();
                break;
            }
            
             case "getListVideoByClub":{
                $this->outLineGetListVideoByClub();
                break;
            }
            
             case "getListVideoByCup":{
                $this->outLineGetListVideoByCup();
                break;
            }
            
            case "getVideoDetail":{
                $this->outLineGetVideoDetail();
                break;
            }
            case "getAppHeaderBongDa":{
                $this->outLineGetAppHeaderBongDa();
                break;
            }
             case "registerMember":{
                $this->outLineRegisterMember();
                break;
            }
            case "getCommentByMatch":{
                $this->outLineGetCommentByMatch();
                break;
            }
            case "postCommentMatch":{
                $this->outLinePostCommentMatch();
                break;
            }
            case "checkHadVoteMatch":{
                $this->outLineCheckHadVoteMatch();
                break;
            }
            case "postMatchVote":{
                $this->outLinePostMatchVote();
                break;
            }
            case "getCup_LichThiDau":{
                $this->outLineGetCup_LichThiDau();
                break;
            }
            case "getCupFavortie":{
                $this->outLineGetCupFavortie();
                break;
            }
            case "getClubFavortie":{
                $this->outLineGetClubFavortie();
                break;
            }
             case "postCupFavorite":{
                $this->outLinePostCupFavorite();
                break;
            }  
            case "postClubFavorite":{
                $this->outLinePostClubFavorite();
                break;
            }     
             case "postMatchFavorite":{
                $this->outLinePostMatchFavorite();
                break;
            }
            case "removeMatchFavorite":{
                $this->outLineRemoveMatchFavorite();
                break;
            }
            case "removeCupFavorite":{
                $this->outLineRemoveCupFavorite();
                break;
            }
            case "removeClubFavorite":{
                $this->outLineRemoveClubFavorite();
                break;
            } 
            case "uploadAvatar":{
                $this->outLineUploadAvatar();
                break;
            }
            case "registryNotice":{
                $this->outLineRegistryNotice();
                break;
            }
            case "taoFileCountryClub":{
                $this->outLineTaoFileCountryClub();
                break;
            }
            case "taoFileJSonClub":{
                $this->outLineTaoFileJSonClub();
                break;
            }
            case "taoFileCountryCup":{
                $this->outLineTaoFileCountryCup();
                break;
            } 
            case "taoFileJSonCup":{
                $this->outLineTaoFileCup();
                break;
            }
            case "getKetQuaTranDau_GiaiDauYeuThich":{
                $this->outLineGetKetQuaTranDau_GiaiDauYeuThich();
                break;
            }   
            case "getKetQuaTranDau_DoiBongYeuThich":{
                $this->outLineGetKetQuaTranDau_DoiBongYeuThich();
                break;
            }
            case "getKetQuaTranDau_YeuThich":{
                $this->outLineGetKetQuaTranDau_YeuThich();
                break;
            }
            case "getTranDau_TuongThuatChiTiet":{
                $this->outLineGetTranDau_TuongThuatChiTiet();
                break;
            }
            case "searchClub":{
                $this->outLineSearchClub();
                break;
            }
            case "searchCup":{
                $this->outLineSearchCup();
                break;
            }
             case "searchCoach":{
                $this->outLineSearchCoach();
                break;
            }
            case "searchFootballer":{
                $this->outLineSearchFootballer();
                break;
            }
             case "searchNews":{
                $this->outLineSearchNews();
                break;
            }   
             case "searchVideo":{
                $this->outLineSearchVideo();
                break;
            }
            case "getCoachDetail":{
                $this->outLineGetCoachDetail();
                break;
            }
        }
    }
    
    function outLineGetKetQuaTranDau(){
        echo "<h1>Function: getKetQuaTranDau</h1>";
        echo "<i>Lấy kết quả các trận đấu theo ngày</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getKetQuaTranDau</LI>";
        echo "<LI>Tham số:<br/> match_date: Ngày đấu theo định dạng d-m-Y;<br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getKetQuaTranDau&app_client_id=1&match_date=".date("d-m-Y")."&token=".$this->token."' target='_blank'>getKetQuaTranDau</a></span>";
        
    }
    
    
    function outLineGetLiveScore(){
        echo "<h1>Function: getLiveScore</h1>";
        echo "<i>Lấy danh sách các trận đấu đang diễn ra </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getLiveScore</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: danh sách các trận đấu đang diễn ra</LI>";
        echo "<LI>Tham số:<br/> <br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getLiveScore&app_client_id=1&token=".$this->token."' target='_blank'>getLiveScore</a></span>";
    }
    
    function outLineGetTranDau_TyLe(){
        echo "<h1>Function: getTranDau_TyLe</h1>";
        echo "<i>Lấy tỷ lệ của trận đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_TyLe</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>match_id: id của trận đấu <br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getTranDau_TyLe&app_client_id=1&match_id=209014&token=".$this->token."' target='_blank'>getTranDau_TyLe</a></span>";
    }
    
    function outLineGetTranDau_ThongKe(){
        echo "<h1>Function: getTranDau_ThongKe</h1>";
        echo "<i>Lấy thống kê của thận đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_TyLe</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>match_id: id của trận đấu <br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getTranDau_ThongKe&app_client_id=1&match_id=209014&token=".$this->token."' target='_blank'>getTranDau_ThongKe</a></span>";
    }
    
    function outLineGetTranDau_DoiHinh(){
        echo "<h1>Function: getTranDau_DoiHinh</h1>";
        echo "<i>Lấy đội hình trận đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_DoiHinh</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>match_id: id của trận đấu <br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getTranDau_DoiHinh&app_client_id=1&match_id=209014&token=".$this->token."' target='_blank'>getTranDau_DoiHinh</a></span>";
    }
    
    function outLineGetBangXepHang(){
        echo "<h1>Function: getBangXepHang</h1>";
        echo "<i>Lấy bảng xếp hạng theo giải đấu và câu lạc bộ </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBangXepHang</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>cup_id: id của giải đấu <br/>club_id_1: id của câu lạc bộ 1<br/>club_id_2: id của câu lạc bộ 2"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getBangXepHang&app_client_id=1&cup_id=8&club_id_1=110&club_id_2=102&token=".$this->token."' target='_blank'>getBangXepHang</a></span>";
    }
    
     function outLineGetBangXepHangGiaiDau(){
        echo "<h1>Function: getBangXepHangGiaiDau</h1>";
        echo "<i>Lấy bảng xếp hạng theo giải đấu  </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getBangXepHangGiaiDau</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>cup_id: id của giải đấu <br/>"; 
        echo "</UL>";
        echo "<span>Ví dụ loai 1: <a href='".$this->url_api."?action=getBangXepHangGiaiDau&app_client_id=1&cup_id=8&token=".$this->token."' target='_blank'>getBangXepHangGiaiDau</a></span>";
        echo "<span>Ví dụ loai 2: <a href='".$this->url_api."?action=getBangXepHangGiaiDau&app_client_id=1&cup_id=266&token=".$this->token."' target='_blank'>getBangXepHangGiaiDau</a></span>";
    }
    
    
     function outLineGetClub_Info(){
        echo "<h1>Function: getClub_Info</h1>";
        echo "<i>Lấy thông tin  câu lạc bộ </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getClub_Info</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>club_id: id của câu lạc bộ"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getClub_Info&app_client_id=1&club_id=110&token=".$this->token."' target='_blank'>getClub_Info</a></span>";
    }
    
     function outLinGetClub_KetQua(){
        echo "<h1>Function: getClub_KetQua</h1>";
        echo "<i>Lấy thông tin kết quả thi đấu câu lạc bộ </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getClub_KetQua</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>club_id: id của câu lạc bộ<br/>page: số trang"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getClub_KetQua&app_client_id=1&club_id=110&page=1&token=".$this->token."' target='_blank'>getClub_KetQua</a></span>";
    }
    
    function outLineGetClub_LichThiDau(){
        echo "<h1>Function: getClub_LichThiDau</h1>";
        echo "<i>Lấy thông tin lịch thi đấu câu lạc bộ </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getClub_LichThiDau</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>club_id: id của câu lạc bộ<br/>page: số trang"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getClub_LichThiDau&app_client_id=1&club_id=110&page=1&token=".$this->token."' target='_blank'>getClub_LichThiDau</a></span>";
    }
    
     function outLineGetClub_CauThu(){
        echo "<h1>Function: getClub_CauThu</h1>";
        echo "<i>Lấy danh sách các cầu thủ của câu lạc bộ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getClub_CauThu</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>club_id: id của câu lạc bộ"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getClub_CauThu&app_client_id=1&club_id=33&token=".$this->token."' target='_blank'>getClub_CauThu</a></span>";
    }
    
    function outLineGetCauThu_ChiTiet(){
        echo "<h1>Function: getCauThu_ChiTiet</h1>";
        echo "<i>Lấy thông tin cầu thủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCauThu_ChiTiet</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Kết quả: </LI>";
        echo "<LI>Tham số:<br/>footballer_id: id của cầu thủ"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getCauThu_ChiTiet&app_client_id=1&footballer_id=117&token=".$this->token."' target='_blank'>getCauThu_ChiTiet</a></span>";
    }
    
    function outLineGetTranDau_TuongThuat(){
        echo "<h1>Function: getTranDau_TuongThuat</h1>";
        echo "<i>Lấy thông tin tường thuật trận đấu</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_TuongThuat</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>match_id: id của trận đấu"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getTranDau_TuongThuat&app_client_id=1&match_id=210370&token=".$this->token."' target='_blank'>getTranDau_TuongThuat</a></span>";
    }
    
    function outLineGetTranDau_ChiTiet(){
        echo "<h1>Function: getTranDau_ChiTiet</h1>";
        echo "<i>Lấy thông tin trận đấu chi tiết</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_ChiTiet</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>match_id: id của trận đấu"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getTranDau_ChiTiet&app_client_id=1&match_id=66180&token=".$this->token."' target='_blank'>getTranDau_ChiTiet</a></span>";
    }
    
    function outLineGetTranDau_PhongDoLichSu(){
        echo "<h1>Function: getTranDau_PhongDoLichSu</h1>";
        echo "<i>Lấy thông tin phong độ và lịch sử thi đấu</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_PhongDoLichSu</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>match_id: id của trận đấu"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getTranDau_PhongDoLichSu&app_client_id=1&match_id=210370&token=".$this->token."' target='_blank'>getTranDau_PhongDoLichSu</a></span>";
    }
    
    function outLineGetListNewsByClub(){
        echo "<h1>Function: getListNewsByClub</h1>";
        echo "<i>Lấy danh sách tin tức theo câu lạc bộ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getListNewsByClub</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>club_id: id của câu lạc bộ"; 
        echo "<br/>page: số trang"; 
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getListNewsByClub&club_id=33&token=".$this->token."' target='_blank'>getListNewsByClub</a></span>";
    }
    
     function outLineGetListNewsByCup(){
        echo "<h1>Function: getListNewsByCup</h1>";
        echo "<i>Lấy danh sách tin tức theo giải đấu</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getListNewsByCup</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>cup_id: id của giải đấu"; 
        echo "<br/>page: số trang"; 
     
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getListNewsByCup&app_client_id=1&cup_id=1&token=".$this->token."' target='_blank'>getListNewsByCup</a></span>";
    }
    
    function outLineGetNewsDetail(){
        echo "<h1>Function: getNewsDetail</h1>";
        echo "<i>Lấy tin tức chi tiết</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getNewsDetail</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>news_id: id của tin tức"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getNewsDetail&app_client_id=1&news_id=6&token=".$this->token."' target='_blank'>getNewsDetail</a></span>";
    }
    
    
    function outLineGetListVideoByClub(){
        echo "<h1>Function: getListVideoByClub</h1>";
        echo "<i>Lấy danh sách video theo câu lạc bộ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getListVideoByClub</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>club_id: id của câu lạc bộ"; 
        echo "<br/>page: số trang"; 
        
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getListVideoByClub&club_id=21&token=".$this->token."' target='_blank'>getListVideoByClub</a></span>";
    }
    
     function outLineGetListVideoByCup(){
        echo "<h1>Function: getListVideoByCup</h1>";
        echo "<i>Lấy danh sách video theo giải đấu</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getListVideoByCup</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>cup_id: id của giải đấu"; 
        echo "<br/>page: số trang"; 
     
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getListVideoByCup&app_client_id=1&cup_id=1&token=".$this->token."' target='_blank'>getListVideoByCup</a></span>";
    }
    
    function outLineGetVideoDetail(){
        echo "<h1>Function: getVideoDetail</h1>";
        echo "<i>Lấy tin tức chi tiết</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getVideoDetail</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/>video_id: id của video"; 
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$this->url_api."?action=getVideoDetail&app_client_id=1&video_id=1&token=".$this->token."' target='_blank'>getNewsDetail</a></span>";
    }
    
     function outLineGetAppHeaderBongDa(){
        echo "<h1>Function: getAppHeaderBongDa</h1>";
        echo "<i>Lấy app header của ứng dụng</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getAppHeaderBongDa</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số: app_header: Mã app header;<br/> app_client_id: id app clien, lần đầu vào app là 0, sau lây app_client_id API trả về;<br/> os_version: version hệ điều hành;<br/>imei: số imei máy client</LI>";
        echo "<LI>Kết quả: Lấy app header của ứng dụng</LI>";
        echo "</UL>";
        echo "<span>Ví dụ IOS: <a href='".$url_api."?action=getAppHeaderBongDa&app_header=FB-MARKET-IOS&app_client_id=1&os_version=3&imei=1&token=".$this->token."' target='_blank'>getAppHeaderBongDa</a></span>";
        echo "<span>Ví dụ APK: <a href='".$url_api."?action=getAppHeaderBongDa&app_header=FB-MARKET-APK&app_client_id=1&os_version=2&imei=1&token=".$this->token."' target='_blank'>getAppHeaderBongDa</a></span>";
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
         echo "<span>Ví dụ: <a href='".$url_api."?action=registerMember&app_client_id=1&token=".$this->token."' target='_blank'>registerMember</a></span>";
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
         echo "<span>Ví dụ: <a href='".$url_api."?action=uploadAvatar&app_client_id=1&token=".$this->token."' target='_blank'>uploadAvatar</a></span>";
    }
    
    
    function outLineGetCommentByMatch(){
        echo "<h1>Function: getCommentByMatch</h1>";
        echo "<i>Lấy danh sách comment by match_id </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCommentByMatch</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> match_id: ID trận đấu;<br/> 
        </LI>";
        echo "<LI>Kết quả: Danh sách comment<br/> </LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=getCommentByMatch&match_id=609&app_client_id=1&token=".$this->token."' target='_blank'>getCommentByMatch</a></span>";
    }
    
     function outLineCheckHadVoteMatch(){
        echo "<h1>Function: checkHadVoteMatch</h1>";
        echo "<i>Kiêm tra xem đã vote trận đấu hay chưa </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: checkHadVoteMatch</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> match_id: ID trận đấu;<br/> user_id: ID của thành viên;<br/> 
        </LI>";
        echo "<LI>Kết quả: 0: chưa tham gia vote, >0 đã vote trận đấu<br/> </LI>";
        echo "</UL>";
         echo "<span>Ví dụ: <a href='".$url_api."?action=checkHadVoteMatch&match_id=211733&user_id=1&app_client_id=1&token=".$this->token."' target='_blank'>checkHadVoteMatch</a></span>";
    }
    
    
    function outLinePostCommentMatch(){
        echo "<h1>Function: postCommentMatch</h1>";
        echo "<i>Comment 1 trận đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postCommentMatch</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>Tham số:<br/> 
        user_id: ID user;<br/> 
        match_id: ID trận đấu;<br/> 
        comment: Nội dung comment;<br/> 
        create_user: Tên người gửi comment;<br/> 
        </LI>";
        echo "<LI>Kết quả: : 0: thành công, 1: thiếu tham số, 2: Lỗi insert. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=postCommentMatch&app_client_id=1&token=".$this->token."' target='_blank'>postCommentMatch</a></span>";
    }
    
     function outLinePostMatchVote(){
        echo "<h1>Function: postMatchVote</h1>";
        echo "<i>Comment 1 trận đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postMatchVote</LI>";
        echo "<LI>method: post</LI>";
        echo "<LI>Tham số:<br/> 
        user_id: ID user;<br/> 
        match_id: ID trận đấu;<br/> 
        vote: 0: hòa, club_id_1: nếu câu lạc bộ 1 thắng, club_id_2: nếu câu lạc bộ 2 thắng;<br/> 
        </LI>";
        echo "<LI>Kết quả: : 0: thành công, 1: thiếu tham số, 3: Lỗi insert. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=postMatchVote&match_id=211733&user_id=1&vote=0&app_client_id=1&token=".$this->token."' target='_blank'>postMatchVote</a></span>";
    }
    
    function outLineGetCup_LichThiDau(){
        echo "<h1>Function: getCup_LichThiDau</h1>";
        echo "<i>Lấy lịch thi đâu của giải đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCup_LichThiDau</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        cup_id: ID của giải đấu;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: : Danh sách trận đấu. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getCup_LichThiDau&cup_id=1&app_client_id=1&token=".$this->token."' target='_blank'>getCup_LichThiDau</a></span>";
    }
    
     function outLinGetCup_KetQua(){
        echo "<h1>Function: getCup_KetQua</h1>";
        echo "<i>Lấy kết quả của giải đấu </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCup_KetQua</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        cup_id: ID của giải đấu;<br/> 
        page: số page;<br/> 
        </LI>";
        echo "<LI>Kết quả: : Danh sách trận đấu. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getCup_KetQua&cup_id=1&page=1&app_client_id=1&token=".$this->token."' target='_blank'>getCup_KetQua</a></span>";
    }
    
    function outLineGetCupFavortie(){
        echo "<h1>Function: getCupFavortie</h1>";
        echo "<i>Lấy danh sách giải đấu yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCupFavortie</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        app_client_id: ID của app client;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: : Danh sách trận đấu. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getCupFavortie&app_client_id=1&token=".$this->token."' target='_blank'>getCupFavortie</a></span>";
    }
    
    function outLineGetClubFavortie(){
        echo "<h1>Function: getClubFavortie</h1>";
        echo "<i>Lấy danh sách câu lạc bộ yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getClubFavortie</LI>";
        echo "<LI>method: get</LI>";
        echo "<LI>Tham số:<br/> 
        app_client_id: ID của app client;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: : Danh sách trận đấu. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getClubFavortie&app_client_id=1&token=".$this->token."' target='_blank'>getClubFavortie</a></span>";
    }
    
    function outLinePostClubFavorite(){
        echo "<h1>Function: postClubFavorite</h1>";
        echo "<i>Post câu lạc bộ yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postClubFavorite</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        
        club_id: ID của club;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: 0: Thanh công, 1: thieu tham so,2: khong thanh cong. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=postClubFavorite&app_client_id=1&club_id=33&token=".$this->token."' target='_blank'>postClubFavorite</a></span>";
    }
    
    function outLineRemoveClubFavorite(){
        echo "<h1>Function: removeClubFavorite</h1>";
        echo "<i>Loại bỏ câu lạc bộ yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: removeClubFavorite</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        
        club_id: ID của club;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: 0: Thanh công, 1: thieu tham so,2: khong thanh cong. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=removeClubFavorite&app_client_id=1&club_id=33&token=".$this->token."' target='_blank'>removeClubFavorite</a></span>";
    }
      
    function outLinePostCupFavorite(){
        echo "<h1>Function: postCupFavorite</h1>";
        echo "<i>Post giải đấu yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postCupFavorite</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
      
        cup_id: ID của club;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: 0: Thanh công, 1: thieu tham so,2: khong thanh cong. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=postCupFavorite&app_client_id=1&cup_id=1&token=".$this->token."' target='_blank'>postCupFavorite</a></span>";
    }
    
    function outLinePostMatchFavorite(){
        echo "<h1>Function: postMatchFavorite</h1>";
        echo "<i>Post trận đấu yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: postMatchFavorite</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        match_id: ID của trận đấu;<br/> 
        </LI>";
        echo "<LI>Kết quả: 0: Thành công, 1: thieu tham so,2: khong thanh cong. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=postMatchFavorite&app_client_id=1&match_id=1&token=".$this->token."' target='_blank'>postMatchFavorite</a></span>";
    }
    
    function outLineRemoveMatchFavorite(){
        echo "<h1>Function: removeMatchFavorite</h1>";
        echo "<i>Loại bỏ trận đấu yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: removeMatchFavorite</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
       
        match_id: ID của trận đấu;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: 0: Thanh công, 1: thieu tham so,2: khong thanh cong. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=removeMatchFavorite&app_client_id=1&match_id=1&token=".$this->token."' target='_blank'>removeMatchFavorite</a></span>";
    }
    
    function outLineRemoveCupFavorite(){
        echo "<h1>Function: removeCupFavorite</h1>";
        echo "<i>Loại bỏ giải đấu yêu thích </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: removeCupFavorite</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
       
        cup_id: ID của cup;<br/> 
     
        </LI>";
        echo "<LI>Kết quả: 0: Thanh công, 1: thieu tham so,2: khong thanh cong. <br/>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=removeCupFavorite&app_client_id=1&cup_id=1&token=".$this->token."' target='_blank'>removeCupFavorite</a></span>";
    }
             
    
     function outLineRegistryNotice(){
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
        echo "<span>Ví dụ: <a href='".$url_api."?action=registryNotice&device_token=update12131&os_type=2&user_id=1&app_client_id=1&token=".$this->token."' target='_blank'>registryNotice</a></span>";
    }
        
    function outLineTaoFileCountryClub(){
        echo "<h1>Function: taoFileCountryClub</h1>";
        echo "<i>Tạo file Json Phân club by country anphabet</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: taoFileCountryClub</LI>";
        echo "<LI>Kết quả: File Json</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=taoFileCountryClub&app_client_id=1&token=".$this->token."' target='_blank'>taoFileCountryClub</a></span>";
    }
               
    function outLineTaoFileJSonClub(){
        echo "<h1>Function: taoFileJSonClub</h1>";
        echo "<i>Tạo file Json  danh sách club</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: taoFileJSonClub</LI>";
        echo "<LI>Kết quả: File Json</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=taoFileJSonClub&app_client_id=1&token=".$this->token."' target='_blank'>taoFileJSonClub</a></span>";
    }
    
    function outLineTaoFileCup(){
        echo "<h1>Function: taoFileJSonCup</h1>";
        echo "<i>Tạo file Json  danh sách cup</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: taoFileJSonCup</LI>";
        echo "<LI>Kết quả: File Json</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=taoFileJSonCup&app_client_id=1&token=".$this->token."' target='_blank'>taoFileJSonCup</a></span>";
    }
                        
    function outLineTaoFileCountryCup(){
        echo "<h1>Function: taoFileCountryCup</h1>";
        echo "<i>Tạo file Json  danh sách cup theo country</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: taoFileCountryCup</LI>";
        echo "<LI>Kết quả: File Json</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=taoFileCountryCup&app_client_id=1&token=".$this->token."' target='_blank'>taoFileCountryCup</a></span>";
    }
    
    function outLineGetKetQuaTranDau_GiaiDauYeuThich(){
        echo "<h1>Function: getKetQuaTranDau_GiaiDauYeuThich</h1>";
        echo "<i>Danh sach trận đấu theo giải đấu yêu thích</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getKetQuaTranDau_GiaiDauYeuThich</LI>";
        echo "<LI>method: GET</LI>";
        echo "<LI>Tham số:<br/> 
        match_date: Ngày đấu theo định dạng d-m-Y;<br/> 
        app_client_id: ID của appclient;<br/> 
        </LI>";
        echo "<LI>Kết quả: danh sách trận đấu</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getKetQuaTranDau_GiaiDauYeuThich&match_date=16-08-2015&app_client_id=1&token=".$this->token."' target='_blank'>getKetQuaTranDau_GiaiDauYeuThich</a></span>";
    }
    
     function outLineGetKetQuaTranDau_DoiBongYeuThich(){
        echo "<h1>Function: getKetQuaTranDau_DoiBongYeuThich</h1>";
        echo "<i>Danh sach trận đấu theo giải đấu yêu thích</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getKetQuaTranDau_DoiBongYeuThich</LI>";
        echo "<LI>method: GET</LI>";
        echo "<LI>Tham số:<br/> 
        match_date: Ngày đấu theo định dạng d-m-Y;<br/> 
        app_client_id: ID của appclient;<br/> 
        </LI>";
        echo "<LI>Kết quả: danh sách trận đấu</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getKetQuaTranDau_DoiBongYeuThich&match_date=16-08-2015&app_client_id=1&token=".$this->token."' target='_blank'>getKetQuaTranDau_DoiBongYeuThich</a></span>";
    }
    
    function outLineGetKetQuaTranDau_YeuThich(){
        echo "<h1>Function: getKetQuaTranDau_YeuThich</h1>";
        echo "<i>Danh sach trận đấu yêu thích</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getKetQuaTranDau_YeuThich</LI>";
        echo "<LI>method: GET</LI>";
        echo "<LI>Tham số:<br/> 
        match_date: Ngày đấu theo định dạng d-m-Y;<br/> 
        app_client_id: ID của appclient;<br/> 
        </LI>";
        echo "<LI>Kết quả: danh sách trận đấu</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getKetQuaTranDau_YeuThich&match_date=".date("d-m-Y")."&app_client_id=1&token=".$this->token."' target='_blank'>getKetQuaTranDau_YeuThich</a></span>";
    } 
                
    function outLineGetTranDau_TuongThuatChiTiet(){
        echo "<h1>Function: getTranDau_TuongThuatChiTiet</h1>";
        echo "<i>Danh sách tường thuật chi tiết trận đấu</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getTranDau_TuongThuatChiTiet</LI>";
        echo "<LI>method: GET</LI>";
        echo "<LI>Tham số:<br/> 
        match_id: id trận đấu;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getTranDau_TuongThuatChiTiet&match_id=214644&app_client_id=1&token=".$this->token."' target='_blank'>getTranDau_TuongThuatChiTiet</a></span>";
    }
    
     function outLineSearchClub(){
        echo "<h1>Function: searchClub</h1>";
        echo "<i>Tìm kiếm club</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchClub</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchClub&keyword=Malaga&app_client_id=1&token=".$this->token."' target='_blank'>searchClub</a></span>";
    }
    
    function outLineSearchCup(){
        echo "<h1>Function: searchCup</h1>";
        echo "<i>Tìm kiếm cup</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchCup</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchCup&keyword=VĐQG PHÁP&app_client_id=1&token=".$this->token."' target='_blank'>searchCup</a></span>";
    }
    
    function outLineSearchCoach(){
        echo "<h1>Function: searchCoach</h1>";
        echo "<i>Tìm kiếm huấn luyện viên</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchCoach</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchCoach&keyword=Arsene Wenger&app_client_id=1&token=".$this->token."' target='_blank'>searchCoach</a></span>";
    }
    
    function outLineSearchFootballer(){
        echo "<h1>Function: searchFootballer</h1>";
        echo "<i>Tìm kiếm huấn cầu thủ</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchFootballer</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchFootballer&keyword=Mame Biram Diouf&app_client_id=1&token=".$this->token."' target='_blank'>searchFootballer</a></span>";
    }
    
    function outLineSearchNews(){
        echo "<h1>Function: searchNews</h1>";
        echo "<i>Tìm kiếm TIN TỨC</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchNews</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchNews&keyword=HLV Graechen&app_client_id=1&token=".$this->token."' target='_blank'>searchNews</a></span>";
    }
                
     function outLineSearchVideo(){
        echo "<h1>Function: searchVideo</h1>";
        echo "<i>Tìm kiếm Video</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: searchVideo</LI>";
        echo "<LI>method: POST</LI>";
        echo "<LI>Tham số:<br/> 
        keyword: từ khóa tìm kiếm;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=searchVideo&keyword=MU&app_client_id=1&token=".$this->token."' target='_blank'>searchVideo</a></span>";
    }
    
     function outLineGetCoachDetail(){
        echo "<h1>Function: getCoachDetail</h1>";
        echo "<i>Lấy thông tin huấn luyện viên</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: getCoachDetail</LI>";
        echo "<LI>method: GET</LI>";
        echo "<LI>Tham số:<br/> 
        coach_id: id của huấn luyện viên;<br/> 
        </LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".$url_api."?action=getCoachDetail&coach_id=1&app_client_id=1&token=".$this->token."' target='_blank'>getCoachDetail</a></span>";
    }
    
    
   
}
?>
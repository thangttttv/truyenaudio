<?php
 header('Content-type: text/html; charset=utf-8');       
  //  require_once("XoSoDAO.php");
 //   require_once("../function/utils.php");
    date_default_timezone_set('Asia/Saigon');   
class XoSoDOC
{
    private $functionName;

    function __construct($functionName)
    {
       $this->functionName = $functionName;
       
    }
    function outLine(){
         switch ($this->functionName){
             case "registerMember":{
                $this->registerMember();
                break;
             }
             case "postComment":
             {
                     $this->postComment();
                     break;
             }
             case "getTTKQXS": {
                     $this->getTTKQXS();
                     break;
             }
            case "getKTXS":{
                 $this->getKTXS();
                 break;
            }
             case "getKTXSByRegion":{
                     $this->getKTXSByRegion();
                     break;
             }
            case "getKTXSRegionNewest":{
                    $this->getKTXSRegionNewest();
                    break;
            } 
            case "getDream":{
                    $this->getDream();
                    break;
                }
             case "getTKDauSo":{
                     $this->getTKDauSo();
                     break;
             }
             case "getTKDuoiSo":{
                     $this->getTKDuoiSo();
                     break;
             }
             case "getTKBoKep":{
                     $this->getTKBoKep();
                     break;
             }
             case "getTKTongChan":{
                     $this->getTKTongChan();
                     break;
             }
             case "getTKTongLe":{
                     $this->getTKTongLe();
                     break;
             }
             case "getTKBoChanLe":{
                     $this->getTKBoChanLe();
                     break;
             }
             case "getTKBoLeChan":{
                     $this->getTKBoLeChan();
                     break;
             }
             case "getTKBoChanChan":{
                     $this->getTKBoChanChan();
                     break;
             }
             case "getTKBoLeLe":{
                     $this->getTKBoLeLe();
                     break;
             }
             // acc vip
             case "getTKLotoGanCucDai":{
                     $this->getTKLotoGanCucDai();
                     break;
             }
             case "getTKLotoDenKySoVoiKyGanNhat":{
                     $this->getTKLotoDenKySoVoiKyGanNhat();
                     break;
             }
             case "getTKLotoDenKySoVoiKyCucDai":{
                     $this->getTKLotoDenKySoVoiKyCucDai();
                     break;
             }
             case "getTKChuKyLoTo":{
                     $this->getTKChuKyLoTo();
                     break;
             }
             case "getTK12BoSoRaNhieu":{
                     $this->getTK12BoSoRaNhieu();
                     break;
             }
             case "getTK12BoSoRaIt":{
                     $this->getTK12BoSoRaIt();
                     break;
             }
             case "getTKBoSoRaLienTiep":{
                     $this->getTKBoSoRaLienTiep();
                     break;
             }
             case "getTKDauSoMoThuong":{
                     $this->getTKDauSoMoThuong();
                     break;
             }
             case "getTKDuoiSoMoThuong":{
                     $this->getTKDuoiSoMoThuong();
                     break;
             }
             case "getTKDauSoMoThuong":{
                     $this->getTKDauSoMoThuong();
                     break;
             }
             case "getTKBoSoMBGanTren10Ngay":{
                     $this->getTKBoSoMBGanTren10Ngay();
                     break;
             }
             case "getTKGiaiDacBietTheoNgay":{
                     $this->getTKGiaiDacBietTheoNgay();
                     break;
             }
             //API App Header & User
             case "getAppHeaderXoSo":{
                     $this->getAppHeaderXoSo();
                     break;
             }case "getUserXoSo":{
                     $this->getUserXoSo();
                     break;
             }
             case "getTaiKhoanChinh":{
                     $this->getTaiKhoanChinh();
                     break;
             }
             case "updateUser":{
                     $this->updateUser();
                     break;
             }case "getUserXoSo":{
                     $this->getUserXoSo();
                     break;
             }
             case "createPasswordWeb":{
                     $this->createPasswordWeb();
                     break;
             }
             case "uploadAvatar":{
                     $this->uploadAvatar();
                     break;
             }
             case "postChat":{
                     $this->postChat();
                     break;
             }
             //API Chat box
             case "getChatBox":{
                     $this->getChatBox();
                     break;
             }
              case "getChatBoxFromID":{
                     $this->getChatBoxFromID();
                     break;
             }
              case "registryNoticeIOS":{
                     $this->registryNoticeIOS();
                     break;
             }
              case "getNoticeAdroid":{
                     $this->getNoticeAdroid();
                     break;
             }
             case "registryNotice":{
                     $this->registryNotice();
                     break;
             }
             
         }
    }
    function getTTKQXS()
    {
            echo '<header><meta content="text/html; charset=utf-8" http-equiv="Content-Type"></header>';
            echo "<h1>Danh sách Function:</h1>";
            echo "<h2 style='color:red'>getTTKQXS:</h2>";
            echo "<em>Tường thuật trực tiếp kết quả các giải miền bắc miền trung, miền nam.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTTKQXS</li>";  
            echo "<li>region: Mien 1: mien bac, 2 miền trung, 3 miền nam</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTTKQXS&region=1' target='_blank'>Tường thuật miền Bắc</a></span>" ;
    }
    function getKTXS()
    {
            echo "<h1>API Kết Quả</h1>";  
            echo "<h2 style='color:red'>getKTXS:</h2>";
            echo "<em>Lấy kết quả xổ số các miền va tinh.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTTKQXS</li>";  
            echo "<li>region: Mien 1: mien bac, 2 miền trung, 3 miền nam</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>date: Ngày mở giải</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."/ttv_api/xoso/XoSoAPI.php?action=getKTXS&region=1&provinceId=1&date=02/01/2014' target='_blank'>Kết quả XS Miền Bắc</a></span>" ;
    }
    function getKTXSByRegion()
    {
            echo "<h2 style='color:red'>getKTXSByRegion:</h2>";
            echo "<em>Lấy kết quả xổ số các miền.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getKTXSByRegion</li>";  
            echo "<li>region: Mien 1: mien bac, 2 miền trung, 3 miền nam</li>";  
            echo "<li>fDate: Ngày mở giải tu</li>";  
            echo "<li>tDate: Ngày mở giải den</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getKTXSByRegion&region=3&fDate=18/03/2014&tDate=20/03/2014' target='_blank'>Kết quả XS Miền Nam trong 3 ngay</a></span>" ;
            
    }
    function getKTXSRegionNewest(){
        echo "<h2 style='color:red'>getKTXSRegionNewest:</h2>";
            echo "<em>Lấy kết quả xổ số mới nhất các miền.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getKTXSRegionNewest</li>";  
            echo "<li>region: Mien 1: mien bac, 2 miền trung, 3 miền nam</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getKTXSRegionNewest&region=3' target='_blank'>Lấy kết quả xổ số mới nhất các miền</a></span>" ;
    }
    function getDream(){
        echo "<h2 style='color:red'>getDream:</h2>";
            echo "<em>Lấy danh sách xổ mơ.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getDream</li>";  
            echo "<li>title: Tiêu đề của giấy mơ</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getDream&title=' target='_blank'>Xổ mơ</a></span>" ;
    }
    function  getTKDauSo()
    {
            echo "<h2 style='color:red'>getTKDauSo:</h2>";
            echo "<em>Thống kê kết quả theo đầu số.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKDauSo</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKDauSoDangBang&provinceId=1&fromDate=10/02/2014&toDate=20/02/2014' target='_blank'>Thống kê đầu số</a></span>" ;
            
    }
    function getTKDuoiSo()
    {
         echo "<h2 style='color:red'>getTKDuoiSo:121</h2>";
            echo "<em>Thống kê kết quả theo đuôi số.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKDuoiSo</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKDuoiSo&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Đuôi số</a></span>" ;
            
    }
    function getTKBoKep()
    {
            echo "<h2 style='color:red'>getTKBoKep:</h2>";
            echo "<em>Thống kê kết quả bộ kép.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoKep</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoKep&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ kép</a></span>" ;
            
    }
    function getTKTongChan()
    {
             echo "<h2 style='color:red'>getTKTongChan:</h2>";
            echo "<em>Thống kê kết quả bộ Tổng Chẵn.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKTongChan</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKTongChan&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ Sát Kép</a></span>" ;
           
    }
    function getTKTongLe()
    {
        echo "<h2 style='color:red'>getTKTongLe:</h2>";
            echo "<em>Thống kê kết quả bộ Tổng Lẻ.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKTongLe</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKTongLe&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ Tổng lẻ</a></span>" ;
           
    }
    function getTKBoChanLe()
    {
        echo "<h2 style='color:red'>getTKBoChanLe:</h2>";
            echo "<em>Thống kê kết quả bộ Chẵn Lẻ.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoChanLe</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoChanLe&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ Chẵn lẻ</a></span>" ;
           
    }
    function getTKBoLeChan()
    {
         echo "<h2 style='color:red'>getTKBoLeChan:</h2>";
            echo "<em>Thống kê kết quả bộ Lẻ Chẵn.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoLeChan</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoLeChan&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ Lẻ Chẵn</a></span>" ;
           
    }
    function  getTKBoChanChan()
    {
          echo "<h2 style='color:red'>getTKBoChanChan:</h2>";
            echo "<em>Thống kê kết quả bộ Chẵn Chẵn.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoChanChan</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoChanChan&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ Chẵn Chẵn</a></span>" ;
           
    }
    function getTKBoLeLe()
    {
         echo "<h2 style='color:red'>getTKBoLeLe:</h2>";
            echo "<em>Thống kê kết quả bộ Lẻ Lẻ.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoLeLe</li>";  
            echo "<li>provinceId: Id của Tỉnh</li>";  
            echo "<li>fromDate: Ngày bắt đầu thống kê</li>";  
            echo "<li>toDate: Ngày kết thúc thống kê</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoLeLe&provinceId=1&fromDate=10/02/2014&toDate=10/03/2014' target='_blank'>Thống kê Bộ Lẻ Lẻ</a></span>" ;
           
    }
    function getTKLotoGanCucDai()
    {
        echo "<h1>API VIP</h1>";
            echo "<h2 style='color:red'>getTKLotoGanCucDai:</h2>";
            echo "<em>TK Loto gan cuc dai.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKLotoGanCucDai</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKLotoGanCucDai' target='_blank'>TK Loto gan cuc dai</a></span>" ;
            
    }
    function getTKLotoDenKySoVoiKyGanNhat()
    {
        echo "<h2 style='color:red'>getTKLotoDenKySoVoiKyGanNhat:</h2>";
            echo "<em>TK Loto đến kì so với kì gần nhất.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKLotoDenKySoVoiKyGanNhat</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKLotoDenKySoVoiKyGanNhat' target='_blank'>TK Loto đến kì so với kì gần nhất</a></span>" ;

    }
    function getTKLotoDenKySoVoiKyCucDai()
    {
        echo "<h2 style='color:red'>getTKLotoDenKySoVoiKyCucDai:</h2>";
            echo "<em>TK Loto đến kì so với kì cực đại.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKLotoDenKySoVoiKyCucDai</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKLotoDenKySoVoiKyCucDai' target='_blank'>TK Loto đến kì so với kì cực đại</a></span>" ;

    }
    function getTKChuKyLoTo()
    {
        echo "<h2 style='color:red'>getTKChuKyLoTo:</h2>";
            echo "<em>TK Chu Kỳ Loto.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKChuKyLoTo</li>"; 
            echo "<li>boso: bộ số thống kê</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKChuKyLoTo&boso=00' target='_blank'>TK Chu kỳ loto</a></span>" ;

    }
    function getTK12BoSoRaNhieu()
    {
        echo "<h2 style='color:red'>getTK12BoSoRaNhieu:</h2>";
            echo "<em>TK 12 Boso miền bắc ra nhiều.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTK12BoSoRaNhieu</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTK12BoSoRaNhieu' target='_blank'>TK 12 bộ số miền bắc ra nhiều</a></span>" ;
        
    }
    function getTK12BoSoRaIt()
    {
            echo "<h2 style='color:red'>getTK12BoSoRaIt:</h2>";
            echo "<em>TK 12 Boso miền bắc ra ít.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTK12BoSoRaIt</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTK12BoSoRaIt' target='_blank'>TK 12 bộ số miền bắc ra it</a></span>" ;
            
    }
    function getTKBoSoRaLienTiep()
    {
         echo "<h2 style='color:red'>getTKBoSoRaLienTiep:</h2>";
            echo "<em>TK Bộ số miền bắc ra liên tiếp.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoSoRaLienTiep</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoSoRaLienTiep' target='_blank'>TK bộ số miền bắc ra liên tiếp</a></span>" ;
           
    }
    function getTKDauSoMoThuong()
    {
          echo "<h2 style='color:red'>getTKDauSoMoThuong:</h2>";
            echo "<em>TK đầu số mở thưởng miền bắc.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKDauSoMoThuong</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKDauSoMoThuong' target='_blank'>TK đầu số mở thưởng miền bắc</a></span>" ;
            
    }
    function getTKDuoiSoMoThuong()
    {
          echo "<h2 style='color:red'>getTKDuoiSoMoThuong:</h2>";
            echo "<em>TK đuôi số mở thưởng miền bắc.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKDuoiSoMoThuong</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKDuoiSoMoThuong' target='_blank'>TK đuôi số mở thưởng miền bắc</a></span>" ;
            
    }
    function getTKBoSoMBGanTren10Ngay()
    {
        echo "<h2 style='color:red'>getTKBoSoMBGanTren10Ngay:</h2>";
            echo "<em>TK bộ số gan trên 10 ngày.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKBoSoMBGanTren10Ngay</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKBoSoMBGanTren10Ngay' target='_blank'>TK bộ số gan trên 10 ngày.</a></span>" ;     
           
    }
    function getTKGiaiDacBietTheoNgay()
    {
          echo "<h2 style='color:red'>getTKGiaiDacBietTheoNgay:</h2>";
            echo "<em>TK giải đặc biệt trong ngày.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTKGiaiDacBietTheoNgay</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTKGiaiDacBietTheoNgay' target='_blank'>TK giải đặc biệt trong ngày.</a></span>" ;     
            
    }
    function  getAppHeaderXoSo()
    {
         echo "<h2 style='color:red'>getAppHeaderXoSo:</h2>";
            echo "<em>Lấy thông số cầu hình của app.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getAppHeaderXoSo</li>";
            echo "<li>app_header: App Header đc cấp cho mỗi bản build</li>";
            echo "<li>app_client_id: đặt là 0 khi lần đầu vào app, sau đó truyền app_client_id được cấp</li>"; 
            echo "<li>imei: Số imei của máy</li>"; 
            echo "<li>os_version:  version hệ điều hành của máy</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getAppHeaderXoSo&app_header=XOSO-MARKET-IOS&os_version=6.0&app_client_id=123&imei=124' target='_blank'>Lấy thông số cầu hình của app.</a></span>" ;     
            
    }
    function getUserXoSo()
    {
        echo "<h2 style='color:red'>getUserXoSo:</h2>";
            echo "<em>Lấy thông tin user.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getUserXoSo</li>";
            echo "<li>user_id: id của user</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getUserXoSo&user_id=1' target='_blank'>Lấy thông tin user.</a></span>" ;     
            
    }
    
    function getTaiKhoanChinh()
    {
         echo "<h2 style='color:red'>getTaiKhoanChinh:</h2>";
            echo "<em>Lấy thông tài khoản.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getTaiKhoanChinh</li>";
            echo "<li>user_id: id của user</li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getTaiKhoanChinh&user_id=1' target='_blank'>Lấy thông tin tài khoản.</a></span>" ; 
            
    }
    
    function updateUser()
    {
          echo "<h2 style='color:red'>updateUser:</h2>";
            echo "<em>Cập nhật họ tên khách hàng.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: updateUser</li>";
            echo "<li>user_id: id của khách hàng</li>"; 
            echo "<li>fullname: Họ và tên</li>"; 
            echo "<li>Ket qua tra ve: gồm 2 thành phần user: thông tin member và result:<br>0- Thanh cong<br>1- Thieu tham so<br>2- Cap nhat khong thanh cong<br></li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=updateUser&user_id=123&username=thangtt' target='_blank'>Cap nhat ten tai khoan.</a></span>" ; 
            
    }
    function createPasswordWeb()
    {
        echo "<h2 style='color:red'>createPasswordWeb:</h2>";
            echo "<em>Tạo mật khâu truy cập trang 10h.vn.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: createPasswordWeb</li>";
            echo "<li>app_client_id: đặt là 0 khi lần đầu vào app, sau đó truyền app_client_id được cấp</li>"; 
            echo "<li>password: mật khẩu</li>"; 
            echo "<li>ket qua tra ve: <br>0: Thanh cong<br>1: Thieu tham so<br>3: Cap nhat khong thanh cong<br></li>"; 
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=createPasswordWeb&app_client_id=123&password=thangtt' target='_blank'>Cap nhat ten tai khoan.</a></span>" ; 
            
    }
    function uploadAvatar()
    {
         echo "<h2 style='color:red'>uploadAvatar:</h2>";
            echo "<em>Cap nhat Avatar tai khoan.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: uploadAvatar</li>";
            echo "<li>user_id: id của user</li>";
            echo "<li>ket qua tra ve: <br>0: Thanh cong<br>1: Thieu tham so<br>2: File khong duoc gui<br>3: Dung luong file qua lon<br>4: Upload khong thanh cong<br>5: Loi dinh dang file<br>100: Loi khong ro nguyen nhan<br></li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=uploadAvatar&user_id=1updateUser' target='_blank'>Cap nhat ten tai khoan.</a></span>" ;  
            
    }
    
    function postChat()
    {
         echo "<h2 style='color:red'>postChat:</h2>";
            echo "<em>Post Chat.</em><br/>";
            echo "<em>Method:post.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: postChat</li>";
            echo "<li>user_id: id của member</li>";
            echo "<li>content:Noi dung</li>";
            echo "<li>deviceName:Thiet bi</li>";
            echo "<li>region:Vung mien</li>";
          
            echo "<li>result: array['result']=0: Thành công, 1 Thiếu tham số, 2 post thất bại, 3: user không tồn tại</li>";  
            echo "<li>result:0 Trả thêm count: số lượng bản tin, chat: Danh sách chat</li>";  
            
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=postChat&user_id=123' target='_blank'>Post Chat.</a></span>" ;                                
            
    }
    function getChatBox()
    {
         echo "<h2 style='color:red'>getChatBox:</h2>";
            echo "<em>Lay noi dung chat.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getChatBox</li>";  
            echo "<li>page: page lay</li>";  
            echo "<li>region: Vung mien 0: All 1: mien bac, 2: mien trung, 3 mien nam</li>";  
            echo "<li>limit: So item lay tren 1 page</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getChatBox&page=1&limit=10' target='_blank'>Noi dung chat</a></span>" ;
 
    }
    function getChatBoxFromID()
    {
        echo "<h1>API Chat box getChatBoxFromID</h1>";  
            echo "<h2 style='color:red'>getChatBoxFromID:</h2>";
            echo "<em>Lay noi dung chat tu ID nguoc lai.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getChatBoxFromID</li>";  
            echo "<li>id: Lay tu id</li>";  
            echo "<li>region: Vung mien 0: All 1: mien bac, 2: mien trung, 3 mien nam</li>";  
            echo "<li>limit: So item lay tren 1 page max 100</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getChatBoxFromID&id=1&limit=10&region=0' target='_blank'>Noi dung chat</a></span>" ;
            
    }
    function registryNoticeIOS()
    {
            echo "<h1>API đăng ký token send notice cho ios registryNoticeIOS</h1>";  
            echo "<h2 style='color:red'>registryNoticeIOS:</h2>";
            echo "<em>Đăng kí token send cho ios.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: registryNoticeIOS</li>";  
            echo "<li>app_client_id: user_id cấp cho app</li>";  
            echo "<li>device_token: token </li>";  
            echo "<li>username: ten user</li>";  
            echo "<li>ip_address: Dia chi ip cua client</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=registryNoticeIOS&app_client_id=123&device_token=123token&ip_address=123.456' target='_blank'>Đăng ký token send notice cho ios</a></span>" ;
            
    }
    function getNoticeAdroid()
    {
         echo "<h1>API get notice cho Android getNoticeAdroid</h1>";  
            echo "<h2 style='color:red'>getNoticeAdroid:</h2>";
            echo "<em>Get notice cho Android .</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: getNoticeAdroid</li>";  
            echo "<li>app_client_id: user_id cấp cho app</li>";  
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=getNoticeAdroid&app_client_id=123' target='_blank'>Get notice cho Android</a></span>" ;
            
    }
    function registerMember()
    {
        echo "<h1>Function: registerMember</h1>";
        echo "<i>Đăng kí member qua facebook hoặc google plus </i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registerMember</LI>";
        
        echo "<LI>method: POST</LI>";
        echo "<LI>app_client_id: id cua app client</LI>";
        echo "<LI>fullname: Tên hiên thị</LI>";
        echo "<LI>email: email</LI>";
        echo "<LI>mobile: so dien thoai</LI>";
        echo "<LI>sex: giới tính nam:1; nữ 0</LI>";
        echo "<LI>birthday: Ngày sinh</LI>";
        echo "<LI>sso_id: Id facebook hoac google Id</LI>";
        echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=registerMember&app_client_id=123' target='_blank'>Register Member</a></span>" ;
    }
    function postComment()
    {
        echo "<h2 style='color:red'>postComment:</h2>";
            echo "<em>Post nội dung comment.</em><br/>";
            echo "<ul>Tham Số:";
            echo "<li>action: postComment</li>"; 
            echo "<li>id_thread: id chủ đề hot</li>";  
            echo "<li>id_user: id user post </li>";  
            echo "<li>fullname: họ và tên member post</li>"; 
            echo "<li>comment: Nội dung comment</li>"; 
            echo "<li>result: array['result']=0: Thành công, 1 Thiếu tham số, 2 post thất bại</li>";  
            echo "<li>result:0 Trả thêm count: số lượng bản tin, comment: Danh sách comment</li>";                    
            echo "</ul>";
            echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=postComment&id_thread=1&id_user=1&fullname=test&comment=alo alo' target='_blank'>Post Comment chủ đề </a></span>" ;
    }
    
     function registryNotice(){
        echo "<h1>Function: registryNotice</h1>";
        echo "<i>Lấy thông tin version của appstore</i>";
        echo "<h3>Danh sách tham số:</h3>";
        echo "<UL>";
        echo "<LI>action: registryNotice</LI>";
        echo "<LI>device_token: token sinh ra từ apple google</LI>";
        echo "<LI>os_type: Loai he dieu hanh </LI>";
        echo "<LI>user_id: Id của user </LI>";
        echo "<LI>Kết quả: 0: thành công, 1 : thiếu tham số, 2 : có lỗi insert</LI>";
        echo "</UL>";
        echo "<span>Ví dụ: <a href='".baseUrl()."ttv_api/xoso/XoSoAPI.php?action=registryNotice&app_client_id=123&device_token=123ffdf&os_type=2&user_id=1' target='_blank'>registryNotice</a></span>";
    }
}
?>

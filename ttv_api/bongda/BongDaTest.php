<?php
   $fileName = dirname(__FILE__).'/mobile.txt';        
$file = fopen($fileName,"r");
// read first line

// move back to beginning of file
fseek($file,400);
echo fgets($file);  
$strjson = '[{"footballer":"Sagna","icon":"http://www.kenhkiemtien.com/upload/bongda/icon/out.png"},{"footballer":"Matuidi","icon":"http://www.kenhkiemtien.com/upload/bongda/icon/out.png"},{"footballer":"Debuchy","icon":"http://www.kenhkiemtien.com/upload/bongda/icon/in.png"},{"footballer":"Kondogbia","icon":"http://www.kenhkiemtien.com/upload/bongda/icon/in.png"}]';
$arrJson = json_decode($strjson);
var_dump($arrJson);
foreach($arrJson as $event){
    echo $event->footballer;
     echo $event->icon;
     echo "<br/>";
}
$arrBannerID = array();
$arrBannerID["b_footer"] ="ca-app-pub-1646591459636546/7840910511";
$arrBannerID["b_inapp"] ="ca-app-pub-1646591459636546/3271110112";
$arrBannerID["tg_video"] ="ca-app-pub-1646591459636546/1654776110";
$arrBannerID["tg_30s"] ="ca-app-pub-1646591459636546/7282507311";
echo json_encode($arrBannerID)."<br>";

$arrBannerID = array();
$arrBannerID["b_footer"] ="ca-app-pub-1646591459636546/4468641713";
$arrBannerID["b_inapp"] ="ca-app-pub-1646591459636546/5945374910";
$arrBannerID["tg_video"] ="ca-app-pub-1646591459636546/2852307717";
$arrBannerID["tg_30s"] ="ca-app-pub-1646591459636546/5805774111";

echo json_encode($arrBannerID)."<br>";

?>

<form name="smsTest" action="http://kenhkiemtien.com/kkt_api/bongda/BongDaService.php" method="get">
    <table>
        <tr>
            <td>ID</td><td><input type="text" value="1" name="id"></td>
        </tr>
        <tr>
            <td>Phone</td><td><input type="text" value="0974838181" name="phone"></td>
        </tr>
        <tr>
            <td>Shortcode</td><td><input type="text" value="8085" name="shortcode"></td>
        </tr>
        <tr>
            <td>SMS</td><td><input type="text" value="BD AN" name="sms"></td>
        </tr>
        <tr>
            <td>Checksum</td><td><input type="text" value="1" name="checksum"></td>
        </tr>
        <tr>
            <td></td><td><input type="text" value="0" name="mahoa"></td>
        </tr>
        <tr>
            <td></td><td><input type="submit" value="Test" /></td>
        </tr>
    </table>
</form>

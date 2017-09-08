<?php
// usual header used on my all pages
ob_start("ob_gzhandler");
$PHP_SELF=$_SERVER['PHP_SELF'];
include "include/errors.php"; //error log script

// actual script begins here
$type=false;
function open_image ($file) {
    //detect type and process accordinally
    global $type;
    $size=getimagesize($file);
    switch($size["mime"]){
        case "image/jpeg":
            $im = imagecreatefromjpeg($file); //jpeg file
        break;
        case "image/gif":
            $im = imagecreatefromgif($file); //gif file
      break;
      case "image/png":
          $im = imagecreatefrompng($file); //png file
      break;
    default: 
        $im=false;
    break;
    }
    return $im;
}

$user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"";
$folderId = $user_id%1000;
$uploaddir = '/upload/gamestore/avatar/'.$folderId."/".$user_id.".png";
$url = "http://kenhkiemtien.com".$uploaddir;
if(!file_exists("../".$uploaddir)) $url="http://kenhkiemtien.com/upload/gamestore/avatar/avatar_d.png";

if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($url))) {
  // send the last mod time of the file back
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($url)).' GMT', true, 304); //is it cached?
} else {

$image = open_image($url);

if ($image === false) { die ('Unable to open image'); }

$w = imagesx($image);
$h = imagesy($image);

//calculate new image dimensions (preserve aspect)
if(isset($_GET['w']) && !isset($_GET['h'])){
    $new_w=$_GET['w'];
    $new_h=$new_w * ($h/$w);
} elseif (isset($_GET['h']) && !isset($_GET['w'])) {
    $new_h=$_GET['h'];
    $new_w=$new_h * ($w/$h);
} else {
    $new_w=isset($_GET['w'])?$_GET['w']:150;
    $new_h=isset($_GET['h'])?$_GET['h']:150;
    if(($w/$h) > ($new_w/$new_h)){
        $new_h=$new_w*($h/$w);
    } else {
        $new_w=$new_h*($w/$h);    
    }
} 
//echo $new_w, $new_h;
$im2 = ImageCreateTrueColor($new_w, $new_h);
imagecopyResampled ($im2, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
//effects
if(isset($_GET['blur'])){
    $lv=$_GET['blur'];
    for($i=0; $i<$lv;$i++){
        $matrix=array(array(1,1,1),array(1,1,1),array(1,1,1));
        $divisor = 9;
        $offset = 0;
        imageconvolution($im2, $matrix, $divisor, $offset); 
    } 
}
if(isset($_GET['sharpen'])){
    $lv=$_GET['sharpen'];
    for($i=0; $i<$lv;$i++){
        $matrix = array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1));
        $divisor = 8;
        $offset = 0;
        imageconvolution($im2, $matrix, $divisor, $offset);
    } 
}

header('Content-type: image/jpeg');
$name=explode(".", basename($url));
header("Content-Disposition: inline; filename=".$name[0]."_t.jpg");
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($url)) . ' GMT');
header("Cache-Control: public");
header("Pragma: public");
imagejpeg($im2);
imagedestroy($im2); 
imagedestroy($image);
}   

?>
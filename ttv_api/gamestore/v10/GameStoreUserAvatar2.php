<?php
$user_id =   isset($_GET['user_id'])?$_GET['user_id'] :"";
$folderId = $user_id%1000;
$uploaddir = '/upload/gamestore/avatar/'.$folderId."/".$user_id.".png";
$url = "http://kenhkiemtien.com".$uploaddir;
if(!file_exists("../".$uploaddir)) $url="http://kenhkiemtien.com/upload/gamestore/avatar/avatar_d.png";

if(false !== ($data = file_get_contents($url))){
  header('Content-type: image/jpeg');
  echo $data;
}
$data = null;
?>
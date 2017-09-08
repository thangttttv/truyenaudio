<html>
<head>
<title>File Upload Form</title>
</head>
<body>
<?php 
     function cleanFileName($string) {        
           
          //  $string = preg_replace("/(^|&\S+;)|(<[^>]*>)/U", "", $string);
          //  $string = trim(preg_replace('/[^\w\s\(.)\-]/', '', $string));        
          //  $string = strtolower(preg_replace('/[\s\-]+/', '_', $string));    
          //  $string = preg_replace("/[^A-Za-z0-9\(.)\_]/", "", $string);     
           // $string = str_replace("small","s_mall",$string);
          //  $string = str_replace("medium","m_deium",$string);   
            
            $string = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $string);
            return $string;
        }
        
        echo cleanFileName("sohagame-2-0-5_1421399306 f  &  _117.apk")."<br/>";
        $domain = "http://truyenaudio.mobi/";
        
        echo $_SERVER['DOCUMENT_ROOT']."<br>";
        echo $_SERVER['SERVER_NAME']."<br/>";
        echo $_SERVER['HTTP_HOST']."<br/>";
?>
Upload File.<br>
<form action="<?php echo $domain?>/ttv_api/xoso/XoSoAPI.php?action=uploadAvatar&user_id=11554" method="post" enctype="multipart/form-data" ><br>
Type (or select) Filename: <input type="file" name="upfile">
<input type="submit" value="Upload File">
<input type="hidden" name="user_id" value="11554"/>
</form>

<br>
Add User<br>
<form action="<?php echo $domain?>/kkt_api/xoso/XoSoAPI.php?action=registerMember&app_client_id=123" method="post" ><br>
FullName: <input type="text" name="fullname" value="thangtt"/> <br>
email: <input type="text" name="email" value="thang24011983@gmail.com"/> <br>
sex: <input type="text" name="sex" value="1" /> <br>
birthday: <input type="text" name="birthday" value="1983/11/11" /> <br>
sso_id: <input type="text" name="sso_id" value="1"/> <br>
mobile: <input type="text" name="mobile" value="0974838181"/> <br>
<input type="submit" value="Save">
</form>

<br>
Post Comment<br>
<form action="<?php echo $domain?>/kkt_api/xoso/XoSoAPI.php?action=postComment&app_client_id=123" method="post" ><br>
id_thread: <input type="text" name="id_thread" value="1"/> <br>
id_user: <input type="text" name="id_user" value="1"/> <br>
username: <input type="text" name="fullname" value="laoconga7" /> <br>
comment: <input type="text" name="comment" value="hom nay danh con gi" /> <br>
<input type="submit" value="Save">
</form>

Update User<br>
<form action="<?php echo $domain?>/kkt_api/xoso/XoSoAPI.php?action=updateUser" method="post" ><br>
user_id: <input type="text" name="user_id" value="1"/> <br>
fullname: <input type="text" name="fullname" value="thangtt"/> <br>
<input type="submit" value="Save">
</form>

Post Chat<br>
<form action="<?php echo $domain?>/kkt_api/xoso/XoSoAPI.php?action=postChat" method="post" ><br>
region: <input type="text" name="region" value="0"/> <br>
user_id: <input type="text" name="user_id" value="1"/> <br>
content: <input type="text" name="content" value="hom nay danh con gi" /> <br>
deviceName: <input type="text" name="deviceName" value="IOS" /> <br>
<input type="submit" value="Save">
</form>

<?php
//echo dirname(__FILE__)."./upload/gamestore/game/2015/0209/MotaHoy.txt";
//echo $_SERVER['DOCUMENT_ROOT'];
 $str = 'http://kenhkiemtien.com/upload/gamestore/game/2015/0323/DotaTruyenKy.vng1.10.3.ipa';
$str = preg_replace('/^h(.*).com/i',"", $str);
// This will be 'foo o' now
echo $str;


  $file =$_SERVER['DOCUMENT_ROOT']."/upload/gamestore/game/2015/0209/MotaHoy.txt";
    
    if (!unlink($file))
  {
  echo ("Error deleting $file");
  }
else
  {
  echo ("Deleted $file");
  }
    
?>
</body>
</html>

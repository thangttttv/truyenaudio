<html>
<head>
<title>File Upload Form</title>
</head>
<body>
<?php 
     function cleanFileName($string) {        
            $string = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $string);
            return $string;
        }
        
        echo cleanFileName("sohagame-2-0-5_1421399306 f  &  _117.apk")."<br/>";
        $domain = "http://10h.vn";
        
        echo $_SERVER['DOCUMENT_ROOT']."<br>";
        echo $_SERVER['SERVER_NAME']."<br/>";
        echo $_SERVER['HTTP_HOST']."<br/>";
        
        echo  $ck_token = base64_encode(base64_encode( "8aa8d43be81a90853749cacbf0930935168"."8"."8"))."<br>";
?>
Upload File.<br>
<form action="http://truyenaudio.mobi/ttv_api/audio/AudioAPI.php?action=uploadAvatar&user_id=9&&app_id=16&app_client_id=42&token=T0dGaE9HUTBNMkpsT0RGaE9UQTROVE0zTkRsallXTmlaakE1TXpBNU16VXhOamd4TmpReQ==" method="post" enctype="multipart/form-data" ><br>
Type (or select) Filename: <input type="file" name="upfile">
<input type="submit" value="Upload File">
<input type="hidden" name="user_id" value="9"/>
</form>

<br>
Add User<br>
<form action="http://truyenaudio.mobi/ttv_api/audio/AudioAPI.php?action=registerMember&app_client_id=0" method="post" ><br>
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
<form action="http://truyenaudio.mobi/ttv_api/audio/AudioAPI.php?action=postCommentAudio&app_client_id=123" method="post" ><br>
Audio ID: <input type="text" name="audio_id" value="609"/> <br>
User ID: <input type="text" name="user_id" value="1"/> <br>
username: <input type="text" name="create_user" value="thangtt" /> <br>
comment: <input type="text" name="comment" value="Truyen hay" /> <br>
<input type="submit" value="Save">
</form>

<br>
Post Comment<br>
<form action="http://kenhkiemtien.com/kkt_api/audio/AudioAPI.php?action=searchAudio&app_client_id=123" method="post" ><br>
Audio ID: <input type="text" name="page" value="1"/> <br>
Keyword: <input type="text" name="keyword" value="con nha ngheo"/> <br>

<input type="submit" value="Search">
</form>



</body>
</html>

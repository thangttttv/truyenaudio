<?php 
     function cleanFileName($string) {        
            $string = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $string);
            return $string;
        }
        
        echo cleanFileName("sohagame-2-0-5_1421399306 f  &  _117.apk")."<br/>";
        $domain_api = "http://kenhkiemtien.com/kkt_api/bongda/BongDaAPI.php";
        
        echo $_SERVER['DOCUMENT_ROOT']."<br>";
        echo $_SERVER['SERVER_NAME']."<br/>";
        echo $_SERVER['HTTP_HOST']."<br/>";
        
        echo  $ck_token = base64_encode(base64_encode( "d1ad4c5abed7b4e75e61ea4890b42d28"."80"))."<br>";
?>
Upload File.<br>
<form action="<?php echo $domain_api?>?action=uploadAvatar&app_client_id=1&token=<?php echo $ck_token?>" method="post" enctype="multipart/form-data" ><br>
Type (or select) Filename: <input type="file" name="upfile">
<input type="submit" value="Upload File">
<input type="hidden" name="user_id" value="1"/>
</form>

<br>
Add User<br>
<form action="<?php echo $domain_api?>?action=registerMember&app_client_id=1&token=<?php echo $ck_token?>" method="post" ><br>
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
<form action="<?php echo $domain_api?>?action=postCommentMatch&app_client_id=1&token=<?php echo $ck_token?>" method="post" ><br>
Match ID: <input type="text" name="match_id" value="211450"/> <br>
User ID: <input type="text" name="user_id" value="1"/> <br>
username: <input type="text" name="create_user" value="thangtt" /> <br>
comment: <input type="text" name="comment" value="Truyen hay" /> <br>
<input type="submit" value="Save">
</form>

<br>
Post Vote<br>
<form action="<?php echo $domain_api?>?action=postMatchVote&app_client_id=1&token=<?php echo $ck_token?>" method="post" ><br>
Match ID: <input type="text" name="match_id" value="211450"/> <br>
User ID: <input type="text" name="user_id" value="1"/> <br>
username: <input type="text" name="vote" value="1" /> <br>

<input type="submit" value="Save">
</form>
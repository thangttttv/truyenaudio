<?php
require '/home/xoso10h/domains/10h.vn/public_html/facebook/pwall1/src/facebook.php';
require 'AdvFacebookDAO.php';
// Create an Application instance (replace with your appId and secret).
$app_id = "351382901706185";$app_secret="178269fa0c9cc0c5e82f381897c4bace";
$facebook = new Facebook(array(
      'appId'  => $app_id,//'1495814003992449',
      'secret' => $app_secret,//'05d5a7327d33d18e8c9e20b95e642c6d',
       version  =>  'v2.1' // use version 2.0
));
 
// Get User ID
$user = $facebook->getUser();
$access_token = $facebook->getAccessToken();
$account_id =3;

if(empty($account_id)){
    echo "Thieu tham so AccountID";return;
}

 
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.
// Login or logout url will be needed depending on current user state.

if ($user) {
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $loginUrl = $facebook->getLoginUrl(array('scope' => 'publish_stream, read_stream,user_friends,publish_actions
'));
}

if ($user) {
        //Process knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');

        $user_info         = $facebook->api('/'.$user);
        $friends_list      = $facebook->api('/'.$user.'/invitable_friends');

echo "Insert ID Friends:";
        echo '<ul>';
            foreach ($friends_list["data"] as $value) {
               echo '<li>';
               echo '<div class="picName">'.$value["id"].'<br></div>'; 
               
               echo insertUserInvite($value["id"],$account_id);;
              // $ids .=$value["id"].",";
               echo '</li>';
               
            }
            echo '</ul>';
echo "Tong So:".count($friends_list["data"]);    
}
?>

    
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <title>PHP-SDK</title>
        <style>
        body {
            font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
        }
        h1 a {
            text-decoration: none;
            color: #3b5998;
        }
        h1 a:hover {
            text-decoration: underline;
        }
        </style>
    </head>
    <body>
        <h1>PHP SDK with publish_stream and read_stream permissions</h1>
 
        <?php if ($user): ?>
            <a href="<?php echo $logoutUrl; ?>">Logout</a>
        <?php else: ?>
            <div>
            Login using OAuth 2.0 handled by the PHP SDK:
            <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
            <div>
        <?php endif ?>
 
        <h3>PHP Session</h3>
        <pre><?php print_r($_SESSION); ?></pre>
 
        <?php if ($user): ?>
            <h3>You</h3>
            <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
            <h3>Your Permissions (/me/permissions)</h3>
            <pre><?php print_r($permissions); ?></pre>
            <h3>Your User Object (/me)</h3>
            <pre><?php print_r($user_profile); ?></pre>
        <?php else: ?>
            <strong><em>You are not connected.</em></strong>
        <?php endif ?>
        
       



    </body>
</html>
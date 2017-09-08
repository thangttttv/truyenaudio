<?php
  // Discussion
  /* $1: Tên người comment
  $2: Tiêu đề rút gọn của chủ đề
  */
  $discussion_message_1 = "$1 nhận xét chủ đề \"$2\" của bạn"; // Tới người post thảo luận khi có comment
  
  /* $1: Tên người comment
  $2: Tiêu đề rút gọn của chủ đề
  $3: Tên của người post chủ đề
  */
  
  $discussion_message_2 = "$1 cũng nhận xét chủ đề \"$2\"  của $3"; // Tới những người post comment vào chủ đề
  
  /* $1: Tên người post chủ đề
  $2: Tiêu đề rút gọn của chủ đề
  */
  $discussion_message_3 = "$1 viết về chủ đề \"$2\"  của bạn ấy"; // Tới những người post comment vào chủ đề
  
  /* $1: Tên người like chủ đề
  $2: Tiêu đề rút gọn của chủ đề
  */
  $discussion_message_4= "$1 thích chủ đề \"$2\" của bạn."; // Tới người post thảo luận khi có like
  
   /* $1: Tên người gửi tin nhắn
  $2: Nội dung tin nhắn
  */
  $discussion_message_5= "$1 gửi tin nhắn tới bạn."; // Tới người chat offline
  
  define("NOTIFY_TYPE_DISCUSSION","6");
  define("NOTIFY_TYPE_CHAT","5");
  define("NOTIFY_TYPE_NEWS","4");
  define("NOTIFY_TYPE_GIFTCODE","3");
  define("NOTIFY_TYPE_GAME","2");
  define("NOTIFY_TYPE_SYSTEM","1");
  
  define("NOTIFY_DISCUSSION_M1",$discussion_message_1);
  define("NOTIFY_DISCUSSION_M2",$discussion_message_2);
  define("NOTIFY_DISCUSSION_M3",$discussion_message_3);
  define("NOTIFY_DISCUSSION_M4",$discussion_message_4);
  define("NOTIFY_DISCUSSION_M5",$discussion_message_5);
  
  // khi co thao luan va gui toi nguoi post chu de
  function pushNotifyDiscussionMessage1($discussion_id,$usercomment_id,$commenter){
      $discussion = getDiscussionDetail2($discussion_id);
      $object_id = $discussion["id"];
      $content_discussion = $discussion["content"];
      $user = getUserById($usercomment_id);
      
      //var_dump($discussion);
      $content = NOTIFY_DISCUSSION_M1;
      $content = str_replace("$1",$commenter,$content);
      $content = str_replace("$2",$content_discussion,$content);
      $to = $discussion["user_id"];
      
      insertNotice($object_id,$usercomment_id,$to,$content,"", $user["avatar"],NOTIFY_TYPE_DISCUSSION,"SYSTEM");
  }
  
  // khi co comment va gui toi toan bo nguoi comment
  function pushNotifyDiscussionMessage2($discussion_id,$usercomment_id,$commenter){
      $discussion = getDiscussionDetail2($discussion_id);
      $object_id = $discussion["id"];
      $post_user = $discussion["fullname"];
      $content_discussion = $discussion["content"];
      $poster_id = $discussion["user_id"];
      $user = getUserById($usercomment_id);
      
      $content = NOTIFY_DISCUSSION_M2;
      $content = str_replace("$1",$commenter,$content);
      $content = str_replace("$2",$content_discussion,$content);
      $content = str_replace("$3",$post_user,$content);
      $to = "";
      
     $arrUser = getUserIDCommentDiscussionOther($discussion_id,$usercomment_id.",".$poster_id);
     
     writeLogNotify("pushNotifyDiscussionMessage2-> discussion_id:".$discussion_id);
     writeLogNotify("pushNotifyDiscussionMessage2-> get user id:".$usercomment_id.",".$poster_id);
     if(!empty($arrUser)){
         $i = 0;
         while($i<count($arrUser)){
             $to .= $arrUser[$i]["user_id"].",";
             $i++;
         }
         
     }
      writeLogNotify("pushNotifyDiscussionMessage2->".$to);
      if(!empty($to))
      insertNotice($object_id,$usercomment_id,$to,$content,"",$user["avatar"],NOTIFY_TYPE_DISCUSSION,"SYSTEM");
  }
  
  // khi nguoi post chu de comment va gui toi toan bo nguoi comment
  function pushNotifyDiscussionMessage3($discussion_id){
      $discussion = getDiscussionDetail2($discussion_id);
      $object_id = $discussion["id"];
      $post_user = $discussion["fullname"];
      $content_discussion = $discussion["content"];
      $poster_id = $discussion["user_id"];
      
      $content = NOTIFY_DISCUSSION_M3;
      $content = str_replace("$1",$post_user,$content);
      $content = str_replace("$2",$content_discussion,$content);
      
      $user = getUserById($poster_id);
      $to = "";
      
     $arrUser = getUserIDCommentDiscussionOther($discussion_id,$poster_id);
     if(!empty($arrUser)){
         $i = 0;
         while($i<count($arrUser)){
             $to .= $arrUser[$i]["user_id"].",";
             $i++;
         }
         
     }
      if(!empty($to))
      insertNotice($object_id,$poster_id,$to,$content,"",$user["avatar"],NOTIFY_TYPE_DISCUSSION,"SYSTEM");
  }
  
  // Khi co like va gui toi nguoi post chu de
  function pushNotifyDiscussionMessage4($discussion_id,$like_userid,$like_username){
      $discussion = getDiscussionDetail2($discussion_id);
      $object_id = $discussion["id"];
      $post_user = $discussion["fullname"];
      $content_discussion = $discussion["content"];
      
      $content = NOTIFY_DISCUSSION_M4;
      $content = str_replace("$1",$like_username,$content);
      $content = str_replace("$2",$content_discussion,$content);
      
      $to = $discussion["user_id"];
      $user = getUserById($like_userid);
      if(!empty($to))
      insertNotice($object_id,$like_userid,$to,$content,"",$user["avatar"],NOTIFY_TYPE_DISCUSSION,"SYSTEM");
  }
  
  // Khi co người gửi tin nhắn offline
  function pushNotifyChatMessage5($to_user_id,$from_user_id,$sender_name,$message){
      $object_id = $from_user_id;
    
      $content = NOTIFY_DISCUSSION_M5;
      $content = str_replace("$1",$sender_name,$content);
      //$content = str_replace("$2",$message,$content);
      
      $to = $to_user_id;
      
      $result = 0;
      $user = getUserById($from_user_id);
      
      if(!empty($to))
      $result = insertNotice($object_id,$from_user_id,$to,$content,"",$user["avatar"],NOTIFY_TYPE_CHAT,"SYSTEM");
      
      return $result;
  }
  
  function createPayLoadNotify($body,$action_loc_key,$type,$oid,$from_user_id,$icon)
  {
     $arr_cdata = array();
     $arr_cdata["type"] = $type;
     $arr_cdata["oid"] = $oid;
     $arr_cdata["fid"] = $from_user_id;
     $arr_cdata["icon"] = $icon;
     
     $arr_alert = array();
     $arr_alert["body"] = $body;
     $arr_alert["action-loc-key"] = $action_loc_key;
     $arr_alert["cdata"] = $arr_cdata;
     
     $arr_aps = array();
     $arr_aps["alert"] = $arr_alert;
     $arr_aps["sound"] = "default";
     
     $arr_out = array();
     $arr_out["aps"] = $arr_aps;
      
     echo json_encode($arr_out);
  }
  
  function writeLogNotify($mo){
        $date = date('Y-m-d H:i:s');
        $file = dirname(__FILE__).'/logGameStoreNotify.txt';
        
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        $current =$date."  :  ". $mo."\n";
        
        // Write the contents back to the file
        file_put_contents($file, $current,FILE_APPEND | LOCK_EX);
     }                                                                                                                                                
?>

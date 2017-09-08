<?php
require_once ("GameStoreDAO.php");
require_once ("../../function/utils.php");   
      //Set the time out
    set_time_limit(0);

    //path to the file
    $file_path_root = "/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/upload/gamestore/game";
    $file_path_time = "";
    $file_name = "";
    $file_path=$file_path_root.$file_path_time.$file_name;
    $link_root = "http://kenhkiemtien.com/upload/gamestore/game";

    $game_id = isset ( $_GET ['game_id'] ) ? $_GET ['game_id'] : "";
    $game_id = intval ( $game_id );
    $user_id = isset ( $_GET ['user_id'] ) ? $_GET ['user_id'] : "";
    $user_id = intval ( $user_id );
    $type = isset ( $_GET ['type'] ) ? $_GET ['type'] : "";
   
    if($game_id==0||$user_id==0||empty($type)){
            $kq="Invalid parameter";
            echo $kq;
    }else{
       
        
        switch ($type){
            case "apk":
                $gameInfo = getGameFile($game_id,2,0);
                 if(!empty($gameInfo)){
                    $linkAPK = $gameInfo["file_path"];
                    $file_name = substr($linkAPK,strrpos($linkAPK,"/")+1);
                    $file_path_time = str_replace($link_root,"",$linkAPK) ;
                    $file_path=$file_path_root.$file_path_time;
                    
                    output_file($file_path,$file_name, 'apk',2,$game_id,$user_id);
                   // echo $file_path."<br>";
                   // echo $file_name."<br>";
                   
                }else{
                     echo "File Not Found";
                }
            break;
            case "ipa":
                $gameInfo = getGameFile($game_id,3,0);
                 if(!empty($gameInfo)){
                    $linkAPK = $gameInfo["file_path"];
                    $file_name = substr($linkAPK,strrpos($linkAPK,"/")+1);
                    $file_path_time = str_replace($link_root,"",$linkAPK) ;
                    $file_path=$file_path_root.$file_path_time;
                    
                    output_file($file_path,$file_name, 'ipa',3,$game_id,$user_id);
                   // echo $file_path."<br>";
                   // echo $file_name."<br>";
                   
                }else{
                     echo "File Not Found";
                }
            break;
            case "plist":
                $gameInfo = getGameFile($game_id,3,0);
                 if(!empty($gameInfo)){
                    $linkAPK = $gameInfo["file_plist"];
                    $file_name = substr($linkAPK,strrpos($linkAPK,"/")+1);
                    $file_path_time = str_replace($link_root,"",$linkAPK) ;
                    $file_path=$file_path_root.$file_path_time;
                    
                    output_file($file_path,$file_name, 'plist',3,$game_id,$user_id);
                   // echo $file_path."<br>";
                   // echo $file_name."<br>";
                   
                }else{
                     echo "File Not Found";
                }
            break;
            default:
                echo "Invalid type file.";
            break;
            
        }
            
            
            
        }
        

    //Call the download function with file path,file name and file type
    //output_file($file_path,$file_name, '');

?>

 <?php

    function output_file($file, $name, $mime_type='',$type_os,$game_id,$user_id)
    {
     if(!is_readable($file)) die('File not found or inaccessible!');
     $size = filesize($file);
     $name = rawurldecode($name);
     
     /* Figure out the MIME type | Check in array */
     $known_mime_types=array(
         "htm" => "text/html",
        "apk" => "application/octet-stream",
        "plist" => "application/octet-stream",
        "ipa" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "jpg" => "image/jpg",
        "php" => "text/plain",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "pdf" => "application/pdf",
         "txt" => "text/plain",
         "html"=> "text/html",
         "png" => "image/png",
        "jpeg"=> "image/jpg"
     );
     
     if($mime_type==''){
         $file_extension = strtolower(substr(strrchr($file,"."),1));
         if(array_key_exists($file_extension, $known_mime_types)){
            $mime_type=$known_mime_types[$file_extension];
         } else {
            $mime_type="application/force-download";
         };
     };
     
     //turn off output buffering to decrease cpu usage
     @ob_end_clean(); 
     
     // required for IE, otherwise Content-Disposition may be ignored
     if(ini_get('zlib.output_compression'))
     ini_set('zlib.output_compression', 'Off');
     header('Content-Type: ' . $mime_type);
     header('Content-Disposition: attachment; filename="'.$name.'"');
     header("Content-Transfer-Encoding: binary");
     header('Accept-Ranges: bytes');
     
     // multipart-download and download resuming support
     if(isset($_SERVER['HTTP_RANGE']))
     {
        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
        list($range) = explode(",",$range,2);
        list($range, $range_end) = explode("-", $range);
        $range=intval($range);
        if(!$range_end) {
            $range_end=$size-1;
        } else {
            $range_end=intval($range_end);
        }

        $new_length = $range_end-$range+1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
     } else {
        $new_length=$size;
        header("Content-Length: ".$size);
     }
     
     /* Will output the file itself */
     $chunksize = 1*(1024*1024); //you may want to change this
     $bytes_send = 0;
     
    
     if ($file = fopen($file, 'r'))
     {
        if(isset($_SERVER['HTTP_RANGE']))
        fseek($file, $range);
     
        while(!feof($file) && (!connection_aborted()) && ($bytes_send<$new_length))
        {
            $buffer = fread($file, $chunksize);
            echo($buffer); 
            flush();
          
            $bytes_send += strlen($buffer);
        }
        
         
        insertUserDowload($user_id, $game_id, $type_os); 
        if($type_os==2)
        updateCountAndroidDownloadGame($game_id);
        else
        updateCountIOSDownloadGame($game_id);
            
     fclose($file);
     } else
     //If no permissiion
     die('Error - can not open file.');
     //die
    die();
    }

    ?>
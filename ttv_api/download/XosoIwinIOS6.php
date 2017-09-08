<?php

    writeLogDownload("itms-services://?action=download-manifest&amp;url=https://dl.dropboxusercontent.com/s/1ke9cwv98apbodk/iwin.plist");
    header('Location: itms-services://?action=download-manifest&amp;url=https://dl.dropboxusercontent.com/s/1ke9cwv98apbodk/iwin.plist', true, 301);
   
    die();
   
     function writeLogDownload($mo){
        $date = date('Y-m-d H:i:s');
        $file = dirname(__FILE__).'/logDownIwinXoSoIOS.txt';
        
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        $current =$date."  :  ". $mo."\n";
        
        // Write the contents back to the file
        file_put_contents($file, $current,FILE_APPEND | LOCK_EX);
     }
?>

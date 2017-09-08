<?php

    writeLogDownload("http://iwin86.com/upload/game/iWin_all.apk");
    header('Location: http://iwin86.com/upload/game/iWin_all.apk', true, 301);
    die();
   
       function writeLogDownload($mo){
        $date = date('Y-m-d H:i:s');
        $file = dirname(__FILE__).'/logDownIwinXoSoAPK.txt';
        
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        $current =$date."  :  ". $mo."\n";
        
        // Write the contents back to the file
        file_put_contents($file, $current,FILE_APPEND | LOCK_EX);
     }
?>

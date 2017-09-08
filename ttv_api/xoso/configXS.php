<?php   
    $connect = @mysql_connect('127.0.0.1', 'uxoso10h', 'Pxoso10h!@#456');
    if (!$connect) die('Could not connect: ' . mysql_error());    
    @mysql_select_db('vtc_10h_xs', $connect);
    @mysql_query("SET NAMES 'utf8'");          
    
  
    function baseUrl(){
        return "http://kenhkiemtien.com/";
    }
    function baseUrlUpload()
    {
        return "http://kenhkiemtien.com/upload/";
    }
?>
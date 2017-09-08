<?php
    header('Content-type: text/html; charset=utf-8');       
    require_once("GameStoreDAO.php");
    require_once("../../function/utils.php");
    
    $id = isset($_GET['id']) ?$_GET['id'] :"0" ;
    $id  = intval($id);
    
    echo "<style>";
    echo "blockquote {display: block;-webkit-margin-before: 1em;-webkit-margin-after: 1em;-webkit-margin-start: 40px;
    -webkit-margin-end: 40px;}";
    echo ".images{width:100% !important;height:auto;display:block;}";
    echo "</style>";
    $output = getNewsDetailContent($id);
    if(!empty($output))
     echo $output["content"];
    else
     echo "Not Found";
    
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
    <style>
        blockquote {display: block;-webkit-margin-before: 1em;-webkit-margin-after: 1em;-webkit-margin-start: 40px;
        -webkit-margin-end: 40px;}
        .images{width:100% !important;height:auto;display:block;}  
        img{width:100% !important;height:auto;display:block;} 
    </style>
</head>
<body>
<?php
    header('Content-type: text/html; charset=utf-8');       
    require_once("BongDaDAO.php");   
    require_once("../function/utils.php");
    $id = isset($_GET['id']) ?$_GET['id'] :"0" ;
    $id  = intval($id);
   
    $output = getNewsDetail($id);
    if(!empty($output))
     echo $output["content"];
    else
     echo "Not Found";
    
?>
</body>
</html>
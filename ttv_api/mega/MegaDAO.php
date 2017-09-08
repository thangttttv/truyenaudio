<?php
    date_default_timezone_set('Asia/Saigon');

    function connectDB(){
        include('Config.php');
        $mode="development";
        $config = Config::$config[$mode];

        // Create a connection to the database.
        $connect = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['username'],
            $config['db']['password'],
            array());

        // If there is an error executing database queries, we want PDO to
        // throw an exception.
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // We want the database to handle all strings as UTF-8.
        $connect->query('SET NAMES utf8');
        return  $connect;
    }

    function getLastResult645()
    {
        $sql ="SELECT  * FROM ketqua_645  ORDER BY ngay_mo DESC LIMIT 1" ;
        $connect = connectDB();
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $result->fetch();
        return $arr;
    }
    function getLastResultMax4d()
    {
        $sql ="SELECT  * FROM ketqua_max4d  ORDER BY ngay_mo DESC LIMIT 1" ;
        $connect = connectDB();
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $result->fetch();
        return $arr;
    }

    function getResultHistory645($page,$numb_per_page)
    {
        $start = ($page - 1) * $numb_per_page;

        $sql = "SELECT count(id) as count FROM ketqua_645" ;
        $connect = connectDB();
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $result->fetch();
        $max_page = ceil(intval($arr["count"])/$numb_per_page);

        $sql = "SELECT * FROM  ketqua_645 ORDER BY ngay_mo DESC LIMIT ".$start.",".$numb_per_page;
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = array();
        $i=0;
        while($row = $result->fetch()) {
            $arr[$i] =  $row;
            $i++;
        }
        return array($arr,$max_page);
    }

    function getResultHistoryMax4d($page,$numb_per_page)
    {
        $start = ($page - 1) * $numb_per_page;

        $sql = "SELECT count(id) as count FROM ketqua_max4d" ;
        $connect = connectDB();
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $result->fetch();
        $max_page = ceil(intval($arr["count"])/$numb_per_page);

        $sql = "SELECT * FROM  ketqua_max4d ORDER BY ngay_mo DESC LIMIT ".$start.",".$numb_per_page;
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = array();
        $i=0;
        while($row = $result->fetch()) {
            $arr[$i] =  $row;
            $i++;
        }
        return array($arr,$max_page);
    }

    function getStatisticNumber645()
    {
        $sql = "SELECT * FROM  thongke_645";
        $connect = connectDB();
        $result = $connect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $arr = array();
        $i=0;
        while($row = $result->fetch()) {
            $arr[$i] =  $row;
            $i++;
        }
        return $arr;
    }

?>

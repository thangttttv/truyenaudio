<html>
    <head>
        <title>File Upload Form</title>
    </head>
    <body>
        <?php 
            function cleanFileName($string) {        
                $string = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $string);
                return $string;
            }

            echo cleanFileName("sohagame-2-0-5_1421399306 f  &  _117.apk")."<br/>";
            $domain = "http://10h.vn";

            echo $_SERVER['DOCUMENT_ROOT']."<br>";
            echo $_SERVER['SERVER_NAME']."<br/>";
            echo $_SERVER['HTTP_HOST']."<br/>";
        ?>

        Add User<br>
        <form action="http://kenhkiemtien.com/kkt_api/sms/SMSSerivceMO.php" method="get" ><br>
            Phone: <input type="text" name="User_ID" value="84974838181"/> <br>
            service_id: <input type="text" name="Service_ID" value="8377"/> <br>
            command_code: <input type="text" name="Command_Code" value="XSMB" /> <br>
            request_id: <input type="text" name="Request_ID" value="012" /> <br>
            message: <input type="text" name="Message" value="XSMB"/> <br>
            <input type="submit" value="send">
        </form>


    </body>
</html>
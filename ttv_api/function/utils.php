<?php
    function convertStrdmyyToyymd($strDate,$slash)
    {
        if(!IsNullOrEmptyString($strDate)){
            $arrDate = explode($slash,$strDate);
            $newStrDate = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
            return   $newStrDate;
        }else{
            return "";
        }
    }

    function convertTimeToPath($time,$folder,$image)
    {
        $strDate = date("Y/md", $time);
        $path = "http://kenhkiemtien.com/".$folder."/".$strDate."/".$image;
        return   $path;
    }

    function sanitize($string = '', $is_filename = FALSE)
    {
        // Replace all weird characters with dashes
        $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);
        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }

    function makeFolder($upPath){
        //$upPath = "../uploads/RS/2014/BOI/002";   // full path 
        $tags = explode('/' ,$upPath);            // explode the full path
        $mkDir = "";
        foreach($tags as $folder) {          
            $mkDir = $mkDir . $folder ."/";   // make one directory join one other for the nest directory to make
            //  echo '"'.$mkDir.'"<br/>';         // this will show the directory created each time
            if(!is_dir($mkDir)) {             // check if directory exist or not
                mkdir($mkDir, 0777);            // if not exist then make the directory
            }
        }
    }

    function cleanQuery($string)
    {        
        if(empty($string)) return $string;
        $string = mysql_escape_string(trim($string));

        $badWords = array(
        "/Select(.*)From/i"
        , "/Union(.*)Select/i"
        , "/Update(.*)Set/i"
        , "/Delete(.*)From/i"
        , "/Drop(.*)Table/i"
        , "/Insert(.*)Into/i"                
        , "/http/i"
        , "/--/i"
        );

        $string = preg_replace($badWords, "", $string);

        return $string;
    }

    function isValidEmail($email) {
        return eregi ( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email );
    }

    function formatMobile($mobile)
    {    
        if(!empty($mobile)) {
            $first = substr($mobile, 0, 1);
            if($first=="0"){
                $mobile = substr($mobile, 1, strlen($mobile) - 1);
                $mobile = "84" . $mobile;
            } 
        }
        return $mobile;    
    }

    function formatMobileVn($mobile)
    {    
        if(!empty($mobile)) {
            $first = substr($mobile, 0, 2);
            if($first=="84"){
                $mobile = substr($mobile, 2, strlen($mobile) - 1);
                $mobile = "0" . $mobile;
            } 
        }
        return $mobile;    
    }

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function createDataLog($action,$arrParameter,$result){
        $log = "{\"action\":\"".addslashes($action)."\"";

        $logpara=",\"parameters\":{";
        $i=0;
        foreach($arrParameter as $key => $value){
            if($i>0)
                $logpara .=",\"".$key."\":\"".addslashes($value)."\""; else
                $logpara .="\"".$key."\":\"".addslashes($value)."\"";
            $i++;
        }
        $log .= $logpara."}";
        $log .= ",\"result\":\"".addslashes($result)."\"}";
        return $log;
    }


    function imageCreateFromAny($filepath) { 
        echo 1;
        $type = exif_imagetype("http://kenhkiemtien.com/upload/gamestore/avatar/280/280.png"); // [] if you don't have exif you could use getImageSize() 
        $allowedTypes = array( 
        1,  // [] gif 
        2,  // [] jpg 
        3,  // [] png 
        6   // [] bmp 
        ); 
        echo $allowedTypes;die;
        if (!in_array($type, $allowedTypes)) { 
            return false; 
        } 
        switch ($type) { 
            case 1 : 
                $im = imageCreateFromGif($filepath); 
                break; 
            case 2 : 
                $im = imageCreateFromJpeg($filepath); 
                break; 
            case 3 : 
                $im = imageCreateFromPng($filepath); 
                break; 
                //case 6 : 
                //   $im = imageCreateFromBmp($filepath); 
                //break; 
        }    
        return $im;  
    }

    function IsNullOrEmptyString($strvalue){
        return (!isset($strvalue) || trim($strvalue)===''||strcasecmp("null",$strvalue)==0);
    }

    function validUsername($username)
    {
        $arrInvalidName = array("/[^a-zA-Z0-9_\.]/","/^admin.*$/","/^banquantri.*$/","/^quantri.*$/","/^administrator.*$/","/^hochiminh.*$/","/^nguyentandung.*$/","/^nongducmanh.*$/","/^truongtansang.*$/","/^nguyensinhhung.*$/","/^nguyenphutrong.*$/","/^sex.*$/","/^lon.*$/","/^buoi.*$/","/^duongvat.*$/","/^amvat.*$/","/^condi.*$/","/^condiem.*$/","/^traibao.*$/");

        $i = 1;
        foreach($arrInvalidName as $regular)
        {
            if (preg_match($regular, $username, $maches)){
                $i = 0;break;
            }
        }

        return $i;
    }


    function strToHex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }

    function hexToStr($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

    function boDau($str) {
        $coDau = array ("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", "ê", "ù", "à" );

        $khongDau = array ("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "e", "u", "a" );
        return str_replace ( $coDau, $khongDau, $str );
    }


    function unicode_str_filter ($str){
        $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }


    function getMobileOperator($mobile)
    {        
        $first = substr($mobile, 0, 1);
        if($first=="0"){
            $mobile = substr($mobile, 1, strlen($mobile) - 1);
        } else if($first="8"){
                $mobile = substr($mobile, 2, strlen($mobile) - 2);
            }

            $mobile = "84" . $mobile;

        $patternViettel = "/^84(9[678]|16[2-9])[\d]{7}/";
        $patternMobi = "/^84(9[03]|12[01268])[\d]{7}/";
        $patternVina = "/^84(9[14]|12[34579])[\d]{7}/";
        $patternVnmobile = "/^84(9[2]|18[86])[\d]{7}/";
        $patternBeeline = "/^84(9[9]|19[9])[\d]{7}/";

        if(preg_match($patternViettel, $mobile)){
            $telco = "VIETTEL";    
        } else if(preg_match($patternMobi, $mobile)){
                $telco = "VMS";
            } else if(preg_match($patternVina, $mobile)){
                    $telco = "GPC";
                } else if(preg_match($patternVnmobile, $mobile)){
                        $telco = "VNMOBILE";
                    } else if(preg_match($patternBeeline, $mobile)){
                            $telco = "BEELINE";
                        } else {
                            $telco = "KHONGRO";
        }

        return $telco;    
    }     


?>

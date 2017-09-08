<?php
class Config {
    public static $api_url = "http://kenhkiemtien.com/kkt_api/vietloto/MegaAPI.php";
    public static $config = array(
        // These are the settings for development mode
        'development' => array(

            // Configuration of the MySQL database
            'db' => array(
                'host'     => 'localhost',
                'dbname'   => 'vtc_vietlott',
                'username' => 'uvietloto',
                'password' => 'Pvietloto123$%^',
            ),

        ),

        // These are the settings for production mode
        'production' => array(
            // Configuration of the MySQL database
            'db' => array(
                'host'     => 'localhost',
                'dbname'   => 'vtc_vietlott',
                'username' => 'uvietloto',
                'password' => 'Pvietloto123$%^',
            ),
        ),
    );
}






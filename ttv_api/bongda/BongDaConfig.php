<?php

// Configuration file for push.php

$config = array(
    // These are the settings for development mode
    'development' => array(

        // The APNS server that we will use
        'server' => 'gateway.sandbox.push.apple.com:2195',

        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/ck_bongda.pem',
        'passphrase' => '123456',

        // Configuration of the MySQL database
        'db' => array(
            'host'     => 'localhost',
            'dbname'   => 'vtc_bongda',
            'username' => 'uvtcbongda',
            'password' => 'pvtcbongda!@#',
            ),

        // Name and path of our log file
        'logfile' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/push_development.log',
        'logfileIOS' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/push_ios_development.log',
        'logfileMatchQueue' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/match_queue.log',
        'logfileVideoQueue' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/video_queue.log',
        'logfileNewsQueue' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/news_queue.log',
        ),

    // These are the settings for production mode
    'production' => array(

        // The APNS server that we will use
        'server' => 'gateway.push.apple.com:2195',

        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/ck_bongda.pem',
        'passphrase' => '123456',

        // Configuration of the MySQL database
        'db' => array(
            'host'     => 'localhost',
            'dbname'   => 'vtc_bongda',
            'username' => 'uvtcbongda',
            'password' => 'pvtcbongda!@#',
            ),

        // Name and path of our log file
        'logfile' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/push_production.log',
        'logfileIOS' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/push_ios_development.log',
        'logfileMatchQueue' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/match_queue.log',
        'logfileVideoQueue' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/video_queue.log',
        'logfileNewsQueue' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/bongda/log/news_queue.log',
        ),
    );

    
   

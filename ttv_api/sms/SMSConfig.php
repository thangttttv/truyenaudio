<?php

// Configuration file for push.php

$config = array(
    // These are the settings for development mode
    'development' => array(

        // The APNS server that we will use
        'server' => 'gateway.sandbox.push.apple.com:2195',

        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/ck.pem',
        'passphrase' => 'nopass',

        // Configuration of the MySQL database
        'db' => array(
            'host'     => 'localhost',
            'dbname'   => 'vtc_sms',
            'username' => 'usms',
            'password' => 'psms&*(',
            ),

        // Name and path of our log file
        'logfile' => '/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com/kkt_api/log/sent_sms_from_queue.log',
        ),

    // These are the settings for production mode
    'production' => array(

        // The APNS server that we will use
        'server' => 'gateway.push.apple.com:2195',

        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => 'ck_production.pem',
        'passphrase' => 'pushchat',

        // Configuration of the MySQL database
        'db' => array(
            'host'     => 'localhost',
            'dbname'   => 'vtc_sms',
            'username' => 'usms',
            'password' => 'psms&*(',
            ),

        // Name and path of our log file
        'logfile' => '../log/push_production.log',
        ),
    );

    
   
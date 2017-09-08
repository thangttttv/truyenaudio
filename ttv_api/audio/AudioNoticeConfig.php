<?php

// Configuration file for push.php
$DOCUMENT_ROOT = "/home/kktien/domains/kenhkiemtien.com/public_html/kenhkiemtien.com";
$config = array(
    // These are the settings for development mode
    'development' => array(

        // The APNS server that we will use
        'server' => 'gateway.sandbox.push.apple.com:2195',

        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => $DOCUMENT_ROOT.'/kkt_api/audio/ck_audio.pem',
        'passphrase' => '123456',

        // Configuration of the MySQL database
        'db' => array(
            'host'     => 'localhost',
            'dbname'   => 'vtc_kenhkiemtien',
            'username' => 'uvtc_kkt2012',
            'password' => 'pvtc_@)!@kkt',
            ),

        // Name and path of our log file
        'logfileAndroidSend' =>$DOCUMENT_ROOT.'/kkt_api/audio/log/push_android_audio_dev.log',
        'logfileIOSSend' =>$DOCUMENT_ROOT.'/kkt_api/audio/log/push_ios_audio_dev.log',
        'logfileQueue' =>$DOCUMENT_ROOT.'/kkt_api/audio/log/push_queue_audio_dev.log',
        ),

    // These are the settings for production mode
    'production' => array(

        // The APNS server that we will use
        'server' => 'gateway.push.apple.com:2195',

        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => $DOCUMENT_ROOT.'/kkt_api/audio/ck_audio.pem',
        'passphrase' => '123456',

        // Configuration of the MySQL database
        'db' => array(
            'host'     => 'localhost',
            'dbname'   => 'vtc_kenhkiemtien',
            'username' => 'uvtc_kkt2012',
            'password' => 'pvtc_@)!@kkt',
            ),

        // Name and path of our log file
        'logfile' => $DOCUMENT_ROOT.'/kkt_api/xoso/log/push_ios_xoso.log',
        ),
        
        'appota' => array(
        // The APNS server that we will use
        'server' => 'gateway.push.apple.com:2195',
        // The SSL certificate that allows us to connect to the APNS servers
        'certificate' => $DOCUMENT_ROOT.'/kkt_api/ck-appota.pem',
        'passphrase' => 'nopass',
        // Configuration of the MySQL database
        'db' => array(
            'host'     => '127.0.0.1',
            'dbname'   => 'vtc_10h_xs',
            'username' => 'uxoso10h',
            'password' => 'pxoso10h!@#456',
            ),
        // Name and path of our log file
        'logfile' =>$DOCUMENT_ROOT.'/kkt_api/xoso/log/push_appota.log',
        ),
    );

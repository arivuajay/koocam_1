<?php
$whitelist = array('127.0.0.1', '::1');
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    $mailsendby = 'smtp';
} else {
    $mailsendby = 'phpmail';
}
if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false) {
    $fb_app_id = '506092249568171';
    $fb_sec_id = '9d672f389546c6957407b3a9d0b59038';
    
    $google_app_id = '288594682867-bb3csmegd3ka1b3o84anee98ugstd0db.apps.googleusercontent.com';
    $google_sec_id = '4LLWfiAIKSFsBLPr6AxsIFzl';
}

// this contains the application parameters that can be maintained via GUI
// Custom Params Value
return array(
    //Global Settings
    'EMAILLAYOUT' => 'file', // file(file concept) or db(db_concept)
    'EMAILTEMPLATE' => '/mailtemplate/',
    'MAILSENDBY' => $mailsendby,
    //EMAIL Settings
    'SMTPHOST' => 'smtp.gmail.com',
    'SMTPPORT' => '465', // Port: 465 or 587
    'SMTPUSERNAME' => 'marudhuofficial@gmail.com',
    'SMTPPASS' => 'ninja12345',
    'SMTPAUTH' => true, // Auth : true or false
    'SMTPSECURE' => 'ssl', // Secure :tls or ssl
    'NOREPLYMAIL' => 'noreply@koocam.com',
    'CONTACTMAIL' => 'noreply@koocam.com',
    'JS_SHORT_DATE_FORMAT' => 'dd-MM-yyyy',
    'JS_SHORT_DATE_FORMAT_2' => 'DD-MM-YYYY',
    'PHP_SHORT_DATE_FORMAT' => 'd-m-Y',
    'PHP_SHORT_DATE_TIME_FORMAT' => 'd-m-Y H:i:s',

    //Product Settings
    'SITEBASEURL' => 'https://www.koocam.com',
    'UPLOAD_DIR' => 'uploads',
    'EMAILHEADERIMAGE' => '/themes/koocam/images/logo.png',

    'PAGE_SIZE' => '10',

    'SITENAME' => 'KOOCAM',
    
    'FB_APP_ID' => $fb_app_id,
    'FB_SECRET_ID' => $fb_sec_id,
    'GOOGLE_APP_ID' => $google_app_id,
    'GOOGLE_SECRET_ID' => $google_sec_id,
    
    //Paypal values
    'SANDBOXVALUE'  => false,
    'CURRENCY'      => 'USD',
    'BUSINESSEMAIL' => 'seotopil@gmail.com',
);
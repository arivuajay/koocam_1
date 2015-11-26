<?php

//error_reporting(E_ALL & ~E_NOTICE  & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
// change the following paths if necessary
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';
include_once(dirname(__FILE__) . '/protected/config/constants.php');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
$app = Yii::createWebApplication($config);

defined('SITEURL') ||
        @define('SITEURL', Yii::app()->createAbsoluteUrl("/"));
defined('SITENAME') ||
        @define('SITENAME', Yii::app()->name);

defined('DS') ||
        @define('DS', DIRECTORY_SEPARATOR);


$app->run();

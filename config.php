<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

// HTTP
define('HTTP_SERVER', 'http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/');
$documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
define('DOCUMENT_ROOT', $documentRoot); 

$testvar="test";  

// HTTPS
define('HTTPS_SERVER', 'http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/');

$documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
define('API_KEY', "b2d475cf2e336960cd8faa96d8209b3f-us12");
// DIR
define('DIR_APPLICATION', $documentRoot. 'catalog/');
define('DIR_SYSTEM', $documentRoot. 'system/');
define('DIR_DATABASE', $documentRoot. 'system/database/');
define('DIR_LANGUAGE', $documentRoot. 'catalog/language/');
define('DIR_TEMPLATE', $documentRoot. 'catalog/view/theme/');
define('DIR_CONFIG', $documentRoot. 'system/config/');
define('DIR_IMAGE', $documentRoot. 'image/');
define('DIR_CACHE', $documentRoot. 'system/cache/');
define('DIR_DOWNLOAD', $documentRoot. 'download/');
define('DIR_LOGS', $documentRoot. 'system/logs/');
// DB

define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'aa1efuoo5beqqvd.cvwrkeif9dtm.ap-south-1.rds.amazonaws.com');
define('DB_USERNAME', 'fladmin');
define('DB_PASSWORD', 'Welcome!23'); 
define('DB_DATABASE', 'ebdb');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');
?>
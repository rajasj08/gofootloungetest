<?php
//test
error_reporting(E_ALL);
ini_set("display_errors", 1);

// HTTP
//define('HTTP_SERVER', 'http://localhost/GitHub/gofootlounge/');
define('HTTP_SERVER', 'https://footlounge.in/');

//$documentRoot = $_SERVER['DOCUMENT_ROOT'].'GitHub/gofootlounge/';
$documentRoot = "/var/app/current/";

define('DOCUMENT_ROOT', $documentRoot); 

// HTTPS
//define('HTTPS_SERVER', 'http://localhost/GitHub/gofootlounge/');
define('HTTPS_SERVER', 'https://footlounge.in/');




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

define('DB_DRIVER', 'mysqliz');
define('DB_HOSTNAME', 'aap6sgpx9zn9c6.cvwrkeif9dtm.ap-south-1.rds.amazonaws.com');
define('DB_USERNAME', 'fldbuser');
define('DB_PASSWORD', 'Welcome!23');
define('DB_DATABASE', 'ebdb');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');


/*define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'gofootlounge');
define('DB_PREFIX', 'oc_');*/
?>
<?php
// HTTP
define('HTTP_SERVER', 'https://footlounge.in/fladmin15/');
define('HTTP_CATALOG', 'https://footlounge.in/');

$documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
define('DOCUMENT_ROOT', $documentRoot); 

// HTTPS
define('HTTPS_SERVER', 'https://footlounge.in/fladmin15/');
define('HTTPS_CATALOG', 'https://footlounge.in/');

// DIR
define('DIR_APPLICATION', $documentRoot. 'fladmin15/');
define('DIR_SYSTEM', $documentRoot. 'system/');
define('DIR_DATABASE', $documentRoot. 'system/database/');
define('DIR_LANGUAGE', $documentRoot. 'fladmin15/language/');
define('DIR_TEMPLATE', $documentRoot. 'fladmin15/view/template/');
define('DIR_CONFIG', $documentRoot. 'system/config/');
define('DIR_IMAGE', $documentRoot. 'image/');
define('DIR_CACHE', $documentRoot. 'system/cache/');
define('DIR_DOWNLOAD', $documentRoot. 'download/');
define('DIR_LOGS', $documentRoot. 'system/logs/');
define('DIR_CATALOG', $documentRoot. 'catalog/');

define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'aa175eca4p5ixoi.cvwrkeif9dtm.ap-south-1.rds.amazonaws.com');
define('DB_USERNAME', 'fladmin');
define('DB_PASSWORD', 'Welcome!23');
define('DB_DATABASE', 'ebdb');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');
/*define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'aa128rcsxrj96v2.cvwrkeif9dtm.ap-south-1.rds.amazonaws.com');
define('DB_USERNAME', 'fladmin');
define('DB_PASSWORD', 'Welcome!23');
define('DB_DATABASE', 'ebdb');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');*/
?>
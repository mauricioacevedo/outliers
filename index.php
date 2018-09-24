<?php 

//error_reporting(E_ALL ^ E_ERROR ^ E_WARNING ^ E_PARSE ^ E_NOTICE 
//^ E_STRICT ^ E_DEPRECATED); //(^)excluye; (|)incluye
//(^)excluye; (|)incluye
error_reporting(E_ERROR); 
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/1_1_16/yii.php';
//$yii=dirname(__FILE__).'/YII/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//MAIN CONF

define('SITENAME','Outliers');
define('PASSWORD_APP','xxxxxx');
define('APPLICATION','xxxxxxxyy');
define('INSTANCE','mysqlportdllo.une.net.co');
define('DB','dboutliers');
define('DB_USER','usroutliers');
define('DB_PASS','6a2968b25912541cb379607fc453fe33');
//profile path
define('DIRPATH', dirname(__FILE__)); 
define('AVATARPATH','/archivos/multimedia/profiles/pics/');
define('PATH_UPLOAD_REGISTROS', DIRPATH.AVATARPATH);
define('SITE_URL','d-outliers.une.com.co');
//COPYRIGHT
define('COPYRIGHT', 'UNE TELECOMUNICACIONES');
//massdataupload
define('MASSUPLOADPATH','/archivos/tmp/massdataupload/');
define('UPLOADFILEPATH', DIRPATH.'MASSUPLOADPATH');
define('TABLE_PREFIX','tbl_');
require_once($yii); 
Yii::createWebApplication($config)->run(); 
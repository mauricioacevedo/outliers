<?php

/**
 * indexModel class.
 * indexModel is the data structure for keeping
 */
class IndexModel
{

    public function generateIndex($params) {
        $debug      = "false";
        if($params['debug']>0){
          $debug    = "true";  
        }
        $index = "<?php 
//error_reporting(E_ALL ^ E_ERROR ^ E_WARNING ^ E_PARSE ^ E_NOTICE 
//^ E_STRICT ^ E_DEPRECATED); //(^)excluye; (|)incluye
//(^)excluye; (|)incluye
error_reporting(E_ERROR); 
// change the following paths if necessary
\$yii=dirname(__FILE__).'/YII/framework/yii.php';
\$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',{$debug});
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//MAIN CONF
define('SITENAME','{$params['sitename']}');
define('PASSWORD_APP','{$params['password_app']}');
define('APPLICATION','{$params['application']}');
define('INSTANCE','{$params['hostname']}');
define('DB','{$params['dataBase']}');
define('DB_USER','{$params['user']}');
define('DB_PASS','{$params['password']}');
//profile path
define('DIRPATH', dirname(__FILE__)); 
define('AVATARPATH','{$params['avatarPath']}');
define('PATH_UPLOAD_REGISTROS', DIRPATH.AVATARPATH);
//COPYRIGHT
define('COPYRIGHT', '{$params['copyright']}');
//massdataupload
define('MASSUPLOADPATH','{$params['massUploadFilePath']}');
define('UPLOADFILEPATH', DIRPATH.'MASSUPLOADPATH');
define('TABLE_PREFIX','tbl_');
require_once(\$yii); 
Yii::createWebApplication(\$config)->run(); ";

particularFunction::writeDown(DIRPATH.DIRECTORY_SEPARATOR.'index.php',$index);  

    }
	
}
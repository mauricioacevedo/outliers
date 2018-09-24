<?php

class InstallController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/login';

	public function beforeAction($action) {        
            return Yii::app()->sysSecurity->checkUser();            
        }
        /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	 /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
        public function accessRules()
	{
            return array(                
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                'actions'=>array('index'),
                                'users'=>array('*'),
                ),
            );
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{    
            $user  = Yii::app()->getComponent('user');      
         
             if(isset($_POST['saveSettings'])){
                 $this->updateIndex();
             }elseif(isset($_POST['importTables'])){
                 $this->importTables();
             }            
	     $this->render('index',array('user'=>$user));
        }
        /**
         * modifica el archivo index.php del sitio web...
         */
        function updateIndex(){
            $postSettings      = Yii::app()->request->getPost('SettingFormModel'); 
            $postSettings      = array_merge($postSettings,array('debug'=>$_POST['debug']));
            $indexModel        = new IndexModel();
            $indexModel->generateIndex($postSettings);
            header('location: ./index.php?r=install/install&cnf=u');
        }
        
        function importTables(){
           $dbMigrationModel  = new DbMigrationModel();
           $path              = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR
                                .'data'.DIRECTORY_SEPARATOR; 
           $sqlFile           = 'dbappyii.sql';           
           if(file_exists($path.$sqlFile)){
               $response      = $dbMigrationModel->executeFile($path.$sqlFile);               
               $status        = 'c';
           }
           else{
               $status        = 'e';
           }
           header('location: ./index.php?r=install/install&it='.$status);           
        }
	
}
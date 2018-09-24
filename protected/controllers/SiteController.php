<?php

class SiteController extends Controller
{
    public function beforeAction($action) {        
        return Yii::app()->sysSecurity->checkUser();            
    }
	
	public function init() {
        /**
         * Evitar Cross Domain
         */
        header('Access-Control-Allow-Origin: ' . $_SERVER['SERVER_NAME']);
        header('X-Permitted-Cross-Domain-Policies: master-only');
        header('X-Content-Type-Options: nosniff');
        header('Strict-Transport-Security: max-age=15768000 ; includeSubDomains');
        header('Content-Type: text/html; charset=utf-8');
        header('X-Frame-Options:SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('X-Powered-By: what-should-we-put-over-here?');
    }
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xf2f2f2,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        public function accessRules()
	{
            return array(
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                'actions'=>array('Index'),
                                'users'=>array('@'),
                ),
                array('deny',
                    'actions'=>array('Home'),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                'actions'=>array('Login', 'Logout', 'Error','uniqueUser','AutoLogin','SearchLiveAnswer'),
                                'users'=>array('*'),
                ),
            );
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{	
            $siteSettingModel	= Sitesettings::model()->findByAttributes(array('id'=>'1'));
            
            if(strtolower(Yii::app()->user->isGuest)){
                if($siteSettingModel->oauth == 3){
                    $this->actionAutoLogin();                    
                }else{
                    $this->actionLogin();
                }                
            }
            else{
                $this->redirect('index.php?r=evii/evidencias/admin');
            }
	}
        function addQuots(&$value) {
           return $value = '"'.$value.'"';
       }
	/**
	 * Permite realizar una busqueda en el menu top
	 */
	public function actionSearchLiveAnswer()
	{	
           $criteria              = new CDbCriteria;          
           $post                  = Yii::app()->request->getPost('queryString');           
           $In_controller        = array();
           $In_action            = array();

            if(isset(Yii::app()->session['roles_delphos']) && count(Yii::app()->session['roles_delphos'])){
                foreach(Yii::app()->session['roles_delphos'] as $rol =>$value){
                    if(is_object($value) || is_array($value)){
                        foreach($value as $controller =>$action){
                            $In_controller[] = join(',',array_map('self::addQuots',array($controller)));
                            $In_action[]     = join(',',array_map('self::addQuots',$action));
                        }
                    }
                }
                 $criteria->condition        = 'controller in ('.join(',',$In_controller).') AND action in ('.join(',',$In_action).')  AND';
            }           
           $criteria->condition   .= ' name like "%'.$post.'%" AND href !="#" AND publish like "si" ';
           $criteria->order       = ' order_menu ASC';
           $menuModel             = Menu::model()->findAll($criteria);
           if($menuModel !=null){
               echo '<div class="well_simple">';
               foreach($menuModel as $key =>$attribute){
                echo '<a href="'.$menuModel[$key]->href.'"><div id="keyword"><b>'.$menuModel[$key]->name.'</b></div></a>
                 <div id="description"><small>'.$menuModel[$key]->description.'</small> </div>
                 <hr>';
               }
               echo '</div>';
           }
           else{
                echo '<div class="well_simple">
                <div id="keyword"><cite>No se encontraron Resultados</cite></div>                
                <hr></div>';
           }
           
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
        
        public function actionUniqueUser(){
            $mensaje = 'Se inició otra sesión desde otra máquina. Por seguridad ésta ha sido cerrada';                                        
           Yii::app()->user->logout();
           Yii::app()->user->setFlash('info', $mensaje);            
            $this->render('../comunes/mensajes');            
        }
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{ 
		if(Yii::app()->controller->action->id !='index'){
		$this->redirect('index.php');
		}
        $this->layout = "//layouts/login";
		$model									= new LoginForm;		
		$banip									= NULL;
		$wait									= false;
		$banip									= Yii::app()->eventManager->getBanIp();
		$siteSettingModel	  					=Sitesettings::model()->findByAttributes(array('id'=>'1'));
                
                $user = Yii::app()->getComponent('user');               
                $user->setFlash(
                    'warning',
                    "<strong>Advertencia!</strong> Ud ha excedido el número de intentos para autenticarse. Por favor, Regrese en:"
                );
                
		if($banip->penaltydate >= date('Y-m-d H:i:s'))
		{
			$wait								= true;
		}
		else 
		{		
			if(Yii::app()->user->getState('attempts-login') >1) { //make the captcha required if the unsuccessful attemps are more of thee
				$model->scenario 					= 'withCaptcha';
	
				if(isset($_POST['LoginForm']) && Yii::app()->user->getState('attempts-login') >=4)
				{		
					// Banea al usuario mediante su IP. Si no se envia el tiempo (parametro) por defecto son 15 minutos
					Yii::app()->eventManager->banIp($siteSettingModel->bantime);
					// resetea los intentos de login para el usuario
					Yii::app()->user->setState('attempts-login', 0);
					// redirecciona al indice
					$this->redirect('index.php');
				}			
			}		
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login()) {
					Yii::app()->user->setState('attempts-login', 0); //if login is successful, reset the attemps
					// Se registra el ingreso a la aplicación
					Yii::app()->eventManager->registerLogin();	
					// Se redirecciona a la Ultima URL				
					$this->redirect(Yii::app()->user->returnUrl);
				}
				else {//if login is not successful, increase the attemps 
					Yii::app()->user->setState('attempts-login', Yii::app()->user->getState('attempts-login', 0) + 1);
				}
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model,'wait'=>$wait,'penaltydate'=>$banip->penaltydate));
	}
	/**
	 * Displays the login page
	 */
	public function actionAutoLogin()
	{ 
                $this->layout   = "//layouts/login";
		$model          = new LoginForm;				
                $user           = Yii::app()->getComponent('user'); 
                
                $account        = $_SERVER['REMOTE_USER'];
                $extlogin       = substr(strrchr($account, '\\'), 1);
                // collect user input data
                if(isset($account))
                {
                    $model->attributes=array('username'=>$extlogin);
                    // validate user input and redirect to the previous page if valid
                    if($model->login()) {
                            Yii::app()->eventManager->registerLogin();	
                            // Se redirecciona a la Ultima URL				
                            $this->redirect(Yii::app()->user->returnUrl);
                    }
                    else{
                        $user->setFlash(
                                'error',
                                "<strong>Autenticaci&oacute;n fallida.</strong><br> El usuario: (".$extlogin.") no tiene permisos para acceder a esta aplicaci&oacute;n. Por favor, contacte el administrador."
                            );
                    }
                } 
                else{
                        $user->setFlash(
                                'error',
                                "<strong>Autenticaci&oacute;n fallida.</strong><br> El sistema no identifica la cuenta de usuario. Por favor, contacte el administrador."
                            );
                    }
                        
		// display the login form
		$this->render('autologin');
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
<?php
class FrontEndController extends Controller {
		
	
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
                return Yii::app()->sysSecurity->checkPermissions(); 
	}
	
	public function actionIndex()
	{	   
                $mensaje = 'Politicas de uso.....';                                        
                Yii::app()->user->setFlash('info', $mensaje);
		$this->render('index');
	}

	public function actionGlobalAdmin()
	{			
		$this->render('globalAdmin',array('modelMenu'=>$modelMenu,'htmloptions'=>$htmloptions));
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();	    
		$this->redirect('?r=site');
	}
}
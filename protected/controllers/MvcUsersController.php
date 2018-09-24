<?php

class MvcUsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/profile';
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{		
            return array(                    
                     array('allow', // allow authenticated user to perform 'create' and 'update' actions
                     'actions' => array('View'),
                     'users' => array('@'),
                     ),
                    );
        }

/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
        $obCriteria = new CDbCriteria();
        $obCriteria->condition  = 'samaccountname=:us';
        $obCriteria->params     = array(':us'=>Yii::app()->session['users']->samaccountname);
        $model                  = Users::model()->find($obCriteria);       
        $post                   = Yii::app()->request->getPost('Users');
        if(count($post)){
         $model->attributes     = $post;
         $saveResponse          = $model->save();
         
            if($saveResponse){
                Yii::app()->session['users']->cn =$post['cn'];
                Yii::app()->session['users']->mail =$post['mail'];
               $mensaje = 'Se ha actualizado el perfil..';  
               $type    = 'success';  
            }
            else{
               $mensaje = 'El perfil no pudo ser actualizado...';  
               $type    = 'error';  
            }
               Yii::app()->user->setFlash($type, $mensaje);

          }
		   if(strtolower(Yii::app()->user->isGuest)){
		   $mensaje = 'No tiene permisos para ver este sitio. Por favor, inicie sesión de nuevo.';  
            $type    = 'error';  
			Yii::app()->user->setFlash($type, $mensaje);
		   $this->render('../comunes/mensajes');
		   }
		   else{
				$this->render('/mvcUsers/view',array(
							  'model'=>$model,
				));
			}
	}    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MvcUsers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MvcUsers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La página no existe.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MvcUsers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mvc-users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}        
    
    /*
     * Método para subir la foto de perfil del usuario en sesión
     */
    public function actionUploadProfileImage() {
        $id = Yii::app()->generalFunctions->uploadFile($_FILES['MvcUsers'], $_POST['MvcUsers'],Yii::app()->session['file']->id);
        $model = new Attachment;
        $data = $model->findByPk($id);
        Yii::app()->session['file'] = $data;
        
        $userModel =Users::model()->findByAttributes(array('samaccountname'=>Yii::app()->session['users']->samaccountname));
        $userModel->scenario = 'updateProfileImage';  
        $userModel->pic_profile_id = $id;
        $userModel->SaveAttributes(array('pic_profile_id'));
        // lo almacena en session
        Yii::app()->session['users']->pic_profile_id = $id;        
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    
    /*
     * Método para mostrar las imágenes que se encuentran en la NAS
     */
    public function actionShowImage() {
        if(empty($_GET['file'])){ 
            Yii::app()->generalFunctions->fileInLine(Yii::app()->session['file']->filename,PATH_UPLOAD_REGISTROS);
        }else {
            Yii::app()->generalFunctions->fileInLine($_GET['file'],PATH_UPLOAD_REGISTROS);
        }
    }
}

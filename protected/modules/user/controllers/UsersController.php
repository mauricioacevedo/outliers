<?php

class UsersController extends Controller{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/main', meaning
	 * using two-column layout. See 'protected/views/layouts/main.php'.
	 */
	//public $layout='//layouts/main';
        /**
	 * @return array action filters
	 */
    public function beforeAction($action) {        
    	return Yii::app()->sysSecurity->checkUser();            
    }
	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function init(){
		header('Access-Control-Allow-Origin: '.SITE_URL);
		//header("Content-Security-Policy: default-src 'self'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';");
		//header("Content-Security-Policy: script-src 'self';");
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
	public function accessRules() {
		return Yii::app()->sysSecurity->checkPermissions(); 
	}
        	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			
			$check=$this->check_passwd($model->passwd);

			if($check!=""){
				$this->redirect(array('admin','msg'=>$check));
				return;
			}

			$model->passwd=crypt($model->passwd, Yii::app()->sysSecurity->blowfishSalt(13));
			$model->sn="Local";
			$model->cn=$model->givenname;

			$rol=$_POST['Users']['id_profile'];
			if($model->save()){
				$objDateTime = new DateTime('NOW');
				$dates=$objDateTime->format('Y-m-d H:i:s');
				$roles= new UsersRoles;
				$roles->rol=$rol;
				$roles->username=$model->samaccountname;
				$roles->creado_por=Yii::app()->user->name;
				$roles->fecha_creacion=$dates;
				$roles->modificado_por=Yii::app()->user->name;
				$roles->fecha_modificacion=$dates;
				$roles->save();
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}	

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionUpdate($id)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$model=$this->loadModel($id);
		//si ingresan un password, es decir, si passwd es != de vacio se implementa nuevamente el salt/crypt
		$model->passwd="";
	
		//$this->updatepasswords();
		//exit;
		//echo $output;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model2=$this->loadModel($id);
			
			if($model->passwd==""){//la constraseña continua igual
				$model->passwd=$model2->passwd;
			}else{//cambio la contraseña, debo encriptar 
				//valido primero si esta es una contraseña valida:
				
				$check=$this->check_passwd($model->passwd);

				if($check!=""){
					$this->redirect(array('admin','msg'=>$check));
					return;
				}
				$model->passwd=crypt($model->passwd, Yii::app()->sysSecurity->blowfishSalt(13));
			}

			if($model->save()){
				//echo $output;
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function updatepasswords(){
		
		$users=Users::model()->findAll(array("condition"=>"samaccountname not in ('admin','macevedg')"));
		$output="";
		foreach ($users as $user){
			$pass="Outliers".substr($user->samaccountname, -4);
			$pass2 = crypt($pass, Yii::app()->sysSecurity->blowfishSalt(13));
			$user->passwd=$pass2;
			$user->save();
			$output=$output."<br>User: ".$user->samaccountname.", p1: ".$user->passwd.", p2: ".$pass;
		}

		echo $output;
	}



	public function check_passwd($clave){
		$error_clave="";
		if(strlen($clave) < 8){
			$error_clave = "La clave debe tener al menos 8 caracteres";
			return $error_clave;
		}
		if(strlen($clave) > 20){
			$error_clave = "La clave no puede tener más de 20 caracteres";
			return $error_clave;
		}
		if (!preg_match('`[a-z]`',$clave)){
			$error_clave = "La clave debe tener al menos una letra minúscula";
			return $error_clave;
		}
		if (!preg_match('`[A-Z]`',$clave)){
			$error_clave = "La clave debe tener al menos una letra mayúscula";
			return $error_clave;
		}
		if (!preg_match('`[0-9]`',$clave)){
			$error_clave = "La clave debe tener al menos un caracter numérico";
			return $error_clave;
		}
		$error_clave = "";
		return $error_clave;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
    public function actionExport($type) {                            
        /*
        * Init dataProvider for first page
        */
       $model=new Users('search');
       $model->unsetAttributes();  // clear any default values
       if(isset($_GET['Users'])) {
          $model->attributes=$_GET['Users'];
       }
       $dataProvider = $model->search(false);
       
        $headers = array('user_id','givenname','sn','samaccountname','employeenumber','departmentnumber','department','id_profile'); 
        $html = '<style>
                    table
                    {
                    border-collapse:collapse;
                    }
                    table,th, td
                    {
                    border: 1px solid black;
                    }
                 </style>';
        $html .= '<table>';
        $html .= '<tr>';
        foreach($headers as $field) {
            $arrLabels[] = Users::model()->getAttributeLabel($field);
            $html .= '<td style="text-align:center; font-weight: bold;">'.Users::model()->getAttributeLabel($field).'</td>';
        }           
        $html .= '</tr>';
        $lines = '';
        foreach ($dataProvider->getData() as $model) {
            $line = '';
            $html .= '<tr>';
            foreach($headers as $key => $field) {                                   
                if($field == 'user_status') {
                    $line[]= $model->userstatu->status;                                            
                                                                                                              
                }else{
                    $line[]= $model->$field;    
                } 
                $html .= '<td>'.$model->$field.'</td>';
            }
            $html .= '</tr>';
            $lines .= implode(',', $line)."\r\n";  
        }
        $html .= '</table>';
       
        $filename = get_class();
        switch ($type) {
            case 'csv':
                    header('Content-type: text/csv');
                    header('Content-Disposition: attachment;  filename="'.$filename.'.csv"');
                    echo implode(',', $arrLabels)." \r\n";
                    echo $lines;
                break;
            case 'txt':
                    header('Content-type: application/txt');
                    header('Content-Disposition: attachment; filename="'.$filename.'.txt"');
                    echo implode(',', $arrLabels)." \r\n";
                    echo $lines;
                break;
            case 'word':
                    header('Content-type: application/vnd.ms-mord');
                    header('Content-Disposition: attachment; filename="'.$filename.'.doc"');
                    echo $html;
                break;
            case 'pdf':
                    $pdf = Yii::createComponent('application.extensions.mpdf.mpdf');
                    $format = 'A4';
                    $mpdf = new mpdf('', $format, 0, '', 15, 15, 16, 16, 9, 9, '-L');
                    $mpdf->use_embeddedfonts_1252 = true; // false is default
                    $mpdf->setAutoTopMargin = 'stretch';
                    //$html = iconv("UTF-8","UTF-8//IGNORE",$html);
                    $mpdf->WriteHTML($html);
                    $mpdf->Output($filename . '.pdf', 'D');
                break;
            default:
                break;
        }
        exit; 
     }
                
        
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
//Esta funcion es para reinicializar todos los password de los tecnologos al valor por defecto (Outliers + 4 ultimos digitos de la cedula)
		//$this->updatepasswords();
		if(Yii::app()->request->getParam('export')) {
			$this->actionExport(Yii::app()->request->getParam('type'));
			Yii::app()->end();
		}
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

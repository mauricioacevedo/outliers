<?php

class ContentController extends Controller
{
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
        	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Content;
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Content']))
		{
			$model->attributes=$_POST['Content'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->content_id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Content']))
		{
			$model->attributes=$_POST['Content'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->content_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
		$dataProvider=new CActiveDataProvider('Content');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
                    public function actionExport($type) {                            
                    /*
                    * Init dataProvider for first page
                    */
                   $model=new Content('search');
                   $model->unsetAttributes();  // clear any default values
                   if(isset($_GET['Content'])) {
                      $model->attributes=$_GET['Content'];
                   }              
                   $dataProvider = $model->search(false);
                   
                    $headers = array('content_id','category','content','published','date_init','date_end','creadopor','fechacreacion'); 
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
                        $arrLabels[] = Content::model()->getAttributeLabel($field);
                        $html .= '<td style="text-align:center; font-weight: bold;">'.Content::model()->getAttributeLabel($field).'</td>';
                    }           
                    $html .= '</tr>';
                    $lines = '';
                    foreach ($dataProvider->getData() as $model) {
                                $line = '';
                                $html .= '<tr>';
                                foreach($headers as $key => $field) {                                   
                                                                                                           $line[]= $model->$field; 
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
                                $html = iconv("UTF-8","UTF-8//IGNORE",$html);
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
	public function actionAdmin()
	{
				if(Yii::app()->request->getParam('export')) {
			$this->actionExport(Yii::app()->request->getParam('type'));
			Yii::app()->end();
		}
		$model=new Content('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Content']))
			$model->attributes=$_GET['Content'];

		$this->render('admin',array(
			'model'=>$model,
		));
			}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Content the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Content::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Content $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

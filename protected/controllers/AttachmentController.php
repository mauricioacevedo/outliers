<?php

class AttachmentController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @return array action filters
     */
    public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('admin'),
						'users'=>array('*'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
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
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Attachment;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Attachment'])) {
            $model->attributes = $_POST['Attachment'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Attachment'])) {
            $model->attributes = $_POST['Attachment'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Attachment');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
   
     public function actionExport($type) {                            
                /*
                * Init dataProvider for first page
                */
               $model=new Attachment('search');
               $model->unsetAttributes();  // clear any default values
               if(isset($_GET['Attachment'])) {
                  $model->attributes=$_GET['Attachment'];
               }              
               $dataProvider = $model->search(true);
                
                $headers = array(
                                'id',
                                'module_id',
                                'filename',
                                'filesize',
                                'filepath',
                                'zipfile'
                                ); 
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
                    $arrLabels[] = Attachment::model()->getAttributeLabel($field);
                    $html .= '<td style="text-align:center; font-weight: bold;">'.Attachment::model()->getAttributeLabel($field).'</td>';
                }           
                $html .= '</tr>';
                $lines = '';
                //foreach ($dataProvider->getData() as $data) {
                $page=0;
                
                while($models = $dataProvider->getData()) {
                    if($models){
                        foreach($models as $model) {
                            $line = '';
                            $html .= '<tr>';
                            foreach($headers as $field) {
                               $line[]= $model->$field;  
                               $html .= '<td>'.$model->$field.'</td>';
                            }
                            $html .= '</tr>';
                            $lines .= implode(',', $line)."\r\n";   
                        }  
                        unset($model,$dataProvider,$pg);
                        $model=new Attachment('search');
                        $model->unsetAttributes();  // clear any default values
                        if(isset($_GET['Attachment']))
                            $model->attributes=$_GET['Attachment'];

                        $dataProvider = $model->search(true);
                        $nextPage = $page+1;
                        $dataProvider->getPagination()->setCurrentPage($nextPage);
                        $page++;
                        if(($page*$dataProvider->getPagination()->getPageSize()) >= $model->count()){
                            break;
                        }
                    }
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
    public function actionAdmin() {
                $model=new Attachment('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Attachment']))
                        $model->attributes=$_GET['Attachment'];
                
                $this->render('admin',array(
                        'model'=>$model,
                ));               
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Attachment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Attachment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Attachment $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attachment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

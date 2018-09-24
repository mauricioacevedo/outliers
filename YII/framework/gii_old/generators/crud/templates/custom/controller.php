<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
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
		<?php if($this->accessRulesDefault){ ?>
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','actionBuscar<?php echo ucfirst($this->controller) ?>'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
		<?php }else{ ?>
                    return Yii::app()->sysSecurity->checkPermissions(); 
		<?php } ?>
	}
        <?php  if($this->createFindMethod){       
            $key            = $this->tableSchema->primaryKey;
            $i=0;
            foreach ($this->tableSchema->columns as $column => $arrPropertys) {
                if($i == 1){
                    $description    = $column;  
                }
                $i++;
            }
            ?>
        /**
	 * Find by name in the table
	 */
         public function actionBuscar<?php echo ucfirst($this->controller) ?>(){
                $request = trim($_GET['term']);
                if($request != ''){
                    $model=  <?php echo ucfirst($this->controller) ?>::model()->findAll(
                                                        array("select" => "<?php echo $key ?>, <?php echo $description ?>",
                                                              "condition"=>"<?php echo $description ?> like '%$request%'")
                                                            );
                    $data=array();
                    foreach($model as $get){
                        $data[] = array(
                                                    'label' => $get-><?php echo $description ?>,
                                                    'value'=> $get-><?php echo $key ?>,
                                                    'id'=> $get-><?php echo $key ?>
                                                );
                    }
                    $this->layout='empty';
                    echo CJSON::encode($data);
                }
        }
        <?php } ?>
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
		$model=new <?php echo $this->modelClass; ?>;
		
		// Uncomment the following line if AJAX validation is needed
		<?php if(!$this->enableAjaxValidation){	?>// <?php } ?>$this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
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
		<?php if(!$this->enableAjaxValidation){	?>// <?php } ?>$this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
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
		$dataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
        <?php if(!$this->generateReport){ ?>
            public function actionExport($type) {                            
                    /*
                    * Init dataProvider for first page
                    */
                   $model=new <?php echo $this->modelClass; ?>('search');
                   $model->unsetAttributes();  // clear any default values
                   if(isset($_GET['<?php echo $this->modelClass; ?>'])) {
                      $model->attributes=$_GET['<?php echo $this->modelClass; ?>'];
                   }              
                   $dataProvider = $model->search(false);
                   
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if($count<=7){
	 $arrHeaders[] =  $column->name;	 
	}
        if($column->isForeignKey){
                $key            = $this->tableSchema->foreignKeys[$column->name][1];
                $description    = $key;	
                $arrForeignColumns 	= Yii::app()->db->schema->tables[$this->tableSchema->foreignKeys[$column->name][0]]->columns;
                if(is_array($arrForeignColumns)){
                    foreach ($arrForeignColumns as $key1 => $arrColumn){
                            if($key1 != $key){
                                    $description = $key1;
                                    break;
                            }
                    }
                    $table  	= $this->tableSchema->foreignKeys[$column->name][0];                    
                    $table	= str_ireplace('tbl_p_', '', $table);
                    $table	= str_ireplace('tbl_', '', $table);
                    $table	= str_ireplace('_', '', $table);
                    $table = removeS($table);
                    $arrHeadersColumns[$column->name] = "\$model->".$table."->".$description;
                    $arrHeadersForeign[$column->name] = true;
                }
           }
	$count++;
} ?>
                    $headers = array(<?php echo "'".implode("','",$arrHeaders)."'" ?>); 
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
                        $arrLabels[] = <?php echo $this->modelClass; ?>::model()->getAttributeLabel($field);
                        $html .= '<td style="text-align:center; font-weight: bold;">'.<?php echo $this->modelClass; ?>::model()->getAttributeLabel($field).'</td>';
                    }           
                    $html .= '</tr>';
                    $lines = '';
                    foreach ($dataProvider->getData() as $model) {
                                $line = '';
                                $html .= '<tr>';
                                foreach($headers as $key => $field) {                                   
                                   <?php $z=0;
                                        foreach ($arrHeadersColumns as $field => $value) {                                            
                                            if($arrHeadersForeign[$field]){
                                                if($z==0){
                                            ?>
                                            if($field == '<?php echo $field?>') {
                                                 $line[]= <?php echo $value ?>;                                            
                                            <?php }else{ ?>
                                               }elseif($field == '<?php echo $field?>') {
                                                 $line[]= <?php echo $value ?>;  
                                            <?php } ?>                                                                                           
                                        <?php $z++; } ?>
                                    <?php } ?>
                                    <?php if(count($arrHeadersForeign)>0){ ?>
                                   }else{
                                        $line[]= $model->$field;    
                                    } 
                                    <?php }else{ ?>
                                    $line[]= $model->$field; 
                                    <?php } ?>
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
        <?php } ?>
        
        
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		<?php if($this->generateReport){ ?>
		$report_id						= <?php echo $this->reportId ?>;
		$objGridAuto 					= new GridAutomatic();
		$objGridAuto->accionesDefault	= true;
		$objGrid 						= $objGridAuto->createGrid($report_id,true);
		if($objGrid)
		{
			$objGrid->urlActionDefault =  Yii::app()->createUrl('<?php echo $this->modelClass; ?>/update').'&id=';
			$grid = $objGrid->renderGrid($objGrid->edit, $objGrid->add, $objGrid->del);
		}			
		$this->render('admin',array(
			'grid' => $grid
		));
		<?php }else{ ?>
		if(Yii::app()->request->getParam('export')) {
			$this->actionExport(Yii::app()->request->getParam('type'));
			Yii::app()->end();
		}
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'model'=>$model,
		));
		<?php } ?>
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return <?php echo $this->modelClass; ?> the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param <?php echo $this->modelClass; ?> $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

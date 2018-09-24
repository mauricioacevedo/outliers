<?php

class EvidenciasController extends Controller
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
    	//$this->enableCsrfValidation = false;
        return Yii::app()->sysSecurity->checkUser();

    }
	/**
	 * @return array action filters
	 */
	public function filters()
	{
	
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function init(){
		header('Access-Control-Allow-Origin: d-outliers.une.com.co');
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
		$model=new Evidencias;
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Evidencias']))
		{
			//print_r($_POST['Evidencias']);
			
			$model->attributes=$_POST['Evidencias'];
			if($model->save()){
			//salvo el modelo, habria que guardar las relaciones
				
				$arr=$_POST['Evidencias']['hallazgos'];
				$this->insertCrossRelations("Evidenciasxhallazgos",$arr,$model->id);

				$arr=$_POST['Evidencias']['solucion'];
				$this->insertCrossRelations("Evidenciasxsolucion",$arr,$model->id);

				$arr=$_POST['Evidencias']['motivo_outlier'];
                $this->insertCrossRelations("Evidenciasxmotivo",$arr,$model->id);

				$arr=$_POST['Evidencias']['diagnostico_tecnico'];
                $this->insertCrossRelations("Evidenciasxdiagnosticotecnico",$arr,$model->id);

				$arr=$_POST['Evidencias']['acciondemejora'];
                $this->insertCrossRelations("Evidenciasxacciondemejora",$arr,$model->id);

				//ahora guardo las imagenes
				$evidencia_antes = CUploadedFile::getInstancesByName('evidencia_antes');
				$evidencia_despues = CUploadedFile::getInstancesByName('evidencia_despues');
				
				$this->saveImages($evidencia_antes,"evidencia_antes",$model->id);
				$this->saveImages($evidencia_despues,"evidencia_despues",$model->id);
				
				$this->redirect(array('view','id'=>$model->id));
			}else{//ocurrio un error!!
				$this->redirect(array('admin','msg'=>'Ocurrio un error mientras se guardaba el registro de Evidencias'));
			}
			return;// a este punto jamas deberia llegar!!
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function saveImages($objectImage,$name,$evidencia_id){
		$LIMIT_IMAGES_ON_DB=4;
		//echo "Iniciando guardado de imagenes: $name";
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		//exit;
		//Para probar la escritura de un archivo en la ruta definida.
		//$filePath = DIRECTORY_SEPARATOR."datos".DIRECTORY_SEPARATOR."www".DIRECTORY_SEPARATOR."outliers".DIRECTORY_SEPARATOR."archivos".DIRECTORY_SEPARATOR;
		$filePath = "archivos".DIRECTORY_SEPARATOR;
	
		//$filePath = DIRECTORY_SEPARATOR."tmp".DIRECTORY_SEPARATOR."imagen_prueba_outlier.jpg";
		//$filePath = "http://d-outliers.une.com.co/archivos/";
		//$filePath = "archivos".DIRECTORY_SEPARATOR;
		//$filePath = ".".DIRECTORY_SEPARATOR."archivos".DIRECTORY_SEPARATOR;
		//$filePath = ".".DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR;
		//$rootPath = Yii::getPathOfAlias('webroot');
		//$rootPath .= DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Archivos".DIRECTORY_SEPARATOR."outlier".DIRECTORY_SEPARATOR."newfile.txt";
		//$netfilePath = "\\\\net-file\Web Intranet Dllo\Archivos\outlier";
		//echo "File Path: $filePath\n ";
		//echo "User: " . exec('whoami');
		//$myfile = fopen($filePath.$evidencia_id."_"."test.txt", "w") or die("Unable to open file!");
		//$txt = "John Doe\n";
		//fwrite($myfile, $txt);
		//$txt = "Jane Doe\n";
		//fwrite($myfile, $txt);
		//fclose($myfile);
		//exit;
		
		//condiciones adicionales para prevenir mas de 4 fotos!!!
		if($name=="evidencia_antes"){
			$queryimagenes=ImagenesAntes::model()->findAll(array("condition"=>"evidencia_id =  ".$evidencia_id));
		}else{
			$queryimagenes=ImagenesDespues::model()->findAll(array("condition"=>"evidencia_id =  ".$evidencia_id));
		}
		$counter=count($queryimagenes);

		if($counter>=$LIMIT_IMAGES_ON_DB){//aqui no se pueden hacer inserts, regreso!!!
			return;
		}
		//echo "<script>console.log('cantidad de imagenes $name : $counter');</script>";
		if (isset($objectImage) && count($objectImage) > 0) {
        	// go through each uploaded image
            foreach ($objectImage as $image => $pic) {
				if($counter>=$LIMIT_IMAGES_ON_DB){//si alcanzo el limite de imagenes me salgo!!!
					break;
				}
                //echo $pic->name.'<br />';
				//echo Yii::getPathOfAlias('webroot').'/assets/'.$evidencia_id."_".$pic->name;
				//$varii=$pic->saveAs(Yii::getPathOfAlias('webroot').'/assets/'.$evidencia_id."_".$pic->name);
				//var_dump($varii);
                    		//if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/assets/'.$evidencia_id."_".$pic->name)) {
				//echo $filePath.$evidencia_id."_".$pic->name;
                if ($pic->saveAs($filePath.$evidencia_id."_".$pic->name)) {
                	// add it to the main model now
					if($name=="evidencia_antes"){
						$img_add= new ImagenesAntes;
					} else {
						$img_add= new ImagenesDespues;
					}
                        		
					$img_add->nombre_archivo = $evidencia_id."_".$pic->name;
					//$img_add->path=Yii::getPathOfAlias('webroot').'/assets/'.$evidencia_id."_".$pic->name;
					$img_add->path=$filePath.$evidencia_id."_".$pic->name;
            		$img_add->evidencia_id = $evidencia_id; 

            		$img_add->save(); // DONE
					//var_dump($model->getErrors());
					
                } else{ 
					//throw new Exception();
					echo "Error saving images...";
					exit;
				}
				$counter++;
            }
		}
	}

	public function insertCrossRelations($crossModel,$arrays,$mainid){
		$size=count($arrays);
		//echo "<br>$crossModel";
		//var_dump($arrays);

                if($crossModel=='Evidenciasxmotivo'){
			Evidenciasxmotivo::model()->deleteAll("evidencia_id ='".$mainid."'");
                        for($i=0;$i<$size;$i++){
                                $modelx= new Evidenciasxmotivo;
                                $modelx->evidencia_id=$mainid;
                                $modelx->motivo_id=$arrays[$i];
                                $modelx->save();
                        }
                 }

                if($crossModel=='Evidenciasxdiagnosticotecnico'){
			Evidenciasxdiagnosticotecnico::model()->deleteAll("evidencia_id ='".$mainid."'");
                        for($i=0;$i<$size;$i++){
                                $modelx= new Evidenciasxdiagnosticotecnico;
                                $modelx->evidencia_id=$mainid;
                                $modelx->diagnostico_id=$arrays[$i];
                                $modelx->save();
                        }
                 }



		if($crossModel=='Evidenciasxhallazgos'){
			Evidenciasxhallazgos::model()->deleteAll("evidencia_id ='".$mainid."'");
			for($i=0;$i<$size;$i++){
				$modelx= new Evidenciasxhallazgos;
        	        	$modelx->evidencia_id=$mainid;
	                        $modelx->hallazgo_id=$arrays[$i];
                        	$modelx->save();
			}
                 }

                if($crossModel=='Evidenciasxsolucion'){
			Evidenciasxsolucion::model()->deleteAll("evidencia_id ='".$mainid."'");
                        for($i=0;$i<$size;$i++){
                                $modelx= new Evidenciasxsolucion;
                                $modelx->evidencia_id=$mainid;
                                $modelx->solucion_id=$arrays[$i];
                                $modelx->save();
                        }
                 }

		if($crossModel=='Evidenciasxacciondemejora'){
			Evidenciasxaccionmejora::model()->deleteAll("evidencia_id ='".$mainid."'");
                        for($i=0;$i<$size;$i++){
                                $modelx= new Evidenciasxaccionmejora;
                                $modelx->evidencia_id=$mainid;
                                $modelx->accionmejora_id=$arrays[$i];
                                $modelx->save();
                        }
                 }


	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		//return;
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Evidencias']))
		{
			//var_dump($_POST);
			//exit;
			$model->attributes=$_POST['Evidencias'];
			if($model->save()){
			//salvo el modelo, habria que guardar/actualizar las relaciones
				
				$arr=$_POST['Evidencias']['hallazgos'];
				$this->insertCrossRelations("Evidenciasxhallazgos",$arr,$model->id);

				$arr=$_POST['Evidencias']['solucion'];
				$this->insertCrossRelations("Evidenciasxsolucion",$arr,$model->id);

				$arr=$_POST['Evidencias']['motivo_outlier'];
                                $this->insertCrossRelations("Evidenciasxmotivo",$arr,$model->id);

				$arr=$_POST['Evidencias']['diagnostico_tecnico'];
                                $this->insertCrossRelations("Evidenciasxdiagnosticotecnico",$arr,$model->id);

				$arr=$_POST['Evidencias']['acciondemejora'];
                                $this->insertCrossRelations("Evidenciasxacciondemejora",$arr,$model->id);

				//ahora guardo las nuevas imagenes
				$evidencia_antes = CUploadedFile::getInstancesByName('evidencia_antes');
				$evidencia_despues = CUploadedFile::getInstancesByName('evidencia_despues');
				
				$this->saveImages($evidencia_antes,"evidencia_antes",$model->id);
				$this->saveImages($evidencia_despues,"evidencia_despues",$model->id);



				$this->redirect(array('view','id'=>$model->id));
			}
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
		//debemos borrar las imagenes de las tablas y del disco
		//ImagenesAntes::model()->deleteAll("id ='" . date('Y-m-d') . "'");
		//ImagenesDespues::model()->deleteAll("id ='" . date('Y-m-d') . "'");

		// funcionalidad esta ok, con esto restrinjo el borrado de registros hasta que se indique..
        $imagenes_antes=ImagenesAntes::model()->findAll(array("condition"=>"evidencia_id =  ".$id));
	    $imagenes_despues=ImagenesDespues::model()->findAll(array("condition"=>"evidencia_id =  ".$id));

		$i=count($imagenes_antes);

		for($j=0;$j<$i;$j++){
	        $img=$imagenes_antes[$j]->path;
	        unlink($img);
	        $imagenes_antes[$j]->delete();
		}

		$i=count($imagenes_despues);

        for($j=0;$j<$i;$j++){
            $img=$imagenes_despues[$j]->path;
            unlink($img);
            $imagenes_despues[$j]->delete();
        }

		$this->loadModel($id)->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAjax() {
		$type=$_GET["type"];

		if($type=="borrarImagenForm"){
			$this->borrarImagenForm();
		}

		//$this->redirect(array('view','id'=>'232'));
	}
	
	/**
	* Metodo para borrar las imagenes de las evidencias al momento en que se editan
	*/
	private function borrarImagenForm(){
		$id_imagen=$_GET["id_imagen"];
		$typeImage=$_GET["typeImage"]; 

		if($typeImage=="antes"){//borrar imagen de antes
			$imagenantes=ImagenesAntes::model()->findByPk($id_imagen); // assuming there is a post whose ID is 10
			$imagenantes->delete();
		}else{//borrar imagen despues
			$imagendespues=ImagenesDespues::model()->findByPk($id_imagen); // assuming there is a post whose ID is 10
			$imagendespues->delete();

		}
		echo "Imagen borrada exitosamente.";
		Yii::app()->end();
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Evidencias');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	//version de pruebas para el exporte de outliers
	public function actionExport($type) {
		$sql="SELECT a.id, a.pedido,a.documento_cliente,a.observaciones,a.descuento,a.rere,a.fecha_cerrado,".
//"(select contrato from contratos where id=a.contrato) as contrato,".
"(select producto from productos where id=a.producto) as producto,".
"(select nombre from tecnicos where id=a.tecnico_id) as tecnico,".
"(select nombre from revisores where id = a.revisor) as revisor,".
"(select plaza from plazas where id=a.plaza) as plaza,".
"(select responsable_dano from responsabledano where id=a.responsable_dano) as responsable_dano,".
"(select lider from lideresdeplaza where id=a.lider_de_plaza) as lider,".
"(select GROUP_CONCAT(h.hallazgo) from hallazgos h where h.id in (select t.hallazgo_id from evidenciasxhallazgos t where  t.evidencia_id=a.id) ) as hallazgos,".
"(select GROUP_CONCAT(k.diagnostico) from diagnosticotecnico k where k.id in (select t.diagnostico_id from evidenciasxdiagnosticotecnico t  where t.evidencia_id=a.id) ) as diagnostico,".
"(select GROUP_CONCAT(i.motivo) from motivo i where i.id in (select t.motivo_id from evidenciasxmotivo t where t.evidencia_id=a.id)) as  motivos,".
"(select GROUP_CONCAT(j.solucion) from solucion j where j.id in (select t.solucion_id from evidenciasxsolucion t where t.evidencia_id=a.id)) as soluciones, ".
"(select GROUP_CONCAT(l.accion) from acciondemejora l where l.id in (select t.accionmejora_id from evidenciasxaccionmejora t where t.evidencia_id=a.id)) as acciondemejora ".
" FROM evidencias a";

		
		$list= Yii::app()->db->createCommand($sql)->queryAll();
		$headers = array("id","pedido","documento_cliente","acciondemejora","observaciones","descuento","rere","fecha_cerrado","producto","tecnico","revisor","plaza","responsable_dano","lider","hallazgos","diagnostico","motivos","soluciones");

		foreach($headers as $field) {
                        $arrLabels[] = Evidencias::model()->getAttributeLabel($field);
                        //$html .= '<td style="text-align:center; font-weight: bold;">'.Evidencias::model()->getAttributeLabel($field).'</td>';
                }

		$rs=array();
		$lines="";
		foreach($list as $item){
		    //process each item here
			$sep="";
			$line="";
			foreach($headers as $field) {
				$data= str_replace(array("\r", "\n"), "",$item[$field]);
				//$buffer = str_replace(array("\r", "\n"), "", $buffer);
				$line.=$sep.$data;//$item[$field];
				$sep=";";
			}
			$lines .= $line."\r\n";
		    //$rs[]=$item['id'];
		}

		$filename = get_class();
                switch ($type) {
                        case 'csv':
                                header('Content-type: text/csv');
                                header('Content-Disposition: attachment;  filename="'.$filename.'.csv"');
                                echo implode(';', $arrLabels)." \r\n";
                                echo $lines;
                            break;
                        case 'txt':
                                header('Content-type: application/txt');
                                header('Content-Disposition: attachment; filename="'.$filename.'.txt"');
                                echo implode(';', $arrLabels)." \r\n";
                                echo $lines;
                            break;
		}
		exit;
		//return $rs;
	}
		
        public function actionExportOLD($type) {                            
                    /*
                    * Init dataProvider for first page
                    */
                   $model=new Evidencias('search');
                   $model->unsetAttributes();  // clear any default values
                   if(isset($_GET['Evidencias'])) {
                      $model->attributes=$_GET['Evidencias'];
                   }              
                   $dataProvider = $model->search(false);
                   
                    $headers = array('id','pedido','tecnico_id','hallazgos','solucion','acciondemejora','fecha_cerrado','cliente'); 
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
                        $arrLabels[] = Evidencias::model()->getAttributeLabel($field);
                        $html .= '<td style="text-align:center; font-weight: bold;">'.Evidencias::model()->getAttributeLabel($field).'</td>';
                    }
                    $html .= '</tr>';
                    $lines = '';
                    foreach ($dataProvider->getData() as $model) {
                                $line = '';
                                $html .= '<tr>';
                                foreach($headers as $key => $field) {                                   
                                         if($field == 'tecnico_id') {
                                                 $line[]= $model->tecnico->identificacion;
                                                      
                                          }elseif($field == 'hallazgos') {
                                                 $line[]= $model->hallazgos->hallazgo;  
                                         
                                          }elseif($field == 'solucion') {
                                                 $line[]= $model->solucion->solucion;  
                                                                                                                                       
                                          }elseif($field == 'producto') {
                                                 $line[]= $model->producto->producto;  
                                                                                                                                       
                                          }elseif($field == 'revisor') {
                                                 $line[]= $model->revisore->nombre;  
                                                                                                                                       
                                          }elseif($field == 'plaza') {
                                                 $line[]= $model->plaza->plaza;  
                                                                                                                                       
                                          }elseif($field == 'contrato') {
                                                 $line[]= $model->contrato->contrato;  
                                                                                                                                       
                                          }elseif($field == 'motivo_outlier') {
                                                 $line[]= $model->motivo->motivo;  
                                                                                                                                       
                                          }elseif($field == 'responsable_dano') {
                                                 $line[]= $model->responsabledano->responsable_dano;  
                                                                                                                                       
                                          }elseif($field == 'diagnostico_tecnico') {
                                                 $line[]= $model->diagnosticotecnico->diagnostico;  
                                                                                                                                       
                                          }elseif($field == 'lider_de_plaza') {
                                                 $line[]= $model->lideresdeplaza->lider;  
                                                                                                                                       
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
		//$headers = Yii::$app->request->headers;
		//var_dump(Yii::$app->request);

		$model=new Evidencias('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Evidencias']))
			$model->attributes=$_GET['Evidencias'];

		$this->render('admin',array(
			'model'=>$model,
		));
			}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Evidencias the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Evidencias::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Evidencias $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evidencias-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

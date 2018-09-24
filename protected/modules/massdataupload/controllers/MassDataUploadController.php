<?php

class MassDataUploadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/login';

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
    public function accessRules() {
        return Yii::app()->sysSecurity->checkPermissions();
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{ 
                $user                                           = Yii::app()->getComponent('user');               
                $dataUploadModel                                = new ImportToTable();
                $UploadFileModel                                = new UploadFile();                
                $EraseRecordModel                               = new EraseRecord();                
                
                $processList                                    = $dataUploadModel->UploadTableList();
                $erasableTableList                              = $dataUploadModel->ErasableTableList();
               
                $separatorList                                  = $dataUploadModel->separatorList;
                $delHeaderOptions                               = $dataUploadModel->delHeaderOptions;
                 
                if(isset($_POST['loadData'])){ 
                    $postUploadFile                         = Yii::app()->request->getPost('UploadFile');                    
                    $UploadFileModel->allowedSize = 5;
                    $UploadFileModel->extList = array('csv','txt');
                    $UploadFileModel->attributes=$postUploadFile;
                    $UploadFileModel->filename=CUploadedFile::getInstance($UploadFileModel,'filename'); 
                    Yii::app()->session['pathfile']             = UPLOADFILEPATH.Yii::app()->user->name.'_'.$UploadFileModel->filename->name;
                    Yii::app()->session['oldfilename']          = $UploadFileModel->filename->name;
                    if($UploadFileModel->validate()){
                        if($UploadFileModel->filename->saveAs(Yii::app()->session['pathfile']))
                        {          
                            ############################# GUARDAMOS EN SESION #############################                            
                            Yii::app()->session['process']       = $postUploadFile['process'];
                            Yii::app()->session['separator']     = $postUploadFile['separator'];
                            Yii::app()->session['deleteHeader']  = $postUploadFile['deleteHeader'];
                            #################################################################################
                            
                            $user->setFlash('success',"El archivo [".$UploadFileModel->filename->name."] ha sido cargado al sistema.");
                            
                            $dataUploadModel->fileRead           = true;
                            $dataUploadModel->file               = Yii::app()->session['pathfile'];                            
                            $dataUploadModel->separator          = Yii::app()->session['separator'];
                            $dataUploadModel->delHeader          = Yii::app()->session['deleteHeader'];                                                         
                            Yii::app()->session['arrayLoadData'] = $dataUploadModel->ArrayLoadData();                            
                        }
                        else
                        {
                            $user->setFlash('error',"El archivo [".$UploadFileModel->filename->name."] no pudo ser cargado al sistema. Intentelo de nuevo....");
                        }                            
                    }
                }                
                elseif(isset($_POST['import'])){
                    
                        $importResult                           = $this->actionImport($dataUploadModel);                         
                        $user->setFlash($importResult['type'],$importResult['message']);
                        $this->actionClearData(); 
                }
                elseif(isset($_POST['cancel'])){
                         $this->actionClearData(); 
                         $user->setFlash('info',"Proceso cancelado...");
                }elseif(isset($_POST['deleteRecord'])){
                    
                    $postEraseRecord                        = Yii::app()->request->getPost('EraseRecord');     
                    
                     $deleteRecords                      = $dataUploadModel->DeleteRecords($postEraseRecord['processErasable'],
                                                                                               $postEraseRecord['field'],
                                                                                               $postEraseRecord['startRecord'],
                                                                                               $postEraseRecord['finishRecord']);
                    if($deleteRecords==true){
                        $user->setFlash('success',"Los registros fueron eliminados correctamente....");
                    }
                    else{
                        $user->setFlash('error',"Los registros no pudieron ser eliminados... contacte al administrador");
                    }
                }
                $logData                                  = $dataUploadModel->importLogLastProcess();
                $allLogs                                  = $dataUploadModel->importLog(); 
                $cArrayLogData                            = array();
                if($logData ==null){
                    $logData                              = array();
                }else{
                    foreach ($logData['process'] as $keyLog =>$keyVal){                        
                        $cArrayLogData[]              = array('Proceso'=>$logData['process'][$keyLog],
                                                              'Fecha'=>$logData['import_date'][$keyLog],
                                                              'Usuario'=>$logData['user'][$keyLog],
                                                              'Contenido'=>$logData['content'][$keyLog]);
                    }
                } 
                
                $logData = $cArrayLogData;
                
                $cArrayLogData = array();
                 if($allLogs ==null){
                    $allLogs                          = array();
                }else{
                    foreach ($allLogs['process'] as $keyAllLog =>$keyAllVal){                        
                        $cArrayLogData[]              = array('Proceso'=>$allLogs['process'][$keyAllLog],
                                                              'Fecha'=>$allLogs['import_date'][$keyAllLog],
                                                              'Usuario'=>$allLogs['user'][$keyAllLog],
                                                              'Contenido'=>$allLogs['content'][$keyAllLog]);
                    }
                } 
                $allLogs = $cArrayLogData;
                
		$this->render('index',array('dataUploadModel'=>$dataUploadModel,
                                            'UploadFileModel'=>$UploadFileModel,
                                            'processList'=>$processList,
                                            'erasableTableList'=>$erasableTableList,
                                            'separatorList'=>$separatorList,
                                            'delHeaderOptions'=>$delHeaderOptions,
                                            'logData'=>$logData,
                                            'allLogs'=>$allLogs,
                                            'EraseRecordModel'=>$EraseRecordModel,
                            ));
	}
        
        protected function actionImport(&$dataUploadModel){
                   
            $dataUploadModel->fileRead              = false;
            $dataUploadModel->file                  = Yii::app()->session['pathfile'];                            
            $dataUploadModel->separator             = Yii::app()->session['separator'];
            $dataUploadModel->delHeader             = Yii::app()->session['deleteHeader'];
            $dataUploadModel->process               = Yii::app()->session['process'];            
            $dataUploadModel->preloadData           = Yii::app()->session['arrayLoadData']; 
            $dataUploadModel->functionImport        = Yii::app()->session['process'];
            $dataUploadModel->maxAllowedRows        = '10000';
            $dataUploadModel->oldfilename           = Yii::app()->session['oldfilename'];
            return $importResult                    = $dataUploadModel->importData();  
        }
        
        protected function actionClearData(){
            
            if(file_exists(Yii::app()->session['pathfile'])){
              unlink(Yii::app()->session['pathfile']);
            }
             unset(Yii::app()->session['pathfile']);
             unset(Yii::app()->session['arrayLoadData']);
             unset(Yii::app()->session['deleteHeader']);
             unset(Yii::app()->session['separator']);
             unset(Yii::app()->session['process']);    
        }
        
        public function actionListProcessField(){
            
                Yii::import('ext.cascadedropdown.ECascadeDropDown');
	   	ECascadeDropDown::checkValidRequest();	 	
                $dataUploadModel                       = new ImportToTable();
                $erasableTableField                    = $dataUploadModel->ErasableTableField(ECascadeDropDown::submittedKeyValue());
                ECascadeDropDown::renderArrayData($erasableTableField);                
	   	Yii::app()->end();
        }
	
}

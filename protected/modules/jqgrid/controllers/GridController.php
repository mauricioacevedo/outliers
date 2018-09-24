<?php
class GridController extends Controller
{
	public $layout = '';  
       
    function init(){
          $this->layout = 'dialog';
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
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('reload','createFile', 'export'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	/**
	 * Llama al método reaload de la Grid
	 */
	public function actionReload()
	{
		$sessionGrid	= new CHttpSession;
		$grid = new Grid();
		$grid->reload();
	}
	/**
	 * Llama al método expórtar de la Grid
	 */
	function actionCreateFile()
	{				
		$this->layout = '';
		if($_GET['columns'] != ''){		
			$gridObj = new Grid();
                        if($gridObj->export()){                            
                            exit;	
                        }else{
                            Yii::app()->user->setFlash('error', 'No posee permisos para exportar este archivo');  
                            $this->render('application.modules.jqgrid.views.mensajes');			
                        } 
		}else{
			$mensaje['error'][]		= 'Debe seleccionar al menos un campo para exportar';
			$vars['mensaje']		= $mensaje;				
		}			
	}
	/**
	 * Llama al método expórtar de la Grid
	 */
	function actionExport()
	{
		$tipo			= $_GET['tipo'];
		if ($_GET['name'] != ""){
			$name	= $_GET['name'];			
		}
		if($name != ''){			
			$session		= new CHttpSession;
			$session->open(); 
			$grid 			= unserialize($session["ObjGrid".$name]);
			$this->render('application.modules.jqgrid.views.export', array('grid'=>$grid, 'name'=>$name, 'tipo'=>$tipo));			
		}		
		
	}
}
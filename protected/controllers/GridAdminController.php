<?php

class GridAdminController extends Controller
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
	 * Create Manual Grid
	 */
	public function actionGrid()
	{ 
				
		$objGrid  = new Grid();
		$objGrid->setGrid('grid_test', 'tbl_reports', 'report_id', 'tbl_reports');
		$objGrid->setColProperty('report', 'report', 'report', array('label'=>'Report name','width'=>'160px', 'editable'=>'true', 'resizable'=>'true', 					
											'editrules'=> '{ edithidden:true}',
											'sortable' => 'true', 'edittype'=>'text',  'frozen'=>'true', 'searchtype'=>'text',   
										 	'searchoptions'=>"{sopt:['cn','nc','eq','bw','bn','ni','ew','en','in','ni']}",  
											'search' => 'true','align'=>'left',
											'fieldType' => '', 'fieldTableOrigin' => ''));
		$objGrid->setColProperty('field_key', 'field_key', 'field_key', array('label'=>'Field Key','width'=>'200px', 'editable'=>'true', 'resizable'=>'true', 					
											'editrules'=> '{ edithidden:true}',
											'sortable' => 'true', 'edittype'=>'text',  'frozen'=>'true', 'searchtype'=>'text',   
										 	'searchoptions'=>"{sopt:['cn','nc','eq','bw','bn','ni','ew','en','in','ni']}",  
											'search' => 'true','align'=>'left'));
		$objGrid->setColProperty('ppal_table', 'ppal_table', 'ppal_table', array('label'=>'Principal Table','width'=>'200px', 'editable'=>'true', 'resizable'=>'true', 					
											'editrules'=> '{ edithidden:true}',
											'sortable' => 'true', 'edittype'=>'text',  'frozen'=>'true', 'searchtype'=>'text',   
										 	'searchoptions'=>"{sopt:['cn','nc','eq','bw','bn','ni','ew','en','in','ni']}",  
											'search' => 'true','align'=>'left'));

		
		
		$grid = $objGrid->renderGrid(true, true, true, true);
		$this->render('Grid',array('model'=>$model, 'grid' => $grid)); 
		/*In the view*/
		/*
			<?php
			echo $grid; 
			?>
		*/
	}
	/**
	 * Create Grid From Table
	 */
	public function actionTableToGrid()
	{ 
				
		$objGrid  = new Grid();
		$objGrid->setGrid('grid_test', 'tbl_reports', 'report_id', 'tbl_reports');		
		$grid = $objGrid->tableToGrid('tableHtml');	
		$this->render('tableToGrid',array('model'=>$model, 'grid' => $grid)); 
		/*In the view*/
		/**
			<h1>Grid</h1>
			<table id="tableHtml">  
			  <tr> 
				 <th> header 1 </th> 
				 <th> header 2 </th>      
			  </tr> 
			  <tbody> 
				<tr> 
				  <td> data 1 </td> 
				  <td> data 1 </td>       
				</tr> 
			  </tbody> 
			</table>
			<?php
			echo $grid; 
			?>
		*/
	}
	/**
	 * Create Automatic Grid From Report_id
	 */
	public function actionGridAutomatic()
	{           
		$report_id				= $_GET['report_id'];
		$objGridAuto 				= new GridAutomatic();
		$objGridAuto->accionesDefault           = false;
		$objGrid 				= $objGridAuto->createGrid($report_id,true);	
		if($objGrid)
		{
                    $objGrid->options['shrinkToFit'] = false;
			$objGrid->haveAction		= false;
			$objGrid->inputSearch		= false;
			$grid = $objGrid->renderGrid($objGrid->edit, $objGrid->add, $objGrid->del);	
		}
		Yii::app()->eventManager->registerCrud();
		$this->render('Grid',array('model'=>$model, 'grid' => $grid)); 
		/*In the view*/
		/*
			<?php
			echo $grid; 
			?>
		*/
	}
	public function actionGridAdminSistemas()
	{
		$report_id						= $_GET['report_id'];
		$objGridAuto 					= new GridAutomatic();
		$objGridAuto->accionesDefault	= false;
		$objGrid 						= $objGridAuto->createGrid($report_id,true);	
		if($objGrid)
		{
			$objGrid->haveAction		= true;
			$objGrid->icons_img			= array($objGrid->pathGrid.'/pic/16x16/edit.png', $objGrid->pathGrid.'/pic/16x16/fields.png');
			$objGrid->icons_url			= array($objGrid->pathIndex.'?r=Grid/Reports/update', $objGrid->pathIndex.'?r=Grid/ReportsFields/admin');
			$objGrid->icons_title		= array('Edit Report', 'See Fields');
			$objGrid->icons_action		= array('THICKBOX','THICKBOX');
			$objGrid->icons_action_dim	= array('400|850','400|850');
			$objGrid->icons_fields	= array(array('id'=>'report_id'),array('report_id'=>'report_id'));
			$objGrid->inputSearch		= false;
			$grid = $objGrid->renderGrid($objGrid->edit, $objGrid->add, $objGrid->del);	
		}
		$gridExternas	= array('acceso'=>'URL','roles'=>'URL','privilegios'=>'url');
		
		Yii::app()->eventManager->registerCrud();
		$this->render('GridAdminSistemas',array('model'=>$model, 'grid' => $grid,'gridExternas'=>$gridExternas)); 
		/*In the view*/
		/*
			<?php
			echo $grid; 
			?>
		*/
	}
        
    public function actionGridAdminUsuarios()
	{ 		
		
		$report_id						= $_GET['report_id'];
		$objGridAuto                    = new GridAutomatic();
		$objGridAuto->accionesDefault	= false;
		$objGrid 						= $objGridAuto->createGrid($report_id,true);	
		if($objGrid)
		{
                    $objGrid->urlActionModalOptions = "width:1100, height:550";
                    $objGrid->icons_action = array('dialog');
                    $objGrid->icons_action_options = array("width:1200, height:500,title:'Ver Roles'");
                    $objGrid->haveAction = true;
                    $objGrid->icons_img = array(Yii::app()->theme->baseUrl . '/images/global/icoB-bloquear.png');
                    $objGrid->icons_url = array($objGrid->pathIndex . '?r=MvcUsers/AdminUsers');
                    $objGrid->icons_title = array('Edit Report');
                    $objGrid->icons_fields = array(array('user' => 'samaccountname', 'report_id' => 'id_informe'));
                    $objGrid->inputSearch = false;
                }
               $grid = $objGrid->renderGrid($objGrid->edit, $objGrid->add, $objGrid->del);
		$gridExternas	= array('acceso'=>'URL','roles'=>'URL','privilegios'=>'url');
		
		Yii::app()->eventManager->registerCrud();
		$this->render('GridAdminSistemas',array('model'=>$model, 'grid' => $grid,'gridExternas'=>$gridExternas)); 
		/*In the view*/
		/*
			<?php
			echo $grid; 
			?>
		*/
	}
        
        
        
}
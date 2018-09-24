<?php

class AjaxController extends Controller
{
	public $session	= '';		
	
	public function __construct() {
		$this->session	= new CHttpSession;
		$this->session->open();
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
						'actions'=>array('crud'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	/**
	 * Muestra el formulario de logueo.
	 */
	public function actionCrud()
	{
		$objAjax 	= new AjaxModel();
		$fields 	= '';
		$values 	= '';
		$table		= '';
		$fieldsFunc	= array();
		$where 		= '';
		$valor		= '';
                $report_id = $_SESSION['gridReportName'][$_POST["tableCrud"]];
                $objPermissionsModel = new PermissionsModel();            
                $rowRecordSetPermission = $objPermissionsModel->permissionsReports($report_id);                
		if(isset($_POST['type']))
		{			                    
			switch ($_POST['type'])
			{
				case 'insert':
                                        if ($rowRecordSetPermission['insert_']) {
                                            $arrFields = array();
                                            $arrValues = array();
                                            if($_POST['oper'] == 'add'){ 
                                                    $_POST['ignore'] = explode(",", $_POST['ignore'].',fieldsFunc');

                                                    if(isset($_POST["fieldsFunc"])){
                                                            $arrFieldsFunc	= explode(',', $_POST["fieldsFunc"]);
                                                    }
                                                    if(is_array(Yii::app()->session['extraFieldsFuncInsert'])){
                                                        foreach (Yii::app()->session['extraFieldsFuncInsert'] as $fun) {
                                                            $arrFieldsFunc[] = $fun;
                                                        }							
                                                    }
                                                    foreach ($_POST as $key => $valor)
                                                    {
                                                            if(!in_array($key, $_POST['ignore']))
                                                            { 
                                                                   $arrValues[] = $objAjax->formatSql($valor, $key, $arrFieldsFunc);
                                                                   $arrFields[] = $key;								
                                                            }
                                                    }

                                                    if(is_array(Yii::app()->session['extraParamsInsert'])){
                                                        foreach (Yii::app()->session['extraParamsInsert'] as $campo => $myvalue) {
                                                            $arrValues[] = $objAjax->formatSql($myvalue, $campo, $arrFieldsFunc);
                                                            $arrFields[] = $campo;
                                                        }
                                                    }

                                                    /**
                                                     * Se cambia a una varible de session para evitar porsibles vulnerabilidades
                                                     * se debe definir una variable de session y enviar su nombre para determinar cual es
                                                     */
                                                    $table	= $_SESSION['sqlTableCrud'][$_POST["tableCrud"]];						
                                            }					
                                            echo $objAjax->insert($table, $arrFields, $arrValues);
                                        }else{
                                            echo "No posee permisos para ejecutar esta acción";
                                        }
					break;			
				case 'update':
                                    if ($rowRecordSetPermission['edit']) {    
					/*
					 * Guardado automatico con la grid
					 */
					$_POST['ignore'] = explode(",", $_POST['ignore'].',fieldsFunc'); 
					if($_POST['oper'] == 'edit'){
                                                if(isset($_POST["fieldsFunc"])){
							$arrFieldsFunc	= explode(',', $_POST["fieldsFunc"]);
						}
                                                if(is_array(Yii::app()->session['extraFieldsFuncUpdate'])){
                                                    foreach (Yii::app()->session['extraFieldsFuncUpdate'] as $fun) {
                                                        $arrFieldsFunc[] = $fun;
                                                    }							
						}
                                                
						foreach ($_POST as $key => $valor)
						{
							if(!in_array($key, $_POST['ignore']))
							{
                                                                $arrSql[] = $objAjax->formatSqlUpdate($valor, $key, $arrFieldsFunc);                                                                
							}
						}
                                                if(is_array(Yii::app()->session['extraParamsEdit'])){
                                                    foreach (Yii::app()->session['extraParamsEdit'] as $campo => $myvalue) {
                                                        $arrSql[] = $objAjax->formatSqlUpdate($myvalue, $campo, $arrFieldsFunc);							
                                                    }
                                                }
						
						$table	= $_SESSION['sqlTableCrud'][$_POST["tableCrud"]];		
						if(isset($_POST["key"]) && isset($_POST["id"]) && $_POST["key"] != '' && $_POST["id"] != ''){				
							$where	= $_POST["key"]." = '".mysql_escape_string($_POST["id"])."'";
						}
                                                
                                                $whereCrud = $_SESSION['whereUpdate'][$_POST["tableCrud"]];	
						if(isset($whereCrud) && $whereCrud != ''){				
							$where	.= " ".$whereCrud;
						}
						
						$fields	= substr($fields,0,-1);
						$values	= substr($values,0,-1);
					} 
					echo $objAjax->update($table, $arrSql, $where);
                                    }else{
                                         echo "No posee permisos para ejecutar esta acción";
                                    }
					break;
				case 'delete':
                                    if ($rowRecordSetPermission['delete_']) {
					if(isset($_POST["key"]) && isset($_POST["id"])){
						$where	= $_POST["key"]." = '".mysql_escape_string($_POST["id"])."'";
					}
                                        $whereCrud = $_SESSION['whereDelete'][$_POST["tableCrud"]];	
                                        if(isset($whereCrud) && $whereCrud != ''){				
                                                $where	.= " ".$whereCrud;
                                        }
					$tableCrud		= $this->session['sqlTableCrud'][$_POST["tableCrud"]];                                        
					echo $objAjax->delete($tableCrud, $where);
                                    }else{
                                         echo "No posee permisos para ejecutar esta acción";
                                    }
					break;
			}
		}
		elseif(isset($_GET['type']))
		{			
			if(isset($_GET["where"])){
				$where = $_GET["where"];
			}
			if(isset($_GET["valor"])){
				$valor = $_GET["valor"];
			}
			switch ($_GET['type'])
			{
				case 'selectGrid':
					$table		= $_SESSION['sqlTableCrud'][$_GET["tableCrud"]];
					$recordSet 	=  $objAjax->consulta($table, $_GET["field"], $_GET["fields"], $valor, $where);
					$select 	= '<select>';
					while($rowRecordSet = $this->bd->dbFetchAssoc($recordSet))
					{ 
						$select .= '<option value="'.$rowRecordSet['field'].'">'.$rowRecordSet['descripcion'].'</option>';						
					}
					$select 	.= '</select>';
					echo $select;
					break;
				case 'consultar':
					$table 	= $_SESSION['sqlTableCrud'][$_GET["tableCrud"]];
					$sql	= $_SESSION['sqlConsultarCrud'][$_GET["sql"]];
					echo $objAjax->consulta($table, $_GET["field"], $_GET["fields"], $valor, $where, $_GET["json"], $sql);
					break;
				case 'consultaToJson':
					$table = $_SESSION['sqlTableCrud'][$_GET["tableCrud"]];
					echo $objAjax->consultaToJson($_GET["select"], $table, $where);
					break;
			}
		}
	}
}
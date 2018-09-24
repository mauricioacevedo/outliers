<?php
/**
 * Clase AppModel
 * Modelo AppModel, es el super modelo de donde se ejecutan los métodos más comunes
 * @access	public
 * @author	Jorge Arzuaga <jorgearzuaga1@hotmail.com>
 */
class PermissionsModel {
	protected $bd = '';
	
	public function __construct(){
		$this->bd = Yii::app()->db;
	}	
	/**
	 * 
	 * Éste método devuelve los permisos para los reportes en un array asociativo que contenga las siguientes claves
	 * excel,pdf,word,txt,insert_,edit,delete_,view_
	 * 
	 * @author jarzuas
	 * 16/10/2013
	 *
	 * @param int $report_id
	 *
	 * @return array
	 */	
	function permissionsReports($report_id){            
                $roles = "'".implode("','", Yii::app()->session['nombre_roles_delphos'])."'";
                $model = ReportsPermissionsRoles::model()->find(array('condition'=>'report_id='.(int)$report_id.' AND rol IN ('.$roles.')'));                
		/**
		 * Obtengo los permisos de exportar archivos de la grid
		 */
		if(!$model){			
                    $arrPermission = 	array('insert_'  => false,'edit' => false, 'delete_' => false, 'view_' => false,
					'excel' => false, 'pdf'  => false, 'word' => false, 'txt'  => false);
		}else{
                    $arrPermission = 	array('insert_'  => (bool)$model->insert_,'edit' => (bool)$model->edit, 
                                        'delete_' => (bool)$model->delete_, 'view_' => (bool)$model->view_,
					'excel' => (bool)$model->excel, 'pdf'  => (bool)$model->pdf, 
                                        'word' => (bool)$model->word, 'txt'  => (bool)$model->txt);
		}
		return $arrPermission;
	}
	
}
<?php
/**
 * Clase AppModel
 * Modelo AppModel, es el super modelo de donde se ejecutan los métodos más comunes
 * @access	public
 * @author	Jorge Arzuaga <jorgearzuaga1@hotmail.com>
 */
class AppModel {
	protected $bd = '';
	
	public function __construct(){
		$this->bd = Yii::app()->db;
	}
	/**
	 *
	 *
	 * Éste método retorna un recordset del resultado de consulta a tbl_reports_fields pasando como parametros
	 * el nombre dle programa y la condición
	 * 
	 * @param string $intInformeId        	
	 * @param string $where        	
	 */
	function getFieldstable($report_id, $where = '', $order_by = ''){
		if($order_by == '')
			$order_by = "ORDER BY show_in_grid DESC, order_field ASC";
		else
			$order_by = "ORDER BY " . $order_by;
		
		if($where != '')
			$where = " AND " . $where;
		
		$sql = "SELECT tbl_reports_fields.*, tbl_reports_field_type.field_type
						FROM
							tbl_reports_fields
							Inner Join tbl_reports_field_type ON tbl_reports_fields.field_type_id = tbl_reports_field_type.field_type_id
				          WHERE
				          		table_field != '' AND report_id = :report_id
				          		" . $where . "
				          		" . $order_by;
		$command = $this->bd->createCommand($sql);
		$recordSet = $command->query(array(':report_id' => $report_id));
		return $recordSet;
	}	
	/**
	 * Éste metodo crea la condición de tbl_informes_campo a partir de un tipo de campo where
	 * @param string $report_id
	 */
	function whereFieldsTable($report_id)
	{
		$command 	= $this->bd->createCommand("SELECT table_field,field FROM tbl_reports_fields WHERE report_id=:report_id AND field_where = '1' ");
		$recordSet 	= $command->query(array(':report_id' => $report_id));
		$where		= array();
		while(($rowRecordset = $recordSet->read())!==false)				
		{
			if(isset($_REQUEST[$rowRecordset['field']]))
			{
				$where[]= $rowRecordset['table_field'].".".$rowRecordset['field']." = '".$_REQUEST[$rowRecordset['field']]."'";
			}
		}
		$where = implode(" AND ", $where);
		return $where;
	}
}
<?php

/**
 * Clase db
 * Esta clase realiza todos los procesos con la base de datos
 * @access	public
 */
class ReportModel {

    protected $bd = '';
    public $report_id = '';
    public $foreign_keys = '';
    public $foreign_fields = '';
    public $foreign_fields_desc = '';
    public $error = false;
    public $errorMessage = false;

    public function __construct($username = '', $password = '', $host = 'localhost', $database = '') {
        if ($username != '' && $password != '' && $host != '' && $database != '') {
            $dsn = $typeBd . ":host=" . $host . ";dbname=" . $database;
            $this->bd = new CDbConnection($dsn, $username, $password);
        } else {
            $this->bd = Yii::app()->db;   // assuming you have configured a "db" connection
        }
    }

    /**
     *
     * Método para devolver las tablas del schema
     */
    function getTables() {

        return $this->bd->getSchema()->tableNames;
    }

    /**
     *
     * Método para devolver las columnas de una tabla del schema
     */
    function getFieldsTables($table) {
        return $this->bd->schema->tables[$table]->columns;
    }

    /**
     *
     * Método para devolver las tablas del schema
     */

    /**
     * 
     * Éste método...
     * @author jarzuas
     * 8/10/2013
     *
     * @param string $table
     * @param array $arrFields
     * @param array $fields
     * @param array $fieldsName
     *
     */
    function createGridReport($reportName, $field_key, $table, $arrFields, $fields = array(), $fieldsName, $sql_query = '') {
        $bd = Yii::app()->params['jqgrid']['dbname_base'];
        $sql = "SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME, TABLE_SCHEMA
						FROM information_schema.`KEY_COLUMN_USAGE`
						WHERE `CONSTRAINT_SCHEMA` = :bd AND `TABLE_NAME` = :table AND `REFERENCED_TABLE_SCHEMA` IS NOT NULL";
        $command = $this->bd->createCommand($sql);
        $recordSet = $command->query(array(':bd' => $bd, ':table' => $table));
        while (($rowRecordSet = $recordSet->read()) !== false) {
            $this->foreign_keys[$rowRecordSet['COLUMN_NAME']]['REFERENCED_TABLE_NAME'] = $rowRecordSet['REFERENCED_TABLE_NAME'];
            $this->foreign_keys[$rowRecordSet['COLUMN_NAME']]['REFERENCED_COLUMN_NAME'] = $rowRecordSet['REFERENCED_COLUMN_NAME'];
            $i = 1;
            $command = $this->bd->createCommand("DESCRIBE " . $rowRecordSet['TABLE_SCHEMA'] . "." . $rowRecordSet['REFERENCED_TABLE_NAME']);
            $recordSet2 = $command->query();
            while (($rowRecordSet2 = $recordSet2->read()) !== false) {
                /**
                 * Solo obtengo la segunda columna, por lo general ésta siempre trae la descripción del id asociado
                 */
                if ($i == 2) {
                    $this->foreign_fields[] = $rowRecordSet['COLUMN_NAME'];
                    $this->foreign_fields_desc[$rowRecordSet['COLUMN_NAME']] = $rowRecordSet2['Field'];
                    break;
                }
                $i++;
            }
        }
        $transaction = $this->bd->beginTransaction();
        $modelReports = new Reports;
        try {
            $modelReports->attributes = array(
                'report' => $reportName,
                'description' => $reportName,
                'host' => '',
                'bd' => $bd,
                'ppal_table' => $table,
                'field_key' => $field_key,
                'sql_query' => $sql_query
            );
            if ($modelReports->save()) {
                $this->report_id = $modelReports->report_id;
            } else {
                $this->errorMessage = implode('<BR>', $modelReports->getErrors());
                $this->error = true;
            }
        } catch (Exception $e) {
            $this->error = true;
            $this->errorMessage = $e->getMessage();
        }

        if ($this->report_id > 0 && $sql_query == '') {
            $order_field = 0;
            foreach ($fields as $field => $value) {
                if ($field != $field_key) {
                    $this->createField($table, $this->report_id, $field, $fieldsName[$field], $order_field++, $arrFields[$field]);
                    if ($this->error) {
                        break;
                    }
                }
            }
        }
        if ($this->error) {
            $transaction->rollback();
        } else {
            $transaction->commit();
        }
        return $this->bd->schema->tables[$table]->columns;
    }

    /**
     * 
     * Éste método crea el registro en la tabla tbl_reports_fields
     * @author jarzuas
     * 8/10/2013
     *
     * @param string $table
     * @param int $report_id
     * @param string $field
     * @param string $label
     * @param int $order_field
     * @param array $arrFields
     */
    function createField($table, $report_id, $field, $label, $order_field, $arrFields) {
        $select_sql = "";
        $select_filtro = "";
        $required = 0;
        $type = $arrFields->type;
        $length = $arrFields->size;
        if (!$arrFields->allowNull) {
            $required = 1;
        }
        $isForeignKey = $arrFields->isForeignKey;
        $inputText = false;
        $inputCheckbox = false;
        $formatOptions = '';
        if ($type == 'int' || $type == 'tinyint' && $type == 'smallint' &&
                $type == 'mediumint' || $type == 'bigint' || $type == 'integer') {
            if ($length == 1) {
                $inputCheckbox = true;
                $field_type_id = 3;
            } else {
                $field_type_id = 11;
            }
        } elseif ($type == 'datetime' || $type == 'date') {
            $inputText = true;
            $field_type_id = 5;
            $formatOptions = "srcformat : 'Y-m-d',	newformat : 'Y-m-d'";
        } else {
            $inputText = true;
            $field_type_id = 1;
        }
        $sql = array(
            'report_id' => $report_id,
            'order_field' => $order_field,
            'table_field' => $table,
            'required' => $required,
            'field' => $field,
            'alias' => $field,
            'label' => $label,
            'format_options' => $formatOptions,
            'align' => 'left',
            'field_type_id' => $field_type_id
        );
        if (!empty($this->foreign_keys)) {
            if (!$inputCheckbox && $this->foreign_keys[$field]['REFERENCED_COLUMN_NAME'] != '' && $this->foreign_keys[$field]['REFERENCED_COLUMN_NAME'] != '' && $this->foreign_fields_desc[$field] != '') {
                $select_sql = "SELECT " . $this->foreign_keys[$field]['REFERENCED_COLUMN_NAME'] . ", " . $this->foreign_fields_desc[$field] . " FROM " . $this->foreign_keys[$field]['REFERENCED_TABLE_NAME'] . " ORDER BY " . $this->foreign_fields_desc[$field];
                $select_filtro = "SELECT " . $this->foreign_keys[$field]['REFERENCED_COLUMN_NAME'] . ", " . $this->foreign_fields_desc[$field] . " FROM " . $this->foreign_keys[$field]['REFERENCED_TABLE_NAME'] . " ORDER BY " . $this->foreign_fields_desc[$field];
                $sql['select_sql'] = $select_sql;
                $sql['field_type_id'] = 100;
                $sql['field_id_list'] = $this->foreign_keys[$field]['REFERENCED_COLUMN_NAME'];
                $sql['field_desc_list'] = $this->foreign_fields_desc[$field];
                $sql['foreign_table'] = $this->foreign_keys[$field]['REFERENCED_TABLE_NAME'];
                $sql['foreign_table_field_id'] = $this->foreign_keys[$field]['REFERENCED_COLUMN_NAME'];
                $sql['foreign_table_desc'] = $this->foreign_fields_desc[$field];
                $sql['select_filter'] = $select_filtro;
            }
        }
        $modelReportsFields = new ReportsFields();
        try {
            $modelReportsFields->attributes = $sql;
            if ($modelReportsFields->save()) {
                $report_id = $modelReportsFields->field_id;
            } else {
                foreach ($modelReportsFields->getErrors() as $key => $error) {
                    $this->errorMessage .= $error[0] . "<br>";
                }
                $this->error = true;
            }
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            $this->error = true;
        }
    }

}

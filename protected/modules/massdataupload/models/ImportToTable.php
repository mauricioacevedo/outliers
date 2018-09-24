<?php

Yii::import('massdataupload.particularFunctions.particularFunction',true);
/**
 * Esta clase Define el modelo del formulario Consultas
 * para la consulta de datos de usuario.
 * 
 * @package Consultas
 */
class ImportToTable {

    //campos del modelo
    public $attachfile;    
    public $preloadData			 = array();
    public $maxAllowedRows               = "10000";
    public $table			 = null;
    public $database			 = null;
    public $fileRead			 = false;
    public $separator			 = null;
    public $separatorList		 = array(','=>',',';'=>';','*'=>'*','|'=>'|');
    public $file			 = null;
    public $process			 = null;
    public $delHeader			 = null;
    public $delHeaderOptions     	 = array('0'=>'No','1'=>'Si');
    public $delRegs			 = null;
    public $module_id			 = null;
    public $functionImport               = null;
    public $oldfilename                  = null;    
    public $content                      = "";    
    protected $db                        = '';

    public function __construct(){
        $this->db = Yii::app()->db;
	}    
    /**
     * Se encarga de cargar las tablas a las que el usuario tenga permiso
     */
    function UploadTableList(){
        $rowResponse        = array();
        try {            
            $command 	= $this->db->createCommand("SELECT i.tabla,i.alias"
                                                . " FROM  ".TABLE_PREFIX."import_data i");
            $recordSet 	= $command->query();            
            while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse[$rowRecordset['alias']]     = $rowRecordset['alias'];
		}
            
                return $rowResponse;
        } catch (Exception $e) {
             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:UploadTableList',$e->getMessage());
        }
    }    
    /**
     * Se encarga de buscar las tablas que permiten eliminar registros
     */
    function ErasableTableList(){
        $rowResponse        = array();
        try {            
            $command 	= $this->db->createCommand("SELECT i.tabla,i.alias"
                                                . " FROM  ".TABLE_PREFIX."import_data i"
                                                . " WHERE eliminable =1 ;");
            $recordSet 	= $command->query();            
            while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse[$rowRecordset['alias']]     = $rowRecordset['alias'];
		}
            
                return $rowResponse;
        } catch (Exception $e) {
             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:ErasableTableList',$e->getMessage());
        }
    }  
     /**
     * Se encarga de buscar los campos de las tablas tablas que permiten eliminar registros
     */
    function ErasableTableField($alias=''){
        
        try {    
            $rowResponse        = array();
            $field              = array();
            $table              = array();
            if(strlen($alias)>1){
               
                $command 	= $this->db->createCommand("SELECT tabla "
                                                          . "FROM ".TABLE_PREFIX."import_data i "
                                                          . "WHERE alias ='".$alias."';");
                $recordSet 	= $command->query(); 
                $table          = $recordSet->read();
                
                $command 	= $this->db->createCommand("DESCRIBE ".$table['tabla']."  ;");
                $recordSet 	= $command->query();                 
               
                while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse[$rowRecordset['Field']]     = $rowRecordset['Field'];
		}
                
            }
            else{
                $rowResponse = false;
            }            
                return $rowResponse;
        } catch (Exception $e) {
             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:ErasableTableField',$e->getMessage());
        }
    }
     /**
     * Se encarga de eliminar registros
     */
    function DeleteRecords($alias='',$field='',$startRecord='',$finishRecord=''){
        
        try {    
            $rowResponse        = array();
            $table              = array();
            if(strlen($alias)>0 && strlen($field)>0 && strlen($startRecord)>0 && strlen($finishRecord)>0){
                
                $command 	= $this->db->createCommand("SELECT tabla "
                                                          . "FROM ".TABLE_PREFIX."import_data i "
                                                          . "WHERE alias ='".$alias."';");
                $recordSet 	= $command->query(); 
                $table          = $recordSet->read();
                
                $sql            = "DELETE FROM ".$table['tabla']." "
                                                          . " WHERE ".$field." BETWEEN '".$startRecord."'"
                                                          . " AND '".$finishRecord."' ;";
                
                $command 	= $this->db->createCommand($sql);
                
                $recordSet 	= $command->query(); 
                
                 Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-2','fx:DeleteRecords',  addslashes($sql));
                $rowResponse    = true;
            }
            else{
                $rowResponse = false;
            }              
                return $rowResponse;
        } catch (Exception $e) {
             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:DeleteRecords',$e->getMessage());
        }
    }
    /**
     * Consulta los logs de carga de datos
     */
    function importLog(){
        
        try {  
            $command 	= $this->db->createCommand("SELECT *"
                                                . " FROM  ".TABLE_PREFIX."import_data_log l "                                                
                                                . " ORDER BY import_date DESC ;");
            $recordSet 	= $command->query();            
            while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse['process'][]     = $rowRecordset['process'];
                    $rowResponse['import_date'][] = $rowRecordset['import_date'];
                    $rowResponse['user'][]        = $rowRecordset['user'];
                    $rowResponse['content'][]     = $rowRecordset['content'];
		}
            
                return $rowResponse;
        } catch (Exception $e) {
             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:importLog',$e->getMessage());
        }
    }   
    /**
     * Consulta los logs de carga de datos (solo la ultima fecha de cada proceso)
     */
    function importLogLastProcess(){
        
        try {  
            
            $command 	= $this->db->createCommand("SELECT l.process, 
                                                    MAX(l.import_date) as 'import_date', 
                                                    MAX(l.`user`) as 'user', 
                                                    MAX(l.content) as 'content'
                                                    FROM  ".TABLE_PREFIX."import_data_log l
                                                    WHERE l.cod_response = 0 
                                                    GROUP BY l.process
                                                    ORDER BY l.process ASC");
            $recordSet 	= $command->query();            
            while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse['process'][]     = $rowRecordset['process'];
                    $rowResponse['import_date'][] = $rowRecordset['import_date'];
                    $rowResponse['user'][]        = $rowRecordset['user'];
                    $rowResponse['content'][]     = $rowRecordset['content'];
		}
            
                return $rowResponse;
        } catch (Exception $e) {
             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:importLogLastProcess',$e->getMessage());
        }
    }   
   /**
    * retorna un arreglo con las columnas del archivo plano
    * @return array
    */
    function ArrayLoadData() {
        try {
            if ($this->fileRead == true) {
                $countlines         = 0;
                $lines              = file($this->file);
                $data               = array();
                $rowData            = array();
                $row                = array();
                $column             = count(explode($this->separator, trim($lines[0])));
                $flag               = false;
                if ($this->delHeader == '1') {
                    $flag           = true;
                }
                foreach ($lines as $line) {
                    $countlines ++;
                    $row            = explode($this->separator, trim($line));
                    for($i=0;$i<$column;$i++){
                      $rowData['columna_'.($i+1)]  = $row[$i];                      
                    }
                    if ($flag) {
                          $rowData['acciones']     = 'Ignorar';
                          $flag                    = false;
                      }
                      else{
                          $rowData['acciones']    = 'Insertar';  
                      }
                    $data           = array_merge(array($rowData),$data);
                }
                    $data           = array_reverse($data);
                return $data;
            }
        } catch (Exception $e) {
            Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1','fx:ArrayLoadData',$e->getMessage());
        }
    }    
    /**
    * Importa los datos a la tabla
    * @return array
    */
    function importData() {
        try {
            $importDataInfo             = array();
            $values                     = array();
            $skip                       = false;
            if (file_exists($this->file)) {                
                
               /**
                *  CONSULTAMOS LA TABLA  Y LA BASE DE DATOS A IMPORTAR
                */
                $command                = $this->db->createCommand("SELECT bd,tabla "
                                                                . " FROM ".TABLE_PREFIX."import_data"
                                                                . " WHERE alias = '".$this->process."' LIMIT 1 ;");
                $recordSet              = $command->query();   
                $rowRecordset           = $recordSet->read();
                
                $this->database         = $rowRecordset['bd'];
                $this->table            = $rowRecordset['tabla'];
                
                /**
                 *  CONSULTAMOS LOS CAMPOS DE LA TABLA
                 */                
                $command                = $this->db->createCommand("DESCRIBE ".$this->table." ;");
                $recordSet              = $command->query(); 
                $rowCount               = $recordSet->rowCount;
                
                 while(($rowRecordset   = $recordSet->read())!==false)				
                    {
                        $importDataInfo['field'][]     = $rowRecordset['Field'];
                    }
                
                 $importDataInfo['filezise']   = filesize($this->file) . ' bytes';
                 $importDataInfo['numrows']    = count($this->preloadData);
                 $importDataInfo['numcolumns'] = count($this->preloadData[0])-1;                  
                 /**
                  * Se compara si las columnas del archivo son iguales a las de la tabla a importar
                  * El -1, es debido a que en la funcion ArrayLoadData(), 
                  * se agrega una ultima columna con la accion sobre el registro a importar
                  */
                 if($importDataInfo['numcolumns'] == $rowCount){
                     
                     if($importDataInfo['numrows']>$this->maxAllowedRows){
                        $importDataInfo['type']     = 'error';
                        $importDataInfo['message']  = 'El total de registros no puede ser mayor a ['.$this->maxAllowedRows.']';  
                     }
                     else{
                           $startTime               = date('s'); 
                        /**
                         * La importacion se realizara al final del proceso, siempre y cuando todo este bien.
                         * esto para evitar escribir errores en la tabla a importar
                         */
                            $command                = $this->db->createCommand("SET AUTOCOMMIT=0");
                            $recordSet              = $command->query();
                            $command                = $this->db->createCommand("BEGIN");
                            $recordSet              = $command->query();

                            $insert_query_prefix    = "INSERT INTO ".$this->table." \nVALUES";

                            if($this->fileRead == true){
                                $this->preloadData  = self::ArrayLoadData();
                            }

                            if($this->delHeader == '1'){ $skip = true; $outPut='Si';}else{$outPut='No';}

                            foreach($this->preloadData as $row =>$column){

                                #FUNCIONES PARTICULARES                               
                                if (function_exists($this->functionImport)) {
                                    $column = call_user_func($this->functionImport, $column);
                                }

                               if($skip) {
                                   /**
                                    * Salta la primera iteracion (eliminar la cabecera) y se setea como false
                                    * para las siguientes iteraciones
                                    */
                                   $skip    = false;
                               }
                               else{
                                 unset($column['acciones']);
                                $values[]       =  join(',',array_map('self::addQuots',$column));  
                               }                            
                            } 
                            $insert_query_prefix    .= "(".join('),(',$values).");";

                            $command                = $this->db->createCommand($insert_query_prefix);
                            $recordSet              = $command->query();

                            $command                = $this->db->createCommand("COMMIT");
                            $recordSet              = $command->query();
                            $command                = $this->db->createCommand("SET AUTOCOMMIT=1");
                            $recordSet              = $command->query();   

                            
                            $endTime = date('s');
                            $importDataInfo['processTime'] = $endTime - $startTime . ' Segundos';
                            
                            /**
                             * Se registra el log de importacion
                             */

                            $content                = "Archivo: ".$this->oldfilename
                                                     . "\nNumero de Columnas : ".$importDataInfo['numcolumns']
                                                     . "\nNumero de Filas a insertar  : ".$importDataInfo['numrows']
                                                     . "\nNumero de Filas insertadas: ".count($values)
                                                     . "\nEliminar Cabecera?: ".$outPut
                                                     . "\nEstado de la carga: Exitosa"
                                                     . "\nFecha de carga: ".date('Y-m-d H:i:s')
                                                     . "\nTiempo del Proceso: ".$importDataInfo['processTime'];
                            
                             Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('0',$this->process,$content);
                             $this->content         = $content;
                             $importDataInfo['type'] = 'success';
                             $importDataInfo['message'] = 'Los datos fueron importados al sistema.';
                     }
                 }
                 else{
                    $importDataInfo['type']     = 'error';
                    $importDataInfo['message']  = 'El total de columnas del archivo no es el mismo de la tabla a importar. Por favor, valide el archivo...'; 
                 }
                return $importDataInfo;
            }           
        } catch (Exception $e) { 
            
            $content                = "Codigo [".$e->errorInfo['1']."]\n"
                                    . "Proceso [".$this->process."]\n"
                                    . "Mensaje [".$e->errorInfo['2']."]\n"
                                    . "TraceString \n". $e->getTraceAsString();
            
            Yii::app()->getModule('massdataupload')->components['massdataevents']->registerLog('-1',$this->process,$content);
            
            $command                = $this->db->createCommand("COMMIT");
            $recordSet              = $command->query();
            $command                = $this->db->createCommand("SET AUTOCOMMIT=1");
            $recordSet              = $command->query(); 
            $command                = $this->db->createCommand("ROLLBACK");
            $recordSet              = $command->query(); 
            
            $exception     = array('type'=>'error',
                                   'message'=>'Ha ocurrido un error durante el proceso de importación.'
                                 . '<br> Codigo BD ['.$e->errorInfo['1'].']. '
                                 . 'Se realiza ROLLBACK. '.CHtml::link('Ver mas info...','http://es.wikipedia.org/wiki/Rollback',array('target'=>'_blank')));            
            return $exception;
        }
    }  
    /**
    * recorre el objeto de manera recursiva
    * @param type $obj
    */
   function addQuots(&$value) { 
       if (is_null($value))
        return "NULL";

       return $value      = '"'. mysql_real_escape_string($value).'"';
   }

}
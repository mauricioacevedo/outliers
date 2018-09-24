<?php

/**
 * DbMigrationModel class.
 * DbMigrationModel is the data structure for keeping
 */
class DbMigrationModel extends CDbMigration {

    const SQL_COMMAND_DELIMETER = ';';
    const SQL_COMMAND_IGNORE = '--';

    protected function _infoLine($filePath, $next = null) {
        echo "\r    > Ejecutar archivo $filePath ..." . $next;
    }
    /**
     * retorna un arreglo con las columnas del archivo plano
     * @return array
     */
    function _read($file) {
        try {
            $countlines = 0;
            $lines = file($file,FILE_SKIP_EMPTY_LINES);
            $data = array();
            $rowData = "";
            $row = array();
            foreach ($lines as $line) {
                if (!empty($line) && substr($line, 0, 2) != self::SQL_COMMAND_IGNORE) {               
                    $rowData  .= $line;                 
                   }              
            }
            $fileContentArray = explode(self::SQL_COMMAND_DELIMETER, $rowData); 
            return $fileContentArray;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    /**
     * Ejecuta un archivo tipo sql
     * @param string $filePath
     * @return boolean
     * @throws Exception
     */
    public function executeFile($filePath) {

        if (!isset($filePath))
            return false;

        $this->_infoLine($filePath);
        $time = microtime(true);
        if (!file_exists($filePath))
            throw new Exception("No existe el archivo '{$filePath}'");

        try {
            $array_sql = $this->_read($filePath);            
            foreach($array_sql as $sql){
                $sql = trim($sql);
               if(!empty($sql) && $sql!='' && $sql!=null){                   
                    YII::app()->db->createCommand($sql)->execute();
               }
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        $this->_infoLine($filePath, " Hecho (time: " . sprintf('%.3f', microtime(true) - $time) . "s)\n");
    }
}
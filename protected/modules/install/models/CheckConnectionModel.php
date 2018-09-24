<?php

/**
 * checkConnectionModel class.
 * checkConnectionModel is the data structure for keeping
 */
class CheckConnectionModel
{
    public function checkPermissionAndTables() {
        $rowResponse        = array();
        try {            
            $command 	=  Yii::app()->db->createCommand("SHOW TABLES");
            $recordSet 	= $command->query();            
            while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse['tables'][]     = $rowRecordset['Tables_in_'.DB];
		}
            $command 	=  Yii::app()->db->createCommand("SHOW GRANTS FOR ".DB_USER."@".INSTANCE);
            $recordSet 	= $command->query();            
            while(($rowRecordset = $recordSet->read())!==false)				
		{
                    $rowResponse['grants'][]     = $rowRecordset;
		}
            
                return $rowResponse;
        } catch (Exception $e) {
             print_r($e->getMessage());
        }
    }	
}
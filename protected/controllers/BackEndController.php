<?php

/**
 * Description of BackEndController
 *
 * @author jnavarrm
 */
class BackEndController extends Controller {

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
    public function filters() {
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

    public function actionSonda() {
        
        $serviceId              = Yii::app()->request->getPost('serviceId'); 
        $OssModel               = Ossconfig::model()->findByAttributes(array('configname'=>'serviceStatus'));
        
        if(isset($OssModel->wsdl) && isset($serviceId)){
            $serviceContentStatus  = file_get_contents($OssModel->wsdl.'?id='.$serviceId);
        }
        
        $mensaje = 'Por favor, ingrese el id del servicio que quiera consultar.... ';
        Yii::app()->user->setFlash('info', $mensaje);
        $this->render('Sonda',array('OssModel'=>$OssModel,
                                    'serviceId'=>$serviceId,
                                    'serviceContentStatus'=>$serviceContentStatus));
    }

    public function actionTelnet() {        
        $postTelnet             = Yii::app()->request->getPost('Telnet'); 
        $telnetModel            = new Telnet();  
        if(count($postTelnet)){                  
            $telnetResponse     = $telnetModel->testConnection($postTelnet);
        }
        $mensaje = 'Esta vista le permite realizar pruebas de conexion a demanda (TELNET)';
        Yii::app()->user->setFlash('info', $mensaje);
        $this->render('Telnet',array('telnetModel'=>$telnetModel,'telnetResponse'=>$telnetResponse));
    }
    
     public function actionStatistics() {        
        
        $series                = array('modifyUserEntries',
                                       'moveUser',
                                       'removeUserFromGroup',
                                       'addUserToGroup',
                                       'createGroup',
                                       'moveComputer',
                                       'createAccount',
                                    ); 
        $eventDate             = array();
        foreach($series as $value){
            for($i=1;$i<13;$i++){
            $command 	= Yii::app()->db->createCommand('SELECT count(id) as "count"'
                                                        . ' FROM tbl_event_log'
                                                        . ' WHERE eventname ="'.$value.'" '
                                                        . ' AND dateevent BETWEEN "2014-'.$i.'-00" AND "2014-'.$i.'-31"'
                                                        . ' ORDER BY dateevent ASC');
            $recordSet 	= $command->query();   
            $eventDate[$value][$i]  = $recordSet->read();
            }
        }         
        $this->render('statistics',array('eventDate'=>$eventDate));
    }

}

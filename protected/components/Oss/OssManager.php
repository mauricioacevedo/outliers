<?php
/**
 * Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/
Yii::import('application.components.generalFunctions.Array2XML');
class OssManager extends CApplicationComponent {
    
    /**
     * configuracion del Sistema de informacion
     * @param array  $OssEntries
     * @param string $service
     * @return boolean|array
     */
     function OssConfiguration($service,$OssEntries) {
      
        $OssModel               = null;
        $OssModel               =  Ossconfig::model()->findByAttributes(array('configname'=>$service));
        if(!isset($OssModel)){
            return false;
        }        
        $OssResponse['options'] = array('user'=>$OssModel->user,'password'=>$OssModel->passwd); 
        $OssResponse['wsdl']    = $OssModel->wsdl; 
        $OssResponse['method']  = $OssModel->method;              
        $params                 = $OssModel->params;
        $paramsDecode           = json_decode(json_encode(json_decode($params)), true); 
        
        if(count($OssEntries['keyoptions'])){
             $OssResponse['keyoptions']  = $OssEntries['keyoptions']; 
        }
        else{
             $OssResponse['keyoptions']  = array();
        }
        if(count($OssEntries)>0){
           
           $OssResponse['params']  = $OssEntries['param'];

            if(strlen($OssEntries['array_option'])>1)
            {   
                if(is_array($OssResponse['params']))
                {
                    $OssResponse['params']  = array_merge_recursive($paramsDecode,$OssEntries['param']);                    
                }
            }
            if(strlen($OssEntries['array_order'])>1 && is_array($OssResponse['params'])){
                $OssResponse['params']      = $OssEntries['array_order']($OssResponse['params']); 
            }
        }
        else{
                $OssResponse['params']      = $paramsDecode;
        }  
         return $OssResponse;     
    } 
    /**
     * Unico metodo que consulta, modifica, elimina y crea cuentas en el D A.
     * @param string $service
     * @param array  $OssEntries el keyoptions tiene las opc: key_file|passphrase|cert_file     
     * @return array | object
     */
    public function exec($service='',$OssEntries=array()) {   
       
        $OssSettings                 = $this->OssConfiguration($service,$OssEntries);
        if($OssSettings!==false){
            $wsResponse              = Yii::app()->soapClient->invokeWs($OssSettings['wsdl'],
                                                                        $OssSettings['method'],
                                                                        $OssSettings['params'],
                                                                        $OssSettings['options'],
                                                                        $OssSettings['keyoptions']); 
        }
        else{
            $wsResponse              = false;
        }         
         return $wsResponse;
    }   
    
}
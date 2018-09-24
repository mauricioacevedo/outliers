<?php
/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
Yii::import('application.components.soap.WSS_SoapClient');
class InvokeSoapClient extends CApplicationComponent{
	
	public $cache;
	public $ttl;
	public $options     = array();
        public $key_file    = '';    
        public $passphrase  = '';    
        public $cert_file   = ''; 
	private $ws_url;
	private $client     = null;
        
	/**
         * 
         * @param string $ws_url
         * @param array $options
         * @return object
         */
	private function getClientInt($ws_url,$options) {
		
		try {
                     if(file_get_contents($ws_url)){
				$this->ws_url	= $ws_url;
                     }else{
                         $service   = explode('/', $ws_url);
                         $service   = array_reverse($service);
                         throw new Exception('No se pudo conectar con el Web Service ('.$service[0].')... contacte al administrador');
                     }
				if($this->client == null)
				{
		             $socket_context = stream_context_create(
		                array('http' =>
		                        array(
		                                'protocol_version'  => 1.0
		                                )
		                        )
		                );
					// para que reconozca nuevas funciones del WS
					ini_set('soap.wsdl_cache_enable' ,$this->cache);
					ini_set('soap.wsdl_cache_ttl',$this->ttl); 
                                        ini_set('default_socket_timeout', $this->options['connection_timeout']);

                                            $this->options                 = array_merge($options,$this->options);
                                        if(!empty($this->key_file) && !empty($this->passphrase) && !empty($this->cert_file)){
                                            $this->client                  = new WSS_SoapClient($this->ws_url,$this->options);	
                                            $this->cliente->key_file       = $this->key_file;
                                            $this->cliente->passphrase     = $this->passphrase;
                                            $this->cliente->cert_file      = $this->cert_file;
                                        }
                                        else{
                                            $this->client                  = new SoapClient($this->ws_url,$this->options);
                                        }
				}
				return $this->client;
		}
		catch (SoapFault $e){
                    echo "<center><code>".$e->getMessage()."</code></center>";
                    echo "<pre><code>".print_r($this->client->__getFunctions())."</code></pre>";
                    Yii::app()->eventManager->registerException('SoapFault',$e->getTraceAsString().'<br>'.$e->getMessage());
                    
		}
                catch (Exception $ex){
                    Yii::app()->session['soapfault_'.strtolower(Yii::app()->controller->action->id)] = $ex->getMessage();  
                   Yii::app()->eventManager->registerException('SoapFault',$ex->getTraceAsString().'<br>'.$ex->getMessage());
                }
	}
	/**
         * 
         * @param string $ws_url
         * @param string $wsMethod
         * @param array $params
         * @param array $options
         * @param array $keyoptions
         * @return object
         */
	public function invokeWs($ws_url,$wsMethod,$params=NULL,$options=array(),$keyoptions=array())
	{	
		try { 
                        $this->client                           = NULL;
			$wsResponse				= NULL;			
                        $this->key_file                         = $keyoptions['key_file'];
                        $this->passphrase                       = $keyoptions['passphrase'];
                        $this->cert_file                        = $keyoptions['cert_file'];
                        $this->getClientInt($ws_url,$options);
			$objService				= array($this->client,$wsMethod);
                       
			if($params != NULL)
			{
				$wsResponse         = call_user_func_array($objService, $params);                                
			}
			else
			{
				$wsResponse         = call_user_func($objService);
			}
			return $wsResponse;
		}
		catch (SoapFault $e){
                    $functions  = $this->client->__getFunctions();
                    Yii::app()->session['soapfault_'.strtolower(Yii::app()->controller->action->id)] =  "<center><code>".$e->getMessage()."</code></center>"
                                                                                                        ."<pre><code>".$functions[0]."</code></pre>";
                    Yii::app()->eventManager->registerException('SoapFault','Function: '.$functions.'<br>'.$e->getTraceAsString().'<br>'.$e->getMessage());                   
		}
                catch (Exception $ex){
                    echo $ex->getMessage(); 
                }
		 
	}
}
?>
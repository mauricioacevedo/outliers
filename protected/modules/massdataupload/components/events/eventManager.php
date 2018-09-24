<?php
/**
 * Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/

class eventManager extends CApplicationComponent {
       
        /**
	 * Registra las transacciones
	 */
	public function registerLog($code_response='0',$process,$content='')
	{
		$blackList                             = array('r');
		$request                               = array();
		
		foreach($_REQUEST as $key =>$value)
		{
                    if(!in_array($key,$blackList))
                    {
                        if(is_array($value))
                        {
                                foreach($value as $index =>$val)
                                {
                                        $request[]      = "{".$index."=".$val."}";
                                }
                        }
                        else
                        {
                                $request[]              = "{".$key."=".$value."}";
                        }
                    }
		}
		
		$event					= new ImportDataLog();		
		$event->id				= '0';
		$event->module_id			= '';
		$event->cod_response			= $code_response;
		$event->process                         = $process;
		$event->import_date			= date('Y-m-d h:i:s');
		$event->user                            = Yii::app()->user->name;
                if(!empty($content))
                {
                    $event->content			= htmlentities(addslashes($content));
                }		
		$event->Save();		
		 
	}
}
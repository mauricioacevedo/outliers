<?php
/**
 * Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/

class eventManager extends CApplicationComponent {
	
	/**
	 * Obtiene el los datos de la tabla BanIp
	 */
	public function getBanIp()
	{
		return Banip::model()->findByAttributes(array('remote_add'=>$_SERVER['REMOTE_ADDR']));
	}
	/**
	 * Banea una IP por numero de intentos de autenticación
	 * @param number $minutes
	 */
	public function banIp($minutes=15)
	{
		$banIp						= $this->getBanIp();
		
		if(!empty($banIp->ip_id))
		{	
			$banIp->remote_add 		= $_SERVER['REMOTE_ADDR'];
			$banIp->penaltydate 	= date('Y-m-d H:i:s',strtotime('+'.$minutes.' minutes'));
			$banIp->SaveAttributes(array('remote_add','penaltydate'));			
		}
		else
		{
			unset($banIp);
			
			$banIp				= new Banip();
			$banIp->ip_id 			= '0';
			$banIp->remote_add 		= $_SERVER['REMOTE_ADDR'];
			$banIp->penaltydate 	= date('Y-m-d H:i:s',strtotime('+'.$minutes.' minutes'));
			$banIp->Save();
		} 
	}
	/**
	 * Registra el acceso de un usuario
	 */
	public function registerLogin()
	{
		$event					= new EventLog();
		
		$event->id				= '0';
		$event->eventname			= 'login';
		$event->user_exe			= Yii::app()->user->name;
		$event->content				= 'NULL';
		$event->ctr				= Yii::app()->getController()->getId();
		$event->acc				= Yii::app()->controller->action->id;
		$event->dateevent			= date('Y-m-d h:i:s');
		$event->ipaddress			= $_SERVER['REMOTE_ADDR'];
		
		$event->Save();		
		 
	}
	/**
	 * Registra un crud
	 */
	public function registerCrud($eventName='crud')
	{
		$blackList				= array('r');
		$request				= array();
		
		foreach($_REQUEST as $key =>$value)
		{
			if(!in_array($key,$blackList))
			{
				if(is_array($value))
				{
					foreach($value as $index =>$val)
					{
						$request[]	= "{".$index."=".$val."}";
					}
				}
				else
				{
					$request[]	= "{".$key."=".$value."}";
				}
			}
		}
		
		$event					= new EventLog();
		
		$event->id				= '0';
		$event->eventname			= $eventName;
		$event->user_exe			= Yii::app()->user->name;
		$event->content				= join(' ',$request);
		$event->ctr				= Yii::app()->getController()->getId();
		$event->acc				= Yii::app()->controller->action->id;
		$event->dateevent			= date('Y-m-d h:i:s');
		$event->ipaddress			= $_SERVER['REMOTE_ADDR'];
		
		$event->Save();				 
	}
        
        /**
	 * Registra error de la aplicación
	 */
	public function registerException($eventname='',$content='')
	{
		$event					= new EventLog();
		
		$event->id				= '0';
		$event->eventname			= $eventname;
		$event->user_exe			= Yii::app()->user->name;
		$event->content				= addslashes($content);
		$event->ctr				= Yii::app()->getController()->getId();
		$event->acc				= Yii::app()->controller->action->id;
		$event->dateevent			= date('Y-m-d h:i:s');
		$event->ipaddress			= $_SERVER['REMOTE_ADDR'];
		
		$event->Save();		
		 
	}
        
}
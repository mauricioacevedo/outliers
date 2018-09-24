<?php
/**
* Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/
class Messages extends CWidget {
	
	public $type 					  = '';
	public $message 				  = '';
	
	public function init(){

		//Recursos como del lado del cliente (CSS, JS, IMG)
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.stateMessages'));
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/stateMessages.css');
		$HTMLStateMessages			.= '';
		
		switch($this->type)
		{
			case 'error':
			$HTMLStateMessages	   .='<div class="ui-state-alert ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
										<p><center>
											<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
											<strong>'.$this->message.'</strong>
										</center></p>
										</div><br>';
				break;
			case 'info';
			$HTMLStateMessages		.='<div class="ui-state-info ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
										<p><center>
											<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
											<strong>'.$this->message.'</strong>
										</center></p>
										</div><br>';
			break;
			case 'success';
			$HTMLStateMessages		.='<div class="ui-state-success ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
										<p><center>
											<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
											<strong>'.$this->message.'</strong>
										</center></p>
										</div><br>';
			break;
			case 'warning';
			$HTMLStateMessages		.='<div class="ui-state-warning ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
										<p><center>
											<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
											<strong>'.$this->message.'</strong>
										</center></p>
										</div><br>';
			break;
			case 'offline';
			$HTMLStateMessages		.='<div class="ui-state-warning ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
										<p><center>
											<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
											<strong>'.$this->message.'</strong>
										</center></p>
										</div><br>';
			break;
			default:
				echo "<center>El tipo de error [".$this->type."] no exite!</center>";
				break;
		}
		
		echo $HTMLStateMessages.$CSSStateMessages;
	}
}
?>
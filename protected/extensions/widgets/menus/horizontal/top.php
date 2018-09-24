<?php
/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
Yii::import('ext.widgets.menus.core.menu');
class top extends CWidget {
	
	public $modelMenu;
	public $htmloptions;
	
	public function init(){
	
		//Recursos como del lado del cliente (CSS, JS, IMG)		
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.menus.horizontal'));
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/top.css');		

		$getMenu					= menu::singleton();	
		$MENU						= $getMenu->build_menu($this->modelMenu,$this->htmloptions,'top_');
					
		echo "<div id='cssmenu'>				
				".$MENU."					
			</div>";
	}
	
}
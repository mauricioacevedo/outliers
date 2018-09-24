<?php
/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
Yii::import('ext.widgets.menus.core.menu');
class accordion extends CWidget {
	
	public $modelMenu;
	public $htmloptions;
	
	public function init(){
	
		//Recursos como del lado del cliente (CSS, JS, IMG)		
		/**
		 * En caso de llevarse a otro proyecto, tenga en cuenta descargar estos JS desde jquery Ui
		 * 	jquery.js
		 */
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.menus.accordion'));
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/accordion.css');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.cookie.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/accordion.js');

		$getMenu					= menu::singleton();	
		$MENU						= $getMenu->build_menu($this->modelMenu,$this->htmloptions,'accordion_');
		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#accordion").accordion({
				accordion:true,
				speed: 500,
				closedSign:' ▼',
				openedSign:' ▲'
			});											
		});
		</script>
		<?php	
		echo "<div id='accordion'>				
				".$MENU."					
			</div>";		
	}
	
}
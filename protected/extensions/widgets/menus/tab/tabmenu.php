<?php
/**
 * Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/
Yii::import('ext.widgets.menus.core.menu');
class tabmenu extends CWidget {

	public $modelMenu;
	public $htmloptions;

	public function init(){
		/**
		 * En caso de llevarse a otro proyecto, tenga en cuenta descargar estos JS desde jquery Ui
		 * 	jquery.js
		 */
		//Recursos como del lado del cliente (CSS, JS, IMG)
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.menus.tab'));
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/tab.css');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.ui.tabs.js');
		
		$getMenu					= menu::singleton();
		$MENU						= $getMenu->build_tabmenu($this->modelMenu,$this->htmloptions,'tab_');
		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$( "#tabs" ).tabs({
			      beforeLoad: function( event, ui ) {
			        ui.jqXHR.error(function() {
			          ui.panel.html(
			            "No se pudo cargar esta pestaña o no tiene permisos.");
			        });
			      }	     
			    });		    				
		});		
		</script>
		<?php	
		
		echo '<div id="tabs">'.$MENU.' </div>';
	}
	
}
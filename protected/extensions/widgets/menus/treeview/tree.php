<?php
/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
Yii::import('ext.widgets.menus.core.menu');
class tree extends CWidget {

	public $modelMenu;
	public $htmloptions;

	public function init()
	{	
		/**
		 * En caso de llevarse a otro proyecto, tenga en cuenta descargar estos JS desde jquery Ui
		 * 	jquery.js
		 */
		//Recursos como del lado del cliente (CSS, JS, IMG)
		
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.menus.treeview'));		
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/jquery.treeview.css');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.cookie.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.treeview.js');		
		 		
		$getMenu					= menu::singleton(); 		
		$MENU						= $getMenu->build_menu($this->modelMenu,$this->htmloptions,'tree_'); 
		?>
		<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: false,
				animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});			
		});		
		</script>
		<?php
		echo '<div id="sidetree">
				<div class="treeheader">&nbsp;</div>
				<div id="sidetreecontrol"><a class="btn btn-danger" style="color:white;" href="?#">Cerrar</a><a class="btn btn-danger" style="color:white; "href="?#">Abrir</a></div>
				<ul id="tree" class="filetree">
				'.$MENU.'
					</ul>
					</div>';
	}
}

?>
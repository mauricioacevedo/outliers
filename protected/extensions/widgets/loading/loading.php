<?php
/**
* Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/
class loading extends CWidget {
	
	public $imgPath					  = '';
	
	public function init(){           
		//Recursos como del lado del cliente (CSS, JS, IMG)
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.loading'));
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/loading.js'); 
                
                 if(strlen($this->imgPath)<=0)
                    {
                        $this->imgPath = $assetFolder."/images/loading.gif";
                    }
                echo '<div id="loading" style="display: none;">'.CHtml::image($this->imgPath, "Loading").'</div>';                
	}
}
?>
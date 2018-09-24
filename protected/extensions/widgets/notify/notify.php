<?php
/**
 * Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/
class notify extends CWidget {

	public $modelNoty 	= null;
	public $notytime 	= 60;
	
	public function init(){
		/**
		 * En caso de llevarse a otro proyecto, tenga en cuenta descargar estos JS desde jquery Ui
		 * 	jquery.js
		 */
		//Recursos como del lado del cliente (CSS, JS, IMG)
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.notify'));
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/notify.css');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.noty.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/bottom.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/bottomCenter.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/bottomLeft.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/bottomRight.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/center.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/centerLeft.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/centerRight.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/inline.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/top.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/topCenter.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/topLeft.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/layouts/topRight.js');	
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/themes/default.js');		
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/notify.js');		
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/refresh.js');		
	
		if($this->modelNoty==null)
		{
			$criteria 			= new CDbCriteria;
			$criteria->condition            = 'activo = "1" AND fecha_fin >= "'.date('Y-m-d h:i:s').'"'; 
			$criteria->order 		= 'id ASC';
			$this->modelNoty		= Noty::model()->findAll($criteria);
                        if(count($this->modelNoty)){
                            Yii::app()->session['notyBtn']  = '<span style="cursor: pointer;" class="icon-bell" id="bell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.count($this->modelNoty).'</b></span>';
                        }
		}
		else 
		{
			$objNoty		 	=  new stdClass();
			$objNoty->layout 		= $this->modelNoty['layout']; 			$objNoty->text 			= $this->modelNoty['text'];
			$objNoty->type 			= $this->modelNoty['notytype'];			$objNoty->dismiss 		= $this->modelNoty['dismiss'];
			$objNoty->btnoktitle            = $this->modelNoty['btnoktitle'];		$objNoty->oktext 		= $this->modelNoty['oktext'];
			$objNoty->btncanceltitle        = $this->modelNoty['btncanceltitle'];	$objNoty->canceltext 	= $this->modelNoty['canceltext'];
			
			$this->modelNoty[]		= $objNoty;
		}           
                
		if(!isset(Yii::app()->session['notytime']) ) {
			Yii::app()->session['notytime']   = date('Y-m-d H:i:s', strtotime('+'.$this->notytime.' minute'));
			if(count($this->modelNoty))
			{
				foreach($this->modelNoty as $index => $val) 
				{
					echo '<script type="text/javascript">
							notify("'.$this->modelNoty[$index]->layout.'",
									"'.$this->modelNoty[$index]->text.'", 
									"'.$this->modelNoty[$index]->notytype.'", 
									"'.$this->modelNoty[$index]->dismiss.'", 
									"'.$this->modelNoty[$index]->btnoktitle.'",
									"'.$this->modelNoty[$index]->oktext.'",
									"'.$this->modelNoty[$index]->btncanceltitle.'",
									"'.$this->modelNoty[$index]->canceltext.'");
							</script>';
				}
			}				
		}
		else
		{
			if(Yii::app()->session['notytime']< date('Y-m-d H:i:s'))
			{
				unset(Yii::app()->session['notytime']);
			}
		}
                
                 $post                                  = Yii::app()->request->getPost('notyRefresh'); 
                if(isset($post)){
                    unset(Yii::app()->session['notytime']);
                }   
	}
	
}
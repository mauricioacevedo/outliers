<?php

/**
 * Description of helperView
 *
 * @author jnavarrm
 */
class helperView extends CWidget {
    
	
	public function init(){           
		//Recursos como del lado del cliente (CSS, JS, IMG)
		$assetFolder 				= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.helper'));
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/helper.js'); 
                Yii::app()->clientScript->registerCssFile($assetFolder.'/css/helper.css');                
                
                echo '<div id="helper" style="float:right; position: relative;">';
                        echo CHtml::image($assetFolder.'/images/help.jpg', "Help")."<br>";
                       echo CHtml::ajaxLink(
                        'Ver VideoTutorial',
                        Yii::app()->createUrl($this),
                        array( // ajaxOptions
                            'type' =>'GET',                          
                        ),
                        array( //htmlOptions. se envia el controlador y la accion de la vista que quiera consultarse el manual
                        'href'=>Yii::app()->createUrl('Helper/view',array("ctr"=>Yii::app()->getController()->getId(),"acc"=>Yii::app()->getController()->getAction()->id)),
                        'class' => 'btn btn-small',
                        'onclick'=>'$("#guideView").attr("src",$(this).attr("href")); $("#guideDialog").dialog("open");',  
                        )
                );
                        
                echo '</div>'; 
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'guideDialog',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => 'Video Tutorial - ['.Yii::app()->getController()->getAction()->id.']',
                    'autoOpen' => false,
                    'width' => 'auto',
                    'height' => 'auto',
                    'modal' => true
                ),
            ));
            echo '<iframe id="guideView" width="1000" height="370" frameborder="0"></iframe>';
            $this->endWidget('zii.widgets.jui.CJuiDialog'); 
                
	}
}
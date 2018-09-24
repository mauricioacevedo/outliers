<?php
/* @var $this AttachmentController */
/* @var $model Attachment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',	'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
)); ?>
<div class="container-fluid">
        <div class="row-fluid">           
	<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Modules::model()->findAll(), 'module_id', 'title');
                                        echo $form->dropDownListRow(
                                         $model,
                                         'module_id',
                                         $fieldTypeFormOptions, 
                                         array('prompt' => 'Seleccione')
                                         ); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'filename',array('maxlength'=>255,'class' => 'span3')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'filesize',array('class' => 'span3')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'filepath',array('maxlength'=>255,'class' => 'span3')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'zipfile',array('maxlength'=>255,'class' => 'span3')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'attachedby',array('maxlength'=>255,'class' => 'span3')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->datetimepickerRow(
                                            $model,
                                            'attacheddate',
                                             array('options' => array(
                                                                        'showMeridian' => false,
                                                                        'minuteStep' => 5    
                                                                        ),
                                                  'htmlOptions' =>  array()                      
                                                  )
                                           ); ?>
		
		                    </div>	                   
			         </div>
            <div class="row-fluid">
                <div class="span12" style="text-align: center">
                    <?php $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'buttonType' => 'submit', 
                                    'type' => 'primary',
                                    'label' => 'Buscar'
                                    )
                                ); ?>                </div>
            </div>
     </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->
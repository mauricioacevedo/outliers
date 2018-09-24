<?php
/* @var $this AttachmentController */
/* @var $model Attachment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'attachment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
	'enableAjaxValidation'	=> true,
	'enableClientValidation'	=> true,
	'clientOptions'				=> array(
										'validateOnSubmit' => true,
										),)); ?>

<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

<?php
        $this->widget('bootstrap.widgets.TbAlert', array(
                        'block' => true,
                        'fade' => true,
                        'closeText' => '&times;',
                        'events' => array(),
                        'htmlOptions' => array(),
                        'userComponentId' => 'user'
                        )
                    );    
?>
<?php echo $form->errorSummary($model); ?>
<fieldset style="width: 98%">
<legend>Datos Attachment</legend>
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
                                    'label' => $model->isNewRecord ? 'Guardar' : 'Actualizar'
                                    )
                                ); ?>                </div>
            </div>
     </div>
</fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
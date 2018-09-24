<?php
/* @var $this HelpController */
/* @var $model Help */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'help_id'); ?>
		<?php echo $form->textFieldRow($model,'help_id',array(), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'controller'); ?>
		<?php echo $form->textFieldRow($model,'controller',array('size'=>60,'maxlength'=>100), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'action'); ?>
		<?php echo $form->textFieldRow($model,'action',array('size'=>60,'maxlength'=>100), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textFieldRow($model,'title',array('size'=>60,'maxlength'=>300), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textFieldRow($model,'content',array(), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_by'); ?>
		<?php echo $form->textFieldRow($model,'create_by',array('size'=>60,'maxlength'=>100), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_date'); ?>
		<?php echo $form->datetimepickerRow(
                                            $model,
                                            'create_date',
                                             array('options' => array(
                                                                        'showMeridian' => false,
                                                                        'minuteStep' => 5    
                                                                        ),
                                                  'htmlOptions' =>  array()                      
                                                  )
                                           ); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_by'); ?>
		<?php echo $form->textFieldRow($model,'modified_by',array('size'=>60,'maxlength'=>100), array('lable'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_date'); ?>
		<?php echo $form->datetimepickerRow(
                                            $model,
                                            'modified_date',
                                             array('options' => array(
                                                                        'showMeridian' => false,
                                                                        'minuteStep' => 5    
                                                                        ),
                                                  'htmlOptions' =>  array()                      
                                                  )
                                           ); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
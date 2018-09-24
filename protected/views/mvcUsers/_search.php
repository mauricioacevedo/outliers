<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'samaccountname'); ?>
		<?php echo $form->textField($model,'samaccountname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employeenumber'); ?>
		<?php echo $form->textField($model,'employeenumber',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'departmentnumber'); ?>
		<?php echo $form->textField($model,'departmentnumber',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'profile'); ?>
		<?php echo $form->textField($model,'profile',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cn'); ?>
		<?php echo $form->textField($model,'cn',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'passwd'); ?>
		<?php echo $form->passwordField($model,'passwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sessionid'); ?>
		<?php echo $form->textField($model,'sessionid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_visit_date'); ?>
		<?php echo $form->textField($model,'last_visit_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_status'); ?>
		<?php echo $form->textField($model,'user_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
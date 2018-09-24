<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mvc-users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'samaccountname'); ?>
		<?php echo $form->textField($model,'samaccountname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'samaccountname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'employeenumber'); ?>
		<?php echo $form->textField($model,'employeenumber',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'employeenumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'departmentnumber'); ?>
		<?php echo $form->textField($model,'departmentnumber',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'departmentnumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'department'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile'); ?>
		<?php echo $form->textField($model,'profile',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'profile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cn'); ?>
		<?php echo $form->textField($model,'cn',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passwd'); ?>
		<?php echo $form->passwordField($model,'passwd'); ?>
		<?php echo $form->error($model,'passwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sessionid'); ?>
		<?php echo $form->textField($model,'sessionid'); ?>
		<?php echo $form->error($model,'sessionid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_visit_date'); ?>
		<?php echo $form->textField($model,'last_visit_date'); ?>
		<?php echo $form->error($model,'last_visit_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_status'); ?>
		<?php echo $form->textField($model,'user_status'); ?>
		<?php echo $form->error($model,'user_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mvc-users-form',
    'action'=> $this->createUrl('mvcUsers/updateUsers'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'samaccountname'); ?>
		<?php echo $form->textField($model,'samaccountname',array('size'=>15,'maxlength'=>255, 'readonly'=>true, 'value'=>$adLdapObj['samaccountname'][0] )); ?>
		<?php echo $form->error($model,'samaccountname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'employeenumber'); ?>
		<?php echo $form->textField($model,'employeenumber',array('size'=>15,'maxlength'=>255, 'readonly'=>true, 'value'=>$adLdapObj['employeenumber'][0])); ?>
		<?php echo $form->error($model,'employeenumber'); ?>
	</div>

	<div class="column">
		<?php echo $form->labelEx($model,'givenname'); ?>
		<?php echo $form->textField($model,'givenname',array('size'=>20,'maxlength'=>255, 'readonly'=>true, 'value'=>$adLdapObj['givenname'][0])); ?>
		<?php echo $form->error($model,'givenname'); ?>
	</div>
    
	<div class="column">
		<?php echo $form->labelEx($model,'sn'); ?>
		<?php echo $form->textField($model,'sn',array('size'=>20,'maxlength'=>255, 'readonly'=>true, 'value'=>$adLdapObj['sn'][0])); ?>
		<?php echo $form->error($model,'sn'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>60,'maxlength'=>255, 'value'=>$adLdapObj['department'][0])); ?>
		<?php echo $form->error($model,'department'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'departmentnumber'); ?>
		<?php echo $form->textField($model,'departmentnumber',array('size'=>10,'maxlength'=>255, 'value'=>$adLdapObj['departmentnumber'][0])); ?>
		<?php echo $form->error($model,'departmentnumber'); ?>
	</div>    
	<div class="row">
		<?php echo $form->labelEx($model,'headquarters'); ?>
		<?php echo $form->textField($model,'headquarters',array('size'=>25,'maxlength'=>255, 'value'=>$adLdapObj['headquarters'][0])); ?>
		<?php echo $form->error($model,'headquarters'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>40,'maxlength'=>255, 'readonly'=>true, 'value'=>$adLdapObj['mail'][0])); ?>
		<?php echo $form->error($model,'mail'); ?>
	</div>
    <?php echo $form->hiddenField($model,'user_id',array('readonly'=>true, 'value'=>$model->user_id));?>
    <?php echo $form->hiddenField($model,'cn',array('readonly'=>true, 'value'=>$adLdapObj['cn'][0]));?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Sincronizar',array('class'=>'btn btn-small')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
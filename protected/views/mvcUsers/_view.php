<?php
/* @var $this MvcUsersController */
/* @var $data MvcUsers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('samaccountname')); ?>:</b>
	<?php echo CHtml::encode($data->samaccountname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employeenumber')); ?>:</b>
	<?php echo CHtml::encode($data->employeenumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('departmentnumber')); ?>:</b>
	<?php echo CHtml::encode($data->departmentnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile')); ?>:</b>
	<?php echo CHtml::encode($data->profile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cn')); ?>:</b>
	<?php echo CHtml::encode($data->cn); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mail')); ?>:</b>
	<?php echo CHtml::encode($data->mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passwd')); ?>:</b>
	<?php echo CHtml::encode($data->passwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sessionid')); ?>:</b>
	<?php echo CHtml::encode($data->sessionid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_visit_date')); ?>:</b>
	<?php echo CHtml::encode($data->last_visit_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_status')); ?>:</b>
	<?php echo CHtml::encode($data->user_status); ?>
	<br />

	*/ ?>

</div>
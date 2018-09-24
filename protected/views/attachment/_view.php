<?php
/* @var $this AttachmentController */
/* @var $data Attachment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_id')); ?>:</b>
	<?php echo CHtml::encode($data->module_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filesize')); ?>:</b>
	<?php echo CHtml::encode($data->filesize); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filepath')); ?>:</b>
	<?php echo CHtml::encode($data->filepath); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zipfile')); ?>:</b>
	<?php echo CHtml::encode($data->zipfile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attachedby')); ?>:</b>
	<?php echo CHtml::encode($data->attachedby); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('attacheddate')); ?>:</b>
	<?php echo CHtml::encode($data->attacheddate); ?>
	<br />

	*/ ?>

</div>
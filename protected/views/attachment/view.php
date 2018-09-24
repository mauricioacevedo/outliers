<?php
/* @var $this AttachmentController */
/* @var $model Attachment */

$this->breadcrumbs=array(
		'Attachments'=>array('admin'),
		$model->id,
	);
?>

<h1>Attachment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'module_id',
		'filename',
		'filesize',
		'filepath',
		'zipfile',
		'attachedby',
		'attacheddate',
	),
)); ?>

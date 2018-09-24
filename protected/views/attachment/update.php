<?php
/* @var $this AttachmentController */
/* @var $model Attachment */

$this->breadcrumbs=array(
		'Attachments'=>array('admin'),
		'Nuevo'=>array('create'),
		$model->id=>array('view','id'=>$model->id),
		'Actualizar',
	);
?>

<h1>Actualizar Attachment <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
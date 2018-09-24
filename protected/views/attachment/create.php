<?php
/* @var $this AttachmentController */
/* @var $model Attachment */

$this->breadcrumbs=array(
		'Attachments'=>array('admin'),
		'Nuevo',
	);
?>

<h1>Crear Attachment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
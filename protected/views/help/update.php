<?php
/* @var $this HelpController */
/* @var $model Help */

$this->breadcrumbs=array(
		'Helps'=>array('admin'),
		'Nuevo'=>array('create'),
		$model->title=>array('view','id'=>$model->help_id),
		'Actualizar',
	);
?>

<h1>Actualizar Help <?php echo $model->help_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
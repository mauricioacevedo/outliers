<?php
/* @var $this HelpController */
/* @var $model Help */

$this->breadcrumbs=array(
		'Helps'=>array('admin'),
		'Nuevo',
	);
?>

<h1>Crear Help</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs = array('Contents' => array('admin'), 'Nuevo');
?>

<h1>Crear Content</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
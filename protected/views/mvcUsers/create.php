<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */

$this->breadcrumbs=array(
	'Mvc Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MvcUsers', 'url'=>array('index')),
	array('label'=>'Manage MvcUsers', 'url'=>array('admin')),
);
?>

<h1>Create MvcUsers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
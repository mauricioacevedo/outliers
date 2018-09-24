<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array('Users' => array('admin'), 'Nuevo');
?>

<h1>Crear Usuarios</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
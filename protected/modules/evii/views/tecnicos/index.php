<?php
/* @var $this TecnicosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Tecnicoses');

$this->menu=array(
    array('label'=>'Create Tecnicos', 'url'=>array('create')),
    array('label'=>'Manage Tecnicos', 'url'=>array('admin')),
);
?>

<h1>Tecnicoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
<?php
/* @var $this RevisoresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Revisores');

$this->menu=array(
    array('label'=>'Create Revisores', 'url'=>array('create')),
    array('label'=>'Manage Revisores', 'url'=>array('admin')),
);
?>

<h1>Revisores</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
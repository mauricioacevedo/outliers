<?php
/* @var $this EvidenciasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Evidenciases');

$this->menu=array(
	array('label'=>'Create Evidencias', 'url'=>array('create')),
	array('label'=>'Manage Evidencias', 'url'=>array('admin')),
);
?>

<h1>Evidenciases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

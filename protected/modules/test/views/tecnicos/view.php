<?php
/* @var $this TecnicosController */
/* @var $model Tecnicos */

$this->breadcrumbs = array('Tecnicoses' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id
                     );
?>

<h1>Tecnicos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'identificacion',
		'nombre',
		'creadopor',
		'modificadopor',
		'fechamodificacion',
		'fechacreacion',
		'contrato',
	),
)); ?>

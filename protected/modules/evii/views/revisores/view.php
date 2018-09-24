<?php
/* @var $this RevisoresController */
/* @var $model Revisores */

$this->breadcrumbs = array('Revisores' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id
                     );
?>

<h1>Revisores #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'nombre',
        'cedula',
        array('label'=>'Ciudad','type'=>'raw','value'=>$model->getCiudadName($model->ciudad)),
        array('label'=>'Contrato','type'=>'raw','value'=>$model->getContratoName($model->contrato)),
        //'creadopor',
        //'modificadopor',
        //'fechamodificacion',
        //'fechacreacion',
    ),
)); ?>
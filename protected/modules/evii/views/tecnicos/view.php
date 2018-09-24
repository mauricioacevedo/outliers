<?php
/* @var $this TecnicosController */
/* @var $model Tecnicos */

$this->breadcrumbs = array('Tecnicoses' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id
                     );
?>

<h1>Tecnico #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'nombre',
        'identificacion',
        array('label'=>'Ciudad','type'=>'raw','value'=>$model->getCiudadName($model->ciudad)),
        array('label'=>'Contrato','type'=>'raw','value'=>$model->getContratoName($model->contrato)),
        'celular',
       // 'creadopor',
        //'modificadopor',
        //'fechamodificacion',
        //'fechacreacion',
    ),
)); ?>
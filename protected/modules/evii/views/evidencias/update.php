<?php
/* @var $this EvidenciasController */
/* @var $model Evidencias */

$this->breadcrumbs = array('Evidencias' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id=> array('view&id='.$model->id),
                        'Actualizar',
                    );
?>

<h1>Actualizar Evidencias <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
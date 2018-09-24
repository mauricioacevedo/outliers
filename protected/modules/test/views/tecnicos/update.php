<?php
/* @var $this TecnicosController */
/* @var $model Tecnicos */

$this->breadcrumbs = array('Tecnicoses' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id=> array('view&id='.$model->id),
                        'Actualizar',
                    );
?>

<h1>Actualizar Tecnicos <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
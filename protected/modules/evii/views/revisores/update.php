<?php
/* @var $this RevisoresController */
/* @var $model Revisores */

$this->breadcrumbs = array('Revisores' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id=> array('view&id='.$model->id),
                        'Actualizar',
                    );
?>

<h1>Actualizar Revisores <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
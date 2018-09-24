<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs = array('Contents' => array('admin'),
                            'Nuevo'=> array('create'),
                            $model->content_id=> array('view&id='.$model->content_id),
                            'Actualizar',
                       );
?>

<h1>Actualizar Content <?php echo $model->content_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
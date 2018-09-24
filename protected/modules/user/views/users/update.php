<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array('Users' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->user_id=> array('view&id='.$model->user_id),
                        'Actualizar',
                    );
?>

<h1>Actualizar Users <?php echo $model->user_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
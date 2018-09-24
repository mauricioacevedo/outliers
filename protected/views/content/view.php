<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs = array('Contents' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->content_id
        );
?>

<h1>Content #<?php echo $model->content_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content_id',
		'alias',
		'category',
		'published:boolean',
		'date_init',
		'date_end',
		'creadopor',
		'fechacreacion',
		'modificadopor',
		'fechamodificacion',
	),
)); ?>

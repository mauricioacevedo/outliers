<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array('Users' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->user_id
                     );
?>

<h1>Usuario  <?php echo $model->givenname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'givenname',
		'sn',
		'samaccountname',
		//'employeenumber',
		//'departmentnumber',
		//'department',
		//'id_profile',
		'cn',
		'mail',
		//'passwd',
		//'sessionid',
		//'last_visit_date',
		//'user_status',
		//'immediate_boss',
		//'immediate_boss_mail',
		//'streetaddress',
		//'headquarters',
		//'telephonenumber',
		//'mobile',
		//'location',
		//'module_id',
		//'pic_profile_id',
		//'creadopor',
		//'fechacreacion',
		//'modificadopor',
		//'fechamodificacion',
	),
)); ?>

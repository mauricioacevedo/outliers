<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('givenname')); ?>:</b>
	<?php echo CHtml::encode($data->givenname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sn')); ?>:</b>
	<?php echo CHtml::encode($data->sn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('samaccountname')); ?>:</b>
	<?php echo CHtml::encode($data->samaccountname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employeenumber')); ?>:</b>
	<?php echo CHtml::encode($data->employeenumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('departmentnumber')); ?>:</b>
	<?php echo CHtml::encode($data->departmentnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_profile')); ?>:</b>
	<?php echo CHtml::encode($data->id_profile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cn')); ?>:</b>
	<?php echo CHtml::encode($data->cn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail')); ?>:</b>
	<?php echo CHtml::encode($data->mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passwd')); ?>:</b>
	<?php echo CHtml::encode($data->passwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sessionid')); ?>:</b>
	<?php echo CHtml::encode($data->sessionid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_visit_date')); ?>:</b>
	<?php echo CHtml::encode($data->last_visit_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_status')); ?>:</b>
	<?php echo CHtml::encode($data->user_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('immediate_boss')); ?>:</b>
	<?php echo CHtml::encode($data->immediate_boss); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('immediate_boss_mail')); ?>:</b>
	<?php echo CHtml::encode($data->immediate_boss_mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('streetaddress')); ?>:</b>
	<?php echo CHtml::encode($data->streetaddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('headquarters')); ?>:</b>
	<?php echo CHtml::encode($data->headquarters); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telephonenumber')); ?>:</b>
	<?php echo CHtml::encode($data->telephonenumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_id')); ?>:</b>
	<?php echo CHtml::encode($data->module_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pic_profile_id')); ?>:</b>
	<?php echo CHtml::encode($data->pic_profile_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creadopor')); ?>:</b>
	<?php echo CHtml::encode($data->creadopor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechacreacion')); ?>:</b>
	<?php echo CHtml::encode($data->fechacreacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modificadopor')); ?>:</b>
	<?php echo CHtml::encode($data->modificadopor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechamodificacion')); ?>:</b>
	<?php echo CHtml::encode($data->fechamodificacion); ?>
	<br />

	*/ ?>

</div>
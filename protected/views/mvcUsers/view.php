<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */
$this->renderPartial('../comunes/mensajes');
?>
<table class="detail-view">
    <tr class="even">
        <th>
            <div class="loadImg"><?php echo CHtml::image(Yii::app()->theme->baseUrl . '/images/global/ajax-loader.gif');?></div>
            <?php if($model->pic_profile_id){?>
                <div id="img-perfil"><img src="<?php echo Yii::app()->createUrl('/mvcUsers/showImage',array('file'=>Yii::app()->session['file']->filename)); ?>" width="90px"/></div>
            <?php } else { ?>
                <div id="img-perfil"><?php echo CHtml::image(Yii::app()->theme->baseUrl . '/images/global/profile.png') ?></div>
            <?php }  ?>
        </th>
        <td style="vertical-align: middle">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'mvc-users-form',
                'action'=> Yii::app()->createUrl('/mvcUsers/uploadProfileImage'),
                'enableAjaxValidation'=>false,
            )); ?>
            <?php echo $form->error($model,'file'); ?>
           
            <!-- label para simular el boton "seleccionar archivo" -->
            <label class="cargar">
                Examinar
                <span><?php echo $form->fileField($model,'file',array('class'=>'uploadFile')); ?></span>
            </label>
            <?php $this->endWidget(); ?>
        </td>
    </tr>
</table>

<?php

$this->renderPartial('_profileform',array('model'=>$model));
/*
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'samaccountname',
        'mail',
        'mobile',
		'employeenumber',
		'departmentnumber',
		'department',
		'location',
		'headquarters',
		'immediate_boss',
		'immediate_boss_mail',
        array(
            'label'=>$model->getAttributeLabel('id_profile'),
            'value'=>$model->userProfile->name_profile,
        ),
        array(
            'label'=>$model->getAttributeLabel('user_status'),
            'value'=>$model->userStatus->status,
        ),
	),
));*/

?>

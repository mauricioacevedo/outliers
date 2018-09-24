<?php
/* @var $this RolPermissionController */
/* @var $model RolPermission */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'rol-permission-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
	'enableAjaxValidation'	=> true,
	'enableClientValidation'	=> true,
	'clientOptions'				=> array(
										'validateOnSubmit' => true,
										),)); ?>

<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

<?php
        $this->widget('bootstrap.widgets.TbAlert', array(
                        'block' => true,
                        'fade' => true,
                        'closeText' => '&times;',
                        'events' => array(),
                        'htmlOptions' => array(),
                        'userComponentId' => 'user'
                        )
                    );    
?>
<?php echo $form->errorSummary($model); ?>
<fieldset style="width: 98%">
<legend>Datos RolPermission</legend>
<div class="container-fluid">
        <div class="row-fluid">           
	<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Action::model()->findAll(), 'action_id', 'controller_id');
                                        echo $form->dropDownListRow(
                                         $model,
                                         'action_id',
                                         $fieldTypeFormOptions, 
                                         array('prompt' => 'Seleccione'), 
                                         array('lable'=>'')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'rol_id',array(), array('lable'=>'')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->toggleButtonRow($model,'access', array('enabledLabel' => 'Si','disabledLabel' => 'No'), array('lable'=>'')); ?>
		
		                    </div>	                   
			         </div>
            <div class="row-fluid">
                <div class="span12" style="text-align: center">
                    <?php $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'buttonType' => 'submit', 
                                    'type' => 'primary',
                                    'label' => $model->isNewRecord ? 'Guardar' : 'Actualizar'
                                    )
                                ); ?>                </div>
            </div>
     </div>
</fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'users-form',
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
<legend>Datos Users</legend>
<div class="container-fluid">
        <div class="row-fluid">           
	<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'givenname',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'samaccountname',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'mail',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->passwordFieldRow($model,'passwd',array('class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Userstatus::model()->findAll(), 'id', 'status');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'user_status',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
		
		                    </div>
				<div class="span6">

					<?php if($model->isNewRecord){
						
						$fieldTypeFormOptions = CHtml::listData(UsersRoles::model()->findAll(array('select'=>'rol','distinct'=>true,)), 'rol', 'rol');	
                            	$selectedOptions = array('selected'=>'selected');
                                echo $form->dropDownListRow(
                             		$model,
                             		'id_profile',//utilizo temporalmente este campo para que lleve el valor que necesito para la entrada en la tabla usersroles...
                             		$fieldTypeFormOptions, 
                             		array('prompt' => 'Seleccione','options'=>$selectedOptions)
                            ); 
					} else {//es una actualizacion, solo muestro el valor
						$userrole=UsersRoles::model()->find(array("condition"=>"username =  '".$model->samaccountname."'"));
						echo "Rol: ".$userrole->rol;
					}
					?>
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

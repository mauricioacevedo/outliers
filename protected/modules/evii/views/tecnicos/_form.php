<?php
/* @var $this TecnicosController */
/* @var $model Tecnicos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'tecnicos-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
    'enableAjaxValidation'    => true,
    'enableClientValidation'    => true,
    'clientOptions'                => array(
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
<legend>Datos Tecnicos</legend>
<div class="container-fluid">
        <div class="row-fluid">           
    <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'nombre',array('maxlength'=>100,'class' => 'span6')); ?>
        
                            </div>                       
            <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'identificacion',array('maxlength'=>50,'class' => 'span6')); ?>
        
                            </div>                       
                        </div>
                <div class="row-fluid">
            <div class="span6">
                    
                <?php $fieldTypeFormOptions = CHtml::listData(Contratos::model()->findAll(), 'id', 'contrato');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'contrato',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
        
                            </div>                       
            <div class="span6">
                    
                <?php $fieldTypeFormOptions = CHtml::listData(Ciudades::model()->findAll(), 'id', 'ciudad');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'ciudad',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
        
                            </div>                       
                        </div>
                <div class="row-fluid">
            <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'celular',array('maxlength'=>50,'class' => 'span6')); ?>
        
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
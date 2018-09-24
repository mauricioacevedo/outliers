<?php
/* @var $this HelpController */
/* @var $model Help */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'help-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('autocomplete' => 'off'),
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),));
    ?>

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
        <legend>Datos Help</legend>
        <div class="container-fluid">
            <div class="row-fluid">           
                <div class="span12">

<?php echo $form->textFieldRow($model, 'controller', array('size' => 60, 'maxlength' => 100)); ?>

                </div>	                   
            </div>
            <div class="row-fluid">
                <div class="span12">

<?php echo $form->textFieldRow($model, 'action', array('size' => 60, 'maxlength' => 100)); ?>

                </div>	                   
            </div>
            <div class="row-fluid">
                <div class="span12">

<?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 300)); ?>

                </div>	                   
            </div>
            <div class="row-fluid">
                <div class="span12">                    
                    <?php echo $form->ckEditorRow(
                                                $model,
                                                'content',
                                                array(),
                                                array(
                                                        'options' => array(
                                                                            'fullpage' => 'js:true',
                                                                            'width' => '640',
                                                                            'resize_maxWidth' => '640',
                                                                            'resize_minWidth' => '320'
                                                                            )
                                                        )
                                                ); ?>

                </div>	                   
            </div>                        
            <div class="row-fluid">
                <div class="span12" style="text-align: center">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
                        'buttonType' => 'submit',
                        'type' => 'danger',
                        'label' => $model->isNewRecord ? 'Guardar' : 'Actualizar'
                            )
                    );
                    ?>                </div>
            </div>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php
$bdFormModel = new SettingFormModel();
$form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
        'id' => 'bdForm',
        'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true)
        )
);
?>
<!-- FIN GLOBAL -->
<h5>CONFIGURACI&Oacute;N GLOBAL SITIO</h5>
<div class="row-fluid">
    <div class="span2">
        <!-- block -->
        <label>NOMBRE DEL SITIO:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'sitename', 
                         array('class' => 'span10',
                               'value'=>SITENAME), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span2">
        <!-- block -->
        <label>COPY RIGHT:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'copyright', 
                         array('class' => 'span10',
                               'value'=>COPYRIGHT), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span3">
        <!-- block -->
        <label>RUTA DEL AVATAR DE PERFIL:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'avatarPath', 
                         array('class' => 'span10',
                               'value'=>AVATARPATH), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span3">
        <!-- block -->
        <label>RUTA DE CARGAS MASIVAS:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'massUploadFilePath', 
                         array('class' => 'span10',
                               'value'=>MASSUPLOADPATH), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span2">
        <!-- block -->
        <label>¿ACTIVAR DEBUG?</label>
        <div class="block">
<?php                                                        
    $form->widget(
            'bootstrap.widgets.TbToggleButton',
            array(
                'name' => 'debug',
                'enabledLabel' => 'SI',
                'disabledLabel' => 'NO',
                'value' => YII_DEBUG,
            )
        );

    ?>
        </div>
        <!-- /block -->
    </div>   
    
</div>
<!-- FIN GLOBAL -->
<hr>
<!-- DELPHOS -->
<h5>CONFIGURACI&Oacute;N SITIO - DELPHOS</h5>
<div class="row-fluid">
    <div class="span6">
        <!-- block -->
        <label>NOMBRE APLICACI&Oacute;N (registrada en delphos):</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'application', 
                         array('class' => 'span10',
                               'value'=>APPLICATION), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span6">
        <!-- block -->
        <label>CLAVE APLICACI&Oacute;N (registrado en delphos):</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'password_app', 
                         array('class' => 'span10',
                               'value'=>PASSWORD_APP), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>          
    
</div>
<!-- FIN DELPHOS -->
<hr>
<h5>CONFIGURACI&Oacute;N BASE DE DATOS</h5>
<div class="row-fluid">
    <div class="span2">
        <!-- block -->
        <label>INSTANCIA/IP:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'hostname', 
                         array('class' => 'span10',
                               'value'=>INSTANCE), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span2">
        <!-- block -->
        <label>USUARIO:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'user', 
                         array('class' => 'span10',
                               'value'=>DB_USER), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span2">
        <!-- block -->
        <label>CLAVE:</label>
        <div class="block">
<?php
echo $form->passwordFieldRow($bdFormModel, 'password', 
                         array('class' => 'span10',
                               'value'=>DB_PASS), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div>   
    <div class="span2">
        <!-- block -->
        <label>ESQUEMA:</label>
        <div class="block">
<?php
echo $form->textFieldRow($bdFormModel, 'dataBase', 
                         array('class' => 'span10',
                               'value'=>DB), 
                         array('label' => ''));
?>
        </div>
        <!-- /block -->
    </div> 
</div>
<hr>
<!-- GUARDAR -->
<div class="row-fluid">
 <div class="span2">
    <!-- block -->
    <div class="block"><br>
       <?php 
        $this->widget('bootstrap.widgets.TbButton', 
                array('buttonType'=>'submit', 
                      'htmlOptions'=>array('name'=>'saveSettings'),
                                           'label'=>'Guardar',
                                           'type' => 'danger', 
                                           'size' => 'normal'));
       ?>
    </div>
    <!-- /block -->
</div>
</div>
<!-- FIN GUARDAR -->
<?php
$this->endWidget();
unset($form);
<?php
$this->pageTitle = Yii::app()->name . ' - Autenticación';
$this->breadcrumbs = array('Autenticación',);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form/form.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css"/>

<div class="container-fluid" align="center">
    <div class="row-fluid">                
        <!--/span-->
        <div class="span12" id="content">
            <!-- morris stacked chart -->
            <div class="row-fluid">
                <!-- block -->
                <div class="block">
                    <div class="block-content collapse in well" style="margin-top: 6%;">
                        <?php if ($wait) { ?>
                            <div><p>&nbsp;</p>
                                <?php
                               $this->renderPartial('../comunes/mensajes');
                                echo "<br><br>";
                                $this->widget('ext.widgets.countDown.countDown', array('time' => $penaltydate));
                                echo "<br><br>";
                                ?>
                            </div>
                        <?php
                        } else {
                            $form = $this->beginWidget(
                                    'bootstrap.widgets.TbActiveForm', array(
                                    'id' => 'loginForm',
                                    'htmlOptions' => array('autocomplete' => 'off'), // for inset effect
                                    'enableClientValidation' => true,
                                    'clientOptions' => array('validateOnSubmit' => true,),
                                        )
                            );
                            ?> 
                            <div class="span12">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend style="text-align: center;"><h3>Autenticaci&oacute;n</h3></legend>
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput">Usuario: </label>
                                            <div class="controls">
                                            <?php echo $form->textFieldRow($model, 'username', array('style' => 'text-align:center;', 
                                                                                                     'class'=>'input-xlarge focused'),
                                                                                                                         array('label'=>'')); ?>	                                                
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Contraseña</label>
                                            <div class="controls">
                                            <?php echo $form->passwordFieldRow($model, 'password', array('style' => 'text-align:center;', 
                                                                                                         'class'=>'input-xlarge focused'),
                                                                                                                        array('label'=>'')); ?>
                                            </div>
                                        </div>
                                         <div class="control-group">
                                            <label class="control-label">Recordar la pr&oacute;xima vez</label>
                                            <div class="controls">
                                            <?php //echo $form->toggleButtonRow($model, 'rememberMe','',array('label'=>'')) . '<br><br>';                                            
                                            if ($model->scenario == 'withCaptcha' && CCaptcha::checkRequirements()): ?>
                                                <div><?php $this->widget('CCaptcha',array('buttonOptions' => array('style' => 'display:block'))); ?></div>
                                                <div><?php echo $form->textFieldRow($model, 'verifyCode',array('style' => 'text-align:center;', 
                                                                                                         'class'=>'input-xlarge focused'),
                                                                                                         array('label'=>'')); ?></div>
                                                <div><?php echo $form->error($model, 'verifyCode').'<br><br>'; ?></div>
                                                
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <?php
                                                $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit',
                                                    'label' => 'Autenticar',
                                                    'type' => 'danger',
                                                    'size' => 'normal'));
                                                ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                <?php $this->endWidget(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /block -->
            </div>
        </div>
    </div>
</div>
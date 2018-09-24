<?php $this->pageTitle = Yii::app()->name . ' - Sonda'; ?>

<div class="well_content" style="text-align: center; margin-top: 40px;">  
    <?php
    $this->renderPartial('../comunes/mensajes');
    ?>
    <div class="container-fluid" align="center">
        <div class="row-fluid">                
            <!--/span-->
            <div class="span12" id="content">
                <!-- morris stacked chart -->
                <div class="row-fluid">
                    <!-- block -->
                    <div class="block">
                        <div class="block-content collapse in" style="margin-top: 6%;">
                            <?php
                            $form = $this->beginWidget(
                                    'bootstrap.widgets.TbActiveForm', array(
                                    'id' => 'sondaForm',
                                    'htmlOptions' => array('autocomplete' => 'off'), // for inset effect
                                    'enableClientValidation' => true,
                                    'clientOptions' => array('validateOnSubmit' => true,),
                                    )
                            );
                            ?> 
                            <div class="span12">
                                    <fieldset>
                                        <legend style="text-align: center;"><h3>SONDA</h3></legend>
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput">ID Servicio: </label>
                                            <div class="controls">
                                                <?php
                                                echo CHtml::textField('serviceId', '', array('style' => 'text-align:center;','class' => 'focused'));
                                                ?>	                                                
                                            </div>
                                        </div>
                                        <div class="control-group">
                                                <div class="controls">
                                                <?php
                                                $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit',
                                                                                                    'label' => 'Consultar',
                                                                                                    'type' => 'danger',
                                                                                                    'size' => 'normal'));
                                                ?>
                                                </div>
                                            </div>
                                    </fieldset>
                            <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
                <br>
                <div>
                    <fieldset>
                       <legend style="text-align: center;"><h3>Respuesta</h3></legend>
                     <div class="control-group">
                        <div class="controls">
                            <?php
                            echo $serviceContentStatus;
                            ?>	                                                
                        </div>
                    </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>     
</div>

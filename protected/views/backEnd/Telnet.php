<?php $this->pageTitle = Yii::app()->name . ' - Telnet'; ?>

<div class="well_content" style=" margin-top: 40px;">
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
                                'id' => 'telnetForm',
                                'htmlOptions' => array('autocomplete' => 'off'), // for inset effect
                                'enableClientValidation' => true,
                                'clientOptions' => array('validateOnSubmit' => true,),
                                    )
                            );
                            ?> 
                            <div class="span12">
                                    <fieldset>
                                        <legend style="text-align: center;"><h3>Formulario Telenet</h3></legend>
                                        <div class="control-group">
                                            <label class="control-label" for="focusedInput">Host/IP (sin HTTP://): </label>
                                            <div class="controls">
                                                <?php
                                                echo $form->textFieldRow($telnetModel, 'host', array('style' => 'text-align:center;',
                                                                                                      'class' => 'input-xxlarge focused',
                                                                                                      'prepend'=>'@'), 
                                                                                                array('label' => ''));
                                                ?>	                                                
                                            </div>
                                        </div>

                                        <div class="row-fluid">
                                            <div class="span3">
                                                <!-- block -->
                                                <div class="block">
                                                    <div class="control-group">
                                                        <label class="control-label">Protocolo:</label>
                                                        <div class="controls">
                                                            <?php
                                                            echo $form->textFieldRow($telnetModel, 'protocol', array('style' => 'text-align:center;', 'class' => 'focused', 'value' => 'HTTP/1.1', 'disabled' => 'disabled'), array('label' => ''));
                                                            ?>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <!-- /block -->
                                            </div>

                                            <div class="span3">
                                                <!-- block -->
                                                <div class="block">
                                                    <div class="control-group">
                                                        <label class="control-label">Metodo:</label>
                                                        <div class="controls">
                                                            <?php
                                                            echo $form->textFieldRow($telnetModel, 'method', array('style' => 'text-align:center;', 'class' => 'focused', 'value' => 'GET', 'disabled' => 'disabled'), array('label' => ''));
                                                            ?>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <!-- /block -->
                                            </div>

                                            <div class="span3">
                                                <!-- block -->
                                                <div class="block">
                                                    <div class="control-group">
                                                        <label class="control-label">Puerto:</label>
                                                        <div class="controls">
                                                            <?php
                                                            echo $form->textFieldRow($telnetModel, 'port', array('style' => 'text-align:center;', 'class' => 'focused', 'value' => '80'), array('label' => ''));
                                                            ?>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <!-- /block -->
                                            </div>

                                            <div class="span3">
                                                <!-- block -->
                                                <div class="block">
                                                    <div class="control-group">
                                                        <label class="control-label">TimeOut:</label>
                                                        <div class="controls">
                                                            <?php
                                                            echo $form->textFieldRow($telnetModel, 'timeout', array('style' => 'text-align:center;', 'class' => 'focused', 'value' => '30'), array('label' => ''));
                                                            ?>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <!-- /block -->
                                            </div>                                           
                                        </div>
                                        
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <!-- block -->
                                                <div class="block">
                                                    <div class="control-group">
                                                        <label class="control-label">Ruta Servidor/Servicio:</label>
                                                        <div class="controls">
                                                            <?php
                                                            echo $form->textAreaRow($telnetModel, 'route', array('class' => 'input-xxlarge focused', 'value' => '/',), array('label' => ''));
                                                            ?>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <!-- /block -->
                                            </div>

                                            <div class="span5">
                                                <!-- block -->
                                                <div class="block">
                                                    <div class="control-group">
                                                        <label class="control-label">Cabeceras (HTTP):</label>
                                                        <div class="controls">
                                                            <?php
                                                            echo $form->textAreaRow($telnetModel, 'header', array('class' => 'input-xxlarge focused', 'value' => '',), array('label' => ''));
                                                            ?>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <!-- /block -->
                                            </div>                                           
                                        </div>
                                         <div class="control-group">
                                                <div class="controls">
                                                <?php
                                                $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit',
                                                                                                    'label' => 'Probar Conexión',
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
            </div>
        </div>
    </div> 
    
 <fieldset>
<legend style="text-align: center;"><h3>Respuesta</h3></legend>     
<?php
echo "<pre>";
echo $telnetResponse['escribe_rn'];
echo "<br>";
echo($telnetResponse['cadena_html']);
echo "<pre>";
?>
</fieldset>
</div>

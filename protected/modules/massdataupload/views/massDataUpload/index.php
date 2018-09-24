<?php 
Yii::import('ext.cascadedropdown.ECascadeDropDown'); ?>
<!DOCTYPE html>
<html class="no-js">
    <body>
        <div class="well_content">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                     <fieldset>
                       <legend>Carga de archivos planos</legend>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                           <?php        
                              $this->renderPartial('messages');
                              /**
                               * POP UP
                               */
                                $this->renderPartial('preview',array('arrayLoadData'=>Yii::app()->session['arrayLoadData']));                                                          
                            ?> 
                        </div>
                        <!-- /block -->
                    </div>
                    <?php
                     
                    $form = $this->beginWidget(
                        'bootstrap.widgets.TbActiveForm',
                        array(
                            'id' => 'datauploadfrm',
                            'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
                            'enableClientValidation' => true,
                            'clientOptions' => array('validateOnSubmit' => true)
                        )
                    );
                    ?>
                    <div class="row-fluid">
                        <div class="span2">
                            <!-- block -->
                            <label>Processo</label>
                            <div class="block">
                               <?php                                
                                 echo $form->dropDownListRow($UploadFileModel,'process',$processList,array('prompt'=>'Seleccione','class'=>'span10'),array('label'=>''));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span2">
                            <!-- block -->
                            <label>Separador</label>
                            <div class="block">
                               <?php                                 
                                 echo $form->dropDownListRow($UploadFileModel,'separator',$separatorList,array('class'=>'span10'),array('label'=>''));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span2">
                            <!-- block -->
                            <label>¿Eliminar Cabecera?</label>
                            <div class="block">
                               <?php                                 
                                echo $form->dropDownListRow($UploadFileModel,'deleteHeader',$delHeaderOptions,array('class'=>'span10'),array('label'=>''));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                        <!-- <div class="row-fluid"> -->
                        <div class="span3">
                            <!-- block -->
                            <label>Archivo Plano</label>
                            <div class="block">
                               <label class="cargar">
                                Examinar
                                <?php 
                               echo $form->fileFieldRow($UploadFileModel, 'filename', array('class' =>'span2 uploadfile'),array('label'=>''));
                               ?>
                               </label>
                            </div>
                            <!-- /block -->
                        </div> 
                        <div class="span2">
                            <!-- block -->
                            <div class="block"><br>
                               <?php 
                                $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'htmlOptions'=>array('name'=>'loadData'),'label'=>'Validar Datos','type' => 'danger', 'size' => 'normal'));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                   <!-- </div>  -->
                    </div>
                    <?php                    
                    $this->endWidget();
                    unset($form);
                    ?>
                        </fieldset>
                </div>
                 
                
                <!-- End Load Form-->   
               <?php if(strlen($dataUploadModel->content)>1) { ?>
                    <!-- RESPONSE-->
                <div class="span12" id="content">
                     <fieldset>
                       <legend>Resultado:</legend>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block well_simple">
                           <?php                             
                           echo "<pre>".$dataUploadModel->content."</pre>";
                            ?> 
                        </div>
                        <!-- /block -->
                    </div>
                        </fieldset>
                </div>
                <!-- End RESPONSE-->                
                 <?php } ?> 
                
                <!-- DELETE RECORD-->
                <div class="span12">
                     <fieldset>
                       <legend>Eliminar Registros</legend>
                        <?php   
                            $form = $this->beginWidget(
                                'bootstrap.widgets.TbActiveForm',
                                array(
                                    'id' => 'deleteRecordfrm',
                                    #'htmlOptions' => array(), // for inset effect
                                    'enableClientValidation' => true,
                                    'clientOptions' => array('validateOnSubmit' => true)
                                )
                            );                           
                            ?> 
                        <div class="row-fluid">
                        <div class="span2">
                            <!-- block -->
                            <label>Processo</label>
                            <div class="block">
                               <?php                                
                                 echo $form->dropDownListRow($EraseRecordModel,'processErasable',$erasableTableList,array('prompt'=>'Seleccione','class'=>'span10','id'=>'processErasable'),array('label'=>''));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span2">
                            <!-- block -->
                            <label>Campo</label>
                            <div class="block">
                               <?php                                
                                 echo $form->dropDownListRow($EraseRecordModel,'field',array(),array('prompt'=>'Seleccione','class'=>'span10','id'=>'field'),array('label'=>''));
                                 ECascadeDropDown::master('processErasable')->setDependent('field', array('dependentLoadingLabel' => 'Seleccione...'), 'massdataupload/MassDataUpload/ListProcessField');
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span2">
                            <!-- block -->
                            <label>Desde</label>
                            <div class="block">
                               <?php                                 
                                 echo $form->textFieldRow($EraseRecordModel,'startRecord',array('class'=>'span10'),array('label'=>''));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>                        
                        <div class="span2">
                            <!-- block -->
                            <label>Hasta</label>
                            <div class="block">
                               <?php                                 
                                 echo $form->textFieldRow($EraseRecordModel,'finishRecord',array('class'=>'span10'),array('label'=>''));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>                        
                        <div class="span2">
                            <!-- block -->
                            <div class="block"><br>
                               <?php 
                                $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'htmlOptions'=>array('name'=>'deleteRecord'),'label'=>'Eliminar Registro(s)','type' => 'inverse', 'size' => 'normal'));
                               ?>
                            </div>
                            <!-- /block -->
                        </div>
                   <!-- </div>  -->
                    </div>
                    <?php                    
                    $this->endWidget();
                    unset($form);
                    ?>
                        <!-- /block -->
                        </fieldset>
                    </div>               
                <!-- End DELETE RECORD-->                 
                
                <!-- LOGS-->
                <div class="span12" id="content">
                     <fieldset>
                       <legend>Eventos por Proceso </legend>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                           <?php 
                            $this->renderPartial('logs',array('logData'=>$logData));                            
                            ?> 
                        </div>
                        <!-- /block -->
                    </div>
                        </fieldset>
                </div>
                <!-- End LOGS-->                
                <?php 
                if(Yii::app()->session['roles_delphos']->debugger->massdataupload[0] =="all")  {?>
                <!-- ADMIN LOGS-->
                <div class="span12" id="content" style="overflow: auto;">
                     <fieldset>
                       <legend>Todos los Eventos</legend>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                           <?php 
                            $this->renderPartial('logs',array('logData'=>$allLogs));                            
                            ?> 
                        </div>
                        <!-- /block -->
                    </div>
                        </fieldset>
                </div>
                <!-- End ADMIN LOGS-->                
                <?php } ?>
                
            </div>
        </div>
        </div>
    </body>

</html>
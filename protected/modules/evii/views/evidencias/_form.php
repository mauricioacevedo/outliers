<?php
/* @var $this EvidenciasController */
/* @var $model Evidencias */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'evidencias-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
	'enableAjaxValidation'	=> true,
	'enableClientValidation'	=> true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
	'clientOptions'				=> array(
										'validateOnSubmit' => true,
										),)); ?>

<!--p class="note">Campos con <span class="required">*</span> son requeridos.</p-->

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


<div class="container-fluid">

	<legend>Datos Generales</legend> 
    <div class="row-fluid">

		<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Tecnicos::model()->findAll(array('order'=>'nombre')), 'id', 'nombre');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'tecnico_id',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
		</div>
		<div class="span6">
                <?php echo $form->textFieldRow($model,'pedido',array('maxlength'=>50,'class' => 'span6')); ?>
		</div>
	</div>

		<div class="row-fluid">
			<div class="span6">
                <?php echo $form->textFieldRow($model,'documento_cliente',array('maxlength'=>255,'class' => 'span6')); ?>
			</div>	                   
			<div class="span6">
				<?php $fieldTypeFormOptions = CHtml::listData(Productos::model()->findAll(), 'id', 'producto');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'producto',
                                             $fieldTypeFormOptions,
                                             array('prompt' => 'Seleccione')
                                             ); ?>
		
			</div>
		</div>
        <div class="row-fluid">
			<div class="span6">
                <?php $fieldTypeFormOptions = CHtml::listData(Plazas::model()->findAll(), 'id', 'plaza');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'plaza',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
		
			</div>	                   
			<div class="span6">
				<?php $fieldTypeFormOptions = CHtml::listData(Revisores::model()->findAll(), 'id', 'nombre');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'revisor',
                                             $fieldTypeFormOptions,
                                             array('prompt' => 'Seleccione')
                                             ); ?>
			</div>	                   
		</div>

		
		<div class="row-fluid">
			<div class="span6">
				<legend>Informacion del Caso</legend>
				<?php   
					if(isset($model)&&$model->id!=""){

						$evixmotivo=Evidenciasxmotivo::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
        	            $zise=count($evixmotivo);
                	    $selected=array();
                        for($b=0;$b<$zise;$b++){
                        	$pos=$evixmotivo[$b]->motivo_id;
	                        $selected["$pos"]=array('selected' => 'selected');
        	            }
					}
			
					$fieldTypeFormOptions = CHtml::listData(Motivo::model()->findAll(), 'id', 'motivo');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'motivo_outlier',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true,'size'=>'7','options' => $selected)
                                             ); ?>
			</div>

			<div class="span6">
	                <legend>&nbsp; </legend>	
                <?php
					if(isset($model)&&$model->id!=""){
						$evixhallazgos=Evidenciasxhallazgos::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
						$zise=count($evixhallazgos);
						$selected=array();
						for($b=0;$b<$zise;$b++){
							$pos=$evixhallazgos[$b]->hallazgo_id;
							$selected["$pos"]=array('selected' => 'selected');
						}
					}
					$fieldTypeFormOptions = CHtml::listData(Hallazgos::model()->findAll(), 'id', 'hallazgo');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'hallazgos',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true,'size'=>'7','options' => $selected)
                                             ); ?>
		    </div>
		</div>

		<div class="row-fluid">

			<div class="span6">
            	<?php   
            		if(isset($model)&&$model->id!=""){
						$evixdiagnostico=Evidenciasxdiagnosticotecnico::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
		                $zise=count($evixdiagnostico);
	        	        $selected=array();
	                	for($b=0;$b<$zise;$b++){
	                    	$pos=$evixdiagnostico[$b]->diagnostico_id;
	                        $selected["$pos"]=array('selected' => 'selected');
		                }
					}

					$fieldTypeFormOptions = CHtml::listData(Diagnosticotecnico::model()->findAll(), 'id', 'diagnostico');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'diagnostico_tecnico',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true,'size'=>'7','options' => $selected)
                                            ); ?>
			</div>

			<div class="span6">
                	
                <?php   
					if(isset($model)&&$model->id!=""){
			
						$evixsolucion=Evidenciasxsolucion::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
		                $zise=count($evixsolucion);
	        	        $selected=array();
	                	for($b=0;$b<$zise;$b++){
                        	$pos=$evixsolucion[$b]->solucion_id;
                            $selected["$pos"]=array('selected' => 'selected');
		                }
					}

					$fieldTypeFormOptions = CHtml::listData(Solucion::model()->findAll(), 'id', 'solucion');
                                            echo $form->dropDownListRow(
                                            $model,
                                            'solucion',
                                            $fieldTypeFormOptions, 
                                            array( 'multiple' => true,'size'=>'7','options' => $selected)
                                            ); ?>
            </div>
        </div>
		<div class="row-fluid">
			<div class="span6">

				<?php
					if(isset($model)&&$model->id!=""){
						$evixaccion=Evidenciasxaccionmejora::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
    	                $zise=count($evixaccion);
            	        $selected=array();
                    	for($b=0;$b<$zise;$b++){
                        	$pos=$evixaccion[$b]->accionmejora_id;
                            $selected["$pos"]=array('selected' => 'selected');
    	                }
					}
					$fieldTypeFormOptions = CHtml::listData(Acciondemejora::model()->findAll(), 'id', 'accion');
                                            echo $form->dropDownListRow(
                                            $model,
                                            'acciondemejora',
                                            $fieldTypeFormOptions, 
                                            array( 'multiple' => true,'size'=>'7','options' => $selected)
                                            ); ?>
		
			</div>
			<div class="span6">
				<?php echo $form->datepickerRow(
                                            $model,
                                            'fecha_cerrado',
                                             array('options' => array(
                                                                        'language' => 'es',
                                                                        'format' => 'yyyy-mm-dd'
                                                                        ),
                                                  'htmlOptions' =>  array('class' => 'input-small')                      
                                                   )   
                                           );  ?>

<?php


/*
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'fecha_cerrado',
                                'id'=>'fecha_cerrado',
                            'value'=>Yii::app()->dateFormatter->format("d-M-y",strtotime($model->fecha_cerrado)),
                                'options'=>array(
                                'showAnim'=>'fold',
                                ),
                                'htmlOptions'=>array(
                                'style'=>'height:20px;'
                                ),
                        )); 
*/
?>
			</div>	                   
		</div>
        <div class="row-fluid">
			<div class="span6">
				<?php echo $form->textAreaRow($model,'observaciones',array('rows'=>6, 'cols'=>100, 'class' => 'span12')); ?>
		    </div>	                   
			<div class="span6">
                <?php $fieldTypeFormOptions = CHtml::listData(Responsabledano::model()->findAll(), 'id', 'responsable_dano');
                                            echo $form->dropDownListRow(
                                            $model,
                                            'responsable_dano',
                                            $fieldTypeFormOptions, 
                                            array('prompt' => 'Seleccione')
                                            ); ?>
            </div>
        </div>
        <div class="row-fluid">
			<div class="span6">
				<label class="control-label" for="Evidencias_descuento">Descuento</label>
				<div class="controls">
					<?php
						echo $form->DropDownList($model,'descuento',array('NO'=>'NO','SI'=>'SI')); ?>
				</div>
			</div>	                   
			<div class="span6">
				<label class="control-label" for="Evidencias_rere">Rere?</label>
				<div class="controls">
					<?php
						echo $form->DropDownList($model,'rere',array('NO'=>'NO','SI'=>'SI')); ?>
				</div>
		    </div>
		</div>
        <div class="row-fluid">
			<div class="span6">
                <?php $fieldTypeFormOptions = CHtml::listData(Lideresdeplaza::model()->findAll(), 'id', 'lider');
                                            echo $form->dropDownListRow(
                                            $model,
                                            'lider_de_plaza',
                                            $fieldTypeFormOptions, 
                                            array('prompt' => 'Seleccione')
                                            ); ?>
                </div>
         </div>
			<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>

            <div class="row-fluid">
                <div class="span6" style="text-align: center">
					<label class="control-label" for="Evidencias_evidencia_antes">Evidencia Fotografica Antes</label>
                    <?php   

	                    if(isset($model)&&$model->id!=""){//es una actualizacion
						//1. debo obtener el listado de las imagenes que ya se tienen
						$imagenes_antes=ImagenesAntes::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
						//2. hago iteracion sobre este objeto y muestro los nombres de archivo, junto a una opcion para eliminar
						// aca utilizar ajax
						$i=count($imagenes_antes);
						
						for($j=0;$j<$i;$j++){
			        		$img=$imagenes_antes[$j]->nombre_archivo;
							$idi=$imagenes_antes[$j]->id;
							echo "<div id='imagen$idi'>$img ";
							
							echo CHtml::ajaxLink(
								'eliminar',          // the link body (it will NOT be HTML-encoded.)
								$this->createUrl('evidencias/ajax'), // the URL for the AJAX request.
								array(
						                'type'=>'GET',
						                'cache'=>false,
						                'url'=>$this->createUrl('evidencias/ajax'),
						                'data'=>array('type'=>'borrarImagenForm','id_imagen'=>$idi,'typeImage'=>'antes'),
						                'beforeSend'=>'function(xhr, opts){
										if(!confirm("Se eliminara la imagen <'.$img.'>, desea continuar?")){
											//necesito cancelar
											xhr.abort();
										}else{
											//aqui se borraria la imagen
										}
							                //alert("here we go");
										//$("#maindiv").addClass("loading");
						                        }',
							                'success'=>'function(msg){
										console.log(msg);
										var didi=document.getElementById("imagen'.$idi.'");
										//didi.innerHTML="its okey!!!";
										didi.remove();
						                        }',
							                'error'=>'function(jqxhr,textStatus,errorThrown){
										var output = "";
										for (property in jqxhr) {
											output += property + ": " + jqxhr[property]+"; ";
										}
										console.log(output);

									}',
									'update'=>'#imagen'.$idi
						            )
								
							);
							echo "</div>";
						}
							$this->widget('CMultiFileUpload', array(
			                			'name' => 'evidencia_antes',
										'max'=>4,
			                			'accept' => 'jpeg|jpg|gif|png|txt', // useful for verifying files
			                			'duplicate' => 'Archivo Repetido!', // useful, i think
	                					'denied' => 'Tipo de archivo invalido', // useful, i think

			                		));
						}else{
							$this->widget('CMultiFileUpload', array(
					                'name' => 'evidencia_antes',
									'max'=>4,
					                'accept' => 'jpeg|jpg|gif|png|txt', // useful for verifying files
					                'duplicate' => 'Archivo Repetido!', // useful, i think
			                		'denied' => 'Tipo de archivo invalido.', // useful, i think
					                )); 
						}//end if
			 		?>
                </div>
                <div class="span6" style="text-align: center">
					<label class="control-label" for="Evidencias_evidencia_despues">Evidencia Fotografica Despues</label>
                    <?php 
						if(isset($model)&&$model->id!=""){//es una actualizacion
							//1. debo obtener el listado de las imagenes que ya se tienen
							$imagenes_despues=ImagenesDespues::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
							//2. hago iteracion sobre este objeto y muestro los nombres de archivo, junto a una opcion para eliminar
							// aca utilizar ajax
							$i=count($imagenes_despues);
							
							for($j=0;$j<$i;$j++){
				        		$img=$imagenes_despues[$j]->nombre_archivo;
								$idi=$imagenes_despues[$j]->id;
								echo "<div id='imagen$idi'>$img ";
								echo CHtml::ajaxLink(
									'eliminar',          // the link body (it will NOT be HTML-encoded.)
									$this->createUrl('evidencias/ajax'), // the URL for the AJAX request.
									array(
								                'type'=>'GET',
								                'cache'=>false,
								                'url'=>$this->createUrl('evidencias/ajax'),
								                'data'=>array('type'=>'borrarImagenForm','id_imagen'=>$idi,'typeImage'=>'despues'),
								                'beforeSend'=>'function(xhr, opts){
											if(!confirm("Se eliminara la imagen <'.$img.'>, desea continuar?")){
												//necesito cancelar
												xhr.abort();
											}else{
												//aqui se borraria la imagen
											}

											//$("#maindiv").addClass("loading");
							                        }',
								                'success'=>'function(msg){
											console.log(msg);
											var didi=document.getElementById("imagen'.$idi.'");
											//didi.innerHTML="its okey!!!";
											didi.remove();
							                        }',
								                'error'=>'function(jqxhr,textStatus,errorThrown){
											var output = "";
											for (property in jqxhr) {
												output += property + ": " + jqxhr[property]+"; ";
											}
											console.log(output);

										}',
										'update'=>'#imagen'.$idi
							                )
									
								);
								echo "</div>";
							}
							$this->widget('CMultiFileUpload', array(
				                			'name' => 'evidencia_despues',
											'max'=>4,
				                			'accept' => 'jpeg|jpg|gif|png|txt', // useful for verifying files
				                			'duplicate' => 'Archivo repetido!', // useful, i think
		                					'denied' => 'Tipo de archivo invalido.', // useful, i think
				                		));
		                }else{

							$this->widget('CMultiFileUpload', array(
					                'name' => 'evidencia_despues',
									'max'=>4,
					                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
					                'duplicate' => 'Archivo repetido!', // useful, i think
					                'denied' => 'Tipo de archivo invalido.', // useful, i think
				                ));

						}//end if
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
                                ); ?>
                </div>
            </div>
     </div>
</fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->

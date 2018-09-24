<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'content-form',
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
<legend>Datos Content</legend>
<div class="container-fluid">
        <div class="row-fluid">           
	<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'title',array('maxlength'=>200,'class' => 'span12')); ?>
		
		                    </div>	                   
	<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'alias',array('maxlength'=>100,'class' => 'span6')); ?>
		
		                    </div>	                   
				                   
		                </div>
        <div class="row-fluid">           
	<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'category',array('maxlength'=>200,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	<?php echo $form->toggleButtonRow($model,'published', array('enabledLabel' => 'Si','disabledLabel' => 'No')); ?>
                
		
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
                                                                            'width' => '100%',
                                                                            'resize_maxWidth' => '640',
                                                                            'resize_minWidth' => '320'
                                                                            )
                                                        )
                                                ); ?>
		
		                    </div>	                   
				                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->datetimepickerRow(
                                            $model,
                                            'date_end',
                                             array('options' => array(
                                                                        'showMeridian' => false,
                                                                        'minuteStep' => 5    
                                                                        ),
                                                  'htmlOptions' =>  array()                      
                                                  )
                                           ); ?>
		
		                    </div>
                    <div class="span6">
                	
                <?php echo $form->datetimepickerRow(
                                            $model,
                                            'date_init',
                                             array('options' => array(
                                                                        'showMeridian' => false,
                                                                        'minuteStep' => 5    
                                                                        ),
                                                  'htmlOptions' =>  array()                      
                                                  )
                                           ); ?>
		
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
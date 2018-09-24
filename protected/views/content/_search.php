<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',	'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
)); ?>
<div class="container-fluid">
        <div class="row-fluid">           
	<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'category',array('maxlength'=>200,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'content',array('class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->toggleButtonRow($model,'published', array('enabledLabel' => 'Si','disabledLabel' => 'No')); ?>
		
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
			         </div>
            <div class="row-fluid">
                <div class="span12" style="text-align: center">
                    <?php $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'buttonType' => 'submit', 
                                    'type' => 'primary',
                                    'label' => 'Buscar'
                                    )
                                ); ?>                </div>
            </div>
     </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->
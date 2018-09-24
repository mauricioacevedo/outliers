<?php
/* @var $this UsersController */
/* @var $model Users */
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
                	
                <?php echo $form->textFieldRow($model,'givenname',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'samaccountname',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'mail',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->passwordFieldRow($model,'passwd',array('class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Userstatus::model()->findAll(), 'id', 'status');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'user_status',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
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
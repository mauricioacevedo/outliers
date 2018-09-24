<?php
/* @var $this EvidenciasController */
/* @var $model Evidencias */
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
                	
                <?php echo $form->textFieldRow($model,'pedido',array('maxlength'=>100,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Tecnicos::model()->findAll(), 'id', 'nombre');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'tecnico_id',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Hallazgos::model()->findAll(), 'id', 'hallazgo');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'hallazgos',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true)
                                             ); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Solucion::model()->findAll(), 'id', 'solucion');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'solucion',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true)
                                             ); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->textAreaRow($model,'acciondemejora',array('rows'=>6, 'cols'=>50, 'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->datetimepickerRow(
                                            $model,
                                            'fecha_cerrado',
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
                	
                <?php /*echo $form->textFieldRow($model,'cliente',array('maxlength'=>255,'class' => 'span6'));*/ ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'documento_cliente',array('maxlength'=>255,'class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Productos::model()->findAll(), 'id', 'producto');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'producto',
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
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Plazas::model()->findAll(), 'id', 'plaza');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'plaza',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php /* $fieldTypeFormOptions = CHtml::listData(Contratos::model()->findAll(), 'id', 'contrato');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'contrato',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); */ ?>
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Motivo::model()->findAll(), 'id', 'motivo');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'motivo_outlier',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true)
                                             ); ?>
		
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
                	
                <?php $fieldTypeFormOptions = CHtml::listData(Diagnosticotecnico::model()->findAll(), 'id', 'diagnostico');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'diagnostico_tecnico',
                                             $fieldTypeFormOptions, 
                                             array( 'multiple' => true)
                                             ); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textAreaRow($model,'observaciones',array('rows'=>6, 'cols'=>50, 'class' => 'span6')); ?>
		
		                    </div>	                   
		                </div>
                <div class="row-fluid">
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'descuento',array('maxlength'=>45,'class' => 'span6')); ?>
		
		                    </div>	                   
			<div class="span6">
                	
                <?php echo $form->textFieldRow($model,'rere',array('maxlength'=>45,'class' => 'span6')); ?>
		
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

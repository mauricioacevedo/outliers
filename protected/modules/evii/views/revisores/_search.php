<?php
/* @var $this RevisoresController */
/* @var $model Revisores */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',    'htmlOptions'=>array('autocomplete'=>'off'),
  'type' => 'horizontal',
)); ?>
<div class="container-fluid">
        <div class="row-fluid">           
    <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'nombre',array('maxlength'=>100,'class' => 'span6')); ?>
        
                            </div>                       
            <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'cedula',array('maxlength'=>100,'class' => 'span6')); ?>
        
                            </div>                       
                        </div>
                <div class="row-fluid">
            <div class="span6">
                    
                <?php $fieldTypeFormOptions = CHtml::listData(Ciudades::model()->findAll(), 'id', 'ciudad');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'ciudad',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
        
                            </div>                       
            <div class="span6">
                    
                <?php $fieldTypeFormOptions = CHtml::listData(Contratos::model()->findAll(), 'id', 'contrato');
                                            echo $form->dropDownListRow(
                                             $model,
                                             'contrato',
                                             $fieldTypeFormOptions, 
                                             array('prompt' => 'Seleccione')
                                             ); ?>
        
                            </div>                       
                        </div>
                <div class="row-fluid">
            <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'creadopor',array('maxlength'=>100,'class' => 'span6')); ?>
        
                            </div>                       
            <div class="span6">
                    
                <?php echo $form->textFieldRow($model,'modificadopor',array('maxlength'=>100,'class' => 'span6')); ?>
        
                            </div>                       
                        </div>
                <div class="row-fluid">
            <div class="span6">
                    
                <?php echo $form->datetimepickerRow(
                                            $model,
                                            'fechamodificacion',
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
                                            'fechacreacion',
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
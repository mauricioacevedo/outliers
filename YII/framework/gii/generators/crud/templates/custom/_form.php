<?php
/*
 * Se remueve la s al final  para que este acorde a la relación en el modelo
 * 
 */
function removeS($tableName)
{    
        if(strtolower(substr($tableName,-1)) == 's'){
            return substr($tableName,0,-1);
        }else{
            return $tableName;
        }        
}
?>
<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.\n";
	echo "	'htmlOptions'=>array('autocomplete'=>'off'),\n";
	echo "  'type' => 'horizontal',\n";        
	if($this->enableAjaxValidation){	
	echo "	'enableAjaxValidation'	=> true,
	'enableClientValidation'	=> true,
	'clientOptions'				=> array(
										'validateOnSubmit' => true,
										),";
	}else{
	echo "	'enableAjaxValidation'		=>false\n"; 
	}
echo ")); ?>\n"; ?>

<p class="note">Campos con <span class="required">*</span> son requeridos.</p>
<?php
echo "
<?php
        \$this->widget('bootstrap.widgets.TbAlert', array(
                        'block' => true,
                        'fade' => true,
                        'closeText' => '&times;',
                        'events' => array(),
                        'htmlOptions' => array(),
                        'userComponentId' => 'user'
                        )
                    );    
?>
";

function generateMyLabel($label){
	$label=ucwords(trim(strtolower(str_replace(array('-','_'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $label)))));
	$label=preg_replace('/\s+/',' ',$label);
	if(strcasecmp(substr($label,-3),' id')===0)
		$label=substr($label,0,-3);
	if($label==='Id')
		$label='ID';
	$label=str_replace("'","\\'",$label);
	return $label;
}
?>
<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>
<fieldset style="width: 98%">
<legend>Datos <?php echo $this->modelClass ?></legend>
<div class="container-fluid">
        <div class="row-fluid">           
	<?php
	$no	= 1;
	$col	= 0; 
        if($this->columnsForm == 1){
            $class = "span12";
        }elseif($this->columnsForm == 2){
            $class = "span6";        
        }elseif($this->columnsForm == 3){
            $class = "span4";        
        }elseif($this->columnsForm == 4){
            $class = "span3";
        }
	foreach($this->tableSchema->columns as $column)
	{ 
            /**
             * Pregunto si se crea el campo
             */         
        if(in_array($column->name, $this->createField)){
		$fields[$column->name] 			= 1;
		if($this->commentsAsLabels && $column->comment){
			$fieldsLabels[$column->name] 	= generateMyLabel($column->comment);
		}else{
			$fieldsLabels[$column->name] 	= generateMyLabel($column->name);
		}
		if($column->autoIncrement || $column->isPrimaryKey){
			$fieldKey = $column->name;
			continue;
		}
	?>
<div class="<?php echo $class ?>">
                <?php /*echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>";*/ ?>	
                <?php echo "<?php ".$this->generateActiveField($this->modelClass,$column, $this->tableSchema)."; ?>\n"; ?>		
		<?php /*echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n";*/ ?>
                    </div>	                   
		<?php 
		$col++;
		if($col == $this->columnsForm){
			$col = 0;
		?>
                </div>
                <div class="row-fluid">
		<?php } ?>
	<?php
            if($no>=2)
            {
                   $style = "";
                   $style2 = "";
            }
           $no++;
           }
        }
	
	/**
	 * Generar Reporte
	 */
        
	if($this->generateReport && $_POST['generate']){
		try {
			require_once(Yii::getPathOfAlias('application.modules.jqgrid.models').DIRECTORY_SEPARATOR.'ReportModel.php');
			require_once(Yii::getPathOfAlias('application.modules.jqgrid.models').DIRECTORY_SEPARATOR.'Reports.php');
			require_once(Yii::getPathOfAlias('application.modules.jqgrid.models').DIRECTORY_SEPARATOR.'ReportsFields.php');
			$objReportModel = new ReportModel();
			$objReportModel->createGridReport($this->modelClass, $fieldKey, $this->tableSchema->name, $this->tableSchema->columns, $fields, $fieldsLabels);
			$this->reportId = $objReportModel->report_id; 
		} catch (Exception $e) {
			print_r($e);
		}				
	}
	
	?>
         </div>
            <div class="row-fluid">
                <div class="span12" style="text-align: center">
                    <?php echo "<?php \$this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'buttonType' => 'submit', 
                                    'type' => 'primary',
                                    'label' => \$model->isNewRecord ? 'Guardar' : 'Actualizar'
                                    )
                                ); ?>"; ?>
                </div>
            </div>
     </div>
</fieldset>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div><!-- form -->
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
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',";
        echo "	'htmlOptions'=>array('autocomplete'=>'off'),\n";
	echo "  'type' => 'horizontal',\n"; 
echo ")); ?>\n"; 


?>
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
	?>
         </div>
            <div class="row-fluid">
                <div class="span12" style="text-align: center">
                    <?php echo "<?php \$this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'buttonType' => 'submit', 
                                    'type' => 'primary',
                                    'label' => 'Buscar'
                                    )
                                ); ?>"; ?>
                </div>
            </div>
     </div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div><!-- search-form -->
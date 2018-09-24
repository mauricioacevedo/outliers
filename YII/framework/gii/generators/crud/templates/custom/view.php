<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
if($this->createBreadCrumbs){
	$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
	$label=$this->pluralize($this->class2name($this->modelClass));	
        echo "\$this->breadcrumbs = array('$label' => array('admin'),
                        'Nuevo'=> array('create'),
                        \$model->{$nameColumn}
                     );\n";
}
?>
?>

<h1><?php echo $this->modelClass." #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column){
	$format = '';
	if($column->type==='boolean' || $column->dbType==='int(1)' || $column->dbType==='tinyint(1)' || $column->dbType==='bit(1)'){
		$format = ':boolean';
	}
	echo "\t\t'".$column->name.$format."',\n";
}
?>
	),
)); ?>

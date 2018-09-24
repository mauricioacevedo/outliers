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
                        \$model->{$nameColumn}=> array('view&id='.\$model->{$this->tableSchema->primaryKey}),
                        'Actualizar',
                    );\n";
}
?>
?>

<h1>Actualizar <?php echo $this->modelClass." <?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
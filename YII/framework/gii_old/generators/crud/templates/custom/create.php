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
	$label=$this->pluralize($this->class2name($this->modelClass));
        echo "\$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('$label' => array('admin'), 'Nuevo'),
        ));\n";
}
?>
?>

<h1>Crear <?php echo $this->modelClass; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

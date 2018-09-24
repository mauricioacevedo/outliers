<?php if($this->generateReport){ ?>
<div style="width: 100%">	
<?php echo "<?php echo \$grid ?>"; ?>
</div>
<?php }else{ ?>
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
         echo "\$this->breadcrumbs = array('$label' => array('admin'),
                        'Nuevo' => array('create'),
                        'Admin'
                );\n";
}
?>

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<p>
Usted puede opcionalmente agregar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada una de sus valores de búsquedas para especificar como la comparación debería ser realizada.
</p>

<?php echo "<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>"; ?>
<div id="search-allform">
<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->
<div class="icons-exports">
<?php echo "<?php"; ?> 
$arrFileType = array('csv'=>'Csv','txt'=>'Txt','pdf'=>'Pdf', 'word' => 'Word');
$imgExport = '';
 foreach ($arrFileType as $key => $type) {   
  <?php 
    echo "\$imgExport .= '<img src=\"'.Yii::app()->baseUrl.'/images/16x16/'.\$key.'.png\" id=\"export-'.\$key.'\" style=\"cursor:pointer\"/>&nbsp;';";
    ?>   
    Yii::app()->clientScript->registerScript('<?php echo $this->class2id($this->modelClass); ?>-'.$key, "
        $('#export-".$key."').on('click',function() { 
            $.fn.yiiGridView.export".$key."();
        });
        $.fn.yiiGridView.export".$key." = function() {
            $.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid',{
                success: function() {
                    $('#<?php echo $this->class2id($this->modelClass); ?>-grid').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('export')  . "&export=true&type=".$key."&'+$('#search-allform input').serialize();
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
        ");
} 
<?php echo "echo \$imgExport; ?>"; ?>
</div>
<?php echo "<?php"; ?> 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'responsiveTable' => true,
        'pager' => array('class' => 'CLinkPager',
                       'cssFile' => false,
                       'header' => false,
                       'firstPageLabel' => 'Primero',
                       'lastPageLabel' => 'Ultimo',
                   ),
        'type' => 'striped bordered condensed',
	'columns'=>array(
<?php        
$count=0;
$fieldId = '';
foreach($this->tableSchema->columns as $column)
{ 
    if($count==0){
        $fieldId = $column->name;
    }
	if(++$count==7){
		echo "\t\t/*\n";
        }
        if(!$column->isForeignKey){
            if($column->type==='boolean' || $column->dbType==='int(1)' || $column->dbType==='tinyint(1)' || $column->dbType==='bit(1)'){
                echo "\t\t'".$column->name.":booleanState',\n";
            }else{
                echo "\t\t'".$column->name."',\n";
            }
        }else{
            $key            = $this->tableSchema->foreignKeys[$column->name][1];
            $description    = $key;	
            $arrForeignColumns 	= Yii::app()->db->schema->tables[$this->tableSchema->foreignKeys[$column->name][0]]->columns;
            if(is_array($arrForeignColumns)){
                foreach ($arrForeignColumns as $key1 => $arrColumn){
                        if($key1 != $key){
                                $description = $key1;
                                break;
                        }
                }
                $table  	= $this->tableSchema->foreignKeys[$column->name][0];               
                $table	= str_ireplace('tbl_p_', '', $table);
                $table	= str_ireplace('tbl_', '', $table);
                $table	= str_ireplace('_', '', $table);	
                $table	= removeS($table);	
               echo "\t\tarray('name' => '".$column->name."',
                             'value' => '\$data->".$table."->".$description."',\n
                  ),";
            }else{
                if($column->type==='boolean' || $column->dbType==='int(1)' || $column->dbType==='tinyint(1)' || $column->dbType==='bit(1)'){
                    echo "\t\t'".$column->name.":booleanState',\n";
                }else{
                    echo "\t\t'".$column->name."',\n";
                }
            }
        }
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{delete}{update}', // botones a mostrar => {accion_nueva}
                        'viewButtonUrl'=>'Yii::app()->createUrl("/<?php echo $this->class2id($this->modelClass); ?>/view&id=$data-><?php echo $fieldId ?>" )', // url de la acción 'viw'
                        'updateButtonUrl'=>'Yii::app()->createUrl("/<?php echo $this->class2id($this->modelClass); ?>/update&id=$data-><?php echo $fieldId ?>" )', // url de la acción 'update'
                        'deleteButtonUrl'=>'Yii::app()->createUrl("/<?php echo $this->class2id($this->modelClass); ?>/delete&id=$data-><?php echo $fieldId ?>" )', // url de la acción 'delete'
                        'deleteConfirmation'=>'Seguro que quiere eliminar el registro?', // mensaje de confirmación de borrado
                        'afterDelete'=>'$.fn.yiiGridView.update("<?php echo $this->class2id($this->modelClass); ?>-grid");', // actualiza el grid después de borrar
                        /*'buttons'=>array(
                            'accion_nueva' => array( //botón para la acción nueva
                                'label'=>'descripción accion_nueva', // titulo del enlace del botón nuevo
                                'imageUrl'=>Yii::app()->request->baseUrl.'/ruta_carpeta/nombre_foto', //ruta icono para el botón
                                'url'=>'Yii::app()->createUrl("/nombre_modelo/accion_nueva?id=$data->id" )', //url de la acción nueva
                                ),
                            ),*/
                      ),
	),
)); ?>
<?php } ?>
</div>
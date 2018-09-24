<?php
/* @var $this AttachmentController */
/* @var $model Attachment */

$this->breadcrumbs=array(
		'Attachments'=>array('index'),
		'Admin',
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#attachment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Attachments</h1>

<p>
Usted puede opcionalmente agregar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada una de sus valores de búsquedas para especificar como la comparación debería ser realizada.
</p>

<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php 
$arrFileType = array('csv'=>'Csv','txt'=>'Txt','pdf'=>'Pdf', 'word' => 'Word');
$jsExport = "var div = '<div style=\"float:left\">";
 foreach ($arrFileType as $key => $type) {   
    //echo CHtml::button($type, array('id'=>'attachment-'.$key,'class'=>'span-3 button'));  
  $jsExport .= '<img src="'.Yii::app()->baseUrl.'/images/16x16/'.$key.'.png" id="export-$key" style="cursor:pointer"/>&nbsp;';   
    Yii::app()->clientScript->registerScript('attachment-'.$key, "
        $('#export-".$key."').on('click',function() { 
            $.fn.yiiGridView.export".$key."();
        });
        $.fn.yiiGridView.export".$key." = function() {
            $.fn.yiiGridView.update('attachment-grid',{
                success: function() {
                    $('#attachment-grid').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('export')  . "&type=".$key."';
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
        ");
} 
$jsExport .= "</div>';
    $('.summary').html(div+$('.summary').html());
";
Yii::app()->clientScript->registerScript('export', $jsExport);
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'attachment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'responsiveTable' => true,
        'type' => 'striped bordered condensed',
	'columns'=>array(
		'id',
		'module_id',
		'filename',
		'filesize',
		'filepath',
		'zipfile',
		/*
		'attachedby',
		'attacheddate',
		*/
		array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{delete}{update}', // botones a mostrar => {accion_nueva}
                        'viewButtonUrl'=>'Yii::app()->createUrl("/attachment/view&id=$data->id" )', // url de la acción 'viw'
                        'updateButtonUrl'=>'Yii::app()->createUrl("/attachment/update&id=$data->id" )', // url de la acción 'update'
                        'deleteButtonUrl'=>'Yii::app()->createUrl("/attachment/delete&id=$data->id" )', // url de la acción 'delete'
                        'deleteConfirmation'=>'Seguro que quiere eliminar el registro?', // mensaje de confirmación de borrado
                        'afterDelete'=>'$.fn.yiiGridView.update("attachment-grid");', // actualiza el grid después de borrar
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

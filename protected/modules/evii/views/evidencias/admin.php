<?php
/* @var $this EvidenciasController */
/* @var $model Evidencias */



$this->breadcrumbs = array('Evidenciases' => array('admin'),
                        'Nuevo' => array('create'),
                        'Admin'
                );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#evidencias-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


?>

<h1>Administrar Evidencias</h1>

<?php 

  //$headers = apache_request_headers();
/*
foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}*/
  //
  /*foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
  }

*/
  //var_dump(http_get_request_headers());

  //var_dump(headers_list());

?>

<!--p>
Usted puede opcionalmente agregar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada una de sus valores de búsquedas para especificar como la comparación debería ser realizada.
</p-->

<?php //echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?><div id="search-allform">
<div class="search-form" style="display:none">
<?php
 $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="icons-exports">
<?php 
$arrFileType = array('csv'=>'Csv');//,'txt'=>'Txt','pdf'=>'Pdf', 'word' => 'Word');
$imgExport = '';
 foreach ($arrFileType as $key => $type) {   
  $imgExport .= '<img src="'.Yii::app()->baseUrl.'/images/16x16/'.$key.'.png" id="export-'.$key.'" style="cursor:pointer"/>&nbsp;';   
    Yii::app()->clientScript->registerScript('evidencias-'.$key, "
        $('#export-".$key."').on('click',function() { 
            $.fn.yiiGridView.export".$key."();
        });
        $.fn.yiiGridView.export".$key." = function() {
            $.fn.yiiGridView.update('evidencias-grid',{
                success: function() {
                    $('#evidencias-grid').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('export')  . "&export=true&type=".$key."&'+$('#search-allform input').serialize();
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
        ");
} 
echo "Exportar: ".$imgExport; ?></div>

<br><center><font size="5"><a href='/index.php?r=evii/evidencias/create'>Nueva Evidencia</a></font></center>
<?php


$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'evidencias-grid',
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
		//'id',
		'pedido',
		array('name' => 'tecnico_id', 'value' => '$data->getTecnicoName($data->tecnico_id)' ),
		'fecha_cerrado',
		'documento_cliente',
		 array('name' => 'producto', 'value' => '$data->getProducto($data->producto)'),


		/*		array('name' => 'revisor',
                             'value' => '$data->revisore->nombre',

                  ),		array('name' => 'plaza',
                             'value' => '$data->plaza->plaza',

                  ),		array('name' => 'contrato',
                             'value' => '$data->contrato->contrato',

                  ),		array('name' => 'motivo_outlier',
                             'value' => '$data->motivo->motivo',

                  ),		array('name' => 'responsable_dano',
                             'value' => '$data->responsabledano->responsable_dano',

                  ),		array('name' => 'diagnostico_tecnico',
                             'value' => '$data->diagnosticotecnico->diagnostico',

                  ),		'observaciones',
		'descuento',
		'rere',
		array('name' => 'lider_de_plaza',
                             'value' => '$data->lideresdeplaza->lider',

                  ),		'historico_pedido',
		'creadopor',
		'modificadopor',
		'fechamodificacion',
		'fechacreacion',
		*/
		array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        //'template'=>'{view}{delete}{update}', // botones a mostrar => {accion_nueva}
                        'template'=>'{view}{update}', // botones a mostrar => {accion_nueva}
                        'viewButtonUrl'=>'Yii::app()->createUrl("evii/evidencias/view&id=$data->id" )', // url de la acción 'viw'
                        'updateButtonUrl'=>'Yii::app()->createUrl("evii/evidencias/update&id=$data->id" )', // url de la acción 'update'
                        //'deleteButtonUrl'=>'Yii::app()->createUrl("evii/evidencias/delete&id=$data->id" )', // url de la acción 'delete'
                        //'deleteConfirmation'=>'Seguro que quiere eliminar el registro?', // mensaje de confirmación de borrado
                        //'afterDelete'=>'$.fn.yiiGridView.update("evidencias-grid");', // actualiza el grid después de borrar
                        /*'buttons'=>array(
                            'accion_nueva' => array( //botón para la acción nueva
                                'label'=>'descripción accion_nueva', // titulo del enlace del botón nuevo
                                'imageUrl'=>Yii::app()->request->baseUrl.'/ruta_carpeta/nombre_foto', //ruta icono para el botón
                                'url'=>'Yii::app()->createUrl("/nombre_modelo/accion_nueva?id=$data->id" )', //url de la acción nueva
                                ),
                            ),*/
                      ),
	),
)); 


 ?>
</div>

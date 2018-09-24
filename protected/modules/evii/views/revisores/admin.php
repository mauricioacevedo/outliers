<?php
/* @var $this RevisoresController */
/* @var $model Revisores */

$this->breadcrumbs = array('Revisores' => array('admin'),
                        'Nuevo' => array('create'),
                        'Admin'
                );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#revisores-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Administrar Revisores</h1>

<!--p>
Usted puede opcionalmente agregar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada una de sus valores de búsquedas para especificar como la comparación debería ser realizada.
</p-->

<?php //echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?><div id="search-allform">
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="icons-exports">
<?php 
$arrFileType = array('csv'=>'Csv','txt'=>'Txt','pdf'=>'Pdf', 'word' => 'Word');
$imgExport = '';
 foreach ($arrFileType as $key => $type) {   
  $imgExport .= '<img src="'.Yii::app()->baseUrl.'/images/16x16/'.$key.'.png" id="export-'.$key.'" style="cursor:pointer"/>&nbsp;';   
    Yii::app()->clientScript->registerScript('revisores-'.$key, "
        $('#export-".$key."').on('click',function() { 
            $.fn.yiiGridView.export".$key."();
        });
        $.fn.yiiGridView.export".$key." = function() {
            $.fn.yiiGridView.update('revisores-grid',{
                success: function() {
                    $('#revisores-grid').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('export')  . "&export=true&type=".$key."&'+$('#search-allform input').serialize();
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
        ");
} 
//echo $imgExport; ?></div>

<br><center><font size="5"><a href='/index.php?r=evii/revisores/create'>Nuevo Revisor</a></font></center>

<?php 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'revisores-grid',
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
        'nombre',
        'cedula',
        //array('name' => 'ciudad','value' => '$data->ciudad->ciudad', ),
        //array('name' => 'contrato','value' => '$data->contrato->contrato',),
        array('name' => 'contrato', 'value' => '$data->getContratoName($data->contrato)', ),
        array('name' => 'ciudad', 'value' => '$data->getCiudadName($data->ciudad)', ),

        //'creadopor',
        /*
        'modificadopor',
        'fechamodificacion',
        'fechacreacion',
        */
        array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{delete}{update}', // botones a mostrar => {accion_nueva}
                        'viewButtonUrl'=>'Yii::app()->createUrl("evii/revisores/view&id=$data->id" )', // url de la acción 'viw'
                        'updateButtonUrl'=>'Yii::app()->createUrl("evii/revisores/update&id=$data->id" )', // url de la acción 'update'
                        'deleteButtonUrl'=>'Yii::app()->createUrl("evii/revisores/delete&id=$data->id" )', // url de la acción 'delete'
                        'deleteConfirmation'=>'Seguro que quiere eliminar el registro?', // mensaje de confirmación de borrado
                        'afterDelete'=>'$.fn.yiiGridView.update("revisores-grid");', // actualiza el grid después de borrar
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
</div>
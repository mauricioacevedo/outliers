<?php
/* @var $this TecnicosController */
/* @var $model Tecnicos */


$this->breadcrumbs = array('Tecnicoses' => array('admin'),
                        'Nuevo' => array('create'),
                        'Admin'
                );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#tecnicos-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Administrar Técnicos</h1>

<!--p>
Usted puede opcionalmente agregar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada una de sus valores de búsquedas para especificar como la comparación debería ser realizada.
</p-->

<?php //echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>

<!--div id="search-allform">
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
    'model'=>$model,
)); */?>
</div--><!-- search-form -->
<div class="icons-exports">
<?php 
$arrFileType = array('csv'=>'Csv','txt'=>'Txt','pdf'=>'Pdf', 'word' => 'Word');
$imgExport = '';
 foreach ($arrFileType as $key => $type) {   
  $imgExport .= '<img src="'.Yii::app()->baseUrl.'/images/16x16/'.$key.'.png" id="export-'.$key.'" style="cursor:pointer"/>&nbsp;';   
    Yii::app()->clientScript->registerScript('tecnicos-'.$key, "
        $('#export-".$key."').on('click',function() { 
            $.fn.yiiGridView.export".$key."();
        });
        $.fn.yiiGridView.export".$key." = function() {
            $.fn.yiiGridView.update('tecnicos-grid',{
                success: function() {
                    $('#tecnicos-grid').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('export')  . "&export=true&type=".$key."&'+$('#search-allform input').serialize();
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
        ");
} 
//echo $imgExport; ?></div>

<br><center><font size="5"><a href='/index.php?r=evii/tecnicos/create'>Nuevo Técnico</a></font></center>
<?php 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
        'id'=>'tecnicos-grid',
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
        'identificacion',
        array('name' => 'contrato', 'value' => '$data->getContratoName($data->contrato)', ),
        array('name' => 'ciudad', 'value' => '$data->getCiudadName($data->ciudad)', ),
        'celular',
        /*
        'creadopor',
        'modificadopor',
        'fechamodificacion',
        'fechacreacion',
        */
        array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{delete}{update}', // botones a mostrar => {accion_nueva}
                        'viewButtonUrl'=>'Yii::app()->createUrl("evii/tecnicos/view&id=$data->id" )', // url de la acción 'viw'
                        'updateButtonUrl'=>'Yii::app()->createUrl("evii/tecnicos/update&id=$data->id" )', // url de la acción 'update'
                        'deleteButtonUrl'=>'Yii::app()->createUrl("evii/tecnicos/delete&id=$data->id" )', // url de la acción 'delete'
                        'deleteConfirmation'=>'Seguro que quiere eliminar el registro?', // mensaje de confirmación de borrado
                        'afterDelete'=>'$.fn.yiiGridView.update("tecnicos-grid");', // actualiza el grid después de borrar
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
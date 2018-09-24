<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array('Users' => array('admin'),
                        'Nuevo' => array('create'),
                        'Admin'
                );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Usuarios</h1>
<?php 
$msg=$_GET['msg'];
if($msg!="") {
    echo "<br>Mensaje: <font color='red'>$msg</font>"; 
}
?>
<!--p>
Usted puede opcionalmente agregar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al comienzo de cada una de sus valores de búsquedas para especificar como la comparación debería ser realizada.
</p-->

<?php // echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?><div id="search-allform">
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--div class="icons-exports">
<?php /*
$arrFileType = array('csv'=>'Csv','txt'=>'Txt','pdf'=>'Pdf', 'word' => 'Word');
$imgExport = '';
 foreach ($arrFileType as $key => $type) {   
  $imgExport .= '<img src="'.Yii::app()->baseUrl.'/images/16x16/'.$key.'.png" id="export-'.$key.'" style="cursor:pointer"/>&nbsp;';   
    Yii::app()->clientScript->registerScript('users-'.$key, "
        $('#export-".$key."').on('click',function() { 
            $.fn.yiiGridView.export".$key."();
        });
        $.fn.yiiGridView.export".$key." = function() {
            $.fn.yiiGridView.update('users-grid',{
                success: function() {
                    $('#users-grid').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('export')  . "&export=true&type=".$key."&'+$('#search-allform input').serialize();
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
        ");
} 
echo $imgExport;*/ ?></div-->

<br><center><font size="5"><a href='/index.php?r=user/users/create'>Nuevo Usuario</a></font></center>

<?php

$criteria=new CDbCriteria;
$criteria->addCondition("samaccountname !='admin'");;
$dataProvider = new CActiveDataProvider(get_class($model),array('criteria'=>$criteria));
 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'dataProvider'=>$dataProvider,
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
		//'user_id',
		'givenname',
		//'sn',
		'samaccountname',
		//'employeenumber',
		//'departmentnumber',
		
		//'department',
		//'id_profile',
		//'cn',
		'mail',
		//'passwd',
		//'sessionid',
		//'last_visit_date',
		//array('name' => 'user_status', 'value' => '$data->userstatu->status', ),		
    /*'immediate_boss',
		'immediate_boss_mail',
		'streetaddress',
		'headquarters',
		'telephonenumber',
		'mobile',
		'location',
		'module_id',
		'pic_profile_id',
		'creadopor',
		'fechacreacion',
		'modificadopor',
		'fechamodificacion',
		*/
		array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        //'template'=>'{view}{delete}{update}', // botones a mostrar => {accion_nueva}
                        'template'=>'{view}{update}{delete}', // botones a mostrar => {accion_nueva}
                        'viewButtonUrl'=>'Yii::app()->createUrl("user/users/view&id=$data->user_id" )', // url de la acción 'viw'
                        'updateButtonUrl'=>'Yii::app()->createUrl("user/users/update&id=$data->user_id" )', // url de la acción 'update'
                        'deleteButtonUrl'=>'Yii::app()->createUrl("user/users/delete&id=$data->user_id" )', // url de la acción 'delete'
                        //'deleteConfirmation'=>'Seguro que quiere eliminar el registro?', // mensaje de confirmación de borrado
                        //'afterDelete'=>'$.fn.yiiGridView.update("users-grid");', // actualiza el grid después de borrar
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

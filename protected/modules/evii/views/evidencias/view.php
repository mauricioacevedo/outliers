<?php
/* @var $this EvidenciasController */
/* @var $model Evidencias */

$this->breadcrumbs = array('Evidenciases' => array('admin'),
                        'Nuevo'=> array('create'),
                        $model->id
                     );
?>

<h1>Evidencia #<?php echo $model->id;?></h1>

<?php
//tratar de llenar hallazgos con informacion..
$id=$model->id;
$hallazgoss = Yii::app()->db->createCommand()
    ->select('b.hallazgo')
    ->from('evidenciasxhallazgos u')
    ->join('hallazgos b', 'b.id=u.hallazgo_id')
    ->where('u.evidencia_id=:id', array(':id'=>$id))
    ->queryAll();

//print_r($hallazgoss[0]['hallazgo']);

$k=count($hallazgoss);
$hall="<ul>";
$sep="";
for($i=0;$i<$k;$i++){
	$hall=$hall."<li> [".$hallazgoss[$i]['hallazgo']."]</li>";
}
$hall=$hall."</ul>";
$model->hallazgos=$hall;

//customizar la solucion:

$ss = Yii::app()->db->createCommand()
    ->select('b.solucion')
    ->from('evidenciasxsolucion u')
    ->join('solucion b', 'b.id=u.solucion_id')
    ->where('u.evidencia_id=:id', array(':id'=>$id))
    ->queryAll();

 
$k=count($ss);
$hall="<ul>";
$sep="";
for($i=0;$i<$k;$i++){
        $hall=$hall."<li> [".$ss[$i]['solucion']."]</li>";
}
$hall=$hall."</ul>";
$model->solucion=$hall;


//customizar las acciones de mejora:

$ss = Yii::app()->db->createCommand()
    ->select('b.accion')
    ->from('evidenciasxaccionmejora u')
    ->join('acciondemejora b', 'b.id=u.accionmejora_id')
    ->where('u.evidencia_id=:id', array(':id'=>$id))
    ->queryAll();

 
$k=count($ss);
$hall="<ul>";
$sep="";
for($i=0;$i<$k;$i++){
        $hall=$hall."<li> [".$ss[$i]['accion']."]</li>";
}
$hall=$hall."</ul>";
$model->acciondemejora=$hall;


//customizar los motivos
$ss = Yii::app()->db->createCommand()
    ->select('b.motivo')
    ->from('evidenciasxmotivo u')
    ->join('motivo b', 'b.id=u.motivo_id')
    ->where('u.evidencia_id=:id', array(':id'=>$id))
    ->queryAll();


$k=count($ss);
$hall="<ul>";
$sep="";
for($i=0;$i<$k;$i++){
        $hall=$hall."<li> [".$ss[$i]['motivo']."]</li>";
}
$hall=$hall."</ul>";
$model->motivo_outlier=$hall;

//customizar diagnostico del tecnico

$ss = Yii::app()->db->createCommand()
    ->select('b.diagnostico')
    ->from('evidenciasxdiagnosticotecnico u')
    ->join('diagnosticotecnico b', 'b.id=u.diagnostico_id')
    ->where('u.evidencia_id=:id', array(':id'=>$id))
    ->queryAll();


$k=count($ss);
$hall="<ul>";
$sep="";
for($i=0;$i<$k;$i++){
        $hall=$hall."<li> [".$ss[$i]['diagnostico']."]</li>";
}
$hall=$hall."</ul>";
$model->diagnostico_tecnico=$hall;

?>
<table class="detail-view" width="100%" align="center">

<tr class='even'>
<td width="50%">
<b>Pedido:</b> <?php echo $model->pedido; ?>

</td>
<td width="50%">
<b>Técnico:</b> <?php $tecnico=Tecnicos::model()->findByPk($model->tecnico_id); echo $tecnico->nombre; ?>
</td>
</tr>

<tr class='odd'>
<td width="50%"><b>Documento Cliente:</b> <?php echo $model->documento_cliente; ?></td>
<td width="50%"><b>Producto:</b> <?php echo Productos::model()->findByPk($model->producto)->producto; ?></td>
</tr>

<tr class='even'>
<td width="50%"><b>Revisor:</b> <?php echo Revisores::model()->findByPk($model->revisor)->nombre; ?></td>
<td width="50%"><b>Plaza:</b> <?php echo Plazas::model()->findByPk($model->plaza)->plaza; ?></td>
</tr>

<tr class='odd'>
<td width="50%"><b>Lider de plaza:</b> <?php echo Lideresdeplaza::model()->findByPk($model->lider_de_plaza)->lider; ?></td>
<td width="50%"><b>Fecha de Cerrado:</b> <?php echo $model->fecha_cerrado; ?></td>
</tr>


<tr class='even'>
<td width="50%"><b>Hallazgos:</b> <?php echo $model->hallazgos; ?></td>
<td width="50%"><b>Solución:</b> <?php echo $model->solucion; ?></td>
</tr>

<tr class='odd'>
<td width="50%"><b>Motivo Outlier:</b> <?php echo $model->motivo_outlier; ?></td>
<td width="50%"><b>Diagnóstico Técnico:</b> <?php echo $model->diagnostico_tecnico; ?></td>
</tr>

<tr class='even'>
<td width="50%"><b>Acción de Mejora:</b> <?php echo $model->acciondemejora; ?></td>
<td width="50%"><b>Observaciones:</b> <?php echo $model->observaciones; ?></td>
</tr>

<tr class='odd'>
<td width="50%"><b>Responsable Daño:</b> <?php echo Responsabledano::model()->findByPk($model->responsable_dano)->responsable_dano; ?></td>
<td width="50%"><b>Descuento:</b> <?php echo $model->descuento; ?></td>
</tr>

<?php
	$imagenes_antes=ImagenesAntes::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
	$imagenes_despues=ImagenesDespues::model()->findAll(array("condition"=>"evidencia_id =  ".$model->id));
?>
<tr>
<td valign="top" width="50%">
<b>Evidencia Antes</b>:<br>
<?php
$i=count($imagenes_antes);

for($j=0;$j<$i;$j++){
	$img=$imagenes_antes[$j]->nombre_archivo;
	echo "<a href='javascript:showmodal(\"$img\");'><img src='/archivos/$img' height='400' width='400'></a><br><br>";

}

?>
</td>
<td valign="top" width="50%">
<b>Evidencia Despues</b>:<br>

<?php
$i=count($imagenes_despues);

for($j=0;$j<$i;$j++){
        $img=$imagenes_despues[$j]->nombre_archivo;
        //echo "<img src='/archivos/$img' height='400' width='400'><br><br>";
	echo "<a href='javascript:showmodal(\"$img\");'><img src='/archivos/$img' height='400' width='400'></a><br><br>";
}

?>


</td>
</tr>
</table>
<style>
.modal {width: 1000px;height: 1000px;left: 350px;margin-top: -100px},
//modal {width: 95%;height: 10%;left: 300px;margin-top: -100px},
div {}
</style>
<?php 

$this->beginWidget(
'bootstrap.widgets.TbModal',
array('id' => 'myModal',
)
); ?>
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h4><div id="headz"></div></h4>
</div>
<!--div class="modal-body" id="image-body" width='50%' height='100%'-->
<div id="image-body">
<p>One fine body...</p>
</div>
 
<div class="modal-footer" height="50px">
<?php $this->widget(
'bootstrap.widgets.TbButton',
array(
'label' => 'Close',
'url' => '#',
'htmlOptions' => array('data-dismiss' => 'modal'),
)
); ?>
</div>
 
<?php $this->endWidget(); ?>
<?php /**$this->widget(
'bootstrap.widgets.TbButton',
array(
'label' => 'Click me',
//'context' => 'primary',
'htmlOptions' => array(
'data-toggle' => 'modal',
'data-target' => '#myModal',
),
)
);*/?>

<a data-toggle="modal" data-target="#myModal" class="label" id="kain" src='kain'></a>
<script language='javascript'>
	
	function showmodal(img){
		var divi=document.getElementById("image-body");
		var headz=document.getElementById("headz");
		headz.innerHTML="Imagen: "+img;
		//divi.innerHTML="<img src='/archivos/"+img+"' width='100%' height='100%'>";
		divi.innerHTML="<img class='img1' src='/archivos/"+img+"' height='1300px' width='1300px'>";
		document.getElementById('kain').click();
	}
</script>
</body>
</html>

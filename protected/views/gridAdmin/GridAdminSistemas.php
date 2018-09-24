<?php 
foreach ($gridExternas as $index => $val)
{
echo "INDICE: ".$index." VALOR: ".$gridExternas[$index];
}

if(count($grid))
{
	echo $grid;
}
else
{
	$message		= 'No se encontraron datos o no tiene permisos para ver este sitio.';
	$this->widget('ext.widgets.stateMessages.messages',array('message'=>$message,'type'=>'warning'));
}
?>

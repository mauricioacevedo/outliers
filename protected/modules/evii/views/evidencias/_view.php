<?php
/* @var $this EvidenciasController */
/* @var $data Evidencias */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pedido')); ?>:</b>
	<?php echo CHtml::encode($data->pedido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tecnico_id')); ?>:</b>
	<?php echo CHtml::encode($data->tecnico_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hallazgos')); ?>:</b>
	<?php echo CHtml::encode($data->hallazgos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('solucion')); ?>:</b>
	<?php echo CHtml::encode($data->solucion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acciondemejora')); ?>:</b>
	<?php echo CHtml::encode($data->acciondemejora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_cerrado')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_cerrado); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->documento_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producto')); ?>:</b>
	<?php echo CHtml::encode($data->producto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('revisor')); ?>:</b>
	<?php echo CHtml::encode($data->revisor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('plaza')); ?>:</b>
	<?php echo CHtml::encode($data->plaza); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contrato')); ?>:</b>
	<?php echo CHtml::encode($data->contrato); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('motivo_outlier')); ?>:</b>
	<?php echo CHtml::encode($data->motivo_outlier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('responsable_dano')); ?>:</b>
	<?php echo CHtml::encode($data->responsable_dano); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnostico_tecnico')); ?>:</b>
	<?php echo CHtml::encode($data->diagnostico_tecnico); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descuento')); ?>:</b>
	<?php echo CHtml::encode($data->descuento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rere')); ?>:</b>
	<?php echo CHtml::encode($data->rere); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lider_de_plaza')); ?>:</b>
	<?php echo CHtml::encode($data->lider_de_plaza); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('historico_pedido')); ?>:</b>
	<?php echo CHtml::encode($data->historico_pedido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creadopor')); ?>:</b>
	<?php echo CHtml::encode($data->creadopor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modificadopor')); ?>:</b>
	<?php echo CHtml::encode($data->modificadopor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechamodificacion')); ?>:</b>
	<?php echo CHtml::encode($data->fechamodificacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechacreacion')); ?>:</b>
	<?php echo CHtml::encode($data->fechacreacion); ?>
	<br />

	*/ ?>

</div>

<?php
/* @var $this RevisoresController */
/* @var $data Revisores */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
    <?php echo CHtml::encode($data->nombre); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('cedula')); ?>:</b>
    <?php echo CHtml::encode($data->cedula); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('ciudad')); ?>:</b>
    <?php  echo CHtml::encode($data->getCiudadName($data->ciudad)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('contrato')); ?>:</b>
    <?php echo CHtml::encode($data->contrato); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('creadopor')); ?>:</b>
    <?php echo CHtml::encode($data->creadopor); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('modificadopor')); ?>:</b>
    <?php echo CHtml::encode($data->modificadopor); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('fechamodificacion')); ?>:</b>
    <?php echo CHtml::encode($data->fechamodificacion); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('fechacreacion')); ?>:</b>
    <?php echo CHtml::encode($data->fechacreacion); ?>
    <br />

    */ ?>

</div>
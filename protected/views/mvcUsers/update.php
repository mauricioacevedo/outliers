<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */

?>
<h1>Actualizar usuario: <?php echo "<span style='color:red;'>".$adLdapObj['samaccountname'][0]."</span>"; ?></h1>
<?php if (!$save) { ?>
    <?php $this->renderPartial('/mvcUsers/_form_update', array('model' => $model,'adLdapObj'=>$adLdapObj)); ?>
<?php } else { ?>
    <?php Yii::app()->clientScript->registerScript('refreshGrid', "
        parent.$('#Grid_24').jqGrid('setGridParam').trigger('reloadGrid');	
        setTimeout('parent.$(\'#divVentanaModal\').dialog(\'close\')',2000);
    ");
    ?>
    <div class="flash-success">
        Usuario sincronizado correctamente
    </div>
<?php } ?>

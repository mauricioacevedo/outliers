<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
<div id="head-register">
    <table id="format">
        <tr>
            <td style="width: 25%"></td>
            <td id="border-head">
                <table id="censo">
                    <tr>
                        <td>
                            Si después de ingresar tu usuario de red no se completan los campos automáticamente,<br>
                            te solicitamos completar la información en Censo une dando clic en el botón.
                        </td>
                        <td>
                            <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/global/bt-censo.png"), 'https://censoune.epmtelco.com.co', array('target' => '_blank', 'style' => 'border:none')); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>


<?php if (!$save) { ?>
    <div id="main_content">
        <div id="content">
            <?php $this->renderPartial('/mvcUsers/_form_register', array('model' => $model)); ?>
        </div>
    </div>
<?php } else { ?>

    <div class="flash-success">
        <h2>Su registro ha sido exitoso.</h2>
    </div>

<?php } ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'chk-module',
    'options'=>array(
        'title'=>'Soluciones y Ventas',
        'autoOpen'=>false,
        'modal'=>'true',
        'width'=>'500',
        'height'=>'600',
    ),
));
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
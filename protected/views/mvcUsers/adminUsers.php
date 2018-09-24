<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'AddprogramaVentana',
    'options' => array(
        'title' => 'Administrar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
    ),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<div style="width: auto; margin-left: 1%;" align="center">
    <table class="table-ui-Style" width="50%" style="text-align: center;" border="0" align="center">      
        <tr>
            <td>
                <?php
                echo CHtml::ajaxLink('<button class="btn btn-small">Configurar Roles</button>', $this->createUrl('mvcUsers/AdminUsers', array('report_id' => 20, 'bandera' => 1)), array(
                    'beforeSend' => 'function(r){$("#AddprogramaVentana").html("Cargando...").dialog("open");}',
                    'success' => 'function(r){$("#AddprogramaVentana").html(r); return false;}',
                        ), array('id' => 'showJuiDialog20')
                );
                ?>                
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink('<button class="btn btn-small">Configurar Privilegios</button>', $this->createUrl('mvcUsers/AdminUsers', array('report_id' => 21, 'bandera' => 1)), array(
                    'beforeSend' => 'function(r){$("#AddprogramaVentana").html("Cargando...").dialog("open");}',
                    'success' => 'function(r){$("#AddprogramaVentana").html(r); return false;}',
                        ), array('id' => 'showJuiDialog21')
                );
                ?>   
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink('<button class="btn btn-small">Accesos</button>', $this->createUrl('mvcUsers/AdminUsers', array('report_id' => 19, 'bandera' => 1)), array(
                    'beforeSend' => 'function(r){$("#AddprogramaVentana").html("Cargando...").dialog("open");}',
                    'success' => 'function(r){$("#AddprogramaVentana").html(r); return false;}',
                        ), array('id' => 'showJuiDialog19')
                );
                ?>                
            </td>
            <td>
                <img title="Los permisos se otorgan por acceso a las páginas, es decir, un usuario puede tener diferentes roles por pagina del sistema." src="<?php echo Yii::app()->theme->baseUrl . '/images/global/administration/32x32/Info2.png' ?>" >
            </td>
        </tr>
    </table>
    <br>
</div>
<br>
<?php
if (count($grid)) {
    echo $grid;
} else {
    $message = 'No se encontraron datos o no tiene permisos para ver este sitio.';
    $this->widget('ext.widgets.stateMessages.messages', array('message' => $message, 'type' => 'warning'));
}
?>
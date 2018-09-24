<script type="text/javascript">
/**
 * Función para marcar o desmarcar todos los checkbox de un grupo
 * @param checkboxId
 * @param checked
 */
function checkAll(checkboxId, checked){
    $('input:checkbox').prop('checked', checked);
}

function sendForm(){
	var cont 			= 0;
	var arrayCheckBox 	= '';
	$("input[name=\'columns[]\']:checked").each(function(id){
		 myVar = $("input:checked").get(id);
         arrayCheckBox += myVar.value+'|';
		cont++;
	});	     
	if(cont>0){			       
		$('#divVentanaModal').css('display','block');
		var url 	= '?r=jqgrid/grid/createFile&orientacion='+$('#orientacion').val()+'&tipo=<?php echo $tipo ?>&name='+$("#name").val()+'&columns='+arrayCheckBox;
		var a 		= document.createElement('a');
		a.href		= url;
		a.target 	= '_blank';
		document.body.appendChild(a);
		a.click();
		setTimeout('parent.$("#dialogExportGrid").dialog("close")', 1000);
	}
}
</script>
<?php 
$action 	= Yii::app()->request->baseUrl.'?r=jqgrid/exportar&tipo='.$tipo;
if($tipo == 'pdf'){
  //  echo CHtml::beginForm('', 'javascript:sendForm()', array('target'=>'_blank')); 
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'informe-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'action' => 'javascript:sendForm()',
        'htmlOptions' => array('target'=>'_blank'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => false,
        )));
}else{
   // echo CHtml::beginForm('', 'post'); 
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'informe-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => false,
        )));
}

$colNames = str_replace("'", '', $grid->colNames);
$colNames = explode(',',$colNames);
if($grid->hay_accion && $grid->accion_al_final){
	array_shift($colNames);
}elseif($grid->hay_accion && !$grid->accion_al_final){
	array_pop($colNames);
}
?>

<div class="container-fluid">
    <div class="row-fluid">
<?php
foreach ($grid->columns['name'] as $key => $columName){	
	$alias	= $grid->columns['alias'][$key];
	$label	= $grid->columns['propertys'][$columName]['label'];
	$hidden	= $grid->columns['propertys'][$columName]['hidden']; 
	$export	= $grid->columns['propertys'][$columName]['export']; 
	if($hidden != 'true' && $export){
?>
			<div class="span1">
			<?php 			
			echo CHtml::checkBox('columns[]', true, array('value' => $alias, 'id' => 'col_grid_'.$alias, 'style'=>'text-align:center'));
                        ?> &nbsp;
                        <?php
			echo CHtml::encode($label);
			?>
			</div>					
<?php } 
}?>
        </div>	
    </div>	
<table>
	<?php 
	$colspan = 1;
	if($tipo == 'pdf'){
		$colspan = 2;
	?>
	<tr>
		<td width="10%"><?php echo $grid->language_txt['text_orientation']?>: </td>
		<td><?php 
			$data 		= array('L' => 'Horizontal','P' => 'Vertical');
			echo CHtml::dropDownList('orientacion', $orientacion, $data)
			?>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td style="text-align: center;" colspan="<?php echo $colspan ?>">
                        <?php
                        $this->widget(
                                'bootstrap.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'type' => 'danger',
                            'htmlOptions' => array('name' => 'exportar', 'onclick' => 'sendForm()'),
                            'label' => $grid->language_txt['button_export']
                                )
                        );
                        ?>
                        &nbsp;
                        <?php
                        $this->widget(
                                'bootstrap.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'type' => 'danger',
                            'htmlOptions' => array('name' => 'marcarTodo', 'onclick' => "checkAll('columns[]', true)"),
                            'label' => $grid->language_txt['button_check_all']
                                )
                        );
                        ?>
                        &nbsp;
                        <?php
                        $this->widget(
                                'bootstrap.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'type' => 'danger',
                            'htmlOptions' => array('name' => 'desmarcarTodo', 'onclick' => "checkAll('columns[]', false)"),
                            'label' => $grid->language_txt['button_un_check_all']
                                )
                        );
                        ?>
		</td>
	</tr>
</table>
<?php  
echo CHtml::hiddenField('name', $name); 
?>
<?php $this->endWidget(); ?>
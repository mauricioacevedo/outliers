<?php
$class=get_class($model);
Yii::app()->clientScript->registerScript('gii.crud',"
$('#{$class}_controller').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_model').bind('keyup change', function(){
	var controller=$('#{$class}_controller');
	if(!controller.data('changed')) {
		var id=new String($(this).val().match(/\\w*$/));
		if(id.length>0)
			id=id.substring(0,1).toLowerCase()+id.substring(1);
		controller.val(id);
	}
});
$('#{$class}_generateReport').bind('click', function(){
	if($(this).attr('checked')){
		$('#div_commentsAsLabels').css('display','block');
	}else{
		$('#div_commentsAsLabels').css('display','none');
	}
});
");
?>
<script>
    function checkAll(checkboxName, checked){// alert(checkboxName);
		$("input[name='"+checkboxName+"']").each(function(){
			$(this).attr("checked", checked);
		});
}
</script>
<h1>Crud Generator</h1>

<p>This generator generates a controller and views that implement CRUD operations for the specified data model.</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
        <div class="row">
		<?php echo $form->labelEx($model,'moduleName'); ?>
		 <?php                 
                    $htmlOptions[] = '';
                    $d = dir(Yii::getPathOfAlias('application.modules'));
                    while (false !== ($entry = $d->read())) {
                        if(!in_array($entry, array('.','..','jqgrid','massdataupload'))){
                            $htmlOptions[$entry] = $entry;
                        }
                    }
                    $d->close();    
                    echo $form->dropDownList($model, 'moduleName', $htmlOptions);
                ?>
		
		<?php echo $form->error($model,'moduleName'); ?>
        </div><br>
	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>65)); ?>
		<div class="tooltip">
			Model class is case-sensitive. It can be either a class name (e.g. <code>Post</code>)
		    or the path alias of the class file (e.g. <code>application.models.Post</code>).
		    Note that if the former, the class must be auto-loadable.
		</div>
		<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'controller'); ?>
		<?php echo $form->textField($model,'controller',array('size'=>65)); ?>
		<div class="tooltip">
			Controller ID is case-sensitive. CRUD controllers are often named after
			the model class name that they are dealing with. Below are some examples:
			<ul>
				<li><code>post</code> generates <code>PostController.php</code></li>
				<li><code>postTag</code> generates <code>PostTagController.php</code></li>
				<li><code>admin/user</code> generates <code>admin/UserController.php</code>.
					If the application has an <code>admin</code> module enabled,
					it will generate <code>UserController</code> (and other CRUD code)
					within the module instead.
				</li>
			</ul>
		</div>
		<?php echo $form->error($model,'controller'); ?>
	</div>
	<div class="row1">
		<?php echo $form->labelEx($model,'columnsForm'); ?>
                <?php 
                    $htmlOptions = array(1=>1, 2=>2, 3=>3, 4=>4);
                    echo $form->dropDownList($model, 'columnsForm', $htmlOptions);
                ?>	
		<?php echo $form->error($model,'columnsForm'); ?>
	</div>
	<div class="row1">		
		<?php echo $form->labelEx($model,'createBreadCrumbs'); ?>
		<?php 
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkBox($model,'createBreadCrumbs', $htmlOptions); ?>
		<div class="tooltip">
			Access Rule
		</div>
		<?php echo $form->error($model,'createBreadCrumbs'); ?>
	</div>	
	<div class="row1">		
		<?php echo $form->labelEx($model,'accessRulesDefault'); ?>
		<?php 
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkBox($model,'accessRulesDefault', $htmlOptions); ?>
		<div class="tooltip">
			Access Rule
		</div>
		<?php echo $form->error($model,'accessRulesDefault'); ?>
	</div>
	<div class="row1">
		<?php echo $form->labelEx($model,'createFindMethod'); ?>
		<?php 		
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkbox($model,'createFindMethod', $htmlOptions); ?>		
		<?php echo $form->error($model,'createFindMethod'); ?>
	</div>
	<div class="row1">
		<?php echo $form->labelEx($model,'generateReport'); ?>
		<?php 		
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkbox($model,'generateReport', $htmlOptions); ?>		
		<?php echo $form->error($model,'generateReport'); ?>
	</div>
	<div id="div_commentsAsLabels" class="row1" style="display: none">		
		<?php echo $form->labelEx($model,'commentsAsLabels'); ?>
		<?php 
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkBox($model,'commentsAsLabels', $htmlOptions); ?>
		<div class="tooltip">
			Whether comments specified for the table columns should be used as the new model's attribute labels.
			In case your RDBMS doesn't support feature of commenting columns or column comment wasn't set,
			column name would be used as the attribute name base.
		</div>
		<?php echo $form->error($model,'commentsAsLabels'); ?>
	</div>
	<div class="row1">		
		<?php echo $form->labelEx($model,'enableAjaxValidation'); ?>
		<?php 
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkBox($model,'enableAjaxValidation', $htmlOptions); ?>
		<?php echo $form->error($model,'enableAjaxValidation'); ?>
	</div>
	<div class="row1">		
		<?php echo $form->labelEx($model,'toggleButtonRow'); ?>
		<?php 
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkBox($model,'toggleButtonRow', $htmlOptions); ?>
		<?php echo $form->error($model,'toggleButtonRow'); ?>
	</div>
	<!--
	<div class="row1">		
		<?php echo $form->labelEx($model,'insertController'); ?>
		<?php 
		$htmlOptions = array('value'=>1, 'uncheckValue'=>0);
		echo $form->checkBox($model,'insertController', $htmlOptions); ?>
		<div class="tooltip">
			Add insert to tbl_p_controlador
		</div>
		<?php echo $form->error($model,'insertController'); ?>
	</div>
-->

	<div class="row sticky">
		<?php echo $form->labelEx($model,'baseControllerClass'); ?>
		<?php echo $form->textField($model,'baseControllerClass',array('size'=>65)); ?>
		<div class="tooltip">
			This is the class that the new CRUD controller class will extend from.
			Please make sure the class exists and can be autoloaded.
		</div>
		<?php echo $form->error($model,'baseControllerClass'); ?>
	</div>
        <div>
	    <?php echo $form->labelEx($model,'inputsList'); ?>
            <div class="row template sticky ">
                <div class="value">
                            Si hay claves foraneas se crearan como campos tipo lista, si hay más de 15 registros en la tabla foranea el campo se creará tipo
                            lista autocompletable
                    </div>
                </div>
            <table style="width: 100%"> 
                <tr>
                    <td style="text-align: center; width: 50%"><strong>Field</strong></td>
                    <td style="text-align: center; width: 10%"><strong>Field Type List</strong></td>                 
                    <td style="text-align: center"><strong>Create ( <a onclick="checkAll('createField[]', true)" style="cursor: pointer">CheckAll</a> / 
                        <a onclick="checkAll('createField[]', false)" style="cursor: pointer">>UncheckAll</a>)</strong></td>                        
                </tr>
		<?php 
                    $htmlOptions = array('single'=>'Single', 'multiple' => 'Multiple', 'select2Row' => 'select2Row');
                    foreach ($model->_table->columns as $campo => $foreign) {
                        ?>
                        <tr>
                            <td><?php echo $campo;   ?></td>
                            <td><?php
                            if($foreign->isForeignKey){
                                echo CHTML::dropDownList('inputsList['.$campo.']', $_POST['inputsList'][$campo], $htmlOptions);
                            }
                            ?></td>                        
                            <td style="text-align: center"><?php 
                                $htmlOptionsCheck = array('value'=>$campo, 'uncheckValue'=>0, 'checked'=>'checked');
                                $checked = false;
                                if(!$_POST['createField']){
                                    $checked = true;
                                }elseif(in_array($campo, $_POST['createField'])){
                                    $checked = true;
                                }
                                echo CHTML::checkBox('createField[]', $checked, $htmlOptionsCheck); ?></td>                        
                        </tr>  
                    <?php } ?>
	</table>	
        </div>

<?php $this->endWidget(); ?>

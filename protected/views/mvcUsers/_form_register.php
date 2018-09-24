<?php
/* @var $this MvcUsersController */
/* @var $model MvcUsers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mvc-users-form-register',
    'htmlOptions'=>array(
        'autocomplete'=>'off',
        'enableAjaxValidation' => false,
        'enctype' => 'multipart/form-data',
        ),
		'enableClientValidation'=>true,
		'clientOptions'=>array(
            'validateOnSubmit'=>true
        )
    )); ?>

    <?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <h2><?php echo Yii::app()->user->getFlash('error'); ?></h2>
    </div>
    <?php endif; ?>
    
	<div id="<?php echo CHtml::activeId($model, 'samaccountname')?>-label" class="row">
		<?php echo $form->labelEx($model,'samaccountname'); ?>
	</div>
    <div class="row">
        <?php
        echo $form->textField($model, 'samaccountname', array(
            'size' => 36,
            'maxlength' => 255,
            'onkeypress'=>'js:resetInput();'
        ));
        ?>
        <?php echo CHtml::button('',array(
            'id'=>'boton-dummy',
            'title'=>'Buscar',
            'onclick'=>CHtml::ajax(
                        array(
                            'type'=>'POST',
                            'url'=>CController::createUrl('mvcUsers/queryAttributes'),
                            'dataType'=>'json',
                            'success'=>'js:function(data){loadData(data);}',
                            'beforeSend'=>'js:function(){loadImage();}',
                            'data'=>array('username'=>'js:$("#'.CHtml::activeId($model, 'samaccountname').'").val()'),
                            )
                        ))); ?>
        <span id="loading"></span>
        <div id="<?php echo CHtml::activeId($model, 'samaccountname') ?>-error" class="errorMessage"></div>
        <?php echo $form->error($model, 'samaccountname'); ?>
    </div>

	<div class="span-10">
        <div class="row">
            <?php echo $form->labelEx($model,'givenname'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'givenname'); ?>
            <div id="<?php echo CHtml::activeId($model, 'givenname')?>-text" class="name-lastname"><?php echo $model->givenname?></div>
            <?php echo $form->error($model,'givenname'); ?>
        </div>
    </div>
    <div class="span-1">&nbsp;</div>
        
    <div class="span-10">
        <div class="row">
            <?php echo $form->labelEx($model,'sn'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'sn'); ?>
            <div id="<?php echo CHtml::activeId($model, 'sn')?>-text" class="name-lastname"><?php echo $model->sn?></div>
            <?php echo $form->error($model,'sn'); ?>
        </div>
	</div>
    <div style="clear: both"></div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'mail'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'mail'); ?>
            <div id="<?php echo CHtml::activeId($model, 'mail')?>-text" class="input-label"><?php echo $model->mail?></div>
            <?php echo $form->error($model,'mail'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'immediate_boss'); ?>
        </div>
        <div class="row">
            <?php echo $form->textField($model,'immediate_boss',array('maxlength'=>255)); ?>
            <?php echo $form->error($model,'immediate_boss'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'immediate_boss_mail'); ?>
        </div>
        <div class="row">
            <?php echo $form->textField($model,'immediate_boss_mail',array('maxlength'=>255)); ?>
            <?php echo $form->error($model,'immediate_boss_mail'); ?>
        </div>
	</div>
    <div style="clear: both"></div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'department'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'department'); ?>
            <div id="<?php echo CHtml::activeId($model, 'department')?>-text" class="input-label"><?php echo $model->department?></div>
            <?php echo $form->error($model,'department'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'departmentnumber'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'departmentnumber'); ?>
            <div id="<?php echo CHtml::activeId($model, 'departmentnumber')?>-text" class="input-label"><?php echo $model->departmentnumber?></div>
            <?php echo $form->error($model,'departmentnumber'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'employeenumber'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'employeenumber'); ?>
            <div id="<?php echo CHtml::activeId($model, 'employeenumber')?>-text" class="input-label"><?php echo $model->employeenumber?></div>
            <?php echo $form->error($model,'employeenumber'); ?>
        </div>
	</div>
    <div style="clear: both"></div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'streetaddress'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'streetaddress'); ?>
            <div id="<?php echo CHtml::activeId($model, 'streetaddress')?>-text" class="input-label"><?php echo $model->streetaddress?></div>
            <?php echo $form->error($model,'streetaddress'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'headquarters'); ?>
        </div>
        <div class="row">
            <?php echo $form->textField($model,'headquarters',array('maxlength'=>255)); ?>
            <?php echo $form->error($model,'headquarters'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'telephonenumber'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'telephonenumber'); ?>
            <div id="<?php echo CHtml::activeId($model, 'telephonenumber')?>-text" class="input-label"><?php echo $model->telephonenumber?></div>
            <?php echo $form->error($model,'telephonenumber'); ?>
        </div>
	</div>
    <div style="clear: both"></div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'mobile'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'mobile'); ?>
            <div id="<?php echo CHtml::activeId($model, 'mobile')?>-text" class="input-label"><?php echo $model->mobile?></div>
            <?php echo $form->error($model,'mobile'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <div class="row">
            <?php echo $form->labelEx($model,'location'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'location'); ?>
            <div id="<?php echo CHtml::activeId($model, 'location')?>-text" class="input-label"><?php echo $model->location?></div>
            <?php echo $form->error($model,'location'); ?>
        </div>
	</div>
    
    <div class="span-7">
        <?php echo CHtml::submitButton('Solicitar cuenta', 
            array( 
                'id'=>'btn-submit-reg',                    
                )
            ); ?>
	</div>
    
    <div class="span-17">
        <div class="row">
            <?php echo $form->labelEx($model,'modules', array('style'=>'width:330px;float:left')); ?>
            <?php echo $form->error($model,'modules', array('style'=>'width:200px; float: left;')); ?>
        </div>
        <div class="row" id="modules">
           
            <?php
            $label="";
            $input="";
            echo $form->checkBoxList($model, "modules",
                CHtml::listData(MvcModules::model()->findAll('module_id != :id', array('id'=>1)),'module_id','title' ), 
                array(
                    'template'=>"<div class='mod'>{input} {label}</div>",
                    "separator" => "",// es necesario eliminar el separador                 
                ));         
            ?>                                                                  
        </div>
	</div>
    
    <div class="buttons span-4">        
        
	</div>
    <?php echo $form->hiddenField($model,'validaCampos'); ?>
    <?php echo $form->hiddenField($model,'cn'); ?>
    <div style="clear: both"></div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script>
function loadData(data){    
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-label").removeClass('error');
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-label label").removeClass('error');
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>").parent().removeClass('success');
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-error").html('');
    if(data != null){
        if(data.samaccountname === undefined || data.samaccountname === null) {
            $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-label").css('color','#FF0000');
            $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-error").html('Usuario de red es incorrecto');            
            resetInput();
            $("#<?php echo CHtml::activeId($model, 'samaccountname')?>").addClass('error');
            
            $("#loading").html('');
            return;
        }
    } else {
        $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-label").css('color','#FF0000');
        $("#<?php echo CHtml::activeId($model, 'samaccountname')?>").addClass('error');
        $("#<?php echo CHtml::activeId($model, 'samaccountname')?>_em_").html('Este campo es obligatorio');
        $("#<?php echo CHtml::activeId($model, 'samaccountname')?>_em_").css('display','block');
        $("#loading").html('');
        return;
    }
    resetInput();
    $("#<?php echo CHtml::activeId($model, 'validaCampos')?>").val(data.validaCampos);

    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>").val(data.samaccountname);
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-text").html(data.samaccountname);
    $("#<?php echo CHtml::activeId($model, 'givenname')?>").val(data.givenname);
    $("#<?php echo CHtml::activeId($model, 'givenname')?>-text").html(data.givenname);
    $("#<?php echo CHtml::activeId($model, 'sn')?>").val(data.sn);
    $("#<?php echo CHtml::activeId($model, 'sn')?>-text").html(data.sn);
    $("#<?php echo CHtml::activeId($model, 'mail')?>").val(data.mail);
    $("#<?php echo CHtml::activeId($model, 'mail')?>-text").html(data.mail);
    $("#<?php echo CHtml::activeId($model, 'departmentnumber')?>").val(data.departmentnumber);
    $("#<?php echo CHtml::activeId($model, 'departmentnumber')?>-text").html(data.departmentnumber);
    $("#<?php echo CHtml::activeId($model, 'employeenumber')?>").val(data.employeenumber);
    $("#<?php echo CHtml::activeId($model, 'employeenumber')?>-text").html(data.employeenumber);
    $("#<?php echo CHtml::activeId($model, 'streetaddress')?>").val(data.streetaddress);
    $("#<?php echo CHtml::activeId($model, 'streetaddress')?>-text").html(data.streetaddress);
    $("#<?php echo CHtml::activeId($model, 'telephonenumber')?>").val(data.telephonenumber);
    $("#<?php echo CHtml::activeId($model, 'telephonenumber')?>-text").html(data.telephonenumber);
    $("#<?php echo CHtml::activeId($model, 'mobile')?>").val(data.mobile);        
    $("#<?php echo CHtml::activeId($model, 'mobile')?>-text").html(data.mobile);        
    $("#<?php echo CHtml::activeId($model, 'department')?>").val(data.department);        
    $("#<?php echo CHtml::activeId($model, 'department')?>-text").html(data.department);        
    $("#<?php echo CHtml::activeId($model, 'location')?>").val(data.l);        
    $("#<?php echo CHtml::activeId($model, 'location')?>-text").html(data.l);
    $("#<?php echo CHtml::activeId($model, 'cn')?>").val(data.cn);
    
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>-label").css('color','#000');
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>_em_").html('');
    $("#<?php echo CHtml::activeId($model, 'samaccountname')?>").removeClass('error');
    $("#loading").html('');
}

function loadImage(){
    $("#loading").html('<img src="<?php echo Yii::app()->theme->baseUrl . '/images/global/' ?>ajax-loader.gif"/>');
}

function resetInput(){
    $("#<?php echo CHtml::activeId($model, 'givenname')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'sn')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'mail')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'departmentnumber')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'employeenumber')?>").val();
    $("#<?php echo CHtml::activeId($model, 'streetaddress')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'telephonenumber')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'mobile')?>").val('');
    $("#<?php echo CHtml::activeId($model, 'location')?>").val('');
    
    $(".input-label").html('');
    $(".name-lastname").html('');
}
</script>
    
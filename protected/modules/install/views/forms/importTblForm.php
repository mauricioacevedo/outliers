<?php
$form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
        'id' => 'bdForm',
        'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true)
        )
);

$checkConnectionModel = new CheckConnectionModel();
$instanceInfo         = $checkConnectionModel->checkPermissionAndTables();
?>
<!-- FIN GLOBAL -->
<?php if(count($instanceInfo)){ ?>
<h5>Verifique que el usuario <b><?php echo DB_USER; ?></b> tenga suficientes 
    permisos en la instancia: 
    <span style="color:red"><?php echo INSTANCE ;?></span></h5>
<small>
    <table>
        <?php 
        if(count($instanceInfo['grants'])){
            foreach($instanceInfo['grants'] as $key =>$array_value){
                if(is_array($array_value)){
                 foreach($array_value as $index =>$value)
                 {
                    echo "<tr><th>{$index}</th><td>{$value}</td></tr>";
                 }
                }
            }
        }
        ?>
    </table><hr>   
</small>
<?php if($_GET['it']=='c'){
    echo "<h5>Ingreso al portal web....</h5>";
    echo 'Para ingresar al sitio haz click <a href="?r=site/logout"> aquí</a><br>'
         . '<b>USUARIO:</b> admin<br>'
         . '<b>CLAVE:</b> 123456 <hr>';  
    ?>
<h5>Se han importado las siguientes tablas a la BD : 
    <span style="color:red"><?php echo DB ;?></span></h5>
<?php } else { ?>
<h5>Para una mejor instalaci&oacute;n, verique que no existan tablas en la BD : 
    <span style="color:red"><?php echo DB ;?></span></h5>
<?php }?>
<small>
    <table>
        <?php 
        if(count($instanceInfo['tables'])){
            foreach($instanceInfo['tables'] as $key =>$array_value){
                echo "<tr><th>{$key}</th><td>{$array_value}</td></tr>";
            }
        }
        else{
            echo "No se encontraron tablas en esta Base de datos.";
        }
        ?>
    </table><hr>   
</small>
<!-- GUARDAR -->
<div class="row-fluid">
 <div class="span2">
    <!-- block -->
    <div class="block"><br>
       <?php 
        $this->widget('bootstrap.widgets.TbButton', 
                array('buttonType'=>'submit', 
                      'htmlOptions'=>array('name'=>'importTables'),
                                           'label'=>'Importar Tablas',
                                           'type' => 'danger', 
                                           'size' => 'normal'));
       ?>
    </div>
    <!-- /block -->
</div>
</div>
<!-- FIN GUARDAR -->
<?php }
else{
    echo "<h5>La configuraci&oacute;n de la Base de datos no es correcta </h5><hr>";
}
$this->endWidget();
unset($form);
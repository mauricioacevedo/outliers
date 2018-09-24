<?php
$p_active = false;
$c_active = false;
$t_active = false;
if(isset($_GET['cnf'])){ $c_active = true;
$user->setFlash('success',"El archivo index.php ha sido actualizado...");
$this->renderPartial('messages');
}
elseif(isset($_GET['it'])){$t_active = true;
if($_GET['it']=='c'){
$user->setFlash('success',"Las tablas se han importando correctamente...");
}
else if($_GET['it']=='e'){
  $user->setFlash('error',"El archivo <b>dbappyii.sql</b> no existe en la carpeta /data/");  
}
$this->renderPartial('messages');
} 
else {$p_active = true;}
?>
<!DOCTYPE html>
<html class="no-js">
    <body>
        <div class="well_content">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                     <fieldset>
                         <legend><h3>INSTALACI&Oacute;N DE LA PLANTILLA</h3></legend>
                         <?php                         
                         $this->widget(
                                'bootstrap.widgets.TbTabs',
                                array(
                                    'type' => 'tabs', // 'tabs' or 'pills'
                                    'tabs' => array(                                        
                                        array('label' => 'Permisos de archivos/carpetas', 
                                              'content' => $this->renderPartial('../forms/permissionForm',array(),true),
                                              'active' => $p_active 
                                            ),                                              
                                        array(
                                            'label' => 'Configuración',
                                            'content' => $this->renderPartial('../forms/globalForm', array(),true),
                                            'active' => $c_active
                                        ),
                                        array(
                                            'label' => 'Importar Tablas',
                                            'content' => $this->renderPartial('../forms/importTblForm', array(),true),
                                            'active' => $t_active
                                        ),
                                    ),
                                )
                                );
                         ?>                         
                        </fieldset>
                </div>
                
            </div>
        </div>
        </div>
    </body>
</html>
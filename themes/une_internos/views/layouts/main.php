<?php
/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
/**
  MENUS
 */  
  /* Asi se crea un menu personalizado diferente al de YiiBOOSTER
        if (!empty($modelMenu) && count($modelMenu)) {
            $this->widget('ext.widgets.menus.horizontal.top', array('modelMenu' => $modelMenu, 'htmloptions' => $htmloptions));
        } else {
            $message = 'No se encontraron datos para crear el Menú';
            $this->widget('ext.widgets.stateMessages.Messages', array('message' => $message, 'type' => 'warning'));
        }*/

$mod = Yii::app()->sysSecurity->tagsAllowed(Yii::app()->getRequest()->getParam('mod'), false, '/[^0-9]/i');
if(!count($mod)){
   $mod[0] = Yii::app()->session['users']->module_id;    
}
//Se obtiene los datos del menu. si no se envia parametros trae todos los registros. si se quiere filtrar, se envia la condicion
// Ejemplo menu_name ="" and menu_type=""
switch ($mod[0]) {
    case 'conf':
        $modelMenu = Yii::app()->menuManager->getMenu("menu_type='".$mod[0]."' or menu_type='administration'");
        break;
    default:
        $modelMenu = Yii::app()->menuManager->getMenu();
        break;
}  
/**
 * Si se quiere customizar parametros envia el nombre del parametro y su valor Ejemplo array('pagina'=>'link')
 */
        $menu       = Yii::app()->menuManager->build_menu($modelMenu,array('label'=>'name','url'=>'href','icon'=>'icon')); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language; ?>" lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta name="viewport" content="width=device-width, user-scalable=no"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
        <meta name="language" content="<?php echo Yii::app()->language; ?>" />
        <link rel="icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/global/favicon.ico" type="image/x-icon" title="MYSE" />
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/layouts/layout-default-latest.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/global/template.css');?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styleImage.css');?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/searchLiveAnswer.css');?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/sidePanel/sidePanel.css');?>
       
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/layout/jquery.layout.js');?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/layout/customlayout.js');?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/global/jquery.form.min.js');?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/global/imageProfile.js');?>        
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/global/searchLiveAnswer.js');?>        
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/sidePanel/sidePanel.js');?>    
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script type="text/javascript">  
            $(document).ready(function(){                
                $('.openDlgHelp').live('click', function(){
                    $("#ayuda-frame").attr("src",$(this).attr("href")); $("#divHelp").dialog("open");  return false;
                });
                
                 $('.hinttooltip').tooltip({ placement : 'bottom',});
                 $('.hintpopover').popover();                
            }); 
	</script>
    </head> 
    <body>
        <!--
            OUTER-CENTER PANE
        -->
        <div id="outer-center" class="ui-layout-center container hide">

            <div class="ui-layout-north" style="z-index: 9; overflow:visible;">
                <div id="div-menu" style="float:left;width: 100% ">
                    <?php 
                    $this->widget('ext.widgets.notify.notify');
                    $pic        = '';
                    $btnClose   = '';
                    if((Sitesettings::model()->findByAttributes(array('id' => '1'))->oauth == 3)){
                        $btnClose = 'Refrescar Sesión';
                    }
                    else{
                        $btnClose = 'Cerrar Sesión';
                    }
                    if(Yii::app()->session['users']->pic_profile_id > 0){ 
                        $pic =  CHtml::image(Yii::app()->createUrl('/mvcUsers/showImage',array('file'=>Yii::app()->session['file']->filename)), '', array('style'=>'height:100px;width:90px;float:left'));
                      } else {
                        $pic =  CHtml::image(Yii::app()->theme->baseUrl . '/images/global/profile.png','',array('style'=>'height:100px;width:90px;float:left') );
                             } 
                             
                    if(Yii::app()->session['users']->cn == null){
                        
                        $LoginUser      = 'Usuario Visitante';
                        $title          = 'title="Nuevo Usuario" ';
                     ?>
                    <script type="text/javascript">  
                        $(function () { $('.forNewUser').popover('show');});
                        $(function () { $('.forNewUser').on('shown.bs.popover', function () {})});
                    </script>
                    <?php
                    }
                    else{
                        $LoginUser      = Yii::app()->session['users']->cn;
                        $title = Yii::app()->session['users']->samaccountname;
                    }
                   # echo "<pre>"; print_r($menu); echo "</pre>"; exit;
                    $this->widget(
                            'bootstrap.widgets.TbNavbar',
                            array(
                                'type' => null, // null or 'inverse'
                                'brand' => SITENAME,
                                'brandUrl' => '?r=evii/evidencias/admin',
                                'collapse' => true, // requires bootstrap-responsive.css
                                'fixed' => false,
                                'items' => array(
                                    array(
                                        'class' => 'bootstrap.widgets.TbMenu',
                                        'items' => $menu,
                                    ),
                                    '<form class="navbar-search pull-left" action="">'
                                    . '<div><input title="Búsqueda en línea" '
                                    . 'data-trigger="hover"'
                                    . 'data-placement="bottom"'
                                    . 'data-content="Ingrese palabra clave..."'
                                    . 'type="text" class="search-query span2 hintpopover" '
                                    . 'placeholder="Search" id="inputString" onkeyup="lookup(this.value);"></div>'
                                    . '<div id="suggestions" class="ui-state-info ui-corner-all "></div>'
                                    . '</form>',
                                    '<div id="foto">'
                                        . '<div id="div-name" '
                                        . 'data-trigger="hover" '
                                        . 'data-placement="bottom" '
                                        . 'data-content="Click para actualizar el perfil" '
                                        . $title
                                        . 'class="hintpopover forNewUser">'.$LoginUser.'<span>&nbsp;▼</span></p></div>'
                                           . '<div id="div-foto">'
                                             .   '<div id="foto-name">'
                                                .  '<span id="img-perfil-load">'.$pic.'</span>'
                                                . '<p id="name" style="color:#873299">'.$LoginUser.'</p>'
                                                #. '<p style="color:#873299">'.Yii::app()->session['users']->department.'</p>'
                                                . '<p align="center" style="color:#873299">'.Yii::app()->session['users']->mail.'</p>'
                                             . '</div>'
                                             . '<div>'
                                                    .CHtml::ajaxLink(
                                                        'editar perfil',
                                                        Yii::app()->createUrl("mvcUsers/view"),
                                                        array( // ajaxOptions
                                                            'type' =>'GET',                          
                                                        ),
                                                        array( //htmlOptions
                                                        'href'=>Yii::app()->createUrl("mvcUsers/view"),
                                                        'class' => 'btn btn-default',
                                                        'onclick'=>'$("#view-profile-frame").attr("src",$(this).attr("href")); $("#view-profile-dialog").dialog("open");',  
                                                        )
                                                      )
                                                    .'<div class="pull-right">'
                                                    .CHtml::link($btnClose,
                                                        Yii::app()->createUrl('site/logout'),
                                                         array( //htmlOptions
                                                        'href'=>Yii::app()->createUrl("site/logout"),
                                                        'class' => 'btn btn-default',
                                                        )
                                                    )
                                                .'</div></div>' 
                                               . '</div>'                   
                                    . '</div>'
                                    . '<div class="pull-right hintpopover " '
                                    . 'data-trigger="hover"'
                                    . 'data-placement="left"'
                                    . 'data-content="Haz click para ver notificaciones"'
                                    . 'style="margin-right:15px; margin-top:10px;">'.Yii::app()->session['notyBtn'].'</div>',
                                ),
                            )
                        );
                    
                    
                    ?>
                </div> 
            </div>
            <div class="ui-layout-center hide" style="padding: 10px; overflow: auto;">                                    
                <div style="width: 99%; margin-left:15px;">
                    <?php echo $content; ?>
                </div>
            </div>	
        </div>
        <!--
            OUTER-WEST PANE
        -->        
        <!--
            OUTER-NORTH PANE
        -->
        <div class="ui-layout-north no-padding hide" id="head" style="overflow: hidden; background-color: lightgray;">
                   <div style="float: right; z-index: -1000;">
                <a class="openDlgHelp hintpopover" 
                   data-trigger="hover"
                   data-placement="left"
                   data-content="Haz click aquí para leer la guia de usuario.."                   
                   href="<?php echo Yii::app()->createUrl('help/view') ?>&ctr=<?php echo Yii::app()->controller->id ?>&acc=<?php echo Yii::app()->controller->action->id ?>">
                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/global/help_icon.png'?>" border="0" />
                    </a>            
                </div>     
            
            <div id="sitename">
                <?php #echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/global/site.png"), array('Site/index')); ?>
                
            </div>
            <div style="margin: 0 0 0 -10px;">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/global/head.png" width="609" height="121" />
            </div>
            <span style="font-size: 8px;;"><?php echo Yii::app()->generalFunctions->showDate("date")?></span>
        </div>
        <!--
            OUTER-SOUTH PANE
        -->
        <div class="ui-layout-south no-padding hide" id="foot2">	
            &copy; Copyright <?php echo date('Y').' '.Yii::app()->params['site']['copyright']; ?>
            <br /> No está permitida su
            reproducción por ningún medio impreso, fotostático, electrónico o
            similar, sin la previa autorización escrita del titular de los<br />
            derechos reservados
        </div>
    </body>
</html>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'divHelp',
                'options'=>array(
                                'title' => 'Ayuda',
                                'autoOpen' => false,
                                'modal'=>true,
                                'height'=>500,
                                'width'=>"90%")
                )
);
?>
<iframe id="ayuda-frame" width="100%" height="100%" frameborder="0"></iframe>	
<?php
$this->endWidget(); 
?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'view-profile-dialog',
    'options'=>array(
        'title'=>Yii::app()->session['users']->cn,
        'autoOpen'=>false,
        'modal'=>'true',
        'width'=>'430',
        'height'=>'550',
    ),
));
?>
<iframe id="view-profile-frame" width="100%" height="100%" frameborder="0"></iframe>	
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>

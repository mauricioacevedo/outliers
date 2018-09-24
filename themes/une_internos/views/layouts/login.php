<?php
/**
 * @author Subdireccion Aplicaciones Corporativas
 * @copyright UNE TELECOMUNICACIONES
 */
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
       
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/layout/jquery.layout.js');?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/layout/customlayoutmain.js');?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head> 
    <body>
        <!--
            OUTER-CENTER PANE
        -->
        <div id="outer-center" class="ui-layout-center container hide">
            <div class="ui-layout-center hide" style="padding: 10px;">
                <div style="width: 99%;">
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
           
            <div style="margin: 0 0 0 -10px;
                 position: relative;">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/global/head.png" width="609" height="121" />
            </div>
            <?php echo Yii::app()->generalFunctions->showDate("date")?>
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
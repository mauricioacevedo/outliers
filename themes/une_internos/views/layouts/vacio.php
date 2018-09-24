<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language; ?>" lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
        <meta name="language" content="<?php echo Yii::app()->language; ?>" />

        <!-- blueprint CSS framework -->

        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/layouts/layout-default-latest.css');?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/global/template.css');?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/form/buttons.css');?>

        <!-- blueprint JS framework -->

        
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/jquery-ui.custom/js/jquery-ui.js');?>
        
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>
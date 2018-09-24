<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta name="viewport" content="width=device-width, user-scalable=no"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
        <meta name="language" content="<?php echo Yii::app()->language; ?>" />
        <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/jquery-ui.custom.css" />
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/template.css');?>

        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/jquery.min.js"></script>	
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/jquery-ui.custom.min.js"></script>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="keywords" content="proveedores, UNE, EPM, Servicios de Telecomunicaciones, Internet, comunicaciones, tecnologías, Banda Ancha, Movilidad, Internet Móvil, Televisión, Televisión Digital, Televisión Interactiva, Telefonía, Telefonía Móvil, Larga Distancia, Medidor de velocidad, alta velocidad, 4G, 4GLTE, Revolution, speedtest, Paquetes, Correo" />
        <link rel="icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/global/favicon.ico" type="image/x-icon" title="PROVEEDORES" />      
</head>
    <body>
        <div id="outer-center">
            <div>                                    
                <div style="width: auto">
                    <div style="z-index: 9;">
                           <header>
                                <div class="centerdiv">
                                    <div class="navbar"><div class="navbar-inner">
                                            <div class="container">                                                
                                                <a href="index.php" class="brand" >Proveedores</a>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                              </header>
                    </div>
                    <section id="top">
                        <div id="title1"><?php echo $title ?>&nbsp;</div>
                        <div id="Breadcrumb">
                            <?php if(isset($this->breadcrumbs)):?>
                                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                                        'links'=>$this->breadcrumbs,
                                )); ?><!-- breadcrumbs -->
                        <?php endif?>
                        </div>
                      </section>
                      <section id="banner"><img src="<?php echo Yii::app()->baseUrl ?>/images/banner1.png" width="100%" height="100%" alt=""/></section>  
                      <div style="padding-left: 15px; padding-right: 15px; padding-top: 10px">  
                        <?php echo $content; ?>
                      </div>
                    <?php include_once 'footer.php'; ?>
                </div>
            </div>	
        </div>   
    </body>
</html>

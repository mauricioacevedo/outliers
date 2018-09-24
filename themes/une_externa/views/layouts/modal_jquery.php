<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/jquery.min.js"></script>	
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/jquery-ui.custom.min.js"></script>	
<?php Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false; ?>
<?php Yii::app()->clientScript->scriptMap['jquery.min.js'] = false; ?>
<?php Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false; ?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<?php echo $content; ?>
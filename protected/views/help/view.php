<?php if($update){ ?>
<a href="<?php echo Yii::app()->createAbsoluteUrl("help/update") ?>&id=<?php echo $model->help_id; ?>">
    Edit
</a>
<?php } ?>
<h1><?php echo $model->title; ?></h1>
<?php echo $model->content; ?>

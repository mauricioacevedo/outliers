<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="sidebar">
	<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>array(
						'List Reports'			=> array('reports/admin'),
						'Create Report'			=> array('reports/create'),
						'List Reports Fields'	=> array('reportsFields/admin'),
						'Create From Table'		=> array('reports/CreateFromTable')
				),
		));
	?>
	</div><!-- sidebar -->
<div id="content" style="width: 95%">
		<?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
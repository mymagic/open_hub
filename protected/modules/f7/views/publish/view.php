<?php $this->layoutParams['form'] = $model; ?>

<?php if ($model->type == 0) {
	$this->renderPartial('_submissionPartial', array('model' => $model));
} ?>

<hr />
<?php echo $form?>


<?php Yii::app()->clientScript->registerScript('f7-publish-view', "
	$('#auto-save-span').hide();
	if ($('#industry-other').val() == '')
		$('#industry-other').hide();
");
?>
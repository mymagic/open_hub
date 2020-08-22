<?php $this->layoutParams['form'] = $form; ?>

<?php $submissionPartial = trim($this->renderPartial('_submissionPartial', array('model' => $form), true)); echo $submissionPartial; ?>
<?php if (empty($submissionPartial)):?><hr /><?php endif; ?>

<?php echo $htmlForm?>

<?php echo $form->renderPublishViewOkButton(Yii::app()->controller, $submission) ?>

<?php Yii::app()->clientScript->registerScript('f7-publish-view', "
	$('#auto-save-span').hide();
	if ($('#industry-other').val() == '')
		$('#industry-other').hide();
");
?>
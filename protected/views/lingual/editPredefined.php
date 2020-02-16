<form action="<?php echo $this->createUrl('lingual/editPredefined', array('scope'=>$scope)) ?>" role="form" method="POST">
<h1>
<?php echo Yii::t('core', "Edit '{scope}' Predefined Tags", array('{scope}'=>ucwords($scope))); ?> 
	<div class="btn-group pull-right">
		<input class="btn btn-primary" type="submit" value="<?php echo Yii::t('core', 'Save') ?>" />
		<a class="btn btn-default" href="<?php echo $this->createUrl('lingual/index') ?>"><?php echo Yii::t('core', 'Back') ?></a>
	</div>
</h1>
<input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>" />

<?php echo Notice::inline(Yii::t('notice', 'File Path').': '.$filePath, Notice_INFO); ?>
<?php echo Html::textArea("content", $content, array('class'=>'full-width', 'rows'=>17)) ?>
</form>
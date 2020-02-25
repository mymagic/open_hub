<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8">
	<meta name="content-type" http-equiv="content-type" content="text/html; charset=UTF-8" />	
	<?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/javascript/jquery-ui/js/jquery-ui-1.8.17.custom.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/javascript/jquery.qtip.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/javascript/raty/js/jquery.raty.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/javascript/jquery.blockUI.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/javascript/jquery.timers.js'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/reset.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/960.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/javascript/jquery-ui/css/ui-lightness/jquery-ui-1.8.17.custom.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/jquery.qtip.css'); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/javascript/core.js'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/core.css'); ?>
	<?php if ($_GET['frontend']): ?>
		<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/frontend.css'); ?>
	<?php endif; ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="popup-container">
<div class="container" id="page">
	
	<?php echo $content; ?>

	<div id="cancelpopup">
		<?php echo CHtml::button(Yii::t('default', 'Close'), array('id' => 'cancelpopup-button')); ?>
	</div>

</div><!-- page -->
</div>

</body>
</html>
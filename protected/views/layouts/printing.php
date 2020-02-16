<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8">
	<meta name="content-type" http-equiv="content-type" content="text/html; charset=UTF-8" />
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
	
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/reset.css"); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/print.css", 'print'); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/javascript/core.js'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/core.css"); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/printing.css"); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="printing-container">

<div id="printing-cpanel" class="hide">
<form>
	<p><input type="button" value="Print this page" onClick="window.print()"></p>
</form>
</div>

<div class="container" id="page">
	
	<?php echo $content; ?>

</div><!-- page -->

</div>

</body>
</html>
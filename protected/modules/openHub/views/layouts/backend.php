<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/backend.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/backend.js', CClientScript::POS_END); ?>

<?php $this->beginContent('layouts.backend'); ?>
	<?php echo $content; ?>
<?php $this->endContent(); ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/backend.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/webpack/dist/app.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/backend.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/webpack/dist/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->scriptMap['vue.js'] = false; ?>

<?php $this->beginContent('layouts.backend'); ?>
	<?php echo $content; ?>
<?php $this->endContent(); ?>

<?php Yii::app()->clientScript->registerScript('vue-csrf', '

window.csrfToken ="' . Yii::app()->request->csrfToken . '";
window.csrfTokenName="' . Yii::app()->request->csrfTokenName . '";

') ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/frontend.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/frontend.js', CClientScript::POS_END); ?>

<?php $this->beginContent('layouts.cpanel'); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
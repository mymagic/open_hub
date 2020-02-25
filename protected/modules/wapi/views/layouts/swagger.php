<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts.column2', Yii::app()->theme->name)); ?>
<?php Yii::import('webroot.themes.' . Yii::app()->theme->name . '.model.Inspinia'); ?>

<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/swagger/dist/swagger-ui.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl . '/css/wapi.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/swagger/dist/swagger-ui-bundle.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/swagger/dist/swagger-ui-standalone-preset.js', CClientScript::POS_HEAD); ?>

<?php echo $content; ?>

<?php $this->endContent(); ?>

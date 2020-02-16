<?php $this->beginContent('modules.f7.views.layouts.survey'); ?>
<div id="f7-publish">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>


<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/publish.css'); ?>
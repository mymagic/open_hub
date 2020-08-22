<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>


<?php $this->layoutParams['hideFlashes'] = false; ?>

<?php if (!$this->layoutParams['hideFlashes'] && Notice::hasFlashes()) : ?>
<div id="layout-flashNotice">
	<?php echo Notice::renderFlashes() ?>
</div>
<?php endif; ?>

<style type="text/css">
	.modal-dialog {
		z-index: 0;
	}
</style>

<div class="container">

<!-- main-content -->
<div id="main-content">
	<?php echo $content; ?>
</div>
<!-- /main-content -->


</div>
<!-- /container -->


<?php $this->endContent(); ?>

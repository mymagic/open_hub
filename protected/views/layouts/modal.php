<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>

<?php // Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/mymagic.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js'); ?>

<?php //$this->layoutParams['hideFlashes'] = true;?>
<?php $this->layoutParams['bodyClass'] = ' white-bg layout-plain'; ?>

<?php if (!$this->layoutParams['hideFlashes'] && Notice::hasFlashes()) :?>
<div id="layout-flashNotice">
	<?php echo Notice::renderFlashes(); ?>
</div>
<?php endif; ?>

<div class="container">

<!-- main-content -->
<div id="main-content">

<div class="modal-dialog <?php echo $this->layoutParams['modalDialogClass'] ?>" role="document">
<div class="modal-content">
    <?php if ($this->layoutParams['showModalHeader']): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $this->pageTitle ?></h4>
    </div>
    <?php endif; ?>
    <div class="modal-body">
        <?php echo $content; ?>
    </div>
    <?php if ($this->layoutParams['showModalFooter']): ?>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'Close') ?></button>
        
    </div>
    <?php endif; ?>
</div>
</div>

</div>
<!-- /main-content -->


</div>
<!-- /container -->
<?php $this->endContent(); ?>
<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/mymagic.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/css/app.css'); ?>
<?php Yii::app()->ClientScript->registerScriptFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/js/universal.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js'); ?>


<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

<?php $this->layoutParams['bodyClass'] .= ' body-stampede layout-frontend'; ?>
<?php $this->layoutParams['hideFlashes'] = false; ?>

<?php if (!$this->layoutParams['hideFlashes'] && Notice::hasFlashes()) : ?>
    <div id="layout-flashNotice">
        <?php echo Notice::renderFlashes(); ?>
    </div>
<?php endif; ?>

<?php
foreach ($this->menuSub as $key => $menu) {
    $this->menuSub[$key]['url'] = CHtml::normalizeUrl($menu['url']);
}
?>

<header id="universal-header" class="sticky top-0 z-40">

</header>

<!-- container -->
<div class="<?php echo $this->layoutParams['containerFluid'] ? 'container-fluid' : 'container'; ?>">

    <!-- main-content -->
    <div id="main-content">
        <?php echo $content; ?>
    </div>
    <!-- /main-content -->


</div>
<!-- /container -->

<!-- universal footer -->
<footer id="universal-footer">
    
</footer>
<!-- /universal footer -->

<iframe style="border:0; width:1px; height:1px" src="https://<?php echo Yii::app()->params['connectUrl']; ?>/profile"></iframe>


<!-- modal-common -->
<div id="modal-common" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel-common" data-load-url="">
</div>
<!-- /modal-common -->


<div id="block-spinner" class="hidden">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    <span class="sr-only">Loading...</span>
    <h3 class="margin-top-2x"><?php echo Yii::t('core', 'Loading...'); ?></h3>
</div>

<?php $this->endContent(); ?>


<?php Yii::app()->clientScript->registerScript('vue-main-content', "

$('.js-multi-select').select2({
    placeholder: 'Please Select',
    allowClear: true
});

"); ?>


<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/owl.carousel.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/owl.carousel.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>
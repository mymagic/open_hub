<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/mymagic.css'); ?>

<?php Yii::app()->getClientScript()->registerCssFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/css/app.css'); ?>
<?php Yii::app()->ClientScript->registerScriptFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/js/universal.js', CClientScript::POS_END); ?>


<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

<?php $this->layoutParams['bodyClass'] .= ' layout-frontend'; ?>
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
<!-- nav-main -->
<div class="container-fluid border-bottom">
<nav class="navbar navbar-default" id="nav-main" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php echo Html::link(Yii::app()->name, $this->createUrl('/site/index'), array('class' => 'navbar-brand')); ?>
    </div>

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <!-- Main nav -->
        <?php $this->initFrontendMenu(); ?>

        <?php 

			if (!Yii::app()->user->isGuest) {
				$labelMe = sprintf('<img src="%s" class="img-circle" style="width:18px; height:18px" /> %s', ImageHelper::thumb(100, 100, $this->user->profile->image_avatar), ysUtil::truncate($this->user->profile->full_name, 8));

				$this->menuSub['user'] = array(
					'label' => $labelMe . ' <b class="caret"></b>', 'url' => '#',
					'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
					'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
					'items' => $this->menuUser,
				);
			}
		?>
        
        <?php $this->widget('zii.widgets.CMenu', array(
			'htmlOptions' => array('class' => 'nav navbar-nav navbar-right'),
			'encodeLabel' => false,
			'items' => $this->menuSub,
		)); ?>

    </div>
</nav>
</div>
<!-- /nav-main -->

<!-- container -->
<div class="<?php echo $this->layoutParams['containerFluid'] ? 'container-fluid' : 'container'; ?>">

    <!-- main-content -->
    <div id="main-content">
        <?php echo $content; ?>
    </div>
    <!-- /main-content -->


</div>
<!-- /container -->

<!-- // todo: detach MaGIC Connect -->
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

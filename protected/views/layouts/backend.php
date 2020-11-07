<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._backend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/backend.js', CClientScript::POS_END); ?>


<?php
$modules = YeeModule::getActiveParsableModules();
foreach ($modules as $moduleKey => $moduleParams) {
	if (method_exists(Yii::app()->getModule($moduleKey), 'getSharedAssets')) {
		$assets = Yii::app()->getModule($moduleKey)->getSharedAssets('layout-backend');
		foreach ($assets['js'] as $jsAsset) {
			Yii::app()->getClientScript()->registerScriptFile($jsAsset['src'], !empty($jsAsset['position']) ? $jsAsset['position'] : CClientScript::POS_END, !empty($jsAsset['htmlOptions']) ? $jsAsset['htmlOptions'] : array());
		}
		foreach ($assets['css'] as $cssAsset) {
			Yii::app()->getClientScript()->registerCssFile($cssAsset['src'], !empty($cssAsset['media']) ? $cssAsset['media'] : '');
		}
	}
}
?>
<?php Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat'); ?>
</head>

<!-- flashes -->
<?php if (!$this->layoutParams['hideFlashes'] && Notice::hasFlashes()) : ?>
<div class="row">
    <div id="layout-flashNotice">
        <?php echo Notice::renderFlashes(); ?>
    </div>
</div>
<?php endif; ?>
<!-- /flashes -->

<!-- nav-main -->
<div class="row border-bottom white-bg">

	<nav class="navbar navbar-default" id="nav-main" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php echo Html::link(Yii::t('app', 'Backend'), $this->createUrl('/backend/index'), array('class' => 'navbar-brand')); ?>
		</div>

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<!-- Main nav -->
			<?php $this->initBackendMenu(); ?>
			<?php $this->widget('zii.widgets.CMenu', array(
				'htmlOptions' => array('class' => 'nav navbar-nav'),
				'encodeLabel' => false,
				'items' => $this->menuMain,
			)); ?>


			<?php $labelMe = sprintf('<img src="%s" class="img-circle" style="width:18px; height:18px" /> %s', ImageHelper::thumb(100, 100, $this->user->profile->image_avatar), ysUtil::truncate($this->user->profile->full_name, 8)); ?>

			<?php $this->widget('zii.widgets.CMenu', array(
				'encodeLabel' => false,
				'htmlOptions' => array('class' => 'nav navbar-nav navbar-right'),
				'items' => array(
					array(
						'label' => $labelMe . ' <b class="caret"></b>', 'url' => '#',
						'visible' => Yii::app()->user->getState('accessBackend') == true,
						'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => $this->menuUser,
					),
				),
			)); ?>


			<form class="navbar-form navbar-right" action="<?php echo $this->createUrl('/journey/backend/search'); ?>" method="GET">
				<div class="form-group">
					<input name="keyword" type="text" class="form-control" placeholder="Search" size="12" value="<?php echo Yii::app()->request->getParam('keyword'); ?>" pattern=".{2,}" />
				</div>
				<button type="submit" class="btn btn-primary">Go</button>
			</form>


		</div>
	</nav>
</div>
<!-- /nav-main -->

<div class="container-fluid margin-top-lg">

	<!-- main-content -->
	<div id="main-content">

		<?php if (!$this->menu) : ?>

			<div class="row">
				<div class="col-lg-12">
					<?php echo $content; ?>
				</div>
			</div>

		<?php else : ?>

			<div class="row">
				<div class="col-lg-9 layout-left">
					<?php echo $content; ?>
				</div>
				<div class="col-lg-3 layout-right">
					<div class="panel panel-default" id="nav-sideMenu">
						<div class="panel-heading"><span class="dot3 hidden"><?php echo Yii::t('app', 'Menu'); ?></span><span class="menu"><?php echo Yii::t('app', 'Menu'); ?><button type="button" class="close" aria-hidden="true">&times;</button></span></div>
						<?php $this->widget('zii.widgets.CMenu', array(
							'items' => $this->menu,
							'encodeLabel' => false,
							'htmlOptions' => array('class' => 'nav nav-pills nav-stacked'),
						)); ?>
					</div>
				</div>
			</div>

		<?php endif; ?>
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


<?php Yii::app()->clientScript->registerScript(
							'settings-script',
							<<<EOD
updateQuickInfo();
setInterval(function() {updateQuickInfo();}, 10000);
EOD
); ?>


<?php Yii::app()->clientScript->registerScript('vue-main-content', "

$('.js-multi-select').select2({
    placeholder: 'Please Select',
    allowClear: true
});

"); ?>
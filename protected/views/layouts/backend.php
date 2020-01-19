<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._backend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/backend.js', CClientScript::POS_END); ?>

<?php Yii::app()->getClientScript()->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js'); ?>


<?php
$modules = YeeModule::getParsableModules();
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
<!-- nav-main -->
<div class="<?php echo (Yii::app()->theme->name == 'inspinia') ? 'row border-bottom white-bg' : 'container'; ?>">
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


			<?php $labelMe = sprintf('<img src="%s" class="img-circle" style="width:18px; height:18px" /> %s', ImageHelper::thumb(100, 100, $this->user->profile->image_avatar), YsUtil::truncate($this->user->profile->full_name, 8)); ?>

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
						<?php
																																			$this->widget('zii.widgets.CMenu', array(
																																				'items' => $this->menu,
																																				'encodeLabel' => false,
																																				'htmlOptions' => array('class' => 'nav nav-pills nav-stacked'),
																																			));
						?>
					</div>
				</div>
			</div>

		<?php endif; ?>
	</div>
	<!-- /main-content -->

</div>
<!-- /container -->


<?php if (Yii::app()->params['enableMixPanel']) : ?>
	<!-- start Mixpanel -->
	<script type="text/javascript">
		(function(e, a) {
			if (!a.__SV) {
				var b = window;
				try {
					var c, l, i, j = b.location,
						g = j.hash;
					c = function(a, b) {
						return (l = a.match(RegExp(b + "=([^&]*)"))) ? l[1] : null
					};
					g && c(g, "state") && (i = JSON.parse(decodeURIComponent(c(g, "state"))), "mpeditor" === i.action && (b.sessionStorage.setItem("_mpcehash", g), history.replaceState(i.desiredHash || "", e.title, j.pathname + j.search)))
				} catch (m) {}
				var k, h;
				window.mixpanel = a;
				a._i = [];
				a.init = function(b, c, f) {
					function e(b, a) {
						var c = a.split(".");
						2 == c.length && (b = b[c[0]], a = c[1]);
						b[a] = function() {
							b.push([a].concat(Array.prototype.slice.call(arguments,
								0)))
						}
					}
					var d = a;
					"undefined" !== typeof f ? d = a[f] = [] : f = "mixpanel";
					d.people = d.people || [];
					d.toString = function(b) {
						var a = "mixpanel";
						"mixpanel" !== f && (a += "." + f);
						b || (a += " (stub)");
						return a
					};
					d.people.toString = function() {
						return d.toString(1) + ".people (stub)"
					};
					k = "disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
					for (h = 0; h < k.length; h++) e(d, k[h]);
					a._i.push([b, c, f])
				};
				a.__SV = 1.2;
				b = e.createElement("script");
				b.type = "text/javascript";
				b.async = !0;
				b.src = "undefined" !== typeof MIXPANEL_CUSTOM_LIB_URL ? MIXPANEL_CUSTOM_LIB_URL : "file:" === e.location.protocol && "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//) ? "https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js" : "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";
				c = e.getElementsByTagName("script")[0];
				c.parentNode.insertBefore(b, c)
			}
		})(document, window.mixpanel || []);
		mixpanel.init("<?php echo Yii::app()->params['mixpanelToken']; ?>");
		<?php if (!empty(Yii::app()->user) && !empty(Yii::app()->user->username)) : ?>mixpanel.identify("<?php echo Yii::app()->user->username; ?>");
		<?php endif; ?>
	</script><!-- end Mixpanel -->
<?php endif; ?>

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
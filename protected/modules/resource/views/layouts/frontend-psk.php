<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile("//www.mymagic.my/universal-assets/css/bootstrap-social.css", CClientScript::POS_END);?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/mymagic.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/css/app.css'); ?>


<?php
$modules = YeeModule::getActiveParsableModules();
foreach ($modules as $moduleKey => $moduleParams) {
	if (method_exists(Yii::app()->getModule($moduleKey), 'getSharedAssets')) {
		$assets = Yii::app()->getModule($moduleKey)->getSharedAssets('layout-frontend');
		foreach ($assets['js'] as $jsAsset) {
			Yii::app()->getClientScript()->registerScriptFile($jsAsset['src'], !empty($jsAsset['position']) ? $jsAsset['position'] : CClientScript::POS_END, !empty($jsAsset['htmlOptions']) ? $jsAsset['htmlOptions'] : array());
		}
		foreach ($assets['css'] as $cssAsset) {
			Yii::app()->getClientScript()->registerCssFile($cssAsset['src'], !empty($cssAsset['media']) ? $cssAsset['media'] : '');
		}
	}
}
?>


<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

<?php
/*Yii::app()->clientScript->registerScript("uniheader", sprintf('$(function() {
	_muh.config.selectedMenu1="academy";
	_muh.config.disableLanguage=true;
	_muh.config.disableAccount=false;
	_muh.config.isLogin=%s;
	_muh.config.currentUrl = "//hub.mymagic.my";
	_muh.config.logoutUrl = "//hub.mymagic.my/site/logout";
	_muh.render();
});', Yii::app()->user->isGuest?'false':'true'), CClientScript::POS_END); */
?>
<?php $this->layoutParams['bodyClass'] .= ' body-psk layout-frontend-psk'; ?>
<?php $this->layoutParams['bodyClass'] .= ' body-stampede'; ?>
<?php $this->layoutParams['hideFlashes'] = false; ?>
<?php //$this->layoutParams['bodyClass'] .= ' push-body';?>

<div id="layout-flashNotice">
  <?php if (Notice::hasFlashes()) :?><?php echo Notice::renderFlashes(); ?><?php endif; ?>
</div>

<header>
    <div class="uni-header uni-header2">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
          <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <i class="fa fa-reorder"></i>
          </button>
          <a class="navbar-brand" href="#">
              <img src="<?php echo $this->module->getAssetsUrl() ?>/images/med/logo.png" id="logo-psk" alt="MED" />
          </a>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
          <ul class="nav navbar-nav">
            <li class="active"><a aria-expanded="false" role="button" href="/resource?brand=psk"><?php echo Yii::t('resource', 'Resource'); ?></a>
            <!--<li><a aria-expanded="false" role="button" href="/mentor"><?php echo Yii::t('resource', 'Mentorship'); ?></a>
            <li><a aria-expanded="false" role="button" href="https://web.skype.com/" target="_top"><?php echo Yii::t('resource', 'Skype'); ?></a>
            </li>-->
          </ul>
          <ul class="nav navbar-top-links navbar-right">
            <li><a>PSK <?php echo Html::faIcon('fa fa-phone'); ?>1-300-88-1020</a></li>
          </ul>
          </div>
    </nav>
    </div>
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


<?php if (Yii::app()->params['environment'] == 'production'):?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  // .mymagic.my
  ga('create', 'UA-62910124-1', 'auto');
  ga('send', 'pageview');
  // central
  ga('create', 'UA-62910124-5', 'auto', 'centralTracker');
  ga('centralTracker.send', 'pageview');
  // custom
<?php foreach ($this->layoutParams['gaAccounts'] as $gaAccount): ?>
  ga('create', '<?php echo $gaAccount['id']; ?>', 'auto', '<?php echo $gaAccount['trackerName']; ?>');
  ga('<?php echo $gaAccount['trackerName']; ?>', 'pageview');
<?php endforeach; ?>
  // user id
<?php if (!empty(HUB::getSessionUsername())):?>  ga('set', 'userId', '<?php echo HUB::getSessionUsername(); ?>');<?php endif; ?>
</script>
<?php endif; ?>

<?php if (Yii::app()->params['environment'] == 'production'):?>
<!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(["setCookieDomain", "*.mymagic.my"]);
  _paq.push(['setDomains', '*.mymagic.my']);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  _paq.push(['trackAllContentImpressions']);
<?php foreach ($this->layoutParams['piwik']['events'] as $piwikEvent): ?>
  _paq.push(['trackEvent', '<?php echo $piwikEvent['category']; ?>', '<?php echo $piwikEvent['action']; ?>', '<?php echo $piwikEvent['key']; ?>', '<?php echo $piwikEvent['value']; ?>']);
<?php endforeach; ?>
  (function() {
    var u="<?php echo Yii::app()->params['piwikTrackerUrl']; ?>";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
<?php endif; ?>

<?php if (Yii::app()->params['enableMixPanel']): ?>
<!-- start Mixpanel --><script type="text/javascript">(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
mixpanel.init("<?php echo Yii::app()->params['mixpanelToken']; ?>");
<?php if (!empty(Yii::app()->user) && !empty(HUB::getSessionUsername())): ?>mixpanel.identify("<?php echo HUB::getSessionUsername(); ?>");<?php endif; ?></script><!-- end Mixpanel -->
<?php endif; ?>

<?php $utm_source = isset($_GET['utm_source']) ? $_GET['utm_source'] : ''; ?>
<?php $utm_medium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : ''; ?>
<?php $utm_campaign = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : ''; ?>
<?php $utm_term = isset($_GET['utm_term']) ? $_GET['utm_term'] : ''; ?>
<?php $utm_content = isset($_GET['utm_content']) ? $_GET['utm_content'] : ''; ?>

<script type="text/javascript">
jQuery(document).ready(function ($) {
    $(function() {
        /*$("a").attr('href', function(i, h) {
            if(i && h && h.indexOf('#') == -1)
            {
                return h + (h.indexOf('?') != -1 ? "&utm_source=<?php echo $utm_source; ?>&utm_medium=<?php echo $utm_medium; ?>&utm_campaign=<?php echo $utm_campaign; ?>&utm_term=<?php echo $utm_term; ?>&utm_content=<?php echo $utm_content; ?>" : "?utm_source=<?php echo $utm_source; ?>&utm_medium=<?php echo $utm_medium; ?>&utm_campaign=<?php echo $utm_campaign; ?>&utm_term=<?php echo $utm_term; ?>&utm_content=<?php echo $utm_content; ?>");
            }
            
        });*/
    });
});
</script>

<!-- // todo: detach MaGIC Connect -->
<iframe style="border:0; width:1px; height:1px" src="https://<?php echo Yii::app()->params['connectUrl']; ?>/profile"></iframe>


<!-- modal-common -->
<div id="modal-common" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel-common" data-load-url="">
</div>
<!-- /modal-common -->

<?php $this->endContent(); ?>



<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/owl.carousel.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/owl.carousel.js', CClientScript::POS_END); ?>

<?php //Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat');?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>


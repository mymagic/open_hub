<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/javascript/frontend.js', CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile("//www.mymagic.my/universal-assets/css/bootstrap-social.css", CClientScript::POS_END);?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/mymagic.css'); ?>


<?php Yii::app()->ClientScript->registerScriptFile('//mymagic.my/universal-assets/uniheader-new.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('//mymagic.my/universal-assets/unifooter.js', CClientScript::POS_END); ?>

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
<?php $this->layoutParams['bodyClass'] .= ' body-stampede layout-frontend'; ?>
<?php $this->layoutParams['hideFlashes'] = false; ?>
<?php //$this->layoutParams['bodyClass'] .= ' push-body';?>

<?php if (!$this->layoutParams['hideFlashes'] && Notice::hasFlashes()) :?>
<div id="layout-flashNotice">
	<?php echo Notice::renderFlashes(); ?>
</div>
<?php endif; ?>


<style type="text/css">

	.header__fnav .navbar-brand{
    background:#fff;
	}

	.header__fnav .navbar-brand .st0{
	    fill:#00AAC6;
	}
	.header__fnav .navbar-brand .st1{
	    fill:#CE3640;
	}
	.header__fnav .navbar-brand .st2{
	    fill:#F3A629;
	}
	.header__fnav .navbar-brand .st3{
	    fill:#6EA945;
	}
	.header__fnav .navbar-brand .st4{
	    fill:#E75C2D;
	}
	@media (min-width: 1200px)
	{
		.uni-header .header__fnav .navbar-brand {
		    height: 40px;
		    margin-left: 0;
		    margin-right: 20px;
		    height: 40px;
		    line-height: 35px;
		    padding: 12px 0;
		    width: 42px;
		    margin-left: 0!important;
		}
	}
	.header__fnav .navbar-brand svg {
    	height: 15px !important;
    	width: 18px !important;
 
	}
</style>


<header class="header">
    <div class="uni-header">
        <nav class="navbar header__fnav" data-spy="affix" data-offset-top="1">
            <div class="container container_dark">
            </div>
            <div class="container">
                <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right">
                    <button type="button" class="toggle-menu menu-right navbar-toggle">
					<span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</span>
					</button>
                    <a class="logo_main hidden-xs hidden-sm" href="https://mymagic.my/">
						<img width="119" height="20" src="https://mymagic.my/wp-content/themes/magic2017/assets/art/logo.svg" alt="MaGIC">
						<span class="header__tagline hidden-xs hidden-sm">Malaysian Global Innovation &amp; Creativity Centre</span>
					</a>
                    <?php $this->renderBreadcrumb(true); ?>
                    <div class="box_white">
                        <?php if ($this->layoutParams['enableGlobalSearchBox']): ?>
                        <form class="search_block" action="https://mymagic.my/">
                            <div class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
									<i class="icon-search"></i>
								</a>
                                <div class="dropdown-menu">
                                    <fieldset>
                                        <input type="search" class="form-control" placeholder="Search" value="" name="s">
                                        <button type="button" class="close" data-dismiss="dropdown-menu" aria-label="Close"><i class="icon-close"></i></button>
                                        <button type="submit"><i class="icon-search"></i></button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>
                        <?php if (!empty($this->menuSub)): ?>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'htmlOptions' => array('class' => 'nav_pillars'),
                            'itemCssClass' => 'menu-item menu-item-type-post_type menu-item-object-page',
                            'activeCssClass' => 'current-menu-item page_item current_page_item',
                            'encodeLabel' => false,
                            'items' => $this->menuSub,
                        )); ?>
                        <?php endif; ?>
                        
                        <?php if ($this->layoutParams['isShowMenuSubLanguageSelector']): ?>
                        <div class="nav_pillars_lang">
                        <?php if (count(Yii::app()->params['frontendLanguages']) > 1): ?>
                            <ul id="nav-selectLanguage" class="list-inline">
                            <?php foreach (Yii::app()->params['frontendLanguages'] as $langCode => $langTitle): ?> 
                            <li class="<?php echo (Yii::app()->language == $langCode) ? 'active' : ''; ?>">
                                <a href="<?php echo $this->createMultilanguageReturnUrl($langCode); ?>" title="<?php echo $langTitle; ?>"><img src="/images/languages/<?php echo strtolower($langCode); ?>.png" class="flag" alt="<?php echo $langTitle; ?>" width="16px" /></a>
                            </li>
                            <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                    <ul class="nav_main hidden-md hidden-lg">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/about/" class="menu-link main-menu-link">About</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/programs/" class="menu-link main-menu-link">Programs</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/events/" class="menu-link main-menu-link">Events</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/facilities/" class="menu-link main-menu-link">Co-Working</a></li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom"><a target="_blank" href="https://resource.mymagic.my/#sthash.ETSyAo9e.dpbs" class="menu-link main-menu-link">Resources</a></li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://mymagic.my/ace/" class="menu-link main-menu-link">ACE</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/news/" class="menu-link main-menu-link">News</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/publications/" class="menu-link main-menu-link">Publications</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://central.mymagic.my/community/" class="menu-link main-menu-link">Community</a></li>
                    </ul>
                    <ul class="nav_secondary hidden-md hidden-lg">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/jobs/" class="menu-link main-menu-link">Jobs</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/contact/" class="menu-link main-menu-link">Contact Us</a></li> 
                    </ul>
                    <ul class="nav_main nav_myacc hidden-md hidden-lg">
                        <li><a href="https://connect.mymagic.my/"><i class="icon-key"></i> My Account</a></li>
                    </ul>
                </div>
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

<!-- universal footer -->
<footer class="uni-footer"></footer>
<!-- /universal footer -->



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
<?php if (!empty(Yii::app()->user->username)):?>  ga('set', 'userId', '<?php echo Yii::app()->user->username; ?>');<?php endif; ?>
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
<?php if (!empty(Yii::app()->user) && !empty(Yii::app()->user->username)): ?>mixpanel.identify("<?php echo Yii::app()->user->username; ?>");<?php endif; ?></script><!-- end Mixpanel -->
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



<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/vendor/stampede/css/owl.carousel.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/vendor/stampede/js/owl.carousel.js', CClientScript::POS_END); ?>

<?php //Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat');?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/vendor/stampede/css/fix-inspinia-conflict.css'); ?>


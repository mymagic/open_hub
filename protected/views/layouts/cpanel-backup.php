<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._blank', Yii::app()->theme->name)); ?>

<?php $this->layoutParams['hideFlashes'] = false; ?>
<?php $this->layoutParams['bodyClass'] .= ' body-stampede'; ?>

<?php Yii::import('webroot.themes.'.Yii::app()->theme->name.'.model.Inspinia'); ?>

<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/vendor/timeout-dialog/css/timeout-dialog.css', '', 1001); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . "/vendor/timeout-dialog/js/timeout-dialog.js", CClientScript::POS_END); ?>

<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/app.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/frontend.css', '', 1002); ?>
<?php Yii::app()->getClientScript()->registerScriptFile("https://cdn.pubnub.com/pubnub-3.14.4.min.js", CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . "/javascript/app.js", CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . "/javascript/frontend.js", CClientScript::POS_END); ?>

<?php Yii::app()->getClientScript()->registerScriptFile(sprintf('https://maps.googleapis.com/maps/api/js?key=%s', Yii::app()->params['googleMapApiKey']), CClientScript::POS_END); ?>

<?php Yii::app()->ClientScript->registerScriptFile('//mymagic.my/universal-assets/uniheader-new.js',CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('https://mymagic.my/universal-assets/unifooter.js?t=1495631999', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>

<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

<style type="text/css">

	.header__fnav .navbar-brand{
    background:#fff !important;
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
	.skin-1 .header__fnav .nav > li.active{
		background:#1d1d1f;
	}
	.skin-1 .header__fnav .navbar-nav li.active> .dropdown-toggle{
		background:#1d1d1f!important;
	}

	.header__fnav .navbar-nav>li>.dropdown-menu li> a{
		background: #2d2d30 !important;
	}
</style>
<script type="text/javascript">
	var isMemberLogin = '';
</script>

<body id="body-cpanel-<?php echo Yii::app()->controller->id ?>-<?php echo Yii::app()->controller->action->id ?>" class="body-stampede<?php if(!$this->menu): ?>gray-bg<?php endif; ?> skin-1 <?php /* boxed-layout*/ ?>">
	

	<!-- universal header -->
	<div class="color-bar"></div>
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
                    <?php $this->renderBreadcrumb(true) ?>
                     <div class="box_white">
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
                        <!-- <ul class="nav_pillars">
                        <?php if(!empty(Yii::app()->user->accessBackend) && Yii::app()->user->accessBackend): ?>
							<li role="presentation" class="<?php if($this->activeMenuMain=="backend"): ?>active<?php endif; ?>"><a href="<?php echo $this->createUrl('//backend/index') ?>">Backend</a></li><?php endif; ?>   
           					<?php if(!Yii::app()->user->isGuest): ?>
           					<li class="<?php if($this->activeMenuMain=="cpanel"): ?>active<?php endif; ?>"><a href="<?php echo Yii::app()->params['connectUrl'].'/profile' ?>">Profile</a></li>
                			<li class="<?php if($this->activeMenuMain=="logout"): ?>active<?php endif; ?>"><a href="<?php echo $this->createUrl('//site/logout') ?>" title="<?php echo $this->user->username ?>" data-toggle="tooltip" data-placement="bottom"><img src="<?php echo ImageHelper::thumb(100, 100, $this->user->profile->image_avatar) ?>" class="img-circle" style="width:24px; height:24px" /> Logout
							</a></li>
							<?php endif; ?>
							
					
                        </ul> -->
                    </div>
                    <ul class="nav_main hidden-md hidden-lg">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/about/" class="menu-link main-menu-link">About</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/programs/" class="menu-link main-menu-link">Programs</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/events/" class="menu-link main-menu-link">Events</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/facilities/" class="menu-link main-menu-link">Co-Working</a></li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom"><a target="_blank" href="http://resource.mymagic.my/#sthash.ETSyAo9e.dpbs" class="menu-link main-menu-link">Resources</a></li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://mymagic.my/ace/" class="menu-link main-menu-link">ACE</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/news/" class="menu-link main-menu-link">News</a></li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/publications/" class="menu-link main-menu-link">Publications</a></li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="http://central.mymagic.my/community/" class="menu-link main-menu-link">Community</a></li>
                    </ul>
                    <ul class="nav_secondary hidden-md hidden-lg">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/jobs/" class="menu-link main-menu-link">Jobs</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://mymagic.my/contact/" class="menu-link main-menu-link">Contact Us</a></li> 
                    </ul>
                    <ul class="nav_main nav_myacc hidden-md hidden-lg">
                        <li><a href="http://connect.mymagic.my/"><i class="icon-key"></i> My Account</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
	

	<!-- /universal header -->

	<div id="layout-gap"></div>

	<?php if(Notice::hasFlashes()) :?>
	<div id="layout-flashNotice">
		<?php echo Notice::renderFlashes() ?>
	</div>
	<?php endif; ?>

    <div id="wrapper" class="new-dash-bg wrapper-new">

	<?php if($this->menu): ?>
	<!-- nav -->
    <nav id="sidebar-sticky" class="navbar-default new-dash-bg navbar-static-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav new-dash-bg">
			<li class="nav-header new-dash-bg">
				<div class="dropdown"> 
		
    <a href="<?php echo Yii::app()->createUrl('/cpanel/index') ?>">
                            <span class="clear"> <span> <strong class="central-sidehead">MaGIC Dashboard</strong>
                             </span></span></a>
				</div>
				<div class="logo-element hidden"></div>
            </li>
			</ul>
			<?php
				$this->widget('zii.widgets.CMenu', array(
					'items'=>Inspinia::fixMenuItems($this->menu),
					'encodeLabel' => false,
					'htmlOptions'=>array('class'=>'nav', 'id'=>'side-menu'),
				));
			?>
		</div>
	</nav>
	<!-- /nav -->
	<?php endif; ?>
	
	<!-- wrapper -->
	<div <?php if($this->menu): ?>id="page-wrapper"<?php endif; ?> class="over-wrapper white-bg sidebar-10padding sidebar-content">
		<!-- header -->
		<div class="row border-bottom white-bg page-heading">
			<div class="col-lg-12">
				<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0; z-index:998;">
					<div class="navbar-header2">
						<a class="navbar-minimalize minimalize-styl-1 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>
						<div class="pull-right text-right">
							<h2 class="nopadding"><?php echo CHtml::encode($this->pageTitle); ?></h2>
							<!-- breadcrumb -->
							<?php if(isset($this->breadcrumbs)):?>
								<?php $this->widget('zii.widgets.CBreadcrumbs', array(
									'links'=>$this->breadcrumbs,
									'separator'=>'&nbsp;/&nbsp;',
									'htmlOptions'=>array('id'=>'nav-breadcrumbs', 'class'=>'breadcrumbs')
								)); ?>
							<?php endif?>
							<!-- /breadcrumb -->
						</div>
					</div>
				</nav>
			</div>
		</div>
		<!-- /header -->

		<!-- content -->
		  <div class="content-content">
      <!--       <div class="sidebard-panel left-bar">
         
            </div> -->
 					<?php echo $content ?>

        </div>
<!--             <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
								
			            </div>
			        </div>
			    </div>
			</div>
			 -->

		<!-- /content -->	
	</div>
		<!-- footer -->
		<div class="footer hidden">
			<div class="pull-right">
				Profiling: <strong><?php echo round(Yii::getLogger()->getExecutionTime(),2); ?>s / <?php echo round(Yii::getLogger()->getMemoryUsage()/1048576,2); ?> MB</strong>.
			</div>
		</div>
		<!-- /footer -->
		
		
	</div>
	<!-- /wrapper -->

<!-- universal footer -->
<footer class="uni-footer"></footer>
<!-- /universal footer -->

<?php if(Yii::app()->params['environment'] == 'production'):?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  // .mymagic.my
  ga('create', 'UA-62910124-1', 'auto');
  ga('create', 'UA-62910124-5', 'auto', 'centralTracker');
  ga('send', 'pageview');
  ga('centralTracker.send', 'pageview');
</script>
<?php endif; ?>

<?php if(Yii::app()->params['environment'] == 'production'):?>
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
<?php foreach($this->layoutParams['piwik']['events'] as $piwikEvent): ?>
  _paq.push(['trackEvent', '<?php echo $piwikEvent['category'] ?>', '<?php echo $piwikEvent['action'] ?>', '<?php echo $piwikEvent['key'] ?>', '<?php echo $piwikEvent['value'] ?>']);
<?php endforeach; ?>
  (function() {
    var u="<?php echo Yii::app()->params['piwikTrackerUrl'] ?>";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
<?php endif; ?>

<?php if(Yii::app()->params['enableMixPanel']): ?>
<!-- start Mixpanel --><script type="text/javascript">(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
mixpanel.init("<?php echo Yii::app()->params['mixpanelToken'] ?>");<?php if(!empty(Yii::app()->user) && !empty(Yii::app()->user->username)): ?>mixpanel.identify("<?php echo Yii::app()->user->username ?>");<?php endif; ?></script><!-- end Mixpanel -->
<?php endif; ?>


</body>

<?php Yii::app()->clientScript->registerScript('sessionTimeOut', sprintf('sessionTimeoutPopup(%s);', Yii::app()->user->authTimeout, 30)); ?>

<iframe style="border:0; width:1px; height:1px" src="https://<?php echo Yii::app()->params['connectUrl']?>/profile"></iframe>
		
<?php $this->endContent(); ?>


<?php //Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>

<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/new-dashboard.css'); ?>

<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/universal-style-new.css'); ?>



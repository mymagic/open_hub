<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile("//www.mymagic.my/universal-assets/css/bootstrap-social.css", CClientScript::POS_END);?>


<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/uniheader-new.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/unifooter.js', CClientScript::POS_END); ?>
<?php
/*Yii::app()->clientScript->registerScript("uniheader", sprintf('$(function() {
	_muh.config.selectedMenu1="academy";
	_muh.config.disableLanguage=true;
	_muh.config.disableAccount=false;
	_muh.config.isLogin=%s;
	_muh.config.currentUrl = "//hub.mymagic.my";
	_muh.config.logoutUrl = "//hub.mymagic.my/site/logout";
	_muh.render();
});', Yii::app()->user->isGuest?'false':'true'), CClientScript::POS_END);*/
?>

<?php $this->layoutParams['hideFlashes'] = false; ?>
<?php $this->layoutParams['bodyClass'] .= ' body-stampede'; ?>

<?php //$this->layoutParams['bodyClass'] .= ' push-body';?>

<?php if (Notice::hasFlashes()) :?>
<div id="layout-flashNotice">
	<?php echo Notice::renderFlashes() ?>
</div>
<?php endif; ?>

<style type="text/css">
	.modal-dialog {
		z-index: 0;
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
                        <ul class="nav_pillars">   
                         <!--    <li role="presentation" class="<?php if ($this->activeMenuMain == 'start'): ?>active<?php endif; ?>"><a href="<?php echo $this->createUrl('//resource/frontend/index') ?>">Resource Directory</a></li>
							<li role="presentation" class="<?php if ($this->activeMenuMain == 'forum'): ?>active<?php endif; ?>"><a href="http://magiccentral.userecho.com/">Q&amp;A Forum</a></li>
							<li role="presentation" class="<?php if ($this->activeMenuMain == 'appointment'): ?>active<?php endif; ?>"><a href="http://magic.acuityscheduling.com/schedule.php?calendarID=299677">Mentorship</a></li> -->
                        </ul>
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
<div class="container">

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
  ga('create', 'UA-62910124-5', 'auto', 'centralTracker');
  ga('send', 'pageview');
  ga('centralTracker.send', 'pageview');
</script>
<?php endif; ?>

<?php $this->endContent(); ?>



<?php //Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat');?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>
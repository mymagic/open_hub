<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . "/javascript/app.js", CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/javascript/frontend.js", CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile("//www.mymagic.my/universal-assets/css/bootstrap-social.css", CClientScript::POS_END); ?>

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
<?php $this->layoutParams['bodyClass'] .= ' body-stampede'; ?>
<?php $this->layoutParams['hideFlashes'] = false; ?>
<?php //$this->layoutParams['bodyClass'] .= ' push-body'; ?>

<?php if(Notice::hasFlashes()) :?>
<div id="layout-flashNotice">
	<?php echo Notice::renderFlashes() ?>
</div>
<?php endif; ?>


<style type="text/css">

    .main-survey__wrapper {
        z-index: 4;
        background-color: #ffffff;
        left: 0px;
        position: relative;
        height: 100%;
    }
    
    .main-survey {
        position: relative;
        width: 70%;
        background-color: white;
        padding-left: 20px;
        top: 200px;
        box-shadow: 1px 1px 20px 20px rgba(0, 0, 0, 0.1);
        padding-top: 20px;
        margin-bottom: 50px;
    }

    @media (max-width: 640px) {
        .main-survey {
            width: 100%;
            margin: 0 0;
        }
    }

    @media (max-width: 640px) {
        .main-survey__wrapper {
            width: 100%;
        }
    }

    .survey-image-header {
        background-image:url(/images/survey-header.png);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        vertical-align: middle;
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
        border: 0;
        position: absolute;
        z-index: 0;
        top: -50px;
        left: 0px;
        height: 400px;
        width: 100%;
    }

   .stripe-survey{
        background-image:url(/images/stripe.png);
        position: absolute;
        z-index: 1;
        top: 0px;
        left: 0px;
        height: 4px;
        width: 100%;
   }

    .stripe-survey-down {
        background-image:url(/images/stripe.png);
        position: absolute;
        bottom: 00px;
        left: 0px;
        height: 4px;
        width: 100%;
        z-index: 4;
   }
   .logo-survey{
        position: absolute;
        z-index: 2;
        top: 5px;
        left: 80px;
        height: 50px;
        width: 50%;
        padding-top:5px;
        line-height: 30px;
        float: left;
   }
   .logo-text-survey{
    font-family: sofia-pro,Arial,sans-serif;
    color: #1d1d1d;
    font-size: 14px;
    padding-left: 10px;
    text-align: center;
   }

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
	
	.header__fnav .navbar-brand svg {
    	height: 15px !important;
    	width: 18px !important;
 
    }

    .header__fnav {
    padding-top: 3px;
    background-image: url(../images/top-stripe.png);
    background-repeat: repeat-x;
    background-position: 0 0;
    height: 43px;
}
	
</style>


<!-- container -->
<div class="<?php echo $this->layoutParams['containerFluid']?'container-fluid':'container' ?>">

<div class="stripe-survey"></div>

</div>
<a class="hidden-xs hidden-sm logo-survey" href="https://mymagic.my/">
<img width="119" height="20" src="https://mymagic.my/wp-content/themes/magic2017/assets/art/logo.svg" alt="MaGIC">
<span class="logo-text-survey header__tagline hidden-xs hidden-sm">Malaysian Global Innovation &amp; Creativity Centre</span>
</a>




<!-- main-content -->
<div class="main-survey__wrapper">
    <div class="img survey-image-header"></div>
    <div class="main-survey" id="main-content">
        <?php echo $content; ?>
        <div class="stripe-survey-down"></div>
    </div>
</div>




<!-- /main-content -->



<?php if(Yii::app()->params['environment'] == 'production'):?>
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
<?php foreach($this->layoutParams['gaAccounts'] as $gaAccount): ?>
  ga('create', '<?php echo $gaAccount['id'] ?>', 'auto', '<?php echo $gaAccount['trackerName'] ?>');
  ga('<?php echo $gaAccount['trackerName'] ?>', 'pageview');
<?php endforeach; ?>
  // user id
<?php if(!empty(Yii::app()->user->username)):?>  ga('set', 'userId', '<?php echo Yii::app()->user->username ?>');<?php endif; ?>
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
  (function() {
    var u="//misc.mymagic.my/piwik/";
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
mixpanel.init("<?php echo Yii::app()->params['mixpanelToken'] ?>");
<?php if(!empty(Yii::app()->user) && !empty(Yii::app()->user->username)): ?>mixpanel.identify("<?php echo Yii::app()->user->username ?>");<?php endif; ?></script><!-- end Mixpanel -->
<?php endif; ?>

<?php $utm_source = isset($_GET['utm_source']) ? $_GET['utm_source'] : ""; ?>
<?php $utm_medium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : ""; ?>
<?php $utm_campaign = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : ""; ?>
<?php $utm_term = isset($_GET['utm_term']) ? $_GET['utm_term'] : ""; ?>
<?php $utm_content = isset($_GET['utm_content']) ? $_GET['utm_content'] : ""; ?>

<script type="text/javascript">
jQuery(document).ready(function ($) {
    $(function() {
        $("a").attr('href', function(i, h) {
            if(i && h && h.indexOf('#') == -1)
            {
                return h + (h.indexOf('?') != -1 ? "&utm_source=<?php echo $utm_source; ?>&utm_medium=<?php echo $utm_medium; ?>&utm_campaign=<?php echo $utm_campaign; ?>&utm_term=<?php echo $utm_term; ?>&utm_content=<?php echo $utm_content; ?>" : "?utm_source=<?php echo $utm_source; ?>&utm_medium=<?php echo $utm_medium; ?>&utm_campaign=<?php echo $utm_campaign; ?>&utm_term=<?php echo $utm_term; ?>&utm_content=<?php echo $utm_content; ?>");
            }
            
        });
    });
});
</script>

<iframe style="border:0; width:1px; height:1px" src="https://<?php echo Yii::app()->params['connectUrl']?>/profile"></iframe>

<?php $this->endContent(); ?>



<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/owl.carousel.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/owl.carousel.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'); ?>



<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/assets/css/main.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/assets/css/core.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/assets/css/fix-theme-conflict.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/app.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/frontend.css'); ?>

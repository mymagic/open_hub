<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . "/javascript/app.js", CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/javascript/frontend.js", CClientScript::POS_END); ?>

<?php $this->layoutParams['hideFlashes'] = false; ?>
<?php //$this->layoutParams['bodyClass'] .= ' push-body'; ?>

<?php if(Notice::hasFlashes()) :?>
<div id="layout-flashNotice">
	<?php echo Notice::renderFlashes() ?>
</div>
<?php endif; ?>


<div style="margin:0; overflow: hidden;">
	<?php echo $content; ?>
</div>


<!-- /container -->

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
mixpanel.init("<?php echo Yii::app()->params['mixpanelToken'] ?>");
<?php if(!empty(Yii::app()->user) && !empty(Yii::app()->user->username)): ?>mixpanel.identify("<?php echo Yii::app()->user->username ?>");<?php endif; ?></script><!-- end Mixpanel -->
<?php endif; ?>

<?php $this->endContent(); ?>



<?php //Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>
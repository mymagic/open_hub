<?php
$this->breadcrumbs=array(
    'Q&A Forum'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

?>

<div id="notice-forumExternalMembership"><?php echo Notice::inline(Yii::t('cpanel', 'MaGIC Q&amp;A Forum run on external platform by UserEcho. A separate membership applied.')) ?></div>

<div style="min-height:600px">
<iframe src="https://magiccentral.userecho.com" class="full-width" border="0" style="border:0; position: absolute; height:100%"></iframe>
</div>

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
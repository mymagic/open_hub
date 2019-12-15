<?php
$this->breadcrumbs=array(
    'Q&amp;A Forum'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

?>

<div id="notice-forumExternalMembership"><?php echo Notice::inline(Yii::t('cpanel', 'MaGIC Q&amp;A Forum run on external platform by UserEcho. A separate membership applied.')) ?></div>

<div style="background:#e5e5e5; min-height:600px">
<iframe src="https://magiccentral.userecho.com" class="full-width" border="0" style="border:0; position: absolute; height:100%"></iframe>
</div>
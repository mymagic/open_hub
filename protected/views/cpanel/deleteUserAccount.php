<?php
$this->breadcrumbs = array(
	'Terminate Account'
);
?>

<section>
    <div class="px-8 py-6 shadow-panel" id="">
        <h2><?php echo Embed::code2value('cpanel-deleteAccountMessage', 'title') ?></h2>
       
        <div><?php echo Embed::code2value('cpanel-deleteAccountMessage', 'html_content') ?></div>

        <p class="margin-top-3x"><a href=<?php echo $this->createUrl('cpanel/terminateAccount') ?> id="terminate-link2" class="btn btn-sd btn-sd-pad btn-sd-red"><?php echo Yii::t('cpanel', 'Terminate My Account') ?></a></p>
    </div>
</section>
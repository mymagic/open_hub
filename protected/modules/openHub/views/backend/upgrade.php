<div class="well col col-xs-12">
    <a id="btn-confirmUpgrade" class="pull-right btn btn-md btn-primary"><?php echo Yii::t('openHub', 'Confirm Upgrade') ?></a>
    <p>
    <?php if ($canUpgrade): ?>
        <span class="label label-primary"><?php echo Yii::t('openHub', 'Update Available') ?></span>
        <?php echo $versionRunning?> <?php echo Html::faIcon('fa fa-long-arrow-right')?> <?php echo $versionReleased ?>
    <?php else: ?>
        <span class="label lable-default"><?php echo Yii::t('openHub', 'No Update Available') ?></span>
        <?php echo $versionRunning?>
    <?php endif; ?>
    <?php if ($this->isDevOn()):?>
        <p><small class="text-muted">
        <?php echo Yii::t('openHub', 'Token') ?>: <?php echo Yii::app()->user->getState('keyUpgrade') ?></small></p>
        <?php endif; ?>
    </p>
</div>

<div class="col col-sm-4">
    <h3><?php echo Yii::t('openHub', 'Change Log') ?></h3>
    <p><?php echo(nl2br($latestRelease['body'])) ?></p>
</div>
<div class="col col-sm-8">
    <?php if (Yii::app()->getModule('openHub')->isMockUpgrade): ?><?php echo Notice::inline(Yii::t('openHub', 'Mock Upgrade enabled, no files will be overwritten for real.'), Notice_WARNING) ?><?php endif; ?>
    <textarea id="textarea-output" class="border full-width" readonly style="min-height:30em; overflow-y: scroll;" data-url="<?php echo $this->createAbsoluteUrl('//openHub/backend/doUpgrade', array('key' => Yii::app()->user->getState('keyUpgrade'), 'rand' => '1')) ?>" data-msg-pls-wait="<?php echo Yii::t('openHub', "Upgrading, please wait...\n") ?>"></textarea>
</div>

<?php Yii::app()->clientScript->registerScript('openHub-backend-upgrade', "
$('#btn-confirmUpgrade').on('click', function(e){
    $('#btn-confirmUpgrade').addClass('disabled btn-default').removeClass('btn-primary');
    $('#textarea-output').val($('#textarea-output').data('msgPlsWait'));
	streamUpgradeEvent();
});

function streamUpgradeEvent() {
    var ta = document.getElementById('textarea-output');
    var source = new EventSource(ta.getAttribute('data-url'));

    source.addEventListener('message', function (e) {
        if (e.data !== '') {
            ta.value += e.data + '\\n';
            ta.scrollTop = ta.scrollHeight;
        }
    }, false);

    source.addEventListener('error', function (e) {
        source.close();
    }, false);

}") ?>
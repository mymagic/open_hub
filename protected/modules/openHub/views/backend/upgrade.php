<div class="well col col-xs-12">
    <a id="btn-confirmUpgrade" class="pull-right btn btn-md btn-primary" onclick="streamUpgradeEvent();">Confirm Upgrade</a>
    <p class="margin-bottom-xlg">
    <?php if ($canUpgrade): ?>
        <span class="label label-primary">Update Available</span>
        <?php echo $versionRunning?> <?php echo Html::faIcon('fa fa-long-arrow-right')?> <?php echo $versionReleased ?>
    <?php else: ?>
        <span class="label lable-default">No Update Available</span>
        <?php echo $versionRunning?>
    <?php endif; ?>
</div>

<div class="col col-sm-4">
    <h3>Change Log</h3>
    <p><?php echo(nl2br($latestRelease['body'])) ?></p>
</div>
<div class="col col-sm-8">
    <textarea id="textarea-output" class="border full-width" readonly style="min-height:30em; overflow-y: scroll;" data-url="<?php echo $this->createAbsoluteUrl('backend/doUpgrade', array('key' => Yii::app()->user->getState('keyUpgrade'), 'rand' => '1')) ?>"></textarea>
</div>

<?php Yii::app()->clientScript->registerScript('openHub-backend-upgrade', '') ?>

<script>
function streamUpgradeEvent() {
    $('#btn-confirmUpgrade').addClass('disabled btn-default').removeClass('btn-primary');

    var ta = document.getElementById('textarea-output');
    //var source = new EventSource(ta.getAttribute('data-url'));
    ta.value = ta.getAttribute('data-url');

    source.addEventListener('message', function (e) {
        if (e.data !== '') {
            ta.value += e.data + '\n';
        }
    }, false);

    source.addEventListener('error', function (e) {
        source.close();
    }, false);

}
</script>
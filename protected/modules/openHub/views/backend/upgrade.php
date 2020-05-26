<div class="well col col-xs-12">
    <a class="pull-right btn btn-md btn-primary">Confirm Upgrade</a>
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
    <div id="box-output" class="border" style="min-height:30em; overflow-7: scroll;" data-url="<?php echo $this->createUrl('backend/outputUpgrade', array('key' => Yii::app()->user->getState('keyUpgrade'), 'rand' => '1')) ?>"></div>
</div>


<?php Yii::app()->clientScript->registerScript('openHub-backend-upgrade', "
function outputUpgrade(){
    $.ajax({
        url: $('#box-output').data('url')+Math.random(),
        cache: false,
        dataType: 'html',
        success: function(data) {
            $('#box-output').html(data);
        }
    });
}
setInterval(outputUpgrade, 5000); 
outputUpgrade();
") ?>
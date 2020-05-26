<div class="well col col-xs-12">
    <a id="btn-confirmUpgrade" class="pull-right btn btn-md btn-primary" data-url="<?php echo $this->createUrl('backend/doUpgrade', array('key' => Yii::app()->user->getState('keyUpgrade'))) ?>">Confirm Upgrade</a>
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
    <textarea id="textarea-output" class="border full-width" readonly style="min-height:30em; overflow-y: scroll;" data-url="<?php echo $this->createUrl('backend/outputUpgrade', array('key' => Yii::app()->user->getState('keyUpgrade'), 'rand' => '1')) ?>"></textarea>
</div>


<?php Yii::app()->clientScript->registerScript('openHub-backend-upgrade', "

var previousData = '';
var intervalId = '';

$('#btn-confirmUpgrade').click(function(e){
	$.ajax({
        url: $('#btn-confirmUpgrade').data('url'),
        cache: false,
        dataType: 'html',
        success: function(data) {
            
        },
        beforeSend: function(){
            $('#btn-confirmUpgrade').removeClass('btn-primary').addClass('disabled btn-default');
            intervalId = setInterval(outputUpgrade, 5000); 
            outputUpgrade();
        },
        complete: function(){
            $('#btn-confirmUpgrade').removeClass('disabled btn-default').addClass('btn-primary');
        }
    });
});

function outputUpgrade(){
    $.ajax({
        url: $('#textarea-output').data('url')+Math.random(),
        cache: false,
        dataType: 'html',
        success: function(data) {
            $('#textarea-output').html(data);
            if(data != previousData)
            {
                var textarea = $('#textarea-output');
                textarea.scrollTop(textarea[0].scrollHeight);
                previousData = data;
            }
        }
    });
}

") ?>
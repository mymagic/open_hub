<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('core', 'Error');
?>

<div role="dialog" >
<div class="<?php echo !empty($htmlMessage) ? 'modal-dialog-page' : 'modal-dialog'?>">
	<div class="modal-content">
		<div class="modal-header text-danger">
			<h4 class="modal-title"><i class="glyphicon glyphicon-minus-sign"></i>&nbsp;<?php echo !empty($title) ? $title : Yii::t('core', 'Error') ?></h4>
		</div>
		<div class="modal-body">
			<div class="message">
                <p><?php echo Html::encodeDisplay($message); ?></p>

                <?php if (!Yii::app()->user->isGuest && !empty(Yii::app()->user->username)): ?>
                <p class="text-muted"><small>You are currently login as: &nbsp;<img src="<?php echo ImageHelper::thumb(100, 100, $this->user->profile->image_avatar) ?>" class="img-circle" style="width:24px; height:24px" /> <strong><?php echo Yii::app()->user->username ?></strong></small></p>
                <?php endif; ?>

            </div>
			<?php if (!empty($htmlMessage)): ?><div class="htmlMessage text"><?php echo $htmlMessage; ?></div><?php endif; ?>
		</div>
		<div class="modal-footer">
            <?php echo Html::link('Logout', $this->createUrl('/site/logout'), array('class' => 'btn btn-sd btn-sd-red')); ?>
            <?php $urlLabel = !empty($urlLabel) ? $urlLabel : Yii::t('core', 'OK'); ?>
            <?php if ($disableUrl != true): ?>
            <?php if (!empty($url)): ?>
                <?php echo Html::link($urlLabel, ($url), array('class' => 'btn btn-sd btn-sd-green')); ?>
            <?php else: ?>
                <?php echo Html::backLink($urlLabel, array('class' => 'btn btn-sd btn-sd-green')); ?>
            <?php endif; ?>
            <?php endif; ?>

                
		</div>
	</div>
</div>
</div>
<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('core', 'Warning');
?>

<div role="dialog" >
<div class="<?php echo (!empty($htmlMessage) && strlen($htmlMessage) > 200) ? 'modal-dialog-page' : 'modal-dialog'?>">
	<div class="modal-content">
		<div class="modal-header text-warning">
			<h4 class="modal-title"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;<?php echo Yii::t('core', 'Warning') ?></h4>
		</div>
		<div class="modal-body">
			<?php if (!empty($message)): ?><div class="message"><?php echo(Html::encodeDisplay($message)); ?></div><?php endif; ?>
			<?php if (!empty($htmlMessage)): ?><div class="htmlMessage text"><?php echo $htmlMessage; ?></div><?php endif; ?>
		</div>
		<div class="modal-footer">
			<?php $urlLabel = !empty($urlLabel) ? $urlLabel : Yii::t('core', 'OK'); ?>
			<?php $cancelUrlLabel = !empty($cancelUrlLabel) ? $cancelUrlLabel : Yii::t('core', 'Cancel'); ?>
			<?php if ($disableUrl != true): ?>
			<?php if (!empty($url)): ?>
				<?php echo Html::link($urlLabel, ($url), array('class' => 'btn btn-sd btn-sd-green')); ?>
			<?php else: ?>
				<?php echo Html::backLink($urlLabel, array('class' => 'btn btn-sd btn-sd-green')); ?>
			<?php endif; ?>
			<?php endif; ?>
			
			<?php if ($disableCancelUrl != true): ?>
			<?php if (!empty($cancelUrl)): ?>
				<?php echo Html::link($cancelUrlLabel, ($cancelUrl), array('class' => 'btn btn-sd btn-sd-grey')); ?>
			<?php endif; ?>
			<?php endif; ?>
				
		</div>
	</div>
</div>
</div>
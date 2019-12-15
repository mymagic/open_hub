<?php
$this->pageTitle=Yii::app()->name . ' - '. Yii::t('core', 'Error');
?>

<div role="dialog" >
<div class="<?php echo !empty($htmlMessage)?'modal-dialog-page':'modal-dialog'?>">
	<div class="modal-content">
		<div class="modal-header text-danger">
			<h4 class="modal-title"><i class="glyphicon glyphicon-minus-sign"></i>&nbsp;<?php echo !empty($title)?$title:Yii::t('core', 'Error') ?></h4>
		</div>
		<div class="modal-body">
			<div class="message"><?php echo ($message); ?></div>
			<?php if(!empty($htmlMessage)): ?><div class="htmlMessage text"><?php echo $htmlMessage; ?></div><?php endif; ?>
		</div>
		<div class="modal-footer">
				<?php $urlLabel = !empty($urlLabel)?$urlLabel:Yii::t('core', 'OK'); ?>
				<?php if($disableUrl != true): ?>
				<?php if(!empty($url)): ?>
					<?php echo Html::link($urlLabel, ($url), array('class'=>'btn btn-sd btn-sd-green')); ?>
				<?php else: ?>
					<?php echo Html::backLink($urlLabel, array('class'=>'btn btn-sd btn-sd-green')); ?>
				<?php endif; ?>
				<?php endif; ?>
		</div>
	</div>
</div>
</div>
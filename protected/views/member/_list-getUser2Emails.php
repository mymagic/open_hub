<div class="view">
	<small class="text-muted pull-right">
		<?php echo ysUtil::timeElapsed($data->date_modified, 2)?>&nbsp;
		<?php if ($data->is_verify): ?>
			<span class="text-success"><?php echo Html::faIcon('fa-check-circle') ?></span>
		<?php else: ?>
			<span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span>
		<?php endif; ?>
	</small>
	<p>
	<?php if ($realm == 'cpanel'): ?>
	<a href="<?php echo $this->createUrl('cpanel/deleteUser2Email', array('id' => $data->id, 'realm' => $realm))?>" class="text-danger"><?php echo Html::faIcon('fa-trash') ?></a>&nbsp;
	<?php endif; ?>
	<?php echo Html::encodeDisplay($data->user_email); ?>
	<?php if ($realm == 'cpanel'): ?>
	<?php if (!$data->is_verify): ?>
		<br />
		<small class="margin-left-lg"><?php echo Yii::t('cpanel', 'Please check your inbox to verify this.') ?> <a class="" href="<?php echo $this->createUrl('cpanel/resendLinkEmailVerification', array('email' => $data->user_email)) ?>"><?php echo Yii::t('cpanel', 'Resend Verification Email') ?></a></small>
	<?php endif; ?>
	<?php endif; ?>
	</p>
	
</div>


<div class="view">
	<small class="text-muted pull-right">
		<?php echo ysUtil::timeElapsed($data->date_modified, 2)?>&nbsp;
		<?php if ($data->is_verify): ?>
			<span class="text-primary"><?php echo Html::faIcon('fa-check-circle') ?></span>
		<?php else: ?>
			<span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span>
		<?php endif; ?>
	</small>
	<p>
    <a href="<?php echo $this->createUrl('cpanel/deleteUser2Email', array('id' => $data->id, 'realm' => $realm))?>" class="text-danger"><?php echo Html::faIcon('fa-trash') ?></a>&nbsp;
	<?php echo Html::encodeDisplay($data->user_email); ?>
	<br />
	<small class="margin-left-lg"><?php echo Yii::t('cpanel', 'Please check your inbox to verify this.') ?> <a class="" href="<?php echo $this->createUrl('cpanel/resendLinkEmailVerification', array('email' => $data->user_email)) ?>"><?php echo Yii::t('cpanel', 'Resend Verification Email') ?></a></small></p>
	
</div>


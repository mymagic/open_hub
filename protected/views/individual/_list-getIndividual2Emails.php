<div class="view">
	<small class="text-muted pull-right">
		<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'individual', 'action' => (object)['id' => 'toggleIndividual2EmailStatus']])): ?>
			<a href="<?php echo $this->createUrl('individual/toggleIndividual2EmailStatus', array('id' => $data->id, 'realm' => $realm)) ?>">
			<?php if ($data->is_verify): ?>
				<span class="text-primary"><?php echo Html::faIcon('fa-check-circle') ?></span>
			<?php else: ?>
				<span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span>
			<?php endif; ?>
			</a>
		<?php endif; ?>
		<?php echo ysUtil::timeElapsed($data->date_modified, 2)?>&nbsp;
	</small>
	<p>
	<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'individual', 'action' => (object)['id' => 'deleteIndividual2Email']])): ?>
		<a href="<?php echo $this->createUrl('individual/deleteIndividual2Email', array('id' => $data->id, 'realm' => $realm))?>" class="text-danger"><?php echo Html::faIcon('fa-trash') ?></a>&nbsp;
	<?php endif; ?>
	<?php echo Html::encodeDisplay($data->user_email); ?></p>
</div>


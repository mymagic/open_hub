<div class="view margin-top-md">
	<a href="<?php echo $this->createUrl('organization/toggleOrganization2EmailStatus', array('id' => $data->id, 'realm' => $realm)) ?>" class="btn btn-xs btn-<?php echo $data->getNextToggleStatusClass()?> pull-right"><?php echo ucwords($data->getNextToggleStatus()) ?></a>
	<div class="org-listowner">
		<a href="<?php echo $this->createUrl('organization/deleteOrganization2Email', array('id' => $data->id, 'realm' => $realm))?>" class="text-danger"><?php echo Html::faIcon('fa-trash') ?></a>&nbsp; <?php echo Html::encodeDisplay($data->user_email); ?>
		<br />
		<small class="text-muted margin-left-lg">
			<a href="<?php echo $this->createUrl('organization/toggleOrganization2EmailStatus', array('id' => $data->id, 'realm' => $realm)) ?>">
			<?php if ($data->status == 'approve'): ?>
				<span class="text-primary"><?php echo Html::faIcon('fa-check-circle') ?></span>
			<?php elseif ($data->status == 'pending'): ?>
				<span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span>
			<?php elseif ($data->status == 'reject'): ?>
				<span class="text-danger"><?php echo Html::faIcon('fa-minus-circle') ?></span>
			<?php endif; ?>
			</a>
			<?php echo ysUtil::timeElapsed($data->date_modified, 2)?>&nbsp;
		</small>
	</div>
</div>


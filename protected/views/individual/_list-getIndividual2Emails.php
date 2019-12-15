<div class="view">
	<small class="text-muted pull-right">
		<a href="<?php echo $this->createUrl('individual/toggleIndividual2EmailStatus', array('id'=>$data->id, 'realm'=>$realm)) ?>">
		<?php if($data->is_verify): ?>
			<span class="text-primary"><?php echo Html::faIcon('fa-check-circle') ?></span>
        <?php else: ?>
			<span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span>
		<?php endif; ?>
		</a>
		<?php echo ysUtil::timeElapsed($data->date_modified, 2)?>&nbsp;
	</small>
	<p><a href="<?php echo $this->createUrl('individual/deleteIndividual2Email', array('id'=>$data->id, 'realm'=>$realm))?>" class="text-danger"><?php echo Html::faIcon('fa-trash') ?></a>&nbsp; <?php echo Html::encodeDisplay($data->user_email); ?></p>
</div>


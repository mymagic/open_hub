<div class="thumbnail">
    <a href="<?php echo $this->createUrl('/event/view', array('id' => $model->id)) ?>" target="_blank">
    <div class="caption"><?php echo $model->title; ?></div>
<p>From '<?php echo Html::formatDateTime($model->date_started) ?>' to '<?php echo Html::formatDateTime($model->date_ended) ?>'<?php if (!empty($model->at)): ?> at '<?php echo $model->at ?>'<?php endif; ?></p>
    </a>
</div>
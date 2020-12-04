<?php $resources = $model->getResources() ?>

<h4><?php echo Yii::t('resource', 'Resource') ?></h4>
<ul>
<?php foreach ($resources as $resource): ?>
    <li><a href="<?php echo $this->createUrl('/resource/resource/view', array('id' => $resource->id)) ?>" target="_blank">#<?php echo $resource->id ?></a> - <?php echo $resource->title ?></li>
<?php endforeach; ?>
</ul>
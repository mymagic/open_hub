<?php if (!empty($actions['status'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['status'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action[url] ?>" title="<?php echo $action['title'] ?>"><?php echo $action[label] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3>Status Reported</h3>
        <?php if (!empty($model->organizationStatuses)): ?>
        <ol>
        <?php foreach ($model->organizationStatuses as $organizationStatus):?>
            <li><strong><a href="<?php echo $this->createUrl('/organizationStatus/view', array('id' => $organizationStatus->id)) ?>" target="_blank"><?php echo $organizationStatus->renderStatus('html') ?></a></strong> on <?php echo Html::formatDateTime($organizationStatus->date_reported, 'standard', false) ?></li>
        <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>


<?php if (!empty($actions['milestone'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['milestone'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action[url] ?>" title="<?php echo $action['title'] ?>"><?php echo $action[label] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3>Milestone</h3>
        <?php if (!empty($model->milestones)): ?>
        <ol>
        <?php foreach ($model->milestones as $milestone):?>
            <li><a href="<?php echo $this->createUrl('/milestone/view', array('id' => $milestone->id)) ?>" target="_blank"><?php if ($milestone->is_star): ?><?php echo Html::faIcon('fa fa-star text-warning') ?><?php endif; ?> <strong><?php echo $milestone->title ?></strong> (<?php echo ucwords($milestone->formatEnumPresetCode($milestone->preset_code)) ?>)</a></li>
        <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>


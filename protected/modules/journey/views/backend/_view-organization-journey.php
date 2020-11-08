<?php if (!empty($actions['journey'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['journey'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action[url] ?>" title="<?php echo $action['title'] ?>"><?php echo $action[label] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3>Events Participated</h3>
        <?php if (!empty($model->eventOrganizations)): ?>
        <ol>
        <?php foreach ($model->eventOrganizations as $eventOrganization):?>
            <li><strong><a href="<?php echo $this->createUrl('/event/view', array('id' => $eventOrganization->event->id)) ?>" target="_blank"><?php echo $eventOrganization->event->title?></a></strong> on <?php echo Html::formatDateTime($eventOrganization->event->date_started, 'standard', false) ?> as <?php echo $eventOrganization->renderAsRoleCode() ?></li>
        <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
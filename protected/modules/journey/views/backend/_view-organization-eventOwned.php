
<div class="row">
    <div class="col col-md-12">
        <h3>Events Owned</h3>
        <p class="text-muted">Latest 30</p>

        <?php $return = HubEvent::getEventsByOwner($model, 1, '', 30); $eventOwners = $return['items']; ?> <?php if (!empty($eventOwners)): ?>
        <ol>
        <?php foreach ($eventOwners as $eventOwner):?>
            <li><strong><a href="<?php echo $this->createUrl('/event/view', array('id' => $eventOwner->event->id)) ?>" target="_blank"><?php echo $eventOwner->event->title?></a></strong> on <?php echo Html::formatDateTime($eventOwner->event->date_started, 'standard', false) ?> as <?php echo $eventOwner->renderAsRoleCode()?></li>
        <?php endforeach; ?>
        </ol>
        <?php endif; ?>

    </div>
</div>
<h2>Select an event from Eventbrite<br />
<small class="text-muted"><?php echo $webhook->organization->title ?> (#<?php echo $webhook->eventbrite_account_id ?>)</small>
</h2>

<div class="list-group white-bg">
<?php foreach ($result['events'] as $event): ?>
  <a href="<?php echo $this->createUrl('/eventbrite/backend/sync2Event', array('page' => $page, 'code' => $event['id'], 'webhookId' => $webhook->id)); ?>" class="list-group-item">
        <h4 class="nomargin"><?php echo !empty($event['name']['text']) ? $event['name']['text'] : 'No Title'; ?> <span class="badge badge-<?php echo HubEventbrite::eventStatus2BadgeClass($event['status']); ?>"><?php echo $event['status']; ?></span></h4>
        <div class="text-muted"><small>From <?php echo Html::formatDateTime(strtotime($event['start']['local'])); ?> to <?php echo Html::formatDateTime(strtotime($event['end']['local'])); ?></small></div>
        <?php echo ysUtil::truncate($event['summary']); ?><br />  
  </a>
<?php endforeach; ?>
</div>
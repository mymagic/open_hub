<a class="btn btn-white pull-right" href="<?php echo $this->createUrl('/eventbrite/eventbriteOrganizationWebhook/admin') ?>">Manage Webhooks</a>
<h2>Select an organization to sync from Eventbrite</h2>

<?php if (empty($model)): ?>
  <?php echo Notice::inline(Yii::t('eventbrite', '<b>Not seeing an organization here?</b> Add a new one with eventbrite web hook now. {button}', array('{button}' => Html::link('Go', $this->createUrl('/eventbrite/eventbriteOrganizationWebhook/create'), array('class' => 'btn btn-primary btn-xs'))), Notice_INFO)) ?>
<?php else: ?>
<div class="list-group white-bg">
<?php foreach ($model as $webhook): ?>
  <a href="<?php echo $this->createUrl('/eventbrite/backend/sync2Event', array('webhookId' => $webhook->id)); ?>" class="list-group-item">
    <h4 class="nomargin"><?php echo $webhook->organization->title ?></h4>
    <div class="text-muted"><small>#<?php echo $webhook->eventbrite_account_id ?></small></div>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>
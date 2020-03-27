<span class="pull-right"><?php echo Html::activeThumb($model, 'image_logo'); ?></span>
<h3>#<?php echo $model->id; ?>: <?php echo $model->title; ?></h3>
<ul>
    <li><?php echo $model->getAttributeLabel('is_active'); ?>: <?php echo Html::renderBoolean($model->is_active); ?></li>
    <li><?php echo $model->getAttributeLabel('text_oneliner'); ?>: <?php echo $model->text_oneliner; ?></li>
    <li><?php echo $model->getAttributeLabel('text_short_description'); ?>: <?php echo $model->text_short_description; ?></li>
    <li><?php echo $model->getAttributeLabel('url_website'); ?>: <?php echo $model->url_website; ?></li>
    <li><?php echo $model->getAttributeLabel('company_number'); ?>: <?php echo $model->company_number; ?></li>
    <li><?php echo $model->getAttributeLabel('timezone'); ?>: <?php echo $model->timezone; ?></li>
    <li><?php echo $model->getAttributeLabel('full_address'); ?>: <?php echo $model->full_address; ?></li>
</ul>

<h4>Meta</h4>
<ul>
<?php foreach ($model->_dynamicData as $dt => $dd) {
	echo sprintf('<li>%s: %s</li>', $dt, $dd);
}?>
</ul>

<h4>Charge</h4>
<ol>
<?php foreach ($model->charges as $charge) {
	echo sprintf('<li>#%s %s</li>', $charge->id, $charge->title);
}?>
</ol>

<h4>Email with Access <small>organization2Emails</small></h4>
<ol>
<?php foreach ($model->organization2Emails as $organization2Email) {
	echo sprintf('<li>#%s %s [%s]</li>', $organization2Email->id, $organization2Email->user_email, $organization2Email->status);
}?>
</ol>

<h4>Individual <small>individualOrganization</small></h4>
<ol>
<?php foreach ($model->individualOrganizations as $individualOrganization) {
	echo sprintf('<li>#%s individual:%s as role:%s</li>', $individualOrganization->individual->id, $individualOrganization->individual->full_name, $individualOrganization->as_role_code);
}?>
</ol>

<h4>Events <small>eventOrganizations</small></h4>
<ol>
<?php foreach ($model->eventOrganizations as $eventOrganization) {
	echo sprintf('<li>#%s event:%s from vendor:%s as role:%s</li>', $eventOrganization->id, $eventOrganization->event->title, $eventOrganization->event_vendor_code, $eventOrganization->as_role_code);
} ?>
</ol>

<h4>Industry <small>industry2Organization</small></h4>
<ol>
<?php foreach ($model->industries as $industry) {
	echo sprintf('<li>#%s %s</li>', $industry->id, $industry->title);
}?>
</ol>

<h4>SDG <small>sdg2Organization</small></h4>
<ol>
<?php foreach ($model->sdgs as $sdg) {
	echo sprintf('<li>#%s %s</li>', $sdg->id, $sdg->title);
}?>
</ol>

<h4>Impact <small>impact2Organization</small></h4>
<ol>
<?php foreach ($model->impacts as $impact) {
	echo sprintf('<li>#%s %s</li>', $impact->id, $impact->title);
}?>
</ol>

<h4>Persona <small>persona2Organization</small></h4>
<ol>
<?php foreach ($model->personas as $persona) {
	echo sprintf('<li>#%s %s</li>', $persona->id, $persona->title);
}?>
</ol>

<h4>Tags <small>tag2organization</small></h4>
<ol>
<?php foreach ($model->tags as $tag) {
	echo sprintf('<li>#%s %s</li>', $tag->id, $tag->name);
}?>
</ol>

<h4>Funding <small>organizationFundings</small></h4>
<ol>
<?php $sql = sprintf('SELECT * FROM organization_funding WHERE organization_id=%s', $model->id);
$tmps = Yii::app()->db->createCommand($sql)->queryAll();
foreach ($tmps as $tmp) {
	echo sprintf('<li>#%s raised $%s from %s</li>', $tmp[id], $tmp[amount], $tmp['vc_name']);
}?>
</ol>

<h4>Revenue <small>organizationRevenues</small></h4>
<ol>
<?php $sql = sprintf('SELECT * FROM organization_revenue WHERE organization_id=%s', $model->id);
$tmps = Yii::app()->db->createCommand($sql)->queryAll();
foreach ($tmps as $tmp) {
	echo sprintf('<li>#%s reported $%s on year %s</li>', $tmp[id], $tmp[amount], $tmp['year_reported']);
}?>
</ol>

<h4>Status <small>organizationStatus</small></h4>
<ol>
<?php $sql = sprintf('SELECT * FROM organization_status WHERE organization_id=%s', $model->id);
$tmps = Yii::app()->db->createCommand($sql)->queryAll();
foreach ($tmps as $tmp) {
	echo sprintf('<li>#%s is %s according to %s</li>', $tmp[id], $tmp[status], $tmp['source']);
}?>
</ol>

<h4>Products</h4>
<ol>
<?php foreach ($model->products as $product) {
	echo sprintf('<li>#%s %s</li>', $product->id, $product->title);
}?>
</ol>


<h4>Sent notify</h4>
<ol>
<?php foreach ($model->sentNotifies as $notify) {
	echo sprintf('<li>%s</li>', $notify->message);
}?>
</ol>
<h4>Received notify</h4>
<ol>
<?php foreach ($model->receivedNotifies as $notify) {
	echo sprintf('<li>%s</li>', $notify->message);
}?>
</ol>


<?php $modules = YeeModule::getActiveParsableModules(); ?>
<?php foreach ($modules as $moduleKey => $moduleParams): ?>
<?php $view = sprintf('application.modules.%s.views._organization._getOrganizationNodes', $moduleKey); ?>
    <?php if (HUB::isViewExists($view)): ?>
        <?php echo $this->renderPartial($view, array('model' => $model)); ?>
    <?php endif; ?>
<?php endforeach; ?>
<span class="pull-right"><?php echo Html::activeThumb($model, 'image_photo'); ?></span>
<h3>#<?php echo $model->id; ?>: <?php echo $model->full_name; ?></h3>
<ul>
    <li><?php echo $model->getAttributeLabel('is_active'); ?>: <?php echo Html::renderBoolean($model->is_active); ?></li>
    <li><?php echo $model->getAttributeLabel('ic_number'); ?>: <?php echo $model->ic_number; ?></li>
    <li><?php echo $model->getAttributeLabel('gender'); ?>: <?php echo $model->gender; ?></li>
    
    <li><?php echo $model->getAttributeLabel('mobile_number'); ?>: <?php echo $model->mobile_number; ?></li>
    <li><?php echo $model->getAttributeLabel('text_address_residential'); ?>: <?php echo $model->text_address_residential; ?></li>
</ul>

<h4>Meta</h4>
<ul>
<?php foreach ($model->_dynamicData as $dt => $dd) {
	echo sprintf('<li>%s: %s</li>', $dt, $dd);
}?>
</ul>

<h4>Email with Access <small>individual2Emails</small></h4>
<ol>
<?php foreach ($model->individual2Emails as $individual2Email) {
	echo sprintf('<li>#%s %s [%s]</li>', $individual2Email->id, $individual2Email->user_email, $individual2Email->is_verify ? 'Verified' : 'Not Verified');
}?>
</ol>

<h4>Organizations <small>individualOrganizations</small></h4>
<ol>
<?php foreach ($model->individualOrganizations as $individualOrganization) {
	echo sprintf('<li>#%s at comapny:%s as role:%s</li>', $individualOrganization->id, $individualOrganization->organization->title, $individualOrganization->as_role_code);
} ?>
</ol>


<h4>Persona <small>persona2Individual</small></h4>
<ol>
<?php foreach ($model->personas as $persona) {
	echo sprintf('<li>#%s %s</li>', $persona->id, $persona->title);
}?>
</ol>

</ol>


<?php $modules = YeeModule::getParsableModules(); ?>
<?php foreach ($modules as $moduleKey => $moduleParams): ?>
<?php $view = sprintf('application.modules.%s.views._individual._getIndividualNodes', $moduleKey); ?>
    <?php if (HUB::isViewExists($view)): ?>
        <?php echo $this->renderPartial($view, array('model' => $model)); ?>
    <?php endif; ?>
<?php endforeach; ?>
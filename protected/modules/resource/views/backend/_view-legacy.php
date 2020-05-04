<?php // if (Yii::app()->user->getState('isDeveloper')):?>
<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])): ?>

<h3>Developer Only</h3>
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'orid',
		'owner',
		'title',
		array('name' => 'html_content', 'type' => 'raw', 'value' => $model->html_content),
	),
)); ?>

<?php endif; ?>
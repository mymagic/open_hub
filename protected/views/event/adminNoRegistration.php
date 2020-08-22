<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs = array(
	Yii::t('backend', 'Events') => array('index'),
	Yii::t('backend', 'Events without Registrations'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Overview'), 'url' => array('/event/overview'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'overview')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Events without Registrations'); ?></h1>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'event-adminNoRegistration-grid',
	'dataProvider' => $events,
	'columns' => array(
		array('name' => 'id', 'header' => Event::getOneAttributeLabel('id'), 'cssClassExpression' => 'id', 'value' => $data['id'], 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'title', 'header' => Event::getOneAttributeLabel('title'), 'value' => $data['title']),
		array('name' => 'date_started', 'header' => Event::getOneAttributeLabel('date_started'), 'cssClassExpression' => 'date_started', 'value' => 'Html::formatDateTime($data[\'date_started\'], \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date')),
		array('name' => 'is_active', 'header' => Event::getOneAttributeLabel('is_active'), 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data[\'is_active\'])', 'headerHtmlOptions' => array('class' => 'boolean')),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
				'template' => '{view}',
				'buttons' => array(
					'view' => array(
						'url' => 'Yii::app()->controller->createUrl("/event/view", array("id"=>$data[id]))',
						'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'view']]); }
					),
				),
		)
	),
)); ?>

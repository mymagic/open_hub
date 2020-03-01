<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs = array(
	Yii::t('backend', 'Events') => array('index'),
	Yii::t('backend', 'Events without Registrations'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Event'), 'url' => array('/event/admin')),
	array('label' => Yii::t('app', 'Create Event'), 'url' => array('/event/create')),),
);
?>

<h1><?php echo Yii::t('backend', 'Events without Registrations'); ?></h1>


<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'event-adminNoRegistration-grid',
	'dataProvider' => $events,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'code',
		'title',
		/*array(
			'class'=>'application.components.widgets.ButtonColumn',
				'template' => '{view}',
				'buttons' => array(
					'view' => array('url'=>'Yii::app()->controller->createUrl("/event/view", array("id"=>"$data->id"))'),
				),
		),*/
	),
)); ?>

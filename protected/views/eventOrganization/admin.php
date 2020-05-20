<?php
/* @var $this EventOrganizationController */
/* @var $model EventOrganization */

$this->breadcrumbs = array(
	Yii::t('backend', 'Event Organizations') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create Event Organization'), 'url' => array('/eventOrganization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Bulk Insert Event Organization'), 'url' => array('/eventOrganization/bulkInsert'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'bulkInsert')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#event-organization-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Event Organizations'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-eventOrganizationSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-eventOrganizationSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'event-organization-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'event_id', 'cssClassExpression' => 'foreignKey', 'value' => 'Html::link($data->event->title, Yii::app()->createUrl("/event/view", array("id"=>$data->event->id)))', 'type' => 'html', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Event::model()->getForeignReferList(false, true, array('params' => array('mode' => 'idAsKey')))),
		array('name' => 'organization_id', 'cssClassExpression' => 'foreignKey', 'value' => 'Html::link($data->organization->title, Yii::app()->createUrl("/organization/view", array("id"=>$data->organization->id)))', 'type' => 'html', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Organization::model()->getForeignReferList(false, true)),
		array('name' => 'as_role_code', 'cssClassExpression' => '', 'value' => '$data->as_role_code'),
		array('name' => 'event_vendor_code', 'cssClassExpression' => '', 'value' => '$data->event_vendor_code'),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'update' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update'); }),
				'delete' => array('visible' => false)
			),
		),
	),
)); ?>

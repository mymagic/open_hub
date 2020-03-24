<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs = array(
	Yii::t('backend', 'Events') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = YeeModule::composeNavItems('eventAdminSideNav', Yii::app()->controller, array(
	array('label' => Yii::t('app', 'Create Event'), 'url' => array('/event/create')),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#event-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Events'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-eventSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-eventSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'event-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		//'code',
		//array('name'=>'vendor_code', 'cssClassExpression'=>'foreignKey', 'value'=>'$data->->', 'headerHtmlOptions'=>array('class'=>'foreignKey'), 'filter'=>::model()->getForeignReferList(false, true)),
		'title',
		array('name' => 'date_started', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_started, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'event_group_code', 'cssClassExpression' => 'date', 'value' => '$data->eventGroup->title', 'headerHtmlOptions' => array('class' => ''), 'filter' => false),
		//'at',
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'is_survey_enabled', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_survey_enabled)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array('delete' => array('visible' => false)),
		),
	),
)); ?>

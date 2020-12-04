<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs = array(
	Yii::t('backend', 'Events') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = YeeModule::composeNavItems('eventAdminSideNav', Yii::app()->controller, array(
	array(
		'label' => Yii::t('app', 'Create Event'), 'url' => array('/event/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
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

<ul class="nav nav-pills nav-pills-title" role="tablist">
  <li role="presentation" class="active"><a href="<?php echo $this->createUrl('admin') ?>"><?php echo Yii::t('backend', 'Active') ?></a></li>
  <li role="presentation" class=""><a href="<?php echo $this->createUrl('adminTrash') ?>"><?php echo Html::faIcon('fa fa-trash') ?><?php echo Yii::t('backend', 'Deleted') ?></a></li>
</ul>
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
		array('name' => 'title', 'type' => 'raw', 'value' => 'sprintf("%s \ <b>%s</b>", $data->eventGroup->title, $data->title)'),
		array('name' => 'date_started', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_started, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		//'at',

		array('header' => sprintf('%s / %s', Yii::t('app', 'Attendance'), Yii::t('app', 'Registration')), 'type' => 'raw', 'value' => 'sprintf("%s / %s", $data->countAttended, $data->countRegistration)', 'headerHtmlOptions' => array('class' => 'text-center'), 'htmlOptions' => array('class' => 'text-center'), 'filter' => false),

		array('name' => 'is_cancelled', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_cancelled)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		// array('name' => 'is_survey_enabled', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_survey_enabled)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}{update}{trash}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'update' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update'); }),
				'delete' => array('visible' => false),
				'trash' => array(
					'url' => 'Yii::app()->controller->createUrl("event/deactivate", array("id"=>$data->id))',
					'label' => '<i class="fa fa-trash"></i>',
					'options' => array('class' => 'btn btn-sm btn-danger'),
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'deactivate'); }),
			),
		),
	),
)); ?>

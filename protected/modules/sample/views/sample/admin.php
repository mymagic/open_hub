<?php
/* @var $this SampleController */
/* @var $model Sample */

$this->breadcrumbs = array(
	Yii::t('backend', 'Samples') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create Sample'), 'url' => array('/sample/sample/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Samples'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-sampleSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-sampleSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'sample-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'title_en',
		array('name' => 'sample_group_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->getAttributeDataByLanguage($data->sampleGroup, "title")', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => SampleGroup::model()->getForeignReferList(false, true)),
		array('name' => 'sample_zone_code', 'cssClassExpression' => 'foreignKey', 'value' => '$data->sampleZone->label', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => SampleZone::model()->getForeignReferList(false, true)),
		array('name' => 'image_main', 'cssClassExpression' => 'image', 'type' => 'raw', 'value' => 'Html::activeThumb($data, \'image_main\')', 'headerHtmlOptions' => array('class' => 'image'), 'filter' => false),
		array('name' => 'gender', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumGender($data->gender)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumGender(false, true)),
		array('name' => 'ordering', 'headerHtmlOptions' => array('class' => 'ordering'), 'class' => 'application.yeebase.extensions.OrderColumn.OrderColumn'),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_posted', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_posted, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'update' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update'); }),
				'delete' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete'); })
			),
		),
	),
)); ?>

<?php
/* @var $this MilestoneController */
/* @var $model Milestone */

$this->breadcrumbs = array(
	Yii::t('backend', 'Milestones') => array('index'),
	Yii::t('backend', 'Manage All'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Revenue Milestone'), 'url' => array('/milestone/adminRevenue'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'adminRevenue')
	),
	array(
		'label' => Yii::t('app', 'Create Milestone'), 'url' => array('/milestone/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#milestone-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage All Milestones'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-milestoneSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-milestoneSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'milestone-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'organization_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->organization->title', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Organization::model()->getForeignReferList(false, true, array('params' => array('mode' => 'isActiveId')))),
		'title',
		array('name' => 'preset_code', 'cssClassExpression' => 'foreignKey', 'value' => '$data->formatEnumPresetCode($data->preset_code)', 'filter' => Milestone::model()->getEnumPresetCode(false, true)),
		array('name' => 'is_star', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_star)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_modified', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}{delete}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'delete' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete'); })
			),
		),
	),
)); ?>

<?php
/* @var $this ChallengeController */
/* @var $model Challenge */

$this->breadcrumbs = array(
	Yii::t('backend', 'Challenges') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = YeeModule::composeNavItems('challengeAdminSideNav', Yii::app()->controller, array(
	array(
		'label' => Yii::t('app', 'Create Challenge'), 'url' => array('/challenge/challenge/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#challenge-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Challenges'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-challengeSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-challengeSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'challenge-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'title',
		array('name' => 'owner_organization_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->ownerOrganization->title', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Organization::model()->getForeignReferList(false, true)),
		array('name' => 'date_open', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_open, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'date_close', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_close, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'status', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumStatus($data->status)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumStatus(false, true)),
		array('name' => 'date_modified', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

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

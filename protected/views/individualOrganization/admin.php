<?php
/* @var $this IndividualOrganizationController */
/* @var $model IndividualOrganization */

$this->breadcrumbs = array(
	Yii::t('backend', 'Individual Organizations') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create IndividualOrganization'), 'url' => array('/individualOrganization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#individual-organization-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Individual Organizations'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-individualOrganizationSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-individualOrganizationSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'individual-organization-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'individual_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->individual->full_name', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Individual::model()->getForeignReferList(false, true)),
		array('name' => 'organization_code', 'cssClassExpression' => 'foreignKey', 'value' => '$data->organization->title', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Organization::model()->getForeignReferList(false, true)),
		array('name' => 'as_role_code', 'value' => '$data->as_role_code'),
		'job_position',

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

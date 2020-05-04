<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs = array(
	Yii::t('app', 'Settings') => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Setting Panel'), 'url' => array('panel'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'panel')
	),
	array(
		'label' => Yii::t('app', 'Manage Setting'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Setting'), 'url' => array('create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#setting-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', sprintf('Manage %s', 'Settings')); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-settingSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-settingSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'setting-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'code',
		'value',
		array('name' => 'datatype', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumDatatype($data->datatype)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumDatatype(false, true)),
		'note',
		array('name' => 'date_modified', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

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

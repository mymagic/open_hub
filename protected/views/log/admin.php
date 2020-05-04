<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs = array(
	Yii::t('app', 'Logs') => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Log'), 'url' => array('index'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'index')
	)
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', sprintf('Manage %s', 'Logs')); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-logSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-logSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'log-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'user_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->user->username', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => User::model()->getForeignReferList(false, true)),
		'ip',
		'controller',
		'action',
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', \'medium\')', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); })
			),
		),
	),
)); ?>

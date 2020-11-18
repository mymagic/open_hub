<?php
/* @var $this IndividualController */
/* @var $model Individual */

$this->breadcrumbs = array(
	Yii::t('backend', 'Individuals') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = YeeModule::composeNavItems('individualAdminSideNav', Yii::app()->controller, array(
	array(
		'label' => Yii::t('app', 'Create Individual'), 'url' => array('/individual/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Merge Individual'), 'url' => array('/individual/merge'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'merge')),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#individual-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<ul class="nav nav-pills nav-pills-title" role="tablist">
  <li role="presentation" class=""><a href="<?php echo $this->createUrl('admin') ?>"><?php echo Yii::t('backend', 'Active') ?></a></li>
  <li role="presentation" class="active"><a href="<?php echo $this->createUrl('adminTrash') ?>"><?php echo Html::faIcon('fa fa-trash') ?><?php echo Yii::t('backend', 'Deleted') ?></a></li>
</ul>
<h1><?php echo Yii::t('backend', 'Deleted Individuals'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-individualSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-individualSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'individual-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'full_name',
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}{restore}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				//'update' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update'); }),
				'update' => array('visible' => false),
				'delete' => array('visible' => false),
				'restore' => array(
					'url' => 'Yii::app()->controller->createUrl("individual/activate", array("id"=>$data->id))',
					'label' => '<i class="fa fa-recycle"></i>',
					'options' => array('class' => 'btn btn-sm btn-warning'),
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'activate'); }),
			),
		),
	),
)); ?>

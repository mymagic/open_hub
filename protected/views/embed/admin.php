<?php
/* @var $this EmbedController */
/* @var $model Embed */

$this->breadcrumbs = array(
	Yii::t('app', 'Embeds') => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Embed'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Embed'), 'url' => array('create'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#embed-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', sprintf('Manage %s', 'Embeds')); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-embedSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-embedSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'embed-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'code',
		'text_note',
		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'update' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update'); }),
				'delete' => array(
					'url' => 'Yii::app()->createUrl("embed/deleteConfirmed", array("id"=>$data->id))',
					// 'visible' => 'Yii::app()->user->isDeveloper',
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'deleteConfirmed'); }
				),
			),
		),
	),
)); ?>

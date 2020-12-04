<?php
/* @var $this FormController */
/* @var $model Form */

$this->breadcrumbs = array(
	Yii::t('backend', 'Forms') => array('index'),
	Yii::t('backend', 'Manage Deleted'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create Form'), 'url' => array('/f7/form/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#form-grid').yiiGridView('update', {
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
<h1><?php echo Yii::t('backend', 'Manage Forms'); ?></h1>

<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-formSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-formSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'form-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'title', 'type' => 'raw', 'value' => 'sprintf("%s \ <b>%s</b>", $data->getIntake()->title, $data->title)'),

		array('name' => 'date_open', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_open, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'date_close', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_close, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array('header' => Yii::t('app', 'Draft'), 'type' => 'raw', 'value' => '$data->countSubmissionDraft', 'headerHtmlOptions' => array('class' => 'text-center'), 'htmlOptions' => array('class' => 'text-center'), 'filter' => false),
		array('header' => Yii::t('app', 'Submit'), 'type' => 'raw', 'value' => '$data->countSubmissionSubmit', 'headerHtmlOptions' => array('class' => 'text-center'), 'htmlOptions' => array('class' => 'text-center'), 'filter' => false),

		//array('name' => 'is_multiple', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_multiple)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}{restore}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'update' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update'); }),
				'restore' => array(
					'url' => 'Yii::app()->controller->createUrl("form/activate", array("id"=>$data->id))',
					'label' => '<i class="fa fa-recycle"></i>',
					'options' => array('class' => 'btn btn-sm btn-warning'),
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'activate'); }),
			),
		),
	),
)); ?>

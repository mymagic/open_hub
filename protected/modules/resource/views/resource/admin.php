<?php
/* @var $this ResourceController */
/* @var $model Resource */

$this->breadcrumbs = array(
	Yii::t('backend', 'Resources') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->renderPartial('/resource/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#resource-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Resources'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-resourceSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search </a></h4>
</div>
<div id="collapse-resourceSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
		'realm' => $realm,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'resource-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'typefor', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumTypefor($data->typefor)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumTypefor(false, true)),
		'title',
		array('name' => 'is_featured', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_featured)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			/*
			'buttons' => array(
				'view'=>array('visible'=>function(){ return HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller,'view'); }),
				'update'=>array('visible'=>function(){ return HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller,'update'); }),
				'delete'=>array('visible'=>function(){ return HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller,'delete'); })
			),
			*/
		),
	),
)); ?>

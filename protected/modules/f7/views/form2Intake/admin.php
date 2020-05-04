<?php
/* @var $this Form2IntakeController */
/* @var $model Form2Intake */

$this->breadcrumbs = array(
	Yii::t('backend', 'Form2 Intakes') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create Form2Intake'), 'url' => array('/f7/form2Intake/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#form2-intake-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Form2 Intakes'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-form2IntakeSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-form2IntakeSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'form2-intake-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'intake_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->intake->title', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Intake::model()->getForeignReferList(false, true)),
		array('name' => 'form_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->form->title', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Form::model()->getForeignReferList(false, true)),
		array('name' => 'is_primary', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_primary)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'ordering', 'headerHtmlOptions' => array('class' => 'ordering'), 'class' => 'application.yeebase.extensions.OrderColumn.OrderColumn'),

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

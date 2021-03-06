<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs = array(
	Yii::t('app', 'Pages') => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Page'), 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create Page'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#page-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', sprintf('Manage %s', 'Pages')); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-pageSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-pageSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'slug',
		'menu_code',
		'title_' . Yii::app()->language,
		array('name' => 'is_default', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_default)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'date_modified', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'delete' => array(
					'visible' => '$data->is_default==0',
					'url' => 'Yii::app()->createUrl("page/deleteConfirmed", array("id"=>$data->id))'
				),
			),
		),
	),
)); ?>

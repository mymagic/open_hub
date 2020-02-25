<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs = array(
	Yii::t('app', 'Bulletins') => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List Bulletin'), 'url' => array('index')),
	array('label' => Yii::t('app', 'Create Bulletin'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#bulletin-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', sprintf('Manage %s', 'Bulletins')); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-bulletinSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-bulletinSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'bulletin-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'title_en',
		array('name' => 'image_main', 'cssClassExpression' => 'image', 'type' => 'raw', 'value' => 'Html::activeThumb($data, \'image_main\')', 'headerHtmlOptions' => array('class' => 'image'), 'filter' => false),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'value' => "Yii::t('core', Yii::app()->format->boolean(\$data->is_active))", 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_posted', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_posted, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this SampleZoneController */
/* @var $model SampleZone */

$this->breadcrumbs = array(
	Yii::t('backend', 'Sample Zones') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Create SampleZone'), 'url' => array('/sample/sampleZone/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#sample-zone-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Sample Zones'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-sampleZoneSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-sampleZoneSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'sample-zone-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'code',
		'label',
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'date_modified', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array('delete' => array('visible' => false)),		),
	),
)); ?>

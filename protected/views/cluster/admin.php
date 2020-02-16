<?php
/* @var $this ClusterController */
/* @var $model Cluster */

$this->breadcrumbs=array(
	Yii::t('backend', 'Clusters')=>array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Create Cluster'), 'url'=>array('/cluster/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#cluster-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Clusters'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-clusterSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-clusterSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id'=>'cluster-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
		'title',
		array('name'=>'ordering', 'headerHtmlOptions'=>array('class'=>'ordering'), 'class'=>'application.yeebase.extensions.OrderColumn.OrderColumn'),
		array('name'=>'is_active', 'cssClassExpression'=>'boolean', 'type'=>'raw', 'value'=>'Html::renderBoolean($data->is_active)', 'headerHtmlOptions'=>array('class'=>'boolean'), 'filter'=>$model->getEnumBoolean()), 
		array('name'=>'date_added', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),

		array(
			'class'=>'application.components.widgets.ButtonColumn',
			'buttons' => array('delete' => array('visible'=>false)),		),
	),
)); ?>
<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs = array(
	Yii::t('app', 'Faqs') => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Faq'), 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create Faq'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#faq-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', sprintf('Manage %s', 'Faqs')); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-faqSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-faqSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'faq-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'title_' . Yii::app()->language,
		//'ordering',
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'ordering', 'headerHtmlOptions' => array('class' => 'ordering'), 'class' => 'application.yeebase.extensions.OrderColumn.OrderColumn'),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this CvExperienceController */
/* @var $model CvExperience */

$this->breadcrumbs=array(
	Yii::t('backend', 'Cv Experiences')=>array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Create CvExperience'), 'url'=>array('/cv/cvExperience/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#cv-experience-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Cv Experiences'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-cvExperienceSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-cvExperienceSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id'=>'cv-experience-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
		array('name'=>'genre', 'cssClassExpression'=>'enum', 'value'=>'$data->formatEnumGenre($data->genre)', 'headerHtmlOptions'=>array('class'=>'enum'), 'filter'=>$model->getEnumGenre(false, true)), 
		'title',
		array('name'=>'is_active', 'cssClassExpression'=>'boolean', 'type'=>'raw', 'value'=>'Html::renderBoolean($data->is_active)', 'headerHtmlOptions'=>array('class'=>'boolean'), 'filter'=>$model->getEnumBoolean()), 
		array('name'=>'date_modified', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),

		array(
			'class'=>'application.components.widgets.ButtonColumn',
			'buttons' => array('delete' => array('visible'=>false)),		),
	),
)); ?>

<?php
/* @var $this CvExperienceController */
/* @var $model CvExperience */

$this->breadcrumbs=array(
	'Cv Experiences'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvExperience'), 'url'=>array('/cv/cvExperience/admin')),
	array('label'=>Yii::t('app','Create CvExperience'), 'url'=>array('/cv/cvExperience/create')),
	array('label'=>Yii::t('app','Update CvExperience'), 'url'=>array('/cv/cvExperience/update', 'id'=>$model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Cv Experience'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'cv_portfolio_id', 'value'=>$model->cvPortfolio->display_name),
		array('name'=>'genre', 'value'=>$model->formatEnumGenre($model->genre)),
		'title',
		'organization_name',
		'location',
		'full_address',
		array('name'=>'state_code', 'value'=>$model->state->title),
		array('name'=>'country_code', 'value'=>$model->country->printable_name),
		array('name'=>'text_short_description', 'type'=>'raw', 'value'=>nl2br($model->text_short_description)),
		'year_start',
		array('name'=>'month_start', 'value'=>$model->formatEnumMonthStart($model->month_start)),
		'year_end',
		array('name'=>'month_end', 'value'=>$model->formatEnumMonthEnd($model->month_end)),
		array('name'=>'is_active', 'type'=>'raw', 'value'=>Html::renderBoolean($model->is_active)), 
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>

<h3><?php echo $model->getAttributeLabel('latlong_address') ?></h3>
<?php echo Html::mapView('map-resourceAddress', $model->latlong_address[0], $model->latlong_address[1]) ?>

</div>
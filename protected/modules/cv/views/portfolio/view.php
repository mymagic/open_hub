<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */

$this->breadcrumbs = array(
	'Portfolios' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage CvPortfolio'), 'url' => array('/cv/portfolio/admin')),
	array('label' => Yii::t('app', 'Create CvPortfolio'), 'url' => array('/cv/portfolio/create')),
	array('label' => Yii::t('app', 'Update CvPortfolio'), 'url' => array('/cv/portfolio/update', 'id' => $model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Portfolio'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'user_id', 'value' => $model->user->username),
		'slug',
		array('name' => 'jobpos_id', 'value' => $model->cvJobpos->title),
		'organization_name',
		'location',
		array('name' => 'text_address_residential', 'type' => 'raw', 'value' => nl2br($model->text_address_residential)),
		//'latlong_address_residential',
		array('name' => 'state_code', 'value' => $model->state->title),
		array('name' => 'country_code', 'value' => $model->country->printable_name),
		'display_name',
		array('name' => 'image_avatar', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_avatar')),
		//array('name'=>'high_academy_experience_id', 'value'=>$model->->),
		'text_oneliner',
		array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
		array('name' => 'is_looking_fulltime', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_looking_fulltime)),
		array('name' => 'is_looking_contract', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_looking_contract)),
		array('name' => 'is_looking_freelance', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_looking_freelance)),
		array('name' => 'is_looking_cofounder', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_looking_cofounder)),
		array('name' => 'is_looking_internship', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_looking_internship)),
		array('name' => 'is_looking_apprenticeship', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_looking_apprenticeship)),
		array('name' => 'visibility', 'value' => $model->formatEnumVisibility($model->visibility)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>

<h3><?php echo $model->getAttributeLabel('latlong_address_residential') ?></h3>
<?php echo Html::mapView('map-resourceAddress', $model->latlong_address_residential[0], $model->latlong_address_residential[1]) ?>

</div>
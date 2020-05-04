<?php
/* @var $this IndividualOrganizationController */
/* @var $model IndividualOrganization */

$this->breadcrumbs = array(
	'Individual Organizations' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage IndividualOrganization'), 'url' => array('/individualOrganization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create IndividualOrganization'), 'url' => array('/individualOrganization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update IndividualOrganization'), 'url' => array('/individualOrganization/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete IndividualOrganization'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Individual Organization'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'individual_id', 'type' => 'raw', 'value' => Html::link($model->individual->full_name, Yii::app()->createUrl('/individual/view', array('id' => $model->individual->id)))),
		array('name' => 'organization_code', 'type' => 'raw', 'value' => Html::link($model->organization->title, Yii::app()->createUrl('/organization/view', array('id' => $model->organization->id)))),
		array('name' => 'as_role_code', 'value' => $model->as_role_code),
		'job_position',
		array('label' => $model->attributeLabel('date_started'), 'value' => Html::formatDateTime($model->date_started, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_ended'), 'value' => Html::formatDateTime($model->date_ended, 'long', 'medium')),
		//'json_extra',
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>
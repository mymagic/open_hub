<?php
/* @var $this ChallengeController */
/* @var $model Challenge */

$this->breadcrumbs = array(
	'Challenges' => array('index'),
	$model->title,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Challenge'), 'url' => array('/challenge/challenge/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Challenge'), 'url' => array('/challenge/challenge/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Challenge'), 'url' => array('/challenge/challenge/update', 'id' => $model->id), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Challenge'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>



<?php foreach ($model->industries as $industry): ?>
	<?php $inputIndustries .= sprintf('<span class="label">%s</span>&nbsp;', $industry->title) ?>
<?php endforeach; ?>

<h1><?php echo Yii::t('backend', 'View Challenge'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'owner_organization_id', 'value' => $model->ownerOrganization->title),
		array('name' => 'creator_user_id', 'value' => $model->creatorUser->username),
		'title',
		array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
		array('name' => 'html_content', 'type' => 'raw', 'value' => $model->html_content),
		array('name' => 'image_cover', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_cover')),
		array('name' => 'image_header', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_header')),
		'url_video',
		'url_application_form',
		array('name' => 'html_deliverable', 'type' => 'raw', 'value' => $model->html_deliverable),
		array('name' => 'html_criteria', 'type' => 'raw', 'value' => $model->html_criteria),
		'prize_title',
		array('name' => 'html_prize_detail', 'type' => 'raw', 'value' => $model->html_prize_detail),
		array('label' => $model->attributeLabel('date_open'), 'value' => Html::formatDateTime($model->date_open, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_close'), 'value' => Html::formatDateTime($model->date_close, 'long', 'medium')),
		'ordering',
		array('name' => 'text_remark', 'type' => 'raw', 'value' => nl2br($model->text_remark)),
		array('name' => 'status', 'value' => $model->formatEnumStatus($model->status)),
		'timezone',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('name' => 'is_publish', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_publish)),
		array('name' => 'is_highlight', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_highlight)),
		'process_by',
		array('label' => $model->attributeLabel('date_submit'), 'value' => Html::formatDateTime($model->date_submit, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_process'), 'value' => Html::formatDateTime($model->date_process, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),

		array('name' => 'inputIndustries', 'type' => 'raw', 'value' => $inputIndustries),
		array('name' => 'backend', 'type' => 'raw', 'value' => Html::csvArea('backend', $model->backend->toString())),
	),
)); ?>



</div>
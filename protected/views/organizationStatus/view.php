<?php
/* @var $this OrganizationStatusController */
/* @var $model OrganizationStatus */

$this->breadcrumbs = array(
	'Organization Statuses' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage OrganizationStatus'), 'url' => array('/organizationStatus/admin')),
	array('label' => Yii::t('app', 'Create OrganizationStatus'), 'url' => array('/organizationStatus/create')),
	array('label' => Yii::t('app', 'Update OrganizationStatus'), 'url' => array('/organizationStatus/update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete OrganizationStatus'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Organization Status'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'organization_id', 'type' => 'raw', 'value' => Html::link($model->organization->title, Yii::app()->createUrl('/organization/view', array('id' => $model->organization->id)))),
		array('label' => $model->attributeLabel('date_reported'), 'value' => Html::formatDateTime($model->date_reported, 'long', 'medium')),
		array('label' => $model->attributeLabel('status'), 'type' => 'raw', 'value' => $model->renderStatus('html')),
		'source',
		array('name' => 'text_note', 'type' => 'raw', 'value' => nl2br($model->text_note)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



<h3>Proofs <a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/proof/create', array('refTable' => 'organization_status', 'refId' => $model->id)); ?>">Add</a></h3>
<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'organizationStatus-view-proofs',
	'dataProvider' => new CArrayDataProvider($model->proofs),
	'columns' => array(
		'id',
		array('header' => 'value', 'type' => 'html', 'value' => '$data->renderValue("html")'),
		'user_username',
		array('header' => 'date_modified', 'value' => '$data->renderDateModified()'),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
				'template' => '{view}',
				'buttons' => array(
					'view' => array('url' => '$data->getUrl("backendView")'),
				),
		),
	),
)); ?>

</div>
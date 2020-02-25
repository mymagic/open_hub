<?php
/* @var $this OrganizationFundingController */
/* @var $model OrganizationFunding */

$this->breadcrumbs = array(
	'Organization Fundings' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage OrganizationFunding'), 'url' => array('/organizationFunding/admin')),
	array('label' => Yii::t('app', 'Create OrganizationFunding'), 'url' => array('/organizationFunding/create')),
	array('label' => Yii::t('app', 'Update OrganizationFunding'), 'url' => array('/organizationFunding/update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete OrganizationFunding'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Organization Funding'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'organization_id', 'type' => 'raw', 'value' => Html::link($model->organization->title, Yii::app()->createUrl('/organization/view', array('id' => $model->organization->id)))),
		array('label' => $model->attributeLabel('date_raised'), 'value' => $model->renderDateRaised()),
		array('name' => 'vc_organization_id', 'type' => 'raw', 'value' => Html::link($model->vcOrganization->title, Yii::app()->createUrl('/organization/view', array('id' => $model->vcOrganization->id)))),
		'vc_name',
		array('name' => 'is_amount_undisclosed', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_amount_undisclosed)),
		'amount',
		array('name' => 'round_type_code', 'value' => $model->formatEnumRoundTypeCode($model->round_type_code)),
		'source',
		array('name' => 'is_publicized', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_publicized)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => $model->renderDateAdded()),
		array('label' => $model->attributeLabel('date_modified'), 'value' => $model->renderDateModified()),
	),
)); ?>


<h3>Proofs <a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/proof/create', array('refTable' => 'organization_funding', 'refId' => $model->id)) ?>">Add</a></h3>
<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'organizationFunding-view-proofs',
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

<h3>Linked Resources <a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/resource2OrganizationFunding/create', array('organizationFundingId' => $model->id)) ?>">Add</a></h3>
<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'organizationFunding-view-resource2OrganizationFunding',
	'dataProvider' => new CArrayDataProvider($model->resource2OrganizationFundings),
	'columns' => array(
		'id',
		array('name' => 'Resource', 'type' => 'html', 'value' => '$data->resource->title'),
		array('name' => 'From', 'type' => 'html', 'value' => '$data->resource->renderOrganization()'),
		//'as_role_code',
		array('name' => 'date_modified', 'value' => '$data->renderDateModified()'),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
				'template' => '{view}{delete}',
				'buttons' => array(
					'view' => array('url' => '$data->getUrl("backendView")'),
					'delete' => array('url' => '$data->getUrl("backendDelete")'),
				),
		),
	),
)); ?>


</div>
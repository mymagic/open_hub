<?php
/* @var $this OrganizationFundingController */
/* @var $model OrganizationFunding */

$this->breadcrumbs = array(
	'Organization Fundings' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage OrganizationFunding'), 'url' => array('organizationFunding/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create OrganizationFunding'), 'url' => array('organizationFunding/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update OrganizationFunding'), 'url' => array('organizationFunding/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete OrganizationFunding'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')),
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


<h3>Proofs
<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'proof', 'action' => (object)['id' => 'create']])): ?>
	<a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/proof/create', array('refTable' => 'organization_funding', 'refId' => $model->id)) ?>">Add</a>
<?php endif; ?>
</h3>
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
					'view' => array(
						'url' => '$data->getUrl("backendView")',
						'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'proof', 'action' => (object)['id' => 'view']]); }
					),
				),
		),
	),
)); ?>

<h3>Linked Resources
<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource2OrganizationFunding', 'action' => (object)['id' => 'create']])): ?>
	<a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/resource2OrganizationFunding/create', array('organizationFundingId' => $model->id)) ?>">Add</a>
<?php endif; ?>
</h3>
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
					'view' => array(
						'url' => '$data->getUrl("backendView")',
						'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource2OrganizationFunding', 'action' => (object)['id' => 'view']]); }
					),
					'delete' => array(
						'url' => '$data->getUrl("backendDelete")',
						'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource2OrganizationFunding', 'action' => (object)['id' => 'delete']]); }
					),
				),
		),
	),
)); ?>


</div>


<!-- Nav tabs -->
<ul class="nav nav-tabs nav-new" role="tablist">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : ''; ?>"><a href="#<?php echo $tabModule['key']; ?>" aria-controls="<?php echo $tabModule['key']; ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title']; ?></a></li>
<?php endforeach; ?><?php endforeach; ?>
</ul>
<!-- Tab panes -->
<div class="tab-content padding-lg white-bg">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : ''; ?>" id="<?php echo $tabModule['key']; ?>">
		<?php echo $this->renderPartial($tabModule['viewPath'], ['model' => $model, 'event' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab]); ?>
	</div>
<?php endforeach; ?><?php endforeach; ?>
</div>
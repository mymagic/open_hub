<?php
/* @var $this OrganizationRevenueController */
/* @var $model OrganizationRevenue */

$this->breadcrumbs = array(
	'Organization Revenues' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage OrganizationRevenue'), 'url' => array('/organizationRevenue/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create OrganizationRevenue'), 'url' => array('/organizationRevenue/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update OrganizationRevenue'), 'url' => array('/organizationRevenue/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete OrganizationRevenue'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Organization Revenue'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'organization_id', 'type' => 'raw', 'value' => Html::link($model->organization->title, Yii::app()->createUrl('/organization/view', array('id' => $model->organization->id)))),
		'year_reported',
		'amount',
		'amount_profit',
		'amount_profit_before_tax',
		'source',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>

<h3>Proofs
<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'proof', 'action' => (object)['id' => 'create']])): ?>
	<a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/proof/create', array('refTable' => 'organization_revenue', 'refId' => $model->id)); ?>">Add</a>
<?php endif; ?>
</h3>
<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'organizationRevenue-view-proofs',
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
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'proof', 'action' => (object)['id' => 'view']]); }
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
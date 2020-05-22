<?php
/* @var $this ProductController */
/* @var $model Product */
if ($realm == 'backend') {
	$this->breadcrumbs = array(
		Yii::t('backend', 'Products') => array('index'),
		Yii::t('backend', 'Manage'),
	);
	$this->renderPartial('/organization/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));
} elseif ($realm == 'cpanel') {
	$this->breadcrumbs = array(
		'Organization' => array('index'),
		$organization->title => array('organization/view', 'id' => $organization->id, 'realm' => $realm),
		Yii::t('backend', 'Products')
	);
	$this->renderPartial('/cpanel/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));
}
?>

<?php if ($realm == 'backend'): ?><h1><?php echo Yii::t('backend', "Manage Products for '{organizationName}'", array('{organizationName}' => $organization->title)); ?></h1><?php endif; ?>


<?php if ($realm == 'cpanel'): ?>
<div class="sidebard-panel left-bar">
 <div id="header" class="my-org-active">
 	<h3 class="my-org-name"><?php echo $model->organization['title'] ?><span class="hidden-desk">
                <a class="container-arrow scroll-to" href="#">
                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a></span></h3>
 	<a href="<?php echo Yii::app()->createUrl('/organization/select') ?>">
		<h4 class="change-org"><?php echo Yii::t('app', 'Change Organization') ?></h4>
	</a>
 </div>
 <div id="content-services">
 <div class="header-org" class="margin-top-lg">
		<?php

			$this->widget('zii.widgets.CMenu', array(
			'items' => array(
					array('label' => sprintf('%s', Yii::t('app', 'Overview')), 'url' => array('/organization/view', 'id' => $model->organization_id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'view') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Update')), 'url' => array('/organization/update', 'id' => $model->organization_id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'update') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Manage Products')), 'url' => array('/product/adminByOrganization', 'organization_id' => $model->organization_id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'product-adminByOrganization') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Create Product')), 'url' => array('/product/create', 'organization_id' => $model->organization_id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'product-create') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Manage Resources')), 'url' => array('/resource/resource/adminByOrganization', 'organization_id' => $model->organization_id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'resource-adminByOrganization') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Create Resource')), 'url' => array('/resource/resource/create', 'organization_id' => $model->organization_id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'resource-create') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu'))),
		));
		 ?>
 </div>
</div>
</div>
<div class="wrapper wrapper-content content-bg content-left-padding">
	<div class="manage-pad">
		<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'product-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		//array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
		'title',
		// array('name'=>'typeof', 'cssClassExpression'=>'enum', 'value'=>'$data->formatEnumTypeof($data->typeof)', 'headerHtmlOptions'=>array('class'=>'enum'), 'filter'=>$model->getEnumTypeof(false, true)),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		// array('name'=>'date_added', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'view' => array(
					'url' => 'Yii::app()->controller->createUrl(\'product/view\', array(\'id\'=>$data->id, \'realm\'=>$_GET[realm]))',
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'product', 'action' => (object)['id' => 'view']]); }
				),
				'update' => array(
					'url' => 'Yii::app()->controller->createUrl(\'product/update\', array(\'id\'=>$data->id, \'realm\'=>$_GET[realm]))',
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'product', 'action' => (object)['id' => 'update']]); }
				),
				'delete' => array('visible' => false)
			),
		),
	),
)); ?>
	</div>

</div>
<?php endif; ?>
<?php if ($realm == 'backend'): ?>
<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'product-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		//array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
		'title',
		array('name' => 'typeof', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumTypeof($data->typeof)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumTypeof(false, true)),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'view' => array('url' => 'Yii::app()->controller->createUrl(\'product/view\', array(\'id\'=>$data->id, \'realm\'=>$_GET[realm]))'),
				'update' => array('url' => 'Yii::app()->controller->createUrl(\'product/update\', array(\'id\'=>$data->id, \'realm\'=>$_GET[realm]))'),
				'delete' => array('visible' => false)
			),
		),
	),
)); ?>
<?php endif; ?>

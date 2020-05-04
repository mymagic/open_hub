<?php
/* @var $this ResourceController */
/* @var $model Resource */

if ($realm == 'backend') {
	$this->breadcrumbs = array(
		'Resources' => array('index'),
		$model->title,
	);

	$this->menu = array(
		array(
			'label' => Yii::t('app', 'Manage Resources'), 'url' => array('/resource/resource/admin'),
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
		),
		array(
			'label' => Yii::t('app', 'Create Resource'), 'url' => array('/resource/resource/create'),
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
		),
		array(
			'label' => Yii::t('app', 'Update Resource'), 'url' => array('/resource/resource/update', 'id' => $model->id),
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
		),
		array(
			'label' => Yii::t('app', 'Delete Resource'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
		),
	);
} elseif ($realm == 'cpanel') {
	$this->breadcrumbs = array(
		'Organization' => array('index'),
		$organization->title => array('organization/view', 'id' => $organization->id, 'realm' => $realm),
		Yii::t('backend', 'Resources')
	);
}
?>

<?php if (!empty($model->organizations)) : foreach ($model->organizations as $organization) : ?>
		<?php $inputOrganizations .= sprintf('<a href="%s" target="_blank"><span class="label label-success">%s</span></a>&nbsp;', $this->createUrl('//organization/view', array('id' => $organization->id)), $organization->title) ?>
<?php endforeach;
endif; ?>


<?php if (!empty($model->industries)) : foreach ($model->industries as $industry) : ?>
		<?php $inputIndustries .= sprintf('<a href="%s" target="_blank"><span class="label label-success">%s</span></a>&nbsp;', $this->createUrl('//industry/view', array('id' => $industry->id)), $industry->title) ?>
<?php endforeach;
endif; ?>


<?php if (!empty($model->personas)) : foreach ($model->personas as $persona) : ?>
		<?php $inputPersonas .= sprintf('<a href="%s" target="_blank"><span class="label label-success">%s</span></a>&nbsp;', $this->createUrl('//persona/view', array('id' => $persona->id)), $persona->title) ?>
<?php endforeach;
endif; ?>


<?php if (!empty($model->startupStages)) : foreach ($model->startupStages as $startupStage) : ?>
		<?php $inputStartupStages .= sprintf('<a href="%s" target="_blank"><span class="label label-success">%s</span></a>&nbsp;', $this->createUrl('//startupStage/view', array('id' => $startupStage->id)), $startupStage->title) ?>
<?php endforeach;
endif; ?>


<?php if (!empty($model->resourceCategories)) : foreach ($model->resourceCategories as $resourceCategory) : ?>
		<?php $inputResourceCategories .= sprintf('<a href="%s" target="_blank"><span class="label label-success">%s</span></a>&nbsp;', $this->createUrl('//resource/category/view', array('id' => $resourceCategory->id)), $resourceCategory->title) ?>
<?php endforeach;
endif; ?>


<?php if (!empty($model->resourceGeofocuses)) : foreach ($model->resourceGeofocuses as $resourceGeofocus) : ?>
		<?php $inputResourceGeofocuses .= sprintf('<a href="%s" target="_blank"><span class="label label-success">%s</span></a>&nbsp;', $this->createUrl('//resource/geofocus/view', array('id' => $resourceGeofocus->id)), $resourceGeofocus->title) ?>
<?php endforeach;
endif; ?>



<?php if ($realm == 'cpanel') : ?>
	<div class="px-8 py-6 shadow-panel">
		<h2>Resource Information</h2>
		<div>
			<div>
				<div class="flex items-center justify-between">
					<h2><?php echo $model->organizations[0]->title; ?></h2>
				</div>
				<div class="md:inline-block">
					<div class="inline-flex items-center mr-8 my-2">
						<i class="fa fa-link"></i>
						<div class="ml-4"><?php echo $model->organizations[0]->url_website; ?></div>
					</div>
					<div class="inline-flex items-center mr-8 my-2">
						<i class="fa fa-envelope"></i>
						<div class="ml-4"><?php echo $model->organizations[0]->email_contact; ?></div>
					</div>
					<div class="inline-flex items-center mr-8 my-2">
						<span class="label label-success">Active</span>
						<div class="ml-4">Since <?php echo $model->organizations[0]->year_founded; ?></div>
					</div>
				</div>
			</div>
			<!-- <div>
				<img src="<?php echo StorageHelper::getUrl($model->image_logo); ?>" style="max-height: 128px" class="my-4">
			</div> -->
			<div class="mt-4">
				<h5 class="muted">PRODUCT TITLE</h5>
				<p class="break-all"><?php echo $model->title; ?></p>
			</div>
			<div class="mt-4">
				<h5 class="muted">PRODUCT DESCRIPTION</h5>
				<div class="break-all"><?php echo $model->html_content; ?></div>
			</div>
			<div class="mt-4">
				<h5 class="muted">RESOURCE CATEGORY</h5>
				<div>
					<?php foreach ($model->resourceCategories as $category) : ?>
						<span class="label"><?php echo $category->title ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="mt-4">
				<h5 class="muted">INDUSTRIES</h5>
				<div>
					<?php foreach ($model->industries as $industry) : ?>
						<span class="label"><?php echo $industry->title ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="mt-4">
				<h5 class="muted">PERSONAS</h5>
				<div>
					<?php foreach ($model->personas as $persona) : ?>
						<span class="label"><?php echo $persona->title ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="mt-4">
				<h5 class="muted">STARTUP STAGES</h5>
				<div>
					<?php foreach ($model->startupStages as $stage) : ?>
						<span class="label"><?php echo $stage->title ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="mt-4">
				<h5 class="muted">GEO LOCATIONS</h5>
				<div>
					<?php foreach ($model->resourceGeofocuses as $geo) : ?>
						<span class="label"><?php echo $geo->title ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="mt-4 flex justify-end">
		<a type="button" class="btn btn-outline btn-default" href="<?php echo $this->createUrl('update', array('id' => $model->id, 'organization_id' => $organization->id, 'realm' => $realm)); ?>">Edit Resource Information <i class="fa fa-arrow-right"></i></a>
	</div>
<?php elseif ($realm == 'backend') : ?>
	<?php echo $this->renderPartial('_viewBackend', array('model' => $model, 'user' => $user, 'tabs' => $tabs, 'tab' => $tab, 'organization' => $organization, 'inputOrganizations' => $inputOrganizations, 'inputIndustries' => $inputIndustries, 'inputPersonas' => $inputPersonas, 'inputStartupStages' => $inputStartupStages, 'inputResourceCategories' => $inputResourceCategories, 'inputResourceGeofocuses' => $inputResourceGeofocuses)) ?>
<?php endif; ?>
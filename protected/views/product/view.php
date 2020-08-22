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
		Yii::t('backend', 'Products') => array('adminByOrganization', 'organization_id' => $organization->id, 'realm' => $realm),
		$model->title,
	);
}
?>

<?php if ($realm == 'backend') : ?><h1><?php echo Yii::t('backend', 'View Product'); ?></h1><?php endif; ?>

<?php if ($realm == 'cpanel') : ?>
	<div class="px-8 py-6 shadow-panel">
		<h2>Basic Information</h2>
		<div>
			<div>
				<div class="flex items-center justify-between">
					<h2><?php echo $model->organization->title; ?></h2>
					<div>
						<h2 class="text-magic-green">MYR <?php echo $model->price_min; ?></h2>
					</div>
				</div>
				<div class="md:inline-block">
					<div class="inline-flex items-center mr-8 my-2">
						<i class="fa fa-link"></i>
						<div class="ml-4"><?php echo $model->organization->url_website; ?></div>
					</div>
					<div class="inline-flex items-center mr-8 my-2">
						<i class="fa fa-envelope"></i>
						<div class="ml-4"><?php echo $model->organization->email_contact; ?></div>
					</div>
					<div class="inline-flex items-center mr-8 my-2">
						<span class="label label-success">Active</span>
						<div class="ml-4">Since <?php echo $model->organization->year_founded; ?></div>
					</div>
				</div>
			</div>
			<div>
				<img src="<?php echo StorageHelper::getUrl($model->image_cover); ?>" style="max-height: 128px" class="my-4">
				<h3><?php echo $model->title; ?></h3>
			</div>
			<div class="mt-4">
				<h5 class="muted">PRODUCT DESCRIPTION</h5>
				<p class="break-all"><?php echo $model->text_short_description; ?></p>
			</div>
			<div class="mt-4">
				<h5 class="muted">Category</h5>
				<div>
					<span class="label"><?php echo $model->productCategory->title; ?></span>
				</div>
			</div>
			<div class="mt-4">
				<h5 class="muted">Type</h5>
				<div>
					<span class="label"><?php echo $model->typeof; ?></span>
				</div>
			</div>
		</div>
	</div>


	<?php // if (Yii::app()->user->isDeveloper) :?>
	<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) : ?>
		<div class="px-8 py-6 mt-4 shadow-panel">
			<div class="crud-view">
				<?php if (!empty($model->_metaStructures)) : ?>
					<h2><?php echo Yii::t('core', 'Meta Data') ?></h2>
					<?php echo Notice::inline(Yii::t('notice', 'Meta Data Only accessible by developer role'), Notice_WARNING) ?>
					<?php $this->widget('application.components.widgets.DetailView', array(
							'data' => $model,
							'attributes' => $model->metaItems2DetailViewArray(),
						)); ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>



	<div class="mt-4 flex justify-end">
		<a type="button" class="btn btn-outline btn-default" href="<?php echo $this->createUrl('/product/update', array('id' => $model->id, 'realm' => $realm)) ?>">Edit Product Information <i class="fa fa-arrow-right"></i></a>
	</div>

<?php endif; ?>

<?php if ($realm == 'backend') : ?>
	<div class="crud-view">
		<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					'id',
					array('name' => 'organization_id', 'value' => $model->organization->title),
					array('name' => 'product_category_id', 'value' => $model->productCategory->title),
					'title',
					array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
					array('name' => 'typeof', 'value' => $model->formatEnumTypeof($model->typeof)),
					array('name' => 'image_cover', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_cover')),
					'url_website',
					array('name' => 'price', 'type' => 'raw', 'value' => $model->renderPrice()),
					array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
					array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
					array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
				),
			)); ?>

		<?php // if (Yii::app()->user->isDeveloper) :?>
		<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) : ?>
			<div class="crud-view">
				<?php if (!empty($model->_metaStructures)) : ?>
					<h2><?php echo Yii::t('core', 'Meta Data') ?></h2>
					<?php echo Notice::inline(Yii::t('notice', 'Meta Data Only accessible by developer role'), Notice_WARNING) ?>
					<?php $this->widget('application.components.widgets.DetailView', array(
							'data' => $model,
							'attributes' => $model->metaItems2DetailViewArray(),
						)); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
<?php endif; ?>
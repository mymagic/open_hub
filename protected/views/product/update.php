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

<?php if ($realm == 'backend') : ?><h1><?php echo Yii::t('backend', 'Update Product'); ?></h1><?php endif; ?>

<?php if ($realm == 'cpanel') : ?>
	<section>
		<div class="px-8 py-6 shadow-panel">
			<h2>Edit Product</h2>
			<p>People on entrepreneur ecosystem will get to know you with this information</p>
			<div>
				<?php $this->renderPartial('_formCpanel', array('model' => $model, 'realm' => $realm)); ?>
			</div>
		</div>
		</div>
	</section>
	
<?php elseif ($realm == 'backend') : ?>
	<?php $this->renderPartial('_form', array('model' => $model, 'realm' => $realm)); ?>
<?php endif; ?>
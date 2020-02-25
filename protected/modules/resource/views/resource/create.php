<?php
/* @var $this ResourceController */
/* @var $model Resource */

if ($realm == 'backend') {
	$this->breadcrumbs = array(
		'Resources' => array('index'),
		Yii::t('backend', 'Create'),
	);

	$this->renderPartial('/resource/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));
} elseif ($realm == 'cpanel') {
	$this->breadcrumbs = array(
		'Organization' => array('index'),
		$organization->title => array('organization/view', 'id' => $organization->id, 'realm' => $realm),
		Yii::t('backend', 'Resources') => array('adminByOrganization', 'organization_id' => $organization->id, 'realm' => $realm),
		Yii::t('backend', 'Create')
	);
}
?>

<?php if ($realm == 'backend') : ?>
	<h1><?php echo Yii::t('backend', 'Create Resource'); ?></h1>
	<?php $this->renderPartial('_form', array('model' => $model, 'realm' => $realm, 'organization' => $organization)); ?>
<?php elseif ($realm == 'cpanel') : ?>
	<section>
		<div class="px-8 py-6 shadow-panel">
			<h2>Create Resource</h2>
			<p>People on entrepreneur ecosystem will get to know you with this information</p>
			<div>
				<?php $this->renderPartial('_form', array('model' => $model, 'realm' => $realm, 'organization' => $organization)); ?>
			</div>
		</div>
		</div>
	</section>
<?php endif; ?>
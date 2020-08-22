<?php
/* @var $this ResourceController */
/* @var $model Resource */

if ($realm == 'backend') {
	$this->breadcrumbs = array(
		'Resources' => array('index'),
		$model->title => array('view', 'id' => $model->id),
		Yii::t('backend', 'Update'),
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
			'label' => Yii::t('app', 'View Resource'), 'url' => array('/resource/resource/view', 'id' => $model->id),
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
		),
	);
} elseif ($realm == 'cpanel') {
	$this->breadcrumbs = array(
		'Organization' => array('index'),
		$organization->title => array('organization/view', 'id' => $organization->id, 'realm' => $realm),
		Yii::t('backend', 'Resources') => array('adminByOrganization', 'organization_id' => $organization->id, 'realm' => $realm),
		$model->title,
	);
}
?>

<?php if ($realm == 'cpanel') : ?>
	<section>
		<div class="px-8 py-6 shadow-panel">
			<h2>Update Resource</h2>
			<p>People on entrepreneur ecosystem will get to know you with this information</p>
			<div>
				<?php $this->renderPartial('_form', array('model' => $model, 'organization' => $organization, 'realm' => $realm)); ?>
			</div>
		</div>
		</div>
	</section>
<?php elseif ($realm == 'backend') : ?>

	<?php $this->renderPartial('_form', array('model' => $model, 'realm' => $realm)); ?>

<?php endif; ?>
<?php
/* @var $this ProofController */
/* @var $model Proof */

$this->breadcrumbs = array(
	'Proofs' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

if (empty($forRecord)) {
	$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Proof'), 'url' => array('/proof/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Proof'), 'url' => array('/proof/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View Proof'), 'url' => array('/proof/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
);
}
?>

<h1><?php echo Yii::t('backend', 'Update Proof'); ?>
<?php if (!empty($forRecord)): ?><small> for <?php echo $forRecord['title'] ?></small><?php endif; ?>
</h1>

<?php $this->renderPartial('_form', array('model' => $model, 'forRecord' => $forRecord)); ?>
<?php
/* @var $this ProofController */
/* @var $model Proof */

$this->breadcrumbs = array(
	'Proofs' => array('index'),
	Yii::t('backend', 'Create'),
);

if (empty($forRecord)) {
	$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Proof'), 'url' => array('/proof/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
}
?>

<h1>
	<?php echo Yii::t('backend', 'Create Proof'); ?>
	<?php if (!empty($forRecord)): ?><small> for <?php echo $forRecord['title'] ?></small><?php endif; ?>
</h1>

<?php $this->renderPartial('_form', array('model' => $model, 'forRecord' => $forRecord)); ?>
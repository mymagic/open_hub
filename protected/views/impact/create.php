<?php
/* @var $this ImpactController */
/* @var $model Impact */

$this->breadcrumbs = array(
	'Impacts' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Impact'), 'url' => array('/impact/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Impact'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
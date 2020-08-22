<?php
/* @var $this InterestController */
/* @var $model Interest */

$this->breadcrumbs = array(
	'Interests' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Interest'), 'url' => array('/interest/interest/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array('label' => Yii::t('app', 'Create Interest'), 'url' => array('/interest/interest/create')),
	array(
		'label' => Yii::t('app', 'View Interest'), 'url' => array('/interest/interest/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
),
);
?>

<h1><?php echo Yii::t('backend', 'Update Interest'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
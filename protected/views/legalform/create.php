<?php
/* @var $this LegalformController */
/* @var $model Legalform */

$this->breadcrumbs = array(
	'Legalforms' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Legalform'), 'url' => array('/legalform/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Legalform'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
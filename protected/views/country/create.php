<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs = array(
	'Countries' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Country'), 'url' => array('/country/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Country'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
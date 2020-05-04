<?php
/* @var $this RegistryController */
/* @var $model Registry */

$this->breadcrumbs = array(
	'Registries' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Registry'), 'url' => array('/registry/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Registry'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
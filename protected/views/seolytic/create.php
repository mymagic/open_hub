<?php
/* @var $this SeolyticController */
/* @var $model Seolytic */

$this->breadcrumbs = array(
	'Seolytics' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Seolytic'), 'url' => array('/seolytic/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Seolytic'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
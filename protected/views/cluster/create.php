<?php
/* @var $this ClusterController */
/* @var $model Cluster */

$this->breadcrumbs = array(
	'Clusters' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Cluster'), 'url' => array('/cluster/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Cluster'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
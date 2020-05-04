<?php
/* @var $this SeolyticController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Seolytics',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Seolytic'), 'url' => array('/seolytic/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Seolytic'), 'url' => array('/seolytic/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Seolytics'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

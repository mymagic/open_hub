<?php
/* @var $this IndustryKeywordController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Industry Keywords',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage IndustryKeyword'), 'url' => array('/industryKeyword/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create IndustryKeyword'), 'url' => array('/industryKeyword/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Industry Keywords'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

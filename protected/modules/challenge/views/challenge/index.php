<?php
/* @var $this ChallengeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Challenges',
);

$this->menu = array(
	array(
		'label' => Yii::t('challenge', 'Manage Challenge'), 'url' => array('/challenge/challenge/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('challenge', 'Create Challenge'), 'url' => array('/challenge/challenge/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('challenge', 'Challenges'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

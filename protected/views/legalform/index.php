<?php
/* @var $this LegalformController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Legalforms',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Legalform'), 'url' => array('/legalform/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Legalform'), 'url' => array('/legalform/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Legalforms'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

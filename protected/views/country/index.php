<?php
/* @var $this CountryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Countries',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Country'), 'url' => array('/country/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Country'), 'url' => array('/country/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Countries'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

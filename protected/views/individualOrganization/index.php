<?php
/* @var $this IndividualOrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Individual Organizations',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage IndividualOrganization'), 'url' => array('/individualOrganization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create IndividualOrganization'), 'url' => array('/individualOrganization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Individual Organizations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

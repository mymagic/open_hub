<?php
/* @var $this PersonaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Personas',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Persona'), 'url' => array('/persona/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Persona'), 'url' => array('/persona/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Personas'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

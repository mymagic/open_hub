<?php
/* @var $this EmbedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Embeds',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create Embed'), 'url' => array('create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Manage Embed'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('app', 'Embeds'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

<?php
/* @var $this EventOwnerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Event Owners',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage EventOwner'), 'url' => array('/eventOwner/admin')),
	array('label' => Yii::t('app', 'Create EventOwner'), 'url' => array('/eventOwner/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Event Owners'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

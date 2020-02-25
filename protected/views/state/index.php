<?php
/* @var $this StateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'States',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage State'), 'url' => array('/state/admin')),
	array('label' => Yii::t('app', 'Create State'), 'url' => array('/state/create')),
);
?>

<h1><?php echo Yii::t('backend', 'States'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

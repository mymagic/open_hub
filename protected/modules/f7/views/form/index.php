<?php
/* @var $this FormController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Forms',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Form'), 'url' => array('/f7/from/admin')),
	array('label' => Yii::t('app', 'Create Form'), 'url' => array('/f7/form/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Forms'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

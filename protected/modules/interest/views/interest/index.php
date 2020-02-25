<?php
/* @var $this InterestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Interests',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Create Interest'), 'url' => array('/interest/interest/create')),
	array('label' => Yii::t('app', 'Manage Interest'), 'url' => array('/interest/interest/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Interests'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
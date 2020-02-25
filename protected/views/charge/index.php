<?php
/* @var $this ChargeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Charges',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Charge'), 'url' => array('/charge/admin')),
	array('label' => Yii::t('app', 'Create Charge'), 'url' => array('/charge/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Charges'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

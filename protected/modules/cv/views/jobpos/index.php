<?php
/* @var $this CvJobposController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Jobpos',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos'), 'url' => array('/cv/jobpos/admin')),
	array('label' => Yii::t('app', 'Create Jobpos'), 'url' => array('/cv/jobpos/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Jobposes'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

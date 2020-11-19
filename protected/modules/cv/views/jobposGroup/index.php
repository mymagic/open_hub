<?php
/* @var $this CvJobposGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Jobpos Groups',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos Group'), 'url' => array('/cv/jobposGroup/admin')),
	array('label' => Yii::t('app', 'Create Jobpos Group'), 'url' => array('/cv/jobposGroup/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Jobpos Groups'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

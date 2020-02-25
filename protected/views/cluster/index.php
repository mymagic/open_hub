<?php
/* @var $this ClusterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Clusters',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Cluster'), 'url' => array('/cluster/admin')),
	array('label' => Yii::t('app', 'Create Cluster'), 'url' => array('/cluster/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Clusters'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

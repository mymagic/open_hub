<?php
/* @var $this ClassificationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Classifications',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Classification'), 'url' => array('/classification/admin')),
	array('label' => Yii::t('app', 'Create Classification'), 'url' => array('/classification/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Classifications'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

<?php
/* @var $this PageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Pages',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Page'), 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create Page'), 'url' => array('create')),
);
?>

<h1><?php echo Yii::t('app', 'Pages'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

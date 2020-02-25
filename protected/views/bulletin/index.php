<?php
/* @var $this BulletinController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Bulletins',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Create Bulletin'), 'url' => array('create')),
	array('label' => Yii::t('app', 'Manage Bulletin'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Bulletins'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

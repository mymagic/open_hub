<?php
/* @var $this ResourceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Resources',
);

$this->renderPartial('/resource/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));
?>

<h1><?php echo Yii::t('backend', 'Resources'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

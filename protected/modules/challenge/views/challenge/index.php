<?php
/* @var $this ChallengeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Challenges',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Challenge'), 'url' => array('/challenge/challenge/admin')),
	array('label' => Yii::t('app', 'Create Challenge'), 'url' => array('/challenge/challenge/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Challenges'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

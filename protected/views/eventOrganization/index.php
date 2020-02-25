<?php
/* @var $this EventOrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Event Organizations',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage EventOrganization'), 'url' => array('/eventOrganization/admin')),
	array('label' => Yii::t('app', 'Create EventOrganization'), 'url' => array('/eventOrganization/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Event Organizations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

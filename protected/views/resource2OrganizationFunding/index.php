<?php
/* @var $this Resource2OrganizationFundingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Resource2 Organization Fundings',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Resource2OrganizationFunding'), 'url' => array('/resource2OrganizationFunding/admin')),
	array('label' => Yii::t('app', 'Create Resource2OrganizationFunding'), 'url' => array('/resource2OrganizationFunding/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Resource2 Organization Fundings'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

<?php
/* @var $this OrganizationFundingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Organization Fundings',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage OrganizationFunding'), 'url' => array('/organizationFunding/admin')),
	array('label' => Yii::t('app', 'Create OrganizationFunding'), 'url' => array('/organizationFunding/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Organization Fundings'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

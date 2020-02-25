<?php
/* @var $this IndividualOrganizationController */
/* @var $model IndividualOrganization */

$this->breadcrumbs = array(
	'Individual Organizations' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage IndividualOrganization'), 'url' => array('/individualOrganization/admin')),
);
?>

<h1><?php echo $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */

$this->breadcrumbs = array(
	'Event Registrations' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage EventRegistration'), 'url' => array('/eventRegistration/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Event Registration'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
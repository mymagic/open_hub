<?php
/* @var $this CvExperienceController */
/* @var $model CvExperience */

$this->breadcrumbs = array(
	'Cv Experiences' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage CvExperience'), 'url' => array('/cv/cvExperience/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Cv Experience'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
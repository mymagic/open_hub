<?php
/* @var $this EventOrganizationController */
/* @var $model EventOrganization */

$this->breadcrumbs=array(
	'Event Organizations'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage EventOrganization'), 'url'=>array('/eventOrganization/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Event Organization'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
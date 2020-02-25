<?php
/* @var $this EventOrganizationController */
/* @var $model EventOrganization */

$this->breadcrumbs = array(
	'Event Organizations' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage EventOrganization'), 'url' => array('/eventOrganization/admin')),
	array('label' => Yii::t('app', 'Create EventOrganization'), 'url' => array('/eventOrganization/create')),
	array('label' => Yii::t('app', 'View EventOrganization'), 'url' => array('/eventOrganization/view', 'id' => $model->id)),
	// array('label'=>Yii::t('app','Delete EventOrganization'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('backend', 'Update Event Organization'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
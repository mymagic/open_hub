<?php
/* @var $this EventOrganizationController */
/* @var $model EventOrganization */

$this->breadcrumbs=array(
	'Event Organizations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage EventOrganization'), 'url'=>array('/eventOrganization/admin')),
	array('label'=>Yii::t('app','Create EventOrganization'), 'url'=>array('/eventOrganization/create')),
	array('label'=>Yii::t('app','Update EventOrganization'), 'url'=>array('/eventOrganization/update', 'id'=>$model->id)),
	// array('label'=>Yii::t('app','Delete EventOrganization'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Event Organization'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'event_code', 'value'=>$model->event->title),
		array('name'=>'organization_id', 'value'=>$model->organization->title),
		array('name'=>'as_role_code', 'value'=>$model->as_role_code),
		
		array('name'=>'registration_code', 'value'=>$model->registration_code),
		'organization_name',
		array('name'=>'event_vendor_code', 'value'=>$model->event_vendor_code),

		array('label'=>$model->attributeLabel('date_action'), 'value'=>Html::formatDateTime($model->date_action, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>
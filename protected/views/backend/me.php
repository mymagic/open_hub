<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Backend')=>array('index'),
	Yii::t('app', 'My Account'),
);
$this->menu=array(
	array('label'=>Yii::t('app', 'My Account'), 'url'=>array('/backend/me')),
	array('label'=>Yii::t('app', 'Update Account'), 'url'=>array('/backend/updateAccount'), 'linkOptions'=>array('target'=>'_blank')),
	//array('label'=>Yii::t('app', 'Change Password'), 'url'=>array('/backend/changePassword'))
);
?>

<h1><?php echo Yii::t('app', 'My Account') ?></h1>

<div class="row">

<div class="col-lg-5">
	
	<!-- role -->
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('app', 'Assigned Roles'); ?></div>
		<ul class="list-group">
		 <?php foreach($this->user->roles as $role): ?>
			<li class="list-group-item"><?php echo Html::faIcon('fa-check-circle', array('class'=>'text-success')) ?>&nbsp; <?php echo $role->title ?></li>
		 <?php endforeach; ?>
		</ul> 	
	</div>
	<!-- /role -->
</div>

<div class="col-lg-7">

	<!-- account info -->
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('default', 'Account Information') ?></div>
		<?php $this->widget('application.components.widgets.DetailView', array(
				'data'=>$model->user,
				'attributes'=>array(
					'username',
					//'nickname',
					array('name'=>'date_activated', 'value'=>Html::formatDateTime($model->user->date_activated, 'long')),
					array('name'=>'date_modified', 'value'=>Html::formatDateTime($model->user->date_modified, 'long')),
				),
			)); ?>
	</div>
	<!-- /account info -->

	<!-- personal info -->
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('default', 'Personal Information') ?></div>
		<?php $this->widget('application.components.widgets.DetailView', array(
				'data'=>$model,
				'attributes'=>array(
					'full_name',
					array('name'=>'gender', 'value'=>$model->formatEnumGender($model->gender)),
					array('label'=>Yii::t('core', 'Address'), 'value'=>$model->getFullAddress()),
					'mobile_no',
					'fax_no',
				),
			)); ?>
	</div>
	<!-- /personal info -->
</div>


</div>


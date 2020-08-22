<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs = array(
	'Settings' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('app', 'Panel'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Setting Panel'), 'url' => array('panel'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'panel')
	),
	array(
		'label' => Yii::t('app', 'Manage Setting'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('app', 'Setting panel'); ?></h1>
<div class="margin-top-2x">
<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'setting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-horizontal crud-form',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
	)
)); ?>

<fieldset class="margin-top-lg">
<legend><?php echo Yii::t('backend', 'General') ?></legend>
<div class="form-group">
	<div class="col-sm-2"><?php echo Yii::t('backend', 'Master Organization') ?></div>
	<div class="col-sm-10">
		<?php echo $form->bsTextField($model['organization-master-code'], 'value', array('name' => 'Setting[organization-master-code]')); ?>
		<p class="help-block"><?php echo Yii::t('backend', 'Insert the UUID code of the master organization here. A master organization is the owner of this installation.') ?></p>
	</div>
</div>
</fieldset>

<fieldset class="margin-top-lg">
<legend><?php echo Yii::t('backend', 'SEO') ?></legend>
<div class="form-group">
	<div class="col-sm-2"><?php echo Yii::t('backend', 'Meta Title') ?></div>
	<div class="col-sm-10">
		<?php echo $form->bsTextField($model['seo-meta-title'], 'value', array('name' => 'Setting[seo-meta-title]')); ?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-2"><?php echo Yii::t('backend', 'Meta Keywords') ?></div>
	<div class="col-sm-10">
		<?php echo $form->bsTextArea($model['seo-meta-keywords'], 'value', array('name' => 'Setting[seo-meta-keywords]')); ?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-2"><?php echo Yii::t('backend', 'Meta Description') ?></div>
	<div class="col-sm-10">
		<?php echo $form->bsTextArea($model['seo-meta-description'], 'value', array('name' => 'Setting[seo-meta-description]')); ?>
	</div>
</div>
</fieldset>

<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
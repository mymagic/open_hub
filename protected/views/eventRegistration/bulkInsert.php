<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */

$this->breadcrumbs = array(
	'Event Registrations' => array('index'),
	'Bulk Insert',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Registration'), 'url' => array('/eventRegistration/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>


<h1><?php echo Yii::t('backend', 'Bulk Insert'); ?></h1>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Instruction</h5>
    </div>
    <div class="ibox-content">
        <ol>
            <li>Always get the latest template excel file from here. <a class="btn btn-xs btn-primary" href="<?php echo StorageHelper::getUrl($settingTemplateFile) ?>" target="_blank">Download</a></li>
            <li>Fill up the records in it. Max 1000 records per file.</li>
            <li>Select the event that you loading into. <a href="<?php echo $this->createUrl('/event/create') ?>" target="_blank">Create one</a> first if not exists.</li>
            <li>Upload the filled excel back here.</li>
            <li>This script will auto run housekeeping for you after data loaded.</li>
        </ol>
    </div>
</div>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Upload</h5>
    </div>
    <div class="ibox-content">
    <?php $form = $this->beginWidget('ActiveForm', array(
		'id' => 'eventRegistration-bulkInsert-form',
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


    <?php echo Notice::inline(Yii::t('notice', 'Fields with <span class="required">*</span> are required.')); ?>
    <?php if ($model->hasErrors()): ?>
        <?php echo $form->bsErrorSummary($model); ?>
    <?php endif; ?>

    <div class="form-group <?php echo $model->hasErrors('event_id') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx2($model, 'event_id'); ?>
        <div class="col-sm-10">
            <?php echo $form->bsDropDownList($model, 'event_id', Html::listData($events, 'id', 'title'), array('class' => 'chosen form-control')); ?>
            <p class="help-block">Only active, not cancelled event shows here</p>
            <?php echo $form->bsError($model, 'event_id'); ?>
        </div>
    </div>

    <div class="form-group <?php echo $model->hasErrors('uploadFile_excel') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx2($model, 'uploadFile_excel'); ?>
        <div class="col-sm-10">
            <?php echo Html::activeFileField($model, 'uploadFile_excel'); ?>
            <?php echo $form->bsError($model, 'uploadFile_excel'); ?>
        </div>
    </div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Upload')); ?>
		</div>
    </div>

    <?php $this->endWidget(); ?>
    </div>
</div>
<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="">

<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo Yii::t('core', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</div>

<?php $form = $this->beginWidget('ActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>	

	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'id'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'ip'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ip'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'agent_string'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'agent_string'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'url_referrer'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_referrer'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'url_current'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_current'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'user.username'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextfield($model, 'username'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'user.profile.full_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_name'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'is_admin'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_admin', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'is_member'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_member', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'controller'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'controller'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'action'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'action'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'json_params'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'json_params', array('rows' => 5)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'text_note'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_note', array('rows' => 2)); ?>
		</div>
	</div>
	
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'date_added'); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('app', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_added', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('app', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_added', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'date_modified'); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('app', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_modified', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('app', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_modified', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>
	

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Search')); ?>
			<?php echo Html::btnDanger(Yii::t('core', 'Reset'), Yii::app()->createUrl($this->route, array('clearFilters' => '1'))) ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
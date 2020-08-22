<?php
/* @var $this MemberController */
/* @var $model Member */
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
		<?php echo $form->bsLabelEx2($model, 'user.id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'user_id'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'user.username'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'username'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'user.profile.full_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_name'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'user.is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class=" control-label col-sm-2" for=""><?php echo Yii::t('app', 'IP Address') ?></label>
		<label class="control-label col-sm-2"><?php echo Yii::t('app', 'Signup Ip') ?></label>
		<div class="col-sm-3">
			<?php echo $form->bsTextField($model, 'signup_ip'); ?>
		</div>
		<label class="control-label col-sm-2"><?php echo Yii::t('app', 'Last Login Ip') ?></label>
		<div class="col-sm-3">
			<?php echo $form->bsTextField($model, 'last_login_ip'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'date_joined'); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('app', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_joined', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('app', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_joined', array('nullable' => true, 'class' => 'dateRange-end')); ?>
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
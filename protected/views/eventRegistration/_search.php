<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */
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
		<?php echo $form->bsLabelFx2($model, 'id', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'id'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'event_code', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php $this->widget('application.components.widgets.EventSelector', array('form' => $form, 'model' => $model, 'attribute' => 'event_code', 'htmlOptions' => array('style' => 'width:100%'), 'urlAjax' => $this->createUrl('event/ajaxEvent', array('key' => 'code')))) ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'event_vendor_code', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'event_vendor_code'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'registration_code', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'registration_code'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'full_name', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_name'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'first_name', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'first_name'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'last_name', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'last_name'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'email', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'email'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'phone', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'phone'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'organization', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'organization'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'gender', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'gender', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'age_group', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'age_group'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'where_found', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'where_found'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'persona', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'persona'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'paid_fee', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'paid_fee'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_attended', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_attended', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_registered', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_registered', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_registered', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_payment', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_payment', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_payment', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_added', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_added', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_added', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_modified', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_modified', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
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
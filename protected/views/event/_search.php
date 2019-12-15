<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>

<div class="">

<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo Yii::t('core', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</div>

<?php $form=$this->beginWidget('ActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions'=>array
	(
		'class'=>'form-horizontal',
		'role'=>'form'
	)
)); ?>



		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'id', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'id'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'code', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'code'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'event_group_code', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'event_group_code', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_short_desc', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_short_desc',array('rows'=>2)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'url_website', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_started', array('required'=>false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_started', array('nullable'=>true, 'class'=>'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_started', array('nullable'=>true, 'class'=>'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_ended', array('required'=>false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_ended', array('nullable'=>true, 'class'=>'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_ended', array('nullable'=>true, 'class'=>'dateRange-end')); ?>
		</div>
	</div>

	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_paid_event', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_paid_event', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'genre', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'genre'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'funnel', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'funnel'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'vendor', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'vendor'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'vendor_code', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'vendor_code'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'at', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'at'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'address_country_code', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'address_country_code', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'address_state_code', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'address_state_code', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'full_address', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_address'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'latlong_address', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'latlong_address'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'email_contact', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'email_contact'); ?>
		</div>
	</div>
	
		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'searchBackendTags', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputBackendTags', Html::listData(Tag::getForeignReferList()), array('class'=>'form-control chosen', 'multiple'=>'multiple')); ?>
		</div>
	</div>


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_active', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_added', array('required'=>false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_added', array('nullable'=>true, 'class'=>'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_added', array('nullable'=>true, 'class'=>'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_modified', array('required'=>false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_modified', array('nullable'=>true, 'class'=>'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_modified', array('nullable'=>true, 'class'=>'dateRange-end')); ?>
		</div>
	</div>

	

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Search')); ?>
			<?php echo Html::btnDanger(Yii::t('core', 'Reset'), Yii::app()->createUrl($this->route, array('clearFilters'=>'1'))) ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
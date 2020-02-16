<?php
/* @var $this SampleController */
/* @var $model Sample */
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
		<?php echo $form->bsLabelFx2($model, 'sample_group_id', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'sample_group_id', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'sample_zone_code', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'sample_zone_code', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


	<?php if(array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title_en', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_en'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if(array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title_ms', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_ms'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if(array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title_zh', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_zh'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if(array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_short_description_en', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_short_description_en',array('rows'=>2)); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if(array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_short_description_ms', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_short_description_ms',array('rows'=>2)); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if(array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_short_description_zh', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_short_description_zh',array('rows'=>2)); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'file_backup', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'file_backup'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'price_main', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'price_main'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'gender', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'gender', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'age', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'age'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'csv_keyword', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'csv_keyword'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'ordering', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ordering'); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_posted', array('required'=>false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_posted', array('nullable'=>true, 'class'=>'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_posted', array('nullable'=>true, 'class'=>'dateRange-end')); ?>
		</div>
	</div>

	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_active', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_public', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_public', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_member', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_member', array('nullable'=>true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_admin', array('required'=>false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_admin', array('nullable'=>true)); ?>
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
<?php
/* @var $this ChallengeController */
/* @var $model Challenge */
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
		<?php echo $form->bsLabelFx2($model, 'owner_organization_id', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'attribute' => 'owner_organization_id', 'urlAjax' => $this->createUrl('challenge/ajaxOrganization'), 'htmlOptions' => array('style' => 'width:100%'))) ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'creator_user_id', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'creator_user_id', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_short_description', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'url_video', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_video'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'url_application_form', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_application_form'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'prize_title', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'prize_title'); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_open', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_open', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_open', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_close', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_close', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_close', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'ordering', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ordering'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_remark', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_remark', array('rows' => 2)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'status', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'status', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'timezone', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'timezone'); ?>
		</div>
	</div>
	
		
	

		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_publish', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_publish', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_highlight', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_highlight', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'process_by', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'process_by'); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_submit', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_submit', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_submit', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_process', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_process', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_process', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_added', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_added', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_added', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_modified', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_modified', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('challenge', 'End') ?></label>
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
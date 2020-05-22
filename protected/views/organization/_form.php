<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form CActiveForm */
?>

<div class="form-new">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'organization-form',
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


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_oneliner') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_oneliner'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'text_oneliner'); ?>
			<?php echo $form->bsError($model, 'text_oneliner'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('legalform_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'legalform_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'legalform_id', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'legalform_id'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('legal_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'legal_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'legal_name'); ?>
			<p class="help-block"><?php echo Yii::t('app', 'How should we address your company/organization legally for purposes like invoice and etc')?></p>
			<?php echo $form->bsError($model, 'legal_name'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('company_number') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'company_number'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'company_number'); ?>
			<?php echo $form->bsError($model, 'company_number'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('year_founded') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'year_founded'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'year_founded'); ?>
			<?php echo $form->bsError($model, 'year_founded'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('image_logo') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_logo'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_logo'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_logo'); ?>
			<?php echo $form->bsError($model, 'image_logo'); ?><br />
			<?php if ($model->image_logo != $model->getDefaultImageLogo()): ?>
			<?php echo Html::button(Html::faIcon('fa-trash') . ' Remove existing logo', array('class' => 'btn btn-sm btn-danger', 'id' => 'btn-rm-logo', 'type' => 'button')) ?>
			<?php endif; ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'url_website'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model, 'url_website'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('email_contact') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'email_contact'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'email_contact'); ?>
			<p class="help-block">Who should we notify for activities happens to this organization in the system</p>
			<?php echo $form->bsError($model, 'email_contact'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('full_address') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'full_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_address'); ?>
			<?php echo $form->bsError($model, 'full_address'); ?>
		</div>
	</div>

	<?php if (!$model->isNewRecord): ?>
	<div class="form-group hidden <?php echo $model->hasErrors('latlong_address') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'latlong_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsGeoPointField($model, 'latlong_address', array('readonly' => 'readonly', 'isGeoCodingEnabled' => true, 'geoCodingAddress' => $model->full_address, 'mapZoom' => 10)); ?>
			<p class="help-block">Please double click on map to set the marker</p>
			<?php echo $form->bsError($model, 'latlong_address'); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php
		/*
		 * hide the section from view instead
		 * or else the data will become null when update for those user that do not have role accessBackend
		 */
	?>
	<div class="<?php echo Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'superAdmin']]) ? '' : 'hide' ?>">
	
	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputImpacts') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputImpacts'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputImpacts', Html::listData(Impact::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<p class="help-block">This field is only accessible by admin</p>
			<?php echo $form->bsError($model, 'inputImpacts'); ?>
		</div>
	</div>
	<div class="form-group <?php echo $model->hasErrors('inputSdgs') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputSdgs'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputSdgs', Html::listData(Sdg::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<p class="help-block">This field is only accessible by admin</p>
			<?php echo $form->bsError($model, 'inputSdgs'); ?>
		</div>
	</div>
	<div class="form-group <?php echo $model->hasErrors('inputPersonas') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputPersonas'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<p class="help-block">This field is only accessible by admin</p>
			<?php echo $form->bsError($model, 'inputPersonas'); ?>
		</div>
	</div>

	</div>

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>


	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'superAdmin']])):?>
	<div class="form-group <?php echo $model->hasErrors('tag_backend') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'tag_backend'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'tag_backend', array('id' => 'Organization-tag_backend', 'class' => 'form-control csv_tags')) ?>
			<?php echo $form->bsError($model, 'tag_backend') ?>
		</div>
	</div>
	<?php endif; ?>

	<?php // if (Yii::app()->user->accessBackend && Yii::app()->user->isDeveloper):?>
	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])):?>
	<?php echo Notice::inline(Yii::t('notice', 'Meta Data Only accessible by developer role'), Notice_WARNING) ?>
	<?php $this->renderPartial('../../yeebase/views/metaStructure/_sharedForm', array('form' => $form, 'model' => $model)); ?>
	<?php endif; ?>


	<div class="form-group">
		<div class="pull-right margin-top-lg">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create Organization') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div>

<?php
Yii::app()->clientScript->registerScript('formjs', "
$(document).ready(function(){
	$('#btn-rm-logo').on('click', function(){
		$(this).prop('disabled', true);

		var image_href = $(this).closest('div.row').find('a[data-type=image]').attr('href');
		$.ajax({
			url: '" . Yii::app()->createUrl('/organization/removeOrganizationLogo') . "',
			data: {
				id: '" . $model->id . "',
				image_logo: '" . $model->image_logo . "',
				image_href: image_href,
				isAjaxRequest: 1,
				'" . Yii::app()->request->csrfTokenName . "': '" . Yii::app()->request->csrfToken . "'
			},
			type: 'POST',
			success: function(data){
				toastr.success('Logo Image successfully removed.');
				$('#btn-rm-logo').closest('div.row').find('div').first().empty().append(data);
				$('#btn-rm-logo').hide();
			},
			error: function(error){
				toastr.error('There is a problem occurred. Try again later.');
				$('#btn-rm-logo').prop('disabled', false);
			}
		});
	});
});
", CClientScript::POS_END);
?>
<!-- form -->
<!-- </div> -->
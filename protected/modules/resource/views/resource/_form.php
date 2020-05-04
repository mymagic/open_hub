<?php
/* @var $this ResourceController */
/* @var $model Resource */
/* @var $form CActiveForm */
?>

<div class="form-new <?php if ($realm == 'cpanel') : ?>org-padding<?php endif; ?>">

	<?php $form = $this->beginWidget('ActiveForm', array(
																'id' => 'resource-form',
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
	<?php if ($model->hasErrors()) : ?>
		<?php echo $form->bsErrorSummary($model); ?>
	<?php endif; ?>

	<?php if ($realm == 'cpanel') : ?>
		<div class="form-group <?php echo $model->hasErrors('organization') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'organization'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsTextHolder($organization, 'title'); ?>
				<?php echo $form->bsError($model, 'organization'); ?>
			</div>
		</div>
	<?php elseif ($realm == 'backend') : ?>
		<div class="form-group <?php echo $model->hasErrors('inputOrganizations') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'inputOrganizations'); ?>
			<div class="col-sm-10">
				<?php if (!$model->isNewRecord) : ?>
					<?php echo $form->dropDownList($model, 'inputOrganizations', Html::listData(Organization::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
				<?php else : // only those active one for new record
				?>
					<?php echo $form->dropDownList($model, 'inputOrganizations', Html::listData(Organization::getForeignReferList(false, false, array('params' => array('mode' => 'isActiveId')))), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
				<?php endif; ?>
				<?php echo $form->bsError($model, 'inputOrganizations'); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if (!$model->isNewRecord) : // user only change slug after resource created to make filling form easier
	?>
		<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'slug'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsTextField($model, 'slug'); ?>
				<?php echo $form->bsError($model, 'slug'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="form-group <?php echo $model->hasErrors('typefor') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'typefor'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList(
																$model,
																'typefor',
																array(
																	'ajax' => array(
																		'type' => 'GET',
																		'url' => Yii::app()->createUrl('api/renderResourceCategoryList', array('resource_id' => $model->id)), //or $this->createUrl('loadcities') if '$this' extends CController
																		'data' => array('typefor_code' => 'js:this.value'),
																		'success' => 'function(data){
						$(\'#Resource_inputResourceCategories\').html(data).trigger("chosen:updated");
					}',
																		//..or 'update'=>'#Resource_inputResourceCategories',
																	)
																)
															); ?>
			<?php echo $form->bsError($model, 'typefor'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputResourceCategories') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputResourceCategories'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputResourceCategories', Html::listData(ResourceCategory::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputResourceCategories'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'url_website'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model, 'url_website'); ?>
		</div>
	</div>

	<?php if ($realm == 'backend') : ?>
		<div class="form-group <?php echo $model->hasErrors('image_logo') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'image_logo'); ?>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-8">
						<?php echo Html::activeFileField($model, 'imageFile_logo'); ?>
						<?php echo $form->bsError($model, 'image_logo'); ?>
					</div>
					<div class="col-sm-2 text-left">
						<?php echo Html::activeThumb($model, 'image_logo'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group <?php echo $model->hasErrors('full_address') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'full_address'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsTextField($model, 'full_address'); ?>
				<?php echo $form->bsError($model, 'full_address'); ?>
			</div>
		</div>

		<div class="form-group <?php echo $model->hasErrors('latlong_address') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'latlong_address'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsGeoPointField($model, 'latlong_address', array('readonly' => 'readonly', 'isGeoCodingEnabled' => true, 'geoCodingAddress' => $model->full_address, 'mapZoom' => 10)); ?>
				<p class="help-block">Please double click on map to set the marker</p>
				<?php echo $form->bsError($model, 'latlong_address'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="margin-bottom-2x">
		<ul class="nav nav-tabs">

			<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])) : ?><li class="active"><a href="#pane-en" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>
			<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])) : ?><li class=""><a href="#pane-ms" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>
			<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])) : ?><li class=""><a href="#pane-zh" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>
		</ul>
		<div class="tab-content">

			<!-- English -->
			<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])) : ?>
				<div class="tab-pane active" id="pane-en">


					<div class="form-group <?php echo $model->hasErrors('title_en') ? 'has-error' : '' ?>">
						<?php echo $form->bsLabelEx2($model, 'title_en'); ?>
						<div class="col-sm-10">
							<?php echo $form->bsTextField($model, 'title_en'); ?>
							<?php echo $form->bsError($model, 'title_en'); ?>
						</div>
					</div>


					<div class="form-group <?php echo $model->hasErrors('html_content_en') ? 'has-error' : '' ?>">
						<?php echo $form->bsLabelEx2($model, 'html_content_en'); ?>
						<div class="col-sm-10">
							<?php echo $form->bsHtmlEditor($model, 'html_content_en'); ?>
							<?php echo $form->bsError($model, 'html_content_en'); ?>
						</div>
					</div>

				</div>
			<?php endif; ?>
			<!-- /English -->


			<!-- Bahasa -->
			<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])) : ?>
				<div class="tab-pane " id="pane-ms">


					<div class="form-group <?php echo $model->hasErrors('title_ms') ? 'has-error' : '' ?>">
						<?php echo $form->bsLabelEx2($model, 'title_ms'); ?>
						<div class="col-sm-10">
							<?php echo $form->bsTextField($model, 'title_ms'); ?>
							<?php echo $form->bsError($model, 'title_ms'); ?>
						</div>
					</div>


					<div class="form-group <?php echo $model->hasErrors('html_content_ms') ? 'has-error' : '' ?>">
						<?php echo $form->bsLabelEx2($model, 'html_content_ms'); ?>
						<div class="col-sm-10">
							<?php echo $form->bsHtmlEditor($model, 'html_content_ms'); ?>
							<?php echo $form->bsError($model, 'html_content_ms'); ?>
						</div>
					</div>

				</div>
			<?php endif; ?>
			<!-- /Bahasa -->


			<!-- 中文 -->
			<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])) : ?>
				<div class="tab-pane " id="pane-zh">

				</div>
			<?php endif; ?>
			<!-- /中文 -->


		</div>
		<hr />
	</div>



	<!-- many2many -->

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputPersonas') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputPersonas'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputPersonas'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputStartupStages') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputStartupStages'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputStartupStages', Html::listData(StartupStage::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputStartupStages'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('inputResourceGeofocuses') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputResourceGeofocuses'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputResourceGeofocuses', Html::listData(ResourceGeofocus::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputResourceGeofocuses'); ?>
		</div>
	</div>
	<!-- /many2many -->
	<?php // if ($realm == 'backend' && Yii::app()->user->accessBackend && Yii::app()->user->isSuperAdmin) :?>
	<?php if ($realm == 'backend' && Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'superAdmin']])) : ?>
		<div class="form-group <?php echo $model->hasErrors('tag_backend') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'tag_backend'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsTextField($model, 'tag_backend', array('id' => 'Resource-tag_backend', 'class' => 'form-control csv_tags')) ?>
				<?php echo $form->bsError($model, 'tag_backend') ?>
			</div>
		</div>
	<?php endif; ?>


	<?php if ($realm == 'backend') : ?>
		<div class="form-group <?php echo $model->hasErrors('is_featured') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'is_featured'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsBooleanList($model, 'is_featured'); ?>
				<?php echo $form->bsError($model, 'is_featured'); ?>
			</div>
		</div>

		<div class="form-group <?php echo $model->hasErrors('is_blocked') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx2($model, 'is_blocked'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsBooleanList($model, 'is_blocked'); ?>
				<?php echo $form->bsError($model, 'is_blocked'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>


	<div class="form-group">
		<div class="pull-right margin-top-lg margin-right-lg">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScript('google-map', '

	$("#Resource_typefor").trigger("change");

	$(document).on("change", "#Resource_full_address", function(e){$("#geoCoding-address-Resource_latlong_address").val($(this).val());});
'); ?>
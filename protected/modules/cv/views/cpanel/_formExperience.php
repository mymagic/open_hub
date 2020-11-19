
<div class="row">
	<div class="col-sm-9">
		<?php if (Yii::app()->user->getFlash('updateExperience-success')): ?>
			<?php echo Notice::inline(Yii::t('app', 'Portfolio saved successfully!'), Notice_SUCCESS); ?>
		<?php else: ?>
			<?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
		<?php endif; ?>
	</div>
	<div class="col-sm-3 text-right">
        <span class="btn-group btn-group-md">
            <a href="<?php echo $this->createUrl('cpanel/experience') ?>" class="btn btn-default"><?php echo Html::faIcon('fa-arrow-circle-left') ?> Cancel</a>
            <?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
        </span>
	</div>
</div>


<div class="row">
	<div class="col-sm-6">
		<div class="form-group <?php echo $model->hasErrors('genre') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelFx0($model, 'genre'); ?>
			<div class="">
				<?php echo $form->bsEnumDropDownList($model, 'genre'); ?>
				<?php echo $form->bsError($model, 'genre'); ?>
			</div>
		</div>
        
        <div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelFx0($model, 'title'); ?>
            <div class="">
                <?php echo $form->bsTextField($model, 'title'); ?>
                <?php echo $form->bsError($model, 'title'); ?>
            </div>
        </div>

        <div class="form-group <?php echo $model->hasErrors('organization_name') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelFx0($model, 'organization_name'); ?>
            <div class="">
                <?php echo $form->bsTextField($model, 'organization_name'); ?>
                <?php echo $form->bsError($model, 'organization_name'); ?>
            </div>
        </div>

        <div class="form-group <?php echo $model->hasErrors('full_address') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelFx0($model, 'full_address'); ?>
            <div class="">
                <?php echo $form->bsTextArea($model, 'full_address', array('rows' => 2)); ?>
                <?php echo $form->bsError($model, 'full_address'); ?>
            </div>
        </div>
                
        <div class="row nopadding">
		<div class="col col-sm-6 nopadding">
			<div class="form-group <?php echo $model->hasErrors('year_start') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelFx0($model, 'year_start'); ?>
				<div class="">
                    <?php echo $form->bsDropDownList($model, 'year_start', ysUtil::generateArrayRange(date('Y'), 1900, '2d'), array('empty' => 'Please Select'), array('class' => 'form-control', 'prompt' => 'Select Year')); ?>
					<?php echo $form->bsError($model, 'year_start'); ?>
				</div>
			</div>
		</div>
		<div class="col col-sm-6" style="padding-right:0">
			<div class="form-group <?php echo $model->hasErrors('month_start') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelFx0($model, 'month_start'); ?>
				<div class="">
					<?php echo $form->bsEnumDropDownList($model, 'month_start'); ?>
					<?php echo $form->bsError($model, 'month_start'); ?>
				</div>
			</div>
        </div>
        </div>

        <div class="row nopadding">
		<div class="col col-sm-6 nopadding">
			<div class="form-group <?php echo $model->hasErrors('year_end') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelFx0($model, 'year_end'); ?>
				<div class="">
					<?php echo $form->bsDropDownList($model, 'year_end', ysUtil::generateArrayRange(date('Y'), 1900, '2d'), array('empty' => 'Please Select'), array('class' => 'form-control', 'prompt' => 'Select Year')); ?>
					<?php echo $form->bsError($model, 'year_end'); ?>
				</div>
			</div>
		</div>
		<div class="col col-sm-6" style="padding-right:0">
			<div class="form-group <?php echo $model->hasErrors('month_end') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelFx0($model, 'month_end'); ?>
				<div class="">
					<?php echo $form->bsEnumDropDownList($model, 'month_end'); ?>
					<?php echo $form->bsError($model, 'month_end'); ?>
				</div>
			</div>
		</div>
		</div>
		
	</div>
	<div class="col-sm-6">
		<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelFx0($model, 'text_short_description'); ?>
			<div class="">
				<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 20)); ?>
				<?php echo $form->bsError($model, 'text_short_description'); ?>
			</div>
		</div>
	
	</div>
</div>
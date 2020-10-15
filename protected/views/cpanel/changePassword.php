<section>
    <div class="px-8 py-6 shadow-panel">
        <h2><?php echo Yii::t('cpanel', 'Change Password') ?></h2>
        <div class="py-4">
            <?php
			/* @var $this CpanelController */
			/* @var $model User */
			/* @var $form CActiveForm */
			?>


            <div class="">

                <?php $form = $this->beginWidget('ActiveForm', array(
					'id' => 'user-form',
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


                <div class="form-group <?php echo $model->hasErrors('opassword') ? 'has-error' : '' ?>">
                    <?php echo $form->bsLabelEx4($model, 'opassword'); ?>
                    <div class="col-sm-8">
                        <?php echo $form->bsPasswordField($model, 'opassword'); ?>
                        <?php echo $form->bsError($model, 'opassword'); ?>
                    </div>
                </div>


                <div class="form-group <?php echo $model->hasErrors('npassword') ? 'has-error' : '' ?>">
                    <?php echo $form->bsLabelEx4($model, 'npassword'); ?>
                    <div class="col-sm-8">
                        <?php echo $form->bsPasswordField($model, 'npassword'); ?>
                        <?php echo $form->bsError($model, 'npassword'); ?>
                    </div>
                </div>


                <div class="form-group <?php echo $model->hasErrors('cpassword') ? 'has-error' : '' ?>">
                    <?php echo $form->bsLabelEx4($model, 'cpassword'); ?>
                    <div class="col-sm-8">
                        <?php echo $form->bsPasswordField($model, 'cpassword'); ?>
                        <?php echo $form->bsError($model, 'cpassword'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <?php echo $form->bsBtnSubmit(Yii::t('core', 'Submit')); ?>
                    </div>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</section>
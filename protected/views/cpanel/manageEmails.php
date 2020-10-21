
<section>
    <div class="px-8 py-6 shadow-panel">
        <h2><?php echo Yii::t('cpanel', 'Manage Emails') ?></h2>
        <p><?php echo Yii::t('cpanel', 'Link your other email addresses to this account here to consolidate activities registered') ?></p>
        <div class="py-4">
            
            <div class="margin-bottom-2x">
                <div class="form"><?php $user2Email = new User2Email;
				$form = $this->beginWidget('ActiveForm', array(
					'action' => $this->createUrl('cpanel/addEmail'),
					'method' => 'POST',
					'htmlOptions' => array('class' => 'form-inline')
				)); ?>

                    <div class="form-group">
                        <?php echo $form->bsTextField($user2Email, 'user_email', array('placeholder' => 'Email')) ?>
                        <button type="submit" class="btn btn-success"><?php echo Yii::t('cpanel', 'Add') ?></button>
                    </div>

                <?php $this->endWidget(); ?></div>

                <hr />

                <div class="row text-muted">
                    <div class="col-xs-3"><span><?php echo Yii::t('cpanel', 'Legend') ?>:</span></div>
                    <div class="col-xs-3 text-center"><span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span> <small><?php echo Yii::t('cpanel', 'Pending for verfication') ?></small></div>
                    <div class="col-xs-3 text-center"><span class="text-success"><?php echo Html::faIcon('fa-check-circle') ?></span> <small><?php echo Yii::t('cpanel', 'Verified') ?></small></div>
                </div>
            </div>


            <div id="section-user2Emails" class="margin-bottom-3x">
                <span class="text-muted"><?php echo Html::faIcon('fa-spinner fa-spin') ?> Loading...</span>
            </div>

            <?php Yii::app()->clientScript->registerScript(
					'cpanel-manageEmails',
				sprintf("$('#section-user2Emails').load('%s', function(){});", $this->createUrl('member/getUser2Emails', array('userId' => $model->id, 'realm' => $realm)))
			); ?>
            
        </div>

        
    </div>
</section>
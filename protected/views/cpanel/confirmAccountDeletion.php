<div class="wrapper wrapper-content content-bg">
    <div id="service-content" class="row">
        <div class="col col-md-12 margin-bottom-lg"> 
            <div>
                <div role="dialog" >
                    <div class="modal-dialog">
                        <form id="frm" class="modal-content" method="POST" action="<?php echo $this->createUrl('/cpanel/terminateConfirmed')?>">
                            <div class="modal-header text-warning">
                                <h4 class="modal-title"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;<?php echo Yii::t('core', 'Warning') ?></h4>
                            </div>
                            
                            <div class="modal-body">
                                <div class="message"><strong><?php echo Yii::t('cpanel', 'Are you sure?')?></strong><br>
                                    <?php echo Yii::t('cpanel', "Once confirm, your account '<b>{email}</b>' will be permanently terminated. If you still like to proceed, please enter your email address bellow and click 'Confirm' button.", array('{email}' => $model->username)) ?>
                                </div>
                                <div class="form-group margin-top-2x">
                                    <label for="txtemail"><?php echo Yii::t('core', 'Email address') ?></label>
                                    <input type="email" id="txtemail" name="txtemail" class="form-control"  placeholder="<?php echo Yii::t('cpanel', 'Enter your email address here') ?>">
                                    <input type="hidden" name="<?php echo Yii::app()->request->csrfTokenName;?>" value="<?php echo Yii::app()->request->csrfToken;?>" />
                                </div>
                                <div id="feedback-msg"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id="btn-deleteAccount" class="btn btn-sd btn-sd-red"><?php echo Yii::t('cpanel', 'Confirm Terminate Account') ?></button>
                                <a class="btn btn-sd btn-default" href=<?php echo $this->createUrl('cpanel/deleteUserAccount') ?>><?php echo Yii::t('core', 'Cancel') ?></a>			
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('cpanel-confirmAccountDeletion', "
    window.email = '<?php echo $model->username ?>';
   $( document ).ready(function(){
        $('#btn-deleteAccount').click(function(event) {
            event.preventDefault();
            if ($('#txtemail').val() != window.email)
            {
                $('#feedback-msg').text('Please enter your email before confirming account termination.').css('color', 'red');
                
            }
            else
            {
                $('#feedback-msg').hide();
                $(this).unbind('btn-deleteAccount');
                $('#frm').submit();
            }
        });
   });
"); ?>
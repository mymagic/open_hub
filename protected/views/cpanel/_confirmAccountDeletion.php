<?php
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

$csrfTokenName = Yii::app()->request->csrfTokenName;
$csrfToken = Yii::app()->request->csrfToken;
?>

<div class="wrapper wrapper-content content-bg">
    <div id="service-content" class="row">
        <div class="col col-md-12 margin-bottom-lg"> 
            <div>
                <div role="dialog" >
                    <div class="modal-dialog">
                        <form id="frm" class="modal-content" method="POST" action="<?php echo $this->createUrl('/cpanel/terminateConfirmed')?>">
                            <div class="modal-header text-warning">
                                <h4 class="modal-title"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;Warning</h4>
                            </div>
                            
                            <div class="modal-body">
                                <div class="message"><strong>Are you sure?</strong><br>
                                    Once you confirm, your Account (<?php echo $model->username ?>) will be permanently deactivated.<br /><br />
                                    If you want to proceed please enter your email address in the bellow field
                                    and click on the 'Delete anyway' button.<br />
                                </div>
                                <div class="form-group">
                                    <label for="txtemail">Email address</label>
                                    <input type="email" id="txtemail" name="txtemail" class="form-control"  placeholder="Enter email">
                                    <input type="hidden" name="<?php echo Yii::app()->request->csrfTokenName;?>" value="<?php echo Yii::app()->request->csrfToken;?>" />
                                </div>
                                <div id="feedback-msg"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id="deletebtn" class="btn btn-sd btn-sd-red">Deactivate</button>
                                <a class="btn btn-sd btn-default" href=<?php echo $this->createUrl('cpanel/deleteUserAccount') ?>>Cancel</a>			
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.email = '<?php echo $model->username ?>';
   $( document ).ready(function(){
        $('#deletebtn').click(function(event) {
            event.preventDefault();
            if ($('#txtemail').val() != window.email)
            {
                $('#feedback-msg').text('Please enter your email before confirming account termination.').css('color', 'red');
                
            }
            else
            {
                $('#feedback-msg').hide();
                $(this).unbind('deletebtn');
                $('#frm').submit();
            }
        });
   });

   
</script>
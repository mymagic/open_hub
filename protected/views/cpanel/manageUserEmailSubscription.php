<?php
$this->breadcrumbs=array(
    'Manage Your Newsletters'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));
?>

<div class="sidebard-panel left-bar">
    <div id="header">
        <h2>Settings<span class="hidden-desk">
            <a class="container-arrow scroll-to" href="#">
                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </a></span>
        </h2>
        <h4></h4>
    </div>
    <div id="content-services">
        <a id="unsubscribeUserEmail-link" class="service-link active" href="<?php echo $this->createUrl('cpanel/manageUserEmailSubscription') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Manage Your Newsletters</h4>
                <h5>View, change or cancel your subscriptions</h5> 
            </div>
        </a>    

        <a id="downloadUserData-link" class="service-link" href="<?php echo $this->createUrl('cpanel/downloadUserData') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Download Your Information</h4>
                <h5>Get a copy of your data on our platform here</h5> 
            </div>
        </a>
        
        <a id="deleteUserAccount-link" class="service-link" href="<?php echo $this->createUrl('cpanel/deleteUserAccount') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Deactivate Your Account</h4>
                <h5>Permanently deactivate your MaGIC account</h5> 
            </div>
        </a>    
    </div>
</div>


<div class="wrapper wrapper-content content-bg content-left-padding">
    <div id="service-content" class="row">
        <div class="col col-md-12 margin-bottom-lg">
            <h2 style="margin-top: 15px; margin-left: 40px; max-width: 700px;margin-right: 50px;">Manage Your Newsletters</h2>
            <div style="margin-left: 40px; " id="vue-manageUserEmailSubscription">

                <?php foreach($lists as $list): ?>
                <div class="gray-bg padding-lg margin-bottom-lg border mailchimpListItem" data-list-id="<?php echo $list['id'] ?>">
                    <span class="pull-right"><?php echo Html::faIcon('fa fa-spinner fa-spin') ?><input type="checkbox" class="checkbox-subscribe" disabled="disabled" @click="toggleSubscriptionStatus('<?php echo $list['id'] ?>', $event)" /></span>
                    <b><?php echo $list['name'] ?></b>
                    <p><?php echo $list['permission_reminder'] ?></p>
                </div>
                <?php endforeach; ?>
             
            </div>
        </div>
    </div>
</div>



<?php Yii::app()->clientScript->registerScript('cpanel-setting-manageUserEmailSubscription-vuejs', "
var vue = new Vue({
	el: '#vue-manageUserEmailSubscription',
	data: {},
	ready: function () 
	{
        var self = this;
		$.each($('.mailchimpListItem'), function(index, item) {
            $('.mailchimpListItem').filter('[data-list-id=\''+$(item).data('listId')+'\']').find('.fa-spinner').hide();
            $('.mailchimpListItem').filter('[data-list-id=\''+$(item).data('listId')+'\']').find('.checkbox-subscribe').hide();
        });
		$.each($('.mailchimpListItem'), function(index, item) {
            self.getSubscriptionStatus($(item).data('listId'));
        });
	},
	methods: 
	{
		getSubscriptionStatus: function(listId)
		{
            $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.fa-spinner').show();

            $.get(baseUrl+'/cpanel/getSubscriptionStatus?listId='+listId, function(json) 
            {
                if(json.status == 'success')
                {
                    if(json.data.isSubscribed)
                    {
                        $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').prop('disabled', false).prop('checked', true);
                    }
                    else
                    {
                        $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').prop('disabled', false).prop('checked', false);
                    }
                }
                else
                {
                    toastr.error('Opps, something went wrong. '+json.msg)
                }

                $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').show();
                
            }).always(function() {
                $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.fa-spinner').hide();
            });
        
        },
        toggleSubscriptionStatus: function(listId, event)
        {
            $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.fa-spinner').show();
            $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').hide();
            
            $.get(baseUrl+'/cpanel/toggleSubscriptionStatus?listId='+listId, function(json) 
            {
                if(json.status == 'success')
                {
                    if(json.data.isSubscribed)
                    {
                        $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').prop('disabled', false).prop('checked', true);

                        toastr.success('Successfully subscribed '+json.data.result.email_address+' to \"'+json.data.list.name+'\"')
                    }
                    else
                    {
                        $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').prop('disabled', false).prop('checked', false)

                        toastr.success('Successfully unsubscribed '+json.data.result.email_address+' from \"'+json.data.list.name+'\"')
                    }
                }
                else
                {
                    toastr.error('Opps, something went wrong. '+json.msg)
                }

                $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.checkbox-subscribe').show();
            }).always(function() {
                $('.mailchimpListItem').filter('[data-list-id=\''+listId+'\']').find('.fa-spinner').hide();
            });
        }
	}
});"); 
?>
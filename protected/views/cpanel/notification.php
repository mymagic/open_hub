<?php
$this->breadcrumbs=array(
    'Notification'
);
?>

<section>
    <div class="px-8 py-6 shadow-panel" id="vue-manageUserEmailSubscription">
        <h2>Notifications</h2>
        <p>We’ll always let you know about important changes, but you pick what else you want to hear about</p>
        <br>
        <?php foreach ($lists as $list) : ?>

            <div class="flex items-center mailchimpListItem" data-list-id="<?php echo $list['id'] ?>">

                <span class="pull-right"><?php echo Html::faIcon('fa fa-spinner fa-spin') ?><input type="checkbox" class="checkbox-subscribe" disabled="disabled" @click="toggleSubscriptionStatus('<?php echo $list['id'] ?>', $event)" /></span>

                <div class="ml-4">
                    <b><?php echo $list['name'] ?></b><br>
                    <p><?php echo $list['permission_reminder'] ?></p>
                </div>
            </div>

        <?php endforeach; ?>

</section>

<?php Yii::app()->clientScript->registerScript('cpanel-setting-manageUserEmailSubscription-vuejs', "
var vue = new Vue({
	el: '#vue-manageUserEmailSubscription',
	data: {},
	mounted: function () 
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
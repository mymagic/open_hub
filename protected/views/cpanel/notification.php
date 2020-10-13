<?php
$this->breadcrumbs = array(
	'Notification'
);
?>

<section>
    <div class="px-8 py-6 shadow-panel" id="vue-manageUserEmailSubscription">
        <h2><?php echo Yii::t('app', 'Notifications') ?></h2>
        <p><?php echo Yii::t('app', 'We’ll always let you know about important changes, but you pick what else you want to hear about') ?></p>

        <?php if (!empty($masterNewsletter)):?>
        <div class="flex items-center mailchimpListItem margin-top-lg margin-bottom-lg" data-list-id="<?php echo $masterNewsletter['id'] ?>">

            <span class="pull-right"><?php echo Html::faIcon('fa fa-spinner fa-spin') ?><input type="checkbox" class="checkbox-subscribe" disabled="disabled" @click="toggleSubscriptionStatus('<?php echo $masterNewsletter['id'] ?>', $event)" /></span>

            <div class="ml-4">
                <b><?php echo $masterNewsletter['name'] ?></b><br>
                <p><?php echo $masterNewsletter['permission_reminder'] ?></p>
            </div>

        </div>
        <?php endif; ?>

        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a data-toggle="tab" href="#tab-public"><?php echo Yii::t('app', 'Public') ?></a></li>
            <li role="presentation"><a data-toggle="tab" href="#tab-private"><?php echo Yii::t('app', 'Private') ?></a></li>
        </ul>
        <div class="tab-content padding-top-lg">
            <div class="tab-pane fade in active" id="tab-public">
                <?php if (!empty('publicNewsletters')): ?>
                <?php foreach ($publicNewsletters as $list) : ?>

                    <div class="flex items-center mailchimpListItem border-bottom margin-bottom-md" data-list-id="<?php echo $list['id'] ?>">

                        <span class="pull-right"><?php echo Html::faIcon('fa fa-spinner fa-spin') ?><input type="checkbox" class="checkbox-subscribe" disabled="disabled" @click="toggleSubscriptionStatus('<?php echo $list['id'] ?>', $event)" /></span>

                        <div class="ml-4">
                            <b><?php echo $list['name'] ?></b><br>
                            <p><?php echo $list['permission_reminder'] ?></p>
                        </div>
                    </div>

                <?php endforeach; ?>
                <?php else: ?>
                    <?php Notice::inline(Yii::t('app', 'No newsletter found here.')) ?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="tab-private">
                <?php if (!empty('privateNewsletters')): ?>
                <?php foreach ($privateNewsletters as $list) : ?>

                    <div class="flex items-center mailchimpListItem border-bottom margin-bottom-md" data-list-id="<?php echo $list['id'] ?>">

                        <span class="pull-right"><?php echo Html::faIcon('fa fa-spinner fa-spin') ?><input type="checkbox" class="checkbox-subscribe" disabled="disabled" @click="toggleSubscriptionStatus('<?php echo $list['id'] ?>', $event)" /></span>

                        <div class="ml-4">
                            <b><?php echo $list['name'] ?></b><br>
                            <p><?php echo $list['permission_reminder'] ?></p>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <?php Notice::inline(Yii::t('app', 'No newsletter found here.')) ?>
                <?php endif; ?>
            </div>
        </div>

        
        
    </div>
    

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
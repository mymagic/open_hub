<?php
$this->breadcrumbs = array(
	Yii::t('app', 'Backend') => array('index'),
	Yii::t('app', 'Dashboard'),
); ?>

<div class="row">

<div class="col col-lg-3">
    <div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('app', 'Welcome'); ?> </div>
		 <div class="panel-body">
		 	<p><?php echo $this->user->profile->full_name; ?> (<?php echo $this->user->username; ?>)</p>
		 	<div class="row">
			<div class="col-sm-6">
				<div class="widget style1 navy-bg padding-md">
					<a href="<?php echo $this->createUrl('organization/overview'); ?>" class="text-white"><span><i class="fa fa-briefcase"></i> <?php echo Yii::t('backend', 'Organization')?></span>
					<h3 class="font-bold"><?php echo $stat['totalOrganizations']; ?></h3>
					</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="widget style1 padding-md">
					<a href="<?php echo $this->createUrl('individual/admin'); ?>" class=""><span><i class="fa fa-user"></i> <?php echo Yii::t('backend', 'Individual')?></span>
					<h3 class="font-bold"><?php echo $stat['totalIndividuals']; ?></h3>
					</a>
				</div>
			</div>
			</div>
		</div>

		<table class="table">
			<tr><td><a href="<?php echo $this->createUrl('member/admin'); ?>">Users</a></td><td class="text-right"><?php echo number_format($stat['totalUsers']); ?></td></tr>
			<tr><td>Login Session</td><td class="text-right"><?php echo number_format($stat['totalLogins']); ?></td></tr>
			<tr><td><a href="<?php echo $this->createUrl('event/overview'); ?>">Events</a></td><td class="text-right"><?php echo number_format($stat['totalEvents']); ?></td></tr>
			<tr><td>Event Registrations</td><td class="text-right"><?php echo number_format($stat['totalEventRegistrations']); ?></td></tr>

		</table>
		
	</div>	

	<a href="http://bit.ly/2odDCWm" class="btn btn-block btn-warning" target="_blank"><i class="fa fa-book text-primary"></i> <?php echo Yii::t('backend', 'Need Help?') ?></a>
	
	<div class="margin-bottom-lg">&nbsp;</div>
</div>

<div class="col col-lg-9">
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="navTab-backendBashboardViewTabs">
	<li role="presentation" class=""><a href="#welcome" aria-controls="welcome" role="tab" data-toggle="tab">Welcome</a></li>
<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
    <li role="presentation" class=""><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
<?php endforeach; ?><?php endforeach; ?>
</ul><!-- /Nav tabs -->
<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane white-bg padding-md" id="welcome" data-url-view="">
		<div class="flashNotices">
		<?php foreach ($notices as $notice):?>
			<?php echo Notice::inline($notice['message'], !empty($notice['type']) ? $notice['type'] : Notice_INFO, true, false, true); ?>
		<?php endforeach; ?>
		</div>
		<p class="margin-top-lg margin-bottom-3x">Welcome to <?php echo Yii::app()->name ?> Backend</p>
		
	</div>
<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
    <div role="tabpanel" class="tab-pane white-bg padding-md" id="<?php echo $tabModule['key'] ?>" data-url-view="<?php echo $this->createUrl('backend/renderDashboardViewTab', array('viewPath' => $tabModule['viewPath'])) ?>">
        <div class="text-center margin-top-lg margin-bottom-2x"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
    </div>
    <?php endforeach; ?><?php endforeach; ?>
</div><!--/Tab panes -->
</div>


</div>


<?php Yii::app()->clientScript->registerScript('backend-dashboard2', "
var loadedTabs = [];

$(document).on('shown.bs.tab', '#navTab-backendBashboardViewTabs a[data-toggle=\"tab\"]', function (e) {
    var anchor = $(e.target).attr('href');
    if(loadedTabs.indexOf(anchor) == -1 && $(anchor).data('urlView').length>0)
    {
        $(anchor).load($(anchor).data('urlView'), function(){
            loadedTabs.push(anchor); 
        });
    }
});

");
?>
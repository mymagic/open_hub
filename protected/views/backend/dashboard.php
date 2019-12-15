<?php
    // peity
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/vendors/inspinia/js/plugins/peity/jquery.peity.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/vendors/inspinia/js/demo/peity-demo.js', CClientScript::POS_END);
?>

<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Backend') => array('index'),
    Yii::t('app', 'Dashboard'),
); ?>

<style type="text/css">
	.is-collapsed{
  display: none;
}
.timeline-item .date {
	width: auto;
}
@media(max-width: 768px) {
	.timeline-item .date {
		width: 110px;
	}
}
</style>
<div class="row">

<div class="col-lg-3">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('app', 'Welcome'); ?> </div>
		 <div class="panel-body">
		 	<p><?php echo $this->user->profile->full_name; ?> (<?php echo $this->user->username; ?>)</p>
		 	<div class="row">
			<div class="col-sm-6">
				<div class="widget style1 navy-bg padding-md">
					<a href="<?php echo $this->createUrl('organization/overview'); ?>" class="text-white"><span><i class="fa fa-briefcase"></i> Company</span>
					<h3 class="font-bold"><?php echo $stat['totalOrganizations']; ?></h3>
					</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="widget style1 padding-md">
					<a href="<?php echo $this->createUrl('individual/admin'); ?>" class=""><span><i class="fa fa-user"></i> Individual</span>
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

	<a href="http://bit.ly/2odDCWm" class="btn btn-block btn-warning" target="_blank"><i class="fa fa-book text-primary"></i> Need Help?</a>
	
	<div class="margin-bottom-lg">&nbsp;</div>
</div>

<div class="col col-lg-9">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#activity" aria-controls="home" role="tab" data-toggle="tab">Overview</a></li>
		<li role="presentation"><a href="#log" aria-controls="log" role="tab" data-toggle="tab">Log</a></li>
	</ul><!-- /Nav tabs -->
	 <!-- Tab panes -->
	 <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="activity"><?php echo $this->renderPartial('_dashboard-systemActivity'); ?></div>
		<div role="tabpanel" class="tab-pane" id="log"><?php echo $this->renderPartial('_dashboard-systemLog'); ?></div>
	</div><!--/Tab panes -->
	
</div>


</div>

<?php if (Yii::app()->params['environment'] == 'production'):?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  // .mymagic.my
  ga('create', 'UA-62910124-1', 'auto');
  ga('create', 'UA-62910124-5', 'auto', 'centralTracker');
  ga('send', 'pageview');
  ga('centralTracker.send', 'pageview');
</script>
<?php endif; ?>

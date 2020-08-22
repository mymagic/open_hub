<div class="row margin-top-2x">
	<div class="col col-sm-10">
		<form class="form-inline" action="<?php echo $this->createUrl('/event/timeline') ?>" method="GET">
			<label for="date">Year</label>
			<?php echo Html::textField('year', $year, array('size' => 5));?>
			<div class="btn-group">
				<input type="submit" class="btn btn-primary btn-xs" name="output" value="Go" />
			</div>
		</form>
	</div>
	<div class="col col-sm-2">
		<p class="text-right">Total Events <span class="badge badge-primary"><?php echo count($model['events']) ?></span></p>
	</div>
</div>

<?php if (!empty($model['events'])): ?>
<div id="vertical-timeline" class="vertical-container light-timeline center-orientation padding-lg full-width rounded-md" style="background:#ddd !important">
<?php foreach ($model['events'] as $event): ?>
	<div class="vertical-timeline-block">
		<div class="vertical-timeline-icon blue-bg">
			<i class="fa fa-calendar"></i>
		</div>

		<div class="vertical-timeline-content">
			<h2><a href="<?php echo $this->createUrl('/event/view', array('id' => $event->id)) ?>" target="_blank"><?php echo $event->title ?></a><br />
			
			<small><?php if ($event->date_started != $event->date_ended): ?>
				From <span><?php echo Html::formatDateTime($event->date_started, 'medium', false) ?></span> to <span><?php echo Html::formatDateTime($event->date_ended, 'medium', false) ?></span>
				<?php endif; ?>
				 at <span><?php echo Html::encodeDisplay($event->at) ?></span>
			</small></h2>

			<?php if ($event->hasEventRegistration()):?>
			<p><?php echo Html::faIcon('fa fa-user margin-right-lg') ?>&nbsp;<span class="badge badge-warning"><?php echo $event->countRegistration() ?></span> Registered, <span class="badge badge-primary"><?php echo $event->countAttended() ?></span> Attended, <span class="badge badge-default"><?php echo sprintf('%.2f', ($event->countAttended() / $event->countRegistration()) * 100) ?>%</span> Turnout</p>
			<?php endif; ?>

			<?php if ($event->hasEventOrganization()): $tmps = $event->countEventOrganizationRoles(); ?>
			<p><?php echo Html::faIcon('fa fa-briefcase margin-right-lg') ?>&nbsp;
			<?php foreach ($tmps as $tmp): ?>
				<span class="badge badge-warning"><?php echo $tmp['total'] ?></span> <?php echo EventOrganization::renderAsRoleCode($tmp['as_role_code']) ?>&nbsp;&nbsp;
			<?php endforeach; ?>
			</p>
			<?php endif; ?>

			<span class="vertical-date">
				<small><?php echo Html::formatDateTime($event->date_started, 'medium', false) ?></small>
			</span>
		</div>
	</div>
<?php endforeach; ?>

</div>
<?php endif; ?>
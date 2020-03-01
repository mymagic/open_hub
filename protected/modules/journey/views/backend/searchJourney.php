<?php
/* @var $this OrganizationController */
/* @var $model Organization */

$this->breadcrumbs = array(
	Yii::t('backend', 'Journey') => array('index'),
	Yii::t('backend', 'Search'),
);

$this->menu = array(
	//array('label'=>Yii::t('app','Create Organization'), 'url'=>array('/organization/create')),
);
?>

<div class="row padding-top-lg">
<div class="col col-sm-4">
	<?php if ($this->layout == '//layouts/backend'): ?><h1 class="nopadding"><?php echo $this->pageTitle ?></h1><?php endif; ?>
</div>
<div class="col col-sm-8 text-right">
	<?php $form = $this->beginWidget('ActiveForm', array(
		'htmlOptions' => array(
			'class' => 'form-inline',
			'role' => 'form'
		),
		'action' => $this->createUrl('/journey/backend/searchJourney'),
	)); ?>
	<div class="form-group">Insert Either: </div>

	<div class="form-group">
		<?php echo $form->bsTextField($model['form'], 'email', array('placeholder' => 'Email: abc@gmail.com', 'size' => 20)); ?>
	</div>
	<div class="form-group">
		<?php echo $form->bsTextField($model['form'], 'mobileNo', array('placeholder' => 'Mobile Number', 'size' => 16)); ?>
	</div>
	<div class="form-group">
		<?php echo $form->bsTextField($model['form'], 'fullName', array('placeholder' => 'Full Name', 'size' => 16)); ?>
	</div>
	<div class="form-group hidden">
		<?php echo $form->bsTextField($model['form'], 'organization', array('placeholder' => 'Organization', 'size' => 16)); ?>
	</div>
	<?php echo $form->bsBtnSubmit('Search'); ?>

	<?php $this->endWidget(); ?>
</div>
</div>

<div class="row margin-top-2x">
	<div class="col col-sm-10">
		<?php if (!empty($model['profiles'])): ?>
		Matched:
		<?php foreach ($model['profiles'] as $profile): ?>
			<span>
			<?php if ($model['searchMode'] == 'fullName'): ?>
				<a class="label label-primary margin-right-sm" style="display:inline-block" href="<?php echo $this->createUrl('/journey/backend/searchJourney', array('fullName' => "'{$profile->full_name}'")) ?>"><?php echo $profile->full_name ?></a>
			<?php elseif ($model['searchMode'] == 'email'): ?>
				<a class="label label-primary margin-right-sm" style="display:inline-block" href="<?php echo $this->createUrl('/journey/backend/searchJourney', array('email' => $profile->email)) ?>"><?php echo $profile->email ?></a>
			<?php elseif ($model['searchMode'] == 'mobileNo'): ?>
				<a class="label label-primary margin-right-sm" style="display:inline-block" href="<?php echo $this->createUrl('/journey/backend/searchJourney', array('mobileNo' => $profile->mobileNo)) ?>"><?php echo $profile->mobileNo ?></a>
			<?php endif; ?>
			</span>
		<?php endforeach; ?><?php endif; ?>
	</div>
	<div class="col col-sm-2">
		<p class="text-right">Total Events <span class="badge"><?php echo count($model['events']) ?></span></p>
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

			<span class="vertical-date">
				<small><?php echo Html::formatDateTime($event->date_started, 'medium', false) ?></small>
			</span>

		</div>
	</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<p>Here, you can search for one's journey in the ecosystem. As long as his registration/attendance to an event is captured, it will appear in his startup journey timeline.</p>
<?php endif; ?>
<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs = [
	'Events' => ['index'],
	$model->title,
];

$this->menu = [
	[
		'label' => Yii::t('app', 'Manage Event'), 'url' => ['/event/admin'],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	],
	[
		'label' => Yii::t('app', 'Create Event'), 'url' => ['/event/create'],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	],
	[
		'label' => Yii::t('app', 'Update Event'), 'url' => ['/event/update', 'id' => $model->id],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	],
	[
		'label' => Yii::t('app', 'Bulk Insert Registration'), 'url' => ['/eventRegistration/bulkInsert', 'eventId' => $model->id],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'eventRegistration', 'action' => (object)['id' => 'bulkInsert']])
	],
	[
		'label' => Yii::t('app', 'Bulk Insert Organization'), 'url' => ['/eventOrganization/bulkInsert', 'eventId' => $model->id],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'eventOrganization', 'action' => (object)['id' => 'bulkInsert']])
	],
	//array('label'=>Yii::t('app','Delete Event'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
];
?>



<?php foreach ($model->industries as $industry): ?>
	<?php $inputIndustries .= sprintf('<span class="label">%s</span>&nbsp;', $industry->title); ?>
<?php endforeach; ?>


<?php foreach ($model->personas as $persona): ?>
	<?php $inputPersonas .= sprintf('<span class="label">%s</span>&nbsp;', $persona->title); ?>
<?php endforeach; ?>


<?php foreach ($model->startupStages as $startupStage): ?>
	<?php $inputStartupStages .= sprintf('<span class="label">%s</span>&nbsp;', $startupStage->title); ?>
<?php endforeach; ?>

<h1 class="collectible" data-collection-table_name="event" data-collection-ref_id="<?php echo $model->id; ?>"><?php echo Yii::t('backend', 'View Event'); ?></h1>


<div class="row">
<div class="col col-sm-7">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Information'); ?></div>
		<div class="crud-view"><?php $this->widget('application.components.widgets.DetailView', [
			'data' => $model,
			'attributes' => [
				['name' => 'event_group_code', 'type' => 'raw', 'value' => !empty($model->eventGroup) ? Html::link($model->eventGroup->title, ['eventGroup/view', 'id' => $model->eventGroup->id]) : '-'],
				'title',
				'url_website',
				['name' => 'Survey URL', 'type' => 'raw', 'value' => $model->hasSurveyForm() ?
					Html::link(HubEvent::getSurveyFormUrl($model->id, '1Day'), HubEvent::getSurveyFormUrl($model->id, '1Day')) : 'N/A',
				],
				['name' => 'url_register', 'type' => 'raw', 'value' => Html::link($model->getPublicUrl(), $model->getPublicUrl(), ['target' => '_blank'])],
				['name' => 'text_short_desc', 'type' => 'raw', 'value' => nl2br(Html::encodeDisplay($model->text_short_desc))],
				['label' => $model->attributeLabel('date_started'), 'value' => $model->renderDateStarted()],
				['label' => $model->attributeLabel('date_ended'), 'value' => $model->renderDateEnded()],
				['name' => 'is_paid_event', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_paid_event)],
				['name' => 'is_cancelled', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_cancelled)],
				['name' => 'is_survey_enabled', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_survey_enabled)],
				'genre',
				'funnel',

				'at',
				// array('name'=>'address_country_code', 'value'=>!empty($model->country)?$model->country->printable_name:'-'),
				// array('name'=>'address_state_code', 'value'=>!empty($model->state)?$model->state->title:'-'),
				// 'full_address',
				'email_contact',
			],
		]); ?>

		</div>
	</div>

	<!-- address -->
	<div class="panel panel-default margin-bottom-2x">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Address') ?></div>
		<div class="crud-view">
		<?php $this->widget('application.components.widgets.DetailView', array(
			'data' => $model,
			'attributes' => array(
				'full_address',
				'address_line1',
				'address_line2',
				'address_city',
				'address_zip',
				'address_state',
				array('name' => 'address_country_code', 'value' => $model->addressCountry->printable_name),
			),
		)); ?>
		<?php if (!empty($model->latlong_address[0]) && !empty($model->latlong_address[1])): ?>
			<?php echo Html::mapView('map-eventAddress', $model->latlong_address[0], $model->latlong_address[1]) ?>
		<?php endif; ?>
		</div>
	</div>
	<!-- /address -->


	<!-- owner -->
	<div class="ibox m2mBox">
		<div class="ibox-title">
			<h5><?php echo $model->getAttributeLabel('owners'); ?></h5>
			<a class="btn btn-xs btn-success pull-right" href="<?php echo $this->createUrl('eventOwner/create', ['eventCode' => $model->code]); ?>">Add</a>
		</div>
		<div class="ibox-content nopadding">
		<?php if (!empty($model->eventOwners)): ?><table class="table table-striped">
			<?php foreach ($model->eventOwners as $eventOwner):?>
			<tr>
				<td>
					<a href="<?php echo $this->createUrl('organization/view', ['id' => $eventOwner->organization->id]); ?>"><?php echo $eventOwner->organization->title; ?></a><?php if (!empty($eventOwner->department)): ?> \ <?php echo $eventOwner->department; ?><?php endif; ?>
					<span class="label label-default label-sm">&nbsp;<?php echo $eventOwner->as_role_code ?></span>
				</td>
				<td class="width-lg text-center">
					<span class="btn-group btn-group-xs"><a class="btn btn-white" href="<?php echo $this->createUrl('/eventOwner/update', ['id' => $eventOwner->id]); ?>">Edit</a> <a class="btn btn-danger" href="<?php echo $this->createUrl('/eventOwner/delete', ['id' => $eventOwner->id]); ?>">Delete</a></span>
				</td>
			</tr>
		<?php endforeach; ?></table><?php endif; ?>
		</div>
	</div>
	<!-- /owner -->

</div>
<div class="col col-sm-5">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Record Details'); ?></div>
		<div class="crud-view"><?php $this->widget('application.components.widgets.DetailView', [
			'data' => $model,
			'attributes' => [
				'id',
				'code',
				'vendor',
				'vendor_code',
				['name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)],

				['label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')],
				['label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')],

				['name' => 'backend', 'label' => sprintf('%s %s', Html::faIcon('fa-tag'), $model->attributeLabel('backend')), 'type' => 'raw', 'value' => Html::csvArea('backend', $model->backend->toString())],
			],
		]); ?>

		</div>
	</div>

	<?php if (!empty($inputIndustries)): ?>
	<div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('industries'); ?></h5></div>
		<div class="ibox-content">
			<?php echo $inputIndustries; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if (!empty($inputPersonas)): ?>
	<div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('personas'); ?></h5></div>
		<div class="ibox-content">
			<?php echo $inputPersonas; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if (!empty($inputStartupStages)): ?>
	<div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('startupStages'); ?></h5></div>
		<div class="ibox-content">
			<?php echo $inputStartupStages; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
</div>


<?php if (!empty($model->eventRegistrations)): ?>
<div class="row"><div class="col col-xs-12 margin-top-lg">
<?php
	$totalRegistrations = count($model->eventRegistrations);
	$totalAttended = count($model->eventRegistrationsAttended);
?>

<span class="pull-right">
	<span class="label label-primary"><?php echo $totalRegistrations; ?></span> Registered
	<span class="label label-success"><?php echo $totalAttended; ?></span> Attended
	<span class="label label-default"><?php echo sprintf('%.2f', ($totalAttended / $totalRegistrations) * 100); ?>%</span> Turnout
	<span class="margin-left-2x">
		<a class="btn btn-xs btn-default" href="<?php echo $this->createUrl('event/exportRegistration', array('id' => $model->id)) ?>">Export Data</a>
	</span>
</span>
<h3><?php echo Html::faIcon('fa fa-user'); ?> Individual Participants</h3>

<?php if ($model->countRegistrationNoNationality > 0 || $model->countRegistrationNoEmail > 0 || $model->countRegistrationNoName > 0):?>
<div class="alert alert-warning">
	<strong>Data Quality Issue:</strong>&nbsp;
	<?php if ($model->countRegistrationNoNationality > 0): ?><span class="label label-warning"><?php echo $model->countRegistrationNoNationality; ?></span> No Nationality<?php endif; ?>
	<?php if ($model->countRegistrationNoEmail > 0): ?><span class="label label-warning"><?php echo $model->countRegistrationNoEmail; ?></span> No Email<?php endif; ?>
	<?php if ($model->countRegistrationNoName > 0): ?><span class="label label-warning"><?php echo $model->countRegistrationNoName; ?></span> No Name<?php endif; ?>
</div>
<?php endif; ?>

	<?php $this->widget('application.components.widgets.GridView', [
		'id' => 'event-participant-grid',
		'itemsCssClass' => 'table table-striped table-bordered',
		'dataProvider' => $modelEventRegistration->searchRegistration(),
		'enableSorting' => false,
		'columns' => [
			['name' => 'id', 'value' => '($row+1) + ($this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize)', 'headerHtmlOptions' => [], 'header' => 'No'],
			['header' => 'Email', 'value' => '$data->email'],
			['header' => 'Name', 'value' => '$data->full_name'],
			['header' => 'Phone', 'value' => '$data->phone'],
			['header' => 'Company', 'value' => '$data->organization'],
			['header' => 'Attended', 'type' => 'raw', 'htmlOptions' => ['class' => 'text-center'],
				'value' => function ($data) {
					return Html::renderBoolean($data->is_attended);
				}
			],
			[
				'header' => 'Action',
				'htmlOptions' => ['class' => 'text-center'],
				'class' => 'CButtonColumn',
				'template' => '{view}',
				'viewButtonImageUrl' => false,
				'buttons' => [
					'view' => [
						'label' => 'View',
						'url' => 'Yii::app()->createUrl("eventRegistration/view", array("id"=>$data->id))',
						'options' => ['class' => 'btn btn-xs btn-primary'],
					],
				],
			],
		]
	]); ?>
</div></div>
<?php endif; ?>

<?php if ($model->vendor === 'F7'): ?>

	<?php
		$intake = Intake::model()->findByAttributes(['title' => $model->title]);
		$forms = $intake->forms;
		$formNames = [];
		$pipelines = [];
		foreach ($forms as $form) {
			$formNames[$form->slug] = $form->slug;
			foreach ($form->jsonArray_stage as $pipelinesObj) {
				if (!in_array($pipelinesObj->title, $pipelines)) {
					$pipelines[$pipelinesObj->key] = $pipelinesObj->title;
				}
			}
		}
	?>
	<h3><?php echo Yii::t('backend', 'Import Submissions'); ?></h3>

	<form action="/f7/backend/sync2Event" method="POST">
		Form: <?php echo CHtml::dropDownList('form', 'select form', $formNames); ?>

		Pipeline: <?php echo CHtml::dropDownList('pipeline', 'select pipeline', $pipelines); ?>

		Import As: <?php echo CHtml::textField(
		'importAs',
		'Participant',
		['id' => 'importAs', 'width' => 30, 'maxlength' => 30]
	); ?>

		<input type="hidden" name="id_hidden" value="<?php echo Yii::app()->request->getQuery('id'); ?>">
		<input type="hidden" name="title_hidden" value="<?php echo $model->title; ?>">
		<input type="submit" value="import">
	</form>

<?php endif; ?>

<?php if (!empty($model->eventOrganizations)): ?>
	<?php
		foreach ($model->eventOrganizations as $eo):
			if (!$eo->organization->is_active):
				continue;
			endif;
			$buffers[$eo->renderAsRoleCode()][] = $eo;
		endforeach;
	?>

	<div class="row"><div class="col col-xs-12 margin-top-lg">
		<h3><?php echo Html::faIcon('fa fa-briefcase'); ?> <?php echo Yii::t('backend', 'Organization Participants') ?></h3>

		<ul class="nav nav-tabs">
		<?php $j = 0; foreach (array_keys($buffers) as $key): ?>
			<li class="<?php echo ($j == 0) ? 'active' : ''; ?>"><a data-toggle="tab" href="#<?php echo md5($key); ?>"><?php echo $key; ?> <span class="badge badge-default"><?php echo count($buffers[$key]); ?></span></a></li>
		<?php ++$j; endforeach; ?>
		</ul>

		<div class="tab-content">
		<?php $j = 0; foreach (array_keys($buffers) as $key): ?>
			<div id="<?php echo md5($key); ?>" class="tab-pane fade <?php echo ($j == 0) ? ' in active' : ''; ?>">

			<?php
				$dataProvider = new CArrayDataProvider($buffers[$key], [
					'id' => 'id',
					'pagination' => array(
						'pageSize' => 10,
						'pageVar' => str_replace(' ', '_', $key) . '_pages'
					)
				]);

				$this->widget('application.components.widgets.GridView', [
					'id' => 'event-participant-' . str_replace(' ', '-', strtolower($key)) . '-grid',
					'itemsCssClass' => 'table table-striped table-bordered',
					'dataProvider' => $dataProvider,
					'ajaxUpdate' => true,
					'enableSorting' => false,
					'columns' => [
						['name' => 'id', 'value' => '($row+1) + ($this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize)', 'headerHtmlOptions' => [], 'header' => 'No'],
						['header' => 'Name', 'type' => 'raw', 'value' => 'Html::activeThumb($data->organization, \'image_logo\', [\'width\' => 32])', 'headerHtmlOptions' => array('colspan' => '2'), 'htmlOptions' => ['class' => 'text-center']],
						['header' => '', 'value' => 'Html::link($data->organization_name, Yii::app()->createUrl("/organization/view", array("id"=>$data->organization->id)))', 'type' => 'html', 'headerHtmlOptions' => array('style' => 'display:none')],
						['header' => 'Join As', 'value' => '$data->renderAsRoleCode()'],
						['header' => 'Active', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->organization->is_active)', 'htmlOptions' => ['class' => 'text-center']],
						[
							'header' => 'Action',
							'htmlOptions' => ['class' => 'text-center'],
							'class' => 'CButtonColumn',
							'template' => '{view}',
							'viewButtonImageUrl' => false,
							'buttons' => [
								'view' => [
									'label' => 'View',
									'url' => 'Yii::app()->createUrl("eventOrganization/view", array("id"=>$data->id))',
									'options' => ['class' => 'btn btn-xs btn-primary'],
								],
							],
						],
					]
				]);
				?>

				<?php /* ?>
				<table class="table table-bordered table-striped">
				<thead>
				<tr>
					<th>No</th>
					<th colspan="2">Name</th>
					<!--<th>Website</th>-->
					<th>Join As</th>
					<th>Active</th>
					<th class="text-center">Action</th>
				</tr>
				</thead>
				<tbody>
				<?php $i = 0; foreach ($buffers[$key] as $eo): ?>

				<tr>
					<td><?php echo ++$i; ?></td>
					<td class="text-center"><?php echo Html::activeThumb($eo->organization, 'image_logo', ['width' => 32]); ?></td>
					<td><?php echo $eo->organization_name; ?></td>
					<!--<td><?php //echo Html::link($eo->organization->url_website, $eo->organization->url_website)?></td>-->
					<td><?php echo $eo->renderAsRoleCode(); ?></td>
					<td class="text-center"><?php echo Html::renderBoolean($eo->organization->is_active); ?></td>
					<td class="text-center"><a class="btn btn-xs btn-primary" href="<?php echo $this->createUrl('/organization/view', ['id' => $eo->organization_id]); ?>">View</a></td>
				</tr>
				<?php endforeach; ?>
				</tbody>
				</table>
				<?php // */ ?>

			</div>
		<?php ++$j; endforeach; ?>
		</div>
	</div></div>

<?php endif; ?>


<?php if ($model->is_survey_enabled): ?>
<h3><?php echo Html::faIcon('fa fa-file'); ?> Surveys</h3>
<div class="well">
	<form action="<?php echo $this->createUrl('event/sendSurvey', ['eventId' => $model->id]); ?>" method="POST" class="form form-inline">
		<input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>" />
		<?php echo Html::dropDownList('surveyType', '', HubEvent::getSurveyTypesForeignReferList($model->id), ['class' => 'form-control']); ?>
		<input type="submit" class="btn btn-sm btn-success" value="Send" />
	</form>
</div>
<?php endif; ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-new" role="tablist">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : ''; ?>"><a href="#<?php echo $tabModule['key']; ?>" aria-controls="<?php echo $tabModule['key']; ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title']; ?></a></li>
<?php endforeach; ?><?php endforeach; ?>
</ul>
<!-- Tab panes -->
<div class="tab-content padding-lg white-bg">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : ''; ?>" id="<?php echo $tabModule['key']; ?>">
		<?php echo $this->renderPartial($tabModule['viewPath'], ['model' => $model, 'event' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab]); ?>
	</div>
<?php endforeach; ?><?php endforeach; ?>
</div>
<?php
/* @var $this EventGroupController */
/* @var $model EventGroup */

$this->breadcrumbs = [
	'Event Groups' => ['index'],
	$model->title,
];

$this->menu = [
	[
		'label' => Yii::t('app', 'Manage Event Group'), 'url' => ['/eventGroup/admin'],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	],
	[
		'label' => Yii::t('app', 'Create Event Group'), 'url' => ['/eventGroup/create'],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	],
	[
		'label' => Yii::t('app', 'Update Event Group'), 'url' => ['/eventGroup/update', 'id' => $model->id],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	],
	[
		'label' => Yii::t('app', 'Delete Event Group'), 'url' => '#', 'linkOptions' => ['submit' => ['delete', 'id' => $model->id], 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')],
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	],
];
?>


<h1><?php echo Yii::t('backend', 'View Event Group'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', [
	'data' => $model,
	'attributes' => [
		'id',
		'code',
		'title',
		'text_oneliner',
		['name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)],
		'url_website',
		'slug',
		'genre',
		'funnel',
		//'department',
		'participant_type',
		'group_category',
		['label' => $model->attributeLabel('date_started'), 'value' => Html::formatDateTime($model->date_started, 'long', 'medium')],
		['label' => $model->attributeLabel('date_ended'), 'value' => Html::formatDateTime($model->date_ended, 'long', 'medium')],
		['name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)],
		['label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')],
		['label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')],
	],
]); ?>
</div>


<h3>Events
	<span class="">
		<span class="label label-primary"><?php echo count($model->events); ?></span>
	</span>
</h3>

<div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#tab-eventGroupActive" aria-controls="tab-eventGroupActive" role="tab" data-toggle="tab">Active
		<span class="label label-success"><?php echo count($model->eventsActive); ?></span></a></li>
	<li role="presentation"><a href="#tab-eventGroupInactive" aria-controls="tab-eventGroupInactive" role="tab" data-toggle="tab">Draft/Cancelled <span class="label label-danger"><?php echo count($model->eventsInactive); ?></span></a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="tab-eventGroupActive">
		<?php $this->widget('application.components.widgets.GridView', [
			'id' => 'event-group-active-grid',
			'itemsCssClass' => 'table table-striped table-bordered',
			'dataProvider' => $modelEventActiveList->searchActiveOrInactiveEvent(),
			'enableSorting' => false,
			'columns' => [
				['name' => 'id', 'value' => '($row+1) + ($this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize)', 'headerHtmlOptions' => [], 'header' => 'No'],
				['name' => 'date_started', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_started, \'standard\', false)', 'headerHtmlOptions' => ['class' => 'date'], 'filter' => false],
				['header' => 'Code', 'value' => '$data->code'],
				['header' => 'Title', 'value' => '$data->title'],
				['header' => 'Email', 'value' => '$data->email_contact'],
				['header' => 'Vendor', 'value' => '$data->vendor'],
				['header' => 'Participants', 'type' => 'raw', 'htmlOptions' => ['class' => 'text-center'],
					'value' => function ($data) {
						$str = '';
						if ($data->hasEventRegistration()) {
							$str .= Html::faIcon('fa fa-user') . ' ';
							$str .= count($data->eventRegistrationsAttended) . ' / ' . count($data->eventRegistrations);
						}
						if ($data->hasEventOrganization()) {
							$str .= Html::faIcon('fa fa-briefcase') . ' ';
							$str .= count($data->eventOrganizations);
						}

						return $str;
					}
				],
				['header' => 'Active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'htmlOptions' => ['class' => 'text-center']],
				[
					'header' => 'Action',
					'htmlOptions' => ['class' => 'text-center'],
					'class' => 'CButtonColumn',
					'template' => '<div class="btn-group btn-group-xs">{view}{update}</div>',
					'viewButtonImageUrl' => false,
					'updateButtonImageUrl' => false,
					'buttons' => [
						'view' => [
							'label' => 'View',
							'url' => 'Yii::app()->createUrl("event/view", array("id"=>$data->id))',
							'options' => ['class' => 'btn btn-xs btn-primary'], 'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'view']]); }
						],
						'update' => [
							'label' => 'Update',
							'url' => 'Yii::app()->createUrl("event/update", array("id"=>$data->id))',
							'options' => ['class' => 'btn btn-xs btn-default'], 'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'update']]); }
						],
					],
				],
			]
		]); ?>
	</div>

	<div role="tabpanel" class="tab-pane" id="tab-eventGroupInactive">
		<?php $this->widget('application.components.widgets.GridView', [
			'id' => 'event-group-inactive-grid',
			'itemsCssClass' => 'table table-striped table-bordered',
			'dataProvider' => $modelEventInactiveList->searchActiveOrInactiveEvent(),
			'enableSorting' => false,
			'columns' => [
				['name' => 'id', 'value' => '($row+1) + ($this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize)', 'headerHtmlOptions' => [], 'header' => 'No'],
				['name' => 'date_started', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_started, \'standard\', false)', 'headerHtmlOptions' => ['class' => 'date'], 'filter' => false],
				['header' => 'Code', 'value' => '$data->code'],
				['header' => 'Title', 'value' => '$data->title'],
				['header' => 'Email', 'value' => '$data->email_contact'],
				['header' => 'Vendor', 'value' => '$data->vendor'],
				['header' => 'Registration', 'type' => 'raw', 'htmlOptions' => ['class' => 'text-center'],
					'value' => function ($data) {
						return count($data->eventRegistrationsAttended) . ' / ' . count($data->eventRegistrations);
					}
				],
				['header' => 'Active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'htmlOptions' => ['class' => 'text-center']],
				[
					'header' => 'Action',
					'htmlOptions' => ['class' => 'text-center'],
					'class' => 'CButtonColumn',
					'template' => '<div class="btn-group btn-group-xs">{view}{update}</div>',
					'viewButtonImageUrl' => false,
					'updateButtonImageUrl' => false,
					'buttons' => [
						'view' => [
							'label' => 'View',
							'url' => 'Yii::app()->createUrl("event/view", array("id"=>$data->id))',
							'options' => ['class' => 'btn btn-xs btn-primary'], 'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'view']]); }
						],
						'update' => [
							'label' => 'Update',
							'url' => 'Yii::app()->createUrl("event/update", array("id"=>$data->id))',
							'options' => ['class' => 'btn btn-xs btn-default'], 'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'update']]); }
						],
					],
				],
			]
		]); ?>
	</div>

</div>

</div>




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
<?php
	// codemirror
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/lib/codemirror.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/addon/edit/matchbrackets.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/addon/scroll/simplescrollbars.js', CClientScript::POS_END);

	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/javascript/javascript.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/clike/clike.js', CClientScript::POS_END);

	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/lib/codemirror.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/theme/midnight.css');
?>

<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */

$this->breadcrumbs = array(
	'Event Registrations' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Registration'), 'url' => array('/eventRegistration/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Event Registration'), 'url' => array('/eventRegistration/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Event Registration'), 'url' => array('/eventRegistration/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Event Registration'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id, 'returnUrl' => $this->createAbsoluteUrl('/event/view', array('id' => $model->event->id))), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Event Registration'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'event_code', 'type' => 'raw', 'value' => Html::link($model->event->title, $this->createUrl('event/view', array('id' => $model->event->id)))),
		'event_vendor_code',
		'registration_code',
		'full_name',
		'first_name',
		'last_name',
		'email',
		'phone',
		'organization',
		array('name' => 'gender', 'value' => $model->formatEnumGender($model->gender)),
		'age_group',
		'where_found',
		'persona',
		'nationality',
		array('label' => $model->attributeLabel('paid_fee'), 'value' => $model->paid_fee),
		array('name' => 'is_attended', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_attended)),
		array('label' => $model->attributeLabel('date_registered'), 'value' => Html::formatDateTime($model->date_registered, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_payment'), 'value' => Html::formatDateTime($model->date_payment, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),

		// developer only
		array(
			'name' => 'json_original', 'type' => 'raw', 'value' => sprintf('<textarea id="textarea-jsonData" class="full-width" rows="10" disabled>%s</textarea>', nl2br($model->json_original)),
			// 'visible' => Yii::app()->user->isDeveloper
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])
		),
	),
)); ?>

</div>



<div class="px-8 py-6 shadow-panel mt-4">
	<ul class="nav nav-tabs nav-new new-dash-tab" role="tablist">
		<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
		<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
		<?php endforeach; ?><?php endforeach; ?>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content padding-lg white-bg">
		<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
		<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>" id="<?php echo $tabModule['key'] ?>">
			<?php echo $this->renderPartial($tabModule['viewPath'], array('model' => $model, 'member' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab)) ?>
		</div>
		<?php endforeach; ?><?php endforeach; ?>
	</div>
</div>



<?php Yii::app()->clientScript->registerScript('js-f7-update', <<<JS

if(document.getElementById('textarea-jsonData').value != '')
{
	document.getElementById('textarea-jsonData').value = JSON.stringify(JSON.parse(document.getElementById('textarea-jsonData').value), undefined, 4);
	/*var editor = CodeMirror.fromTextArea(document.getElementById("textarea-jsonData"), {
		htmlMode: true,
		lineNumbers: true,
		matchBrackets: true,
		mode: "application/json",
		indentUnit: 4,
		indentWithTabs: true,
		lineWrapping: true,
		scrollbarStyle: 'simple',
		theme:'midnight',
	});*/
}
JS
, CClientScript::POS_READY); ?>
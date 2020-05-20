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
/* @var $this SubmissionController */
/* @var $model FormSubmission */

$this->breadcrumbs = array(
	'Submissions' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Submission'), 'url' => array('/f7/submission/admin'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Submission'), 'url' => array('/f7/submission/create'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Submission'), 'url' => array('/f7/submission/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Submission'), 'url' => array('/f7/submission/delete', 'id' => $model->id),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
	array(
		'label' => Yii::t('app', 'View Form'), 'url' => array('/f7/form/view', 'id' => $model->form->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'form', 'action' => (object)['id' => 'view'], 'module' => (object)['id' => 'f7']])
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Submission'); ?></h1>

<div class="ibox-content text-right">
	<div class="btn-group btn-group-sm">
		<button data-toggle="dropdown" class="btn btn-success dropdown-toggle">Export <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="<?php echo $this->createUrl('exportCsv', array('id' => $model->id)) ?>">CSV</a></li>
			<li><a href="<?php echo $this->createUrl('exportPdf', array('id' => $model->id)) ?>">PDF</a></li>
		</ul>
	</div>
</div>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		array('name' => 'username', 'type' => 'raw', 'value' => sprintf('<a href="%s">#%s - %s (%s)</a>', Yii::app()->createUrl('/member/view', array('id' => $model->user->id)), $model->user->id, $model->user->username, $model->user->profile->full_name)),
		array('name' => 'stage', 'type' => 'raw', 'value' => $model->formatEnumStage($model->stage)),
		array('name' => 'status', 'value' => $model->formatEnumStatus($model->status)),
		//
		array('label' => $model->attributeLabel('date_submitted'), 'value' => Html::formatDateTime($model->date_submitted, 'long', 'medium', '-', $model->form->timezone)),

		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),

		array('name' => 'Submitted Data', 'type' => 'raw', 'value' => sprintf('<div class="white-bg padding-xlg margin-bottom-2x border">%s</div>', $model->renderJsonData('html', 'backend'))),

		// developer only
		array(
			'name' => 'json_data', 'type' => 'raw', 'value' => sprintf('<textarea id="textarea-jsonData" class="full-width" rows="10" disabled>%s</textarea>', nl2br($model->json_data)),
			// 'visible' => Yii::app()->user->isDeveloper
			'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])
		),
	),
)); ?>
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
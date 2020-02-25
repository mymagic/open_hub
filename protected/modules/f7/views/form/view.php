<?php
/* @var $this FormController */
/* @var $model Form */

$this->breadcrumbs = array(
	'Forms' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Form'), 'url' => array('/f7/form/admin')),
	array('label' => Yii::t('app', 'Create Form'), 'url' => array('/f7/form/create')),
	array('label' => Yii::t('app', 'Update Form'), 'url' => array('/f7/form/update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Form'), 'url' => array('/f7/form/delete', 'id' => $model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Form'); ?></h1>


<div class="row">
<div class="col col-sm-8">
	<div class="crud-view">
	<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
			'id',
			'code',
			'slug',
			array('name' => 'intake', 'type' => 'raw', 'value' => sprintf('<a href="%s">%s</a>', Yii::app()->createUrl('/f7/intake/view', array('id' => $model->getIntake()->id)), $model->getIntake()->title), 'visible' => $model->hasIntake()),
			'title',
			array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
			array('name' => 'text_note', 'type' => 'raw', 'value' => nl2br($model->text_note)),

			'timezone',
			array('label' => $model->attributeLabel('date_open'), 'value' => Html::formatDateTimezone($model->date_open, 'long', 'medium', '-', $model->timezone)),
			array('label' => $model->attributeLabel('date_close'), 'value' => Html::formatDateTimezone($model->date_close, 'long', 'medium', '-', $model->timezone)),

			array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
			array('name' => 'Survey', 'type' => 'raw', 'value' => Html::renderBoolean($model->type)),
			array('name' => 'is_multiple', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_multiple)),
			array('name' => 'is_login_required', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_login_required)),
			//array('name'=>'json_structure', 'type'=>'raw', 'value'=>nl2br($model->json_structure)),

			array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
			array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
			array('name' => 'Public URL', 'type' => 'raw', 'value' => Html::link($model->getPublicUrl(), $model->getPublicUrl())),
			array('name' => 'json_stage', 'type' => 'raw', 'value' => $model->renderStages('html')),

			//array('name'=>'inputIndustries', 'type'=>'raw', 'value'=>$inputIndustries),
			//array('name'=>'inputPersonas', 'type'=>'raw', 'value'=>$inputPersonas),
			//array('name'=>'inputStartupStages', 'type'=>'raw', 'value'=>$inputStartupStages),
			//array('name'=>'inputImpacts', 'type'=>'raw', 'value'=>$inputImpacts),
		),
	)); ?>
	</div>
</div>

</div>

<form class="pull-right" action="<?php echo $this->createUrl('export', array('id' => $model->id)) ?>" method="GET">
	<button class="btn btn-xs btn-success" type="submit" value="">Export All <span class="badge badge-primary"><?php echo count($model->formSubmissions) ?></span></button>
</form>

<form style="margin-right:5px" class="pull-right" action="<?php echo $this->createUrl('import', array('id' => $model->id)) ?>" method="GET">
	<button class="btn btn-xs btn-primary" type="submit" value="">Import all to Central <span class="badge badge-primary"><?php echo count($model->formSubmissions) ?></span></button>
</form>

<h3><?php echo Html::faIcon('fa fa-file-alt') ?> Submissions</h3>


<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'submission-grid',
	'dataProvider' => $modelSubmission->search(),
	'filter' => $modelSubmission,
	'viewData' => array('formId' => $model->id),
	'columns' => array(
		'id',
		array('name' => 'username', 'value' => '$data->user->username'),
		// array('name'=>'Details', 'type'=>'raw', 'value'=>'$data->renderBackendDetails()', 'filter'=>false),
		array('name' => 'details', 'type' => 'raw', 'value' => '$data->renderBackendDetails()'),
		array('name' => 'stage', 'value' => '$data->formatEnumStage($data->stage)', 'filter' => $modelSubmission->getEnumStage(false, true)),
		array('name' => 'status', 'value' => '$data->formatEnumStatus($data->status)', 'filter' => $modelSubmission->getEnumStatus(false, true)),
		array('name' => 'date_submitted', 'value' => 'Html::formatDateTimezone($data->date_submitted,  "long", "medium", "-", $data->form->timezone)', 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
				'template' => '{view}{update}',
				'buttons' => array(
					'view' => array('url' => 'Yii::app()->controller->createUrl("/f7/submission/view", array("id"=>$data->id))'),
					'update' => array('url' => 'Yii::app()->controller->createUrl("/f7/submission/update", array("id"=>$data->id))'),
				),
		),
	)
))?>
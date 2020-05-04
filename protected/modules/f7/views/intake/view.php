<?php
/* @var $this IntakeController */
/* @var $model Intake */

$this->breadcrumbs = array(
	'Intakes' => array('index'),
	$model->title,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Intake'), 'url' => array('/f7/intake/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Intake'), 'url' => array('/f7/intake/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Intake'), 'url' => array('/f7/intake/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Intake'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>



<?php foreach ($model->industries as $industry): ?>
	<?php $inputIndustries .= sprintf('<span class="label">%s</span>&nbsp;', $industry->title) ?>
<?php endforeach; ?>


<?php foreach ($model->personas as $persona): ?>
	<?php $inputPersonas .= sprintf('<span class="label">%s</span>&nbsp;', $persona->title) ?>
<?php endforeach; ?>


<?php foreach ($model->startupStages as $startupStage): ?>
	<?php $inputStartupStages .= sprintf('<span class="label">%s</span>&nbsp;', $startupStage->title) ?>
<?php endforeach; ?>


<?php foreach ($model->impacts as $impact): ?>
	<?php $inputImpacts .= sprintf('<span class="label">%s</span>&nbsp;', $impact->title) ?>
<?php endforeach; ?>

<?php foreach ($model->sdgs as $sdg): ?>
	<?php $inputSdgs .= sprintf('<span class="label">%s</span>&nbsp;', $sdg->title) ?>
<?php endforeach; ?>

<h1><?php echo Yii::t('backend', 'View Intake'); ?></h1>


<div class="row">
<div class="col col-sm-8">
	<div class="crud-view">
	<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
			'id',
			'code',
			'slug',
			'title',
			array('name' => 'text_oneliner', 'type' => 'raw', 'value' => nl2br($model->text_oneliner)),
			array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
			array('name' => 'image_logo', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_logo')),
			array('label' => $model->attributeLabel('date_started'), 'value' => Html::formatDateTime($model->date_started, 'long', 'medium')),
			array('label' => $model->attributeLabel('date_ended'), 'value' => Html::formatDateTime($model->date_ended, 'long', 'medium')),
			array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
			array('name' => 'is_highlight', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_highlight)),
			array('name' => 'backend', 'label' => sprintf('%s %s', Html::faIcon('fa-tag'), $model->attributeLabel('backend')), 'type' => 'raw', 'value' => Html::csvArea('backend', $model->backend->toString())),

			array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
			array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),

			//array('name'=>'inputIndustries', 'type'=>'raw', 'value'=>$inputIndustries),
			//array('name'=>'inputPersonas', 'type'=>'raw', 'value'=>$inputPersonas),
			//array('name'=>'inputStartupStages', 'type'=>'raw', 'value'=>$inputStartupStages),
			//array('name'=>'inputImpacts', 'type'=>'raw', 'value'=>$inputImpacts),
		),
	)); ?>
	</div>
</div>
<div class="col col-sm-4">
	<?php if (!empty($inputIndustries)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('industries') ?></h5></div>
		<div class="ibox-content"><?php echo $inputIndustries ?></div>
	</div><?php endif; ?>

	<?php if (!empty($inputPersonas)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('personas') ?></h5></div>
		<div class="ibox-content"><?php echo $inputPersonas ?></div>
	</div><?php endif; ?>

	<?php if (!empty($inputStartupStages)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('startupStages') ?></h5></div>
		<div class="ibox-content"><?php echo $inputStartupStages ?></div>
	</div><?php endif; ?>

	<?php if (!empty($inputImpacts)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('impacts') ?></h5></div>
		<div class="ibox-content"><?php echo $inputImpacts ?></div>
	</div><?php endif; ?>

	<?php if (!empty($inputSdgs)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('sdgs') ?></h5></div>
		<div class="ibox-content"><?php echo $inputSdgs ?></div>
	</div><?php endif; ?>
</div>
</div>




<h2>
<div class="btn-group pull-right">
	<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	Add <span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a href="<?php echo $this->createUrl('/f7/form2Intake/create', array('intakeId' => $model->id)) ?>">Link Existing Form</a></li>
		<li><a href="<?php echo $this->createUrl('/f7/form/create', array('intakeId' => $model->id)) ?>">Create New Form</a></li>
	</ul>
</div>
Forms</h2>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'intake-grid',
	'dataProvider' => $modelForm->search(),
	'viewData' => array('intakeId' => $model->id),
	'columns' => array(
		array('name' => 'form_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->form->title', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Form::model()->getForeignReferList(false, true)),
		array('name' => 'form.date_open', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->form->date_open, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'form.date_close', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->form->date_close, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'form.is_multiple', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->form->is_multiple)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array('name' => 'is_primary', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_primary)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array('name' => 'form.is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->form->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array('name' => 'ordering', 'headerHtmlOptions' => array('class' => 'ordering'),
			'class' => 'application.yeebase.extensions.OrderColumn.OrderColumn',
			'controllerId' => 'form2Intake',
			'filter' => sprintf('form2intake.intake_id=%s', $model->id),
			'redirect' => Yii::app()->controller->createUrl('/f7/intake/view', array('id' => $model->id)),
		),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
				'template' => '{view}{unlink}',
				'buttons' => array(
					'view' => array('url' => 'Yii::app()->controller->createUrl("/f7/form/view", array("intakeId"=>$this->grid->viewData[intakeId], "id"=>$data->form->id))'),
					'unlink' => array('url' => 'Yii::app()->controller->createUrl("/f7/form2Intake/delete", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-xs btn-danger')),
				),
		),
	)))?>
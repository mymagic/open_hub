<?php
/* @var $this IndividualController */
/* @var $model Individual */

$this->breadcrumbs = array(
	'Individuals' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Individual'), 'url' => array('/individual/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Individual'), 'url' => array('/individual/create'),
		// 'visible' => Yii::app()->user->isAdmin,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Individual'), 'url' => array('/individual/update', 'id' => $model->id),
		// 'visible' => Yii::app()->user->isAdmin,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')),
);
?>

<?php foreach ($model->personas as $persona): ?>
	<?php $inputPersonas .= sprintf('<span class="label">%s</span>&nbsp;', $persona->title) ?>
<?php endforeach; ?>

<h1 class="collectible" data-collection-table_name="individual" data-collection-ref_id="<?php echo $model->id; ?>"><?php echo Yii::t('backend', 'View Individual'); ?></h1>

<div class="row">
<div class="col col-sm-7">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Profile') ?></div>
		<div class="crud-view"><?php $this->widget('application.components.widgets.DetailView', array(
			'data' => $model,
			'attributes' => array(
				'full_name',
				array('name' => 'gender', 'value' => $model->formatEnumGender($model->gender)),
				array('name' => 'image_photo', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_photo')),
				array('name' => 'country_code', 'value' => $model->country->printable_name),
				array('name' => 'state_code', 'value' => $model->state->title),
				/*
				array('name' => 'ic_number', 'visible' => Yii::app()->user->isSuperAdmin || Yii::app()->user->isSensitiveDataAdmin),
				array('name' => 'mobile_number', 'visible' => Yii::app()->user->isSuperAdmin || Yii::app()->user->isSensitiveDataAdmin),
				*/
				array('name' => 'ic_number', 'visible' => Yii::app()->user->getState('accessSensitiveData')),
				array('name' => 'mobile_number', 'visible' => Yii::app()->user->getState('accessSensitiveData')),
				array('name' => 'text_address_residential', 'type' => 'raw', 'value' => nl2br($model->text_address_residential)),
				array('name' => 'can_code',  'type' => 'raw', 'value' => Html::renderBoolean($model->can_code)),
			),
		)); ?></div>
	</div>
</div>
<div class="col col-sm-5">
	<!-- details -->
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Record Details') ?></div>
		<div class="crud-view"><?php $this->widget('application.components.widgets.DetailView', array(
			'data' => $model,
			'attributes' => array(
				'id',
				array('name' => 'backend', 'label' => sprintf('%s %s', Html::faIcon('fa-tag'), $model->attributeLabel('backend')), 'type' => 'raw', 'value' => Html::csvArea('backend', $model->backend->toString())),
				array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
				array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
				array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
			),
		)); ?></div>
	</div>
	<!-- /details -->

	<?php if (!empty($inputPersonas)): ?>
	<div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('personas') ?></h5></div>
		<div class="ibox-content">
			<?php echo $inputPersonas ?>
		</div>
	</div>
	<?php endif; ?>

	<h3>Linked Email<small></small></h3>
	<div class="panel panel-default new-panel">
		<div class="panel-heading"><h3 class="panel-title">Insert New Email</h3></div>
		<div class="panel-body">
			<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'addIndividual2Email')): ?>
				<div class="form"><?php $individual2Email = new Individual2Email; $form = $this->beginWidget('ActiveForm', array(
						'action' => $this->createUrl('individual/addIndividual2Email', array('individualId' => $model->id, 'realm' => $realm)),
						'method' => 'POST',
						'htmlOptions' => array('class' => 'form-inline')
					)); ?>

					<div class="form-group">
						<?php echo $form->bsTextField($individual2Email, 'user_email', array('placeholder' => 'Email')) ?>
					</div>
					<button type="submit" class="btn btn-success">Add</button>

				<?php $this->endWidget(); ?></div>

				<p class="text-muted">
				You can add new email to this individual profile.
				</p>
			<hr />
			<?php endif; ?>

			<div class="row text-muted">
				<div class="col-xs-3"><span>Legend:</span></div>
				<div class="col-xs-3 text-center"><span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span> <small>Pending</small></div>
				<div class="col-xs-3 text-center"><span class="text-success"><?php echo Html::faIcon('fa-check-circle') ?></span> <small>Verified</small></div>
			</div>
		</div>
	</div>

	<div id="section-individual2Emails" class="margin-bottom-3x">
		<span class="text-muted"><?php echo Html::faIcon('fa-spinner fa-spin') ?> Loading...</span>
	</div>

	<?php Yii::app()->clientScript->registerScript(
					'backend-individual-view',
		sprintf("$('#section-individual2Emails').load('%s', function(){});", $this->createUrl('individual/getIndividual2Emails', array('individualId' => $model->id, 'realm' => $realm)))
	); ?>
</div>

</div>


<!-- Nav tabs -->
<ul class="nav nav-tabs nav-new" role="tablist">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
<?php endforeach; ?><?php endforeach; ?>
</ul>
<!-- Tab panes -->
<div class="tab-content padding-lg white-bg">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>" id="<?php echo $tabModule['key'] ?>">
		<?php echo $this->renderPartial($tabModule['viewPath'], array('model' => $model, 'individual' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab, 'inputImpacts' => $inputImpacts, 'inputSdgs' => $inputSdgs, 'inputPersonas' => $inputPersonas, 'inputIndustries' => $inputIndustries)) ?>
	</div>
<?php endforeach; ?><?php endforeach; ?>
</div>
<?php if ($realm == 'backend'): ?>
<div class="row">
<div class="col col-md-7 margin-bottom-lg">
	
	<?php if ($model->score_completeness < 100): ?>
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Profile Completeness Score') ?></div>
		<div class="panel-body">
			<div class="progress-bar-container">
					<div style="width:<?php echo $model->score_completeness ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $model->score_completeness ?>" role="progressbar" class="progress-bar progress-bar-<?php echo ($model->score_completeness == 100) ? 'primary' : 'warning' ?>">
						<?php echo $model->score_completeness ?>% 
						<span class="sr-only"><?php echo $model->score_completeness ?>% Completed</span>
					</div>
			</div>
			<?php 
				$tmp = $model->calcProfileCompletenessScore();
				$count = 0;
				foreach ($tmp['check'] as $key => $msg) {
					$count++;
				}
			?>

			<div><b>You have completed <?php echo $count ?> out of 10 profile requirement</b><br />
			Increase your profile strength to improve visibility on our platform services.
			<a class="margin-top-2x pull-right" href="<?php echo Yii::app()->createUrl('/organization/update', array('id' => $organization->id)) ?>">Update</a>
			</div>

		</div>
	</div>
	<?php endif; ?>

	<!-- profile -->
	<div class="panel panel-default margin-bottom-2x">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Profile') ?></div>
		<div class="crud-view">
		<?php $this->widget('application.components.widgets.DetailView', array(
			'data' => $model,
			'attributes' => array(
				'title',
				'text_oneliner',
				array('name' => 'legalform_id', 'value' => $model->legalform->title),
				'legal_name',
				'company_number',
				'year_founded',
				array('name' => 'image_logo', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_logo')),
				array('name' => 'url_website', 'type' => 'raw', 'value' => Html::link($model->url_website, $model->url_website, array('target' => '_blank'))),
				'email_contact',
				array('name' => 'text_short_description', 'type' => 'raw', 'value' => Html::encodeDisplay($model->text_short_description)),
				array('name' => 'inputPersonas', 'type' => 'raw', 'value' => $inputPersonas),
				array('name' => 'inputIndustries', 'type' => 'raw', 'value' => $inputIndustries),
				array('name' => 'inputImpacts', 'type' => 'raw', 'value' => $inputImpacts),
				array('name' => 'inputSdgs', 'type' => 'raw', 'value' => $inputSdgs),
			),
		)); ?>
		</div>
	</div>
	<!-- /profile -->
	
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
				array('name' => 'address_country_code', 'value' => $model->country->printable_name),
			),
		)); ?>
		<?php if (!empty($model->latlong_address[0]) && !empty($model->latlong_address[1])): ?>
			<?php echo Html::mapView('map-organizationAddress', $model->latlong_address[0], $model->latlong_address[1]) ?>
		<?php endif; ?>
		</div>
	</div>
	<!-- /address -->

	
</div>


<div class="col col-md-5">

	<!-- details -->
	<div class="panel panel-default margin-bottom-2x">
		<div class="panel-heading"><?php echo Yii::t('backend', 'Record Details') ?></div>
		<div class="crud-view">
		<?php $this->widget('application.components.widgets.DetailView', array(
			'data' => $model,
			'attributes' => array(
				'id',
				'code',
				array('name' => 'backend', 'label' => sprintf('%s %s', Html::faIcon('fa-tag'), $model->attributeLabel('backend')), 'type' => 'raw', 'value' => Html::csvArea('backend', $model->backend->toString())),
				array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
				array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
				array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
			),
		)); ?>
		</div>
	</div>
	<!-- /details -->

	<h3>Users <small>(with access right)</small></h3>
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Invite New Email</h3></div>
		<div class="panel-body">
			<div class="form"><?php $organization2Email = new Organization2Email; $form = $this->beginWidget('ActiveForm', array(
					'action' => $this->createUrl('organization/addOrganization2Email', array('organizationId' => $model->id, 'realm' => $realm)),
					'method' => 'POST',
					'htmlOptions' => array('class' => 'form-inline')
				)); ?>
			
				<div class="form-group">
					<?php echo $form->bsTextField($organization2Email, 'user_email', array('placeholder' => 'Email')) ?>
				</div>
				<button type="submit" class="btn btn-success">Add</button>
			
			<?php $this->endWidget(); ?></div>

			<p class="text-muted">
			You can add new user to manage this organization along with you by insert his/her email address here. If this email belongs to not registered user, he/she will automatically grant access after signup.
			</p>

			<hr />
			<div class="row text-muted">
				<div class="col-xs-3"><span>Legend:</span></div>
				<div class="col-xs-3 text-center"><span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span> <small>Pending</small></div>
				<div class="col-xs-3 text-center"><span class="text-success"><?php echo Html::faIcon('fa-check-circle') ?></span> <small>Approve</small></div>
				<div class="col-xs-3 text-center"><span class="text-danger"><?php echo Html::faIcon('fa-minus-circle') ?></span> <small>Reject</small></div>
			</div>
		</div>
	</div>

	<div id="section-organization2Emails" class="margin-bottom-3x">
		<span class="text-muted"><?php echo Html::faIcon('fa-spinner fa-spin') ?> Loading...</span>
	</div>
	
	<?php Yii::app()->clientScript->registerScript(
					'backend-organization-view',
		sprintf("$('#section-organization2Emails').load('%s', function(){});", $this->createAbsoluteUrl('organization/getOrganization2Emails', array('organizationId' => $model->id, 'realm' => $realm)))
	); ?>

	
</div>
</div><!-- /.row -->

<?php endif; ?>

<?php if ($realm == 'cpanel'): ?>

    <div class="sidebard-panel left-bar">
		 <div id="header" class="my-org-active">
		 	<h3 class="my-org-name"><?php echo $model->title ?>
		 		<span class="hidden-desk">
		                <a class="container-arrow scroll-to" href="#">
		                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
		                </a></span>
		    </h3>
		 	<a href="<?php echo Yii::app()->createUrl('/organization/select') ?>">
				<h4 class="change-org"><?php echo Yii::t('app', 'Change Organization')?></h4>
			</a>
		 </div>
        <div id="content-services">
            <div class="header-org" class="margin-top-lg">
		         	<?php 

					$this->widget('zii.widgets.CMenu', array(
					'items' => array(
							array('label' => sprintf('%s', Yii::t('app', 'Overview')), 'url' => array('/organization/view', 'id' => $model->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'view') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
							array('label' => sprintf('%s', Yii::t('app', 'Update')), 'url' => array('/organization/update', 'id' => $model->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'update') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
							array('label' => sprintf('%s', Yii::t('app', 'Manage Products')), 'url' => array('/product/adminByOrganization', 'organization_id' => $model->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'product-adminByOrganization') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
							array('label' => sprintf('%s', Yii::t('app', 'Create Product')), 'url' => array('/product/create', 'organization_id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'product-create') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
							array('label' => sprintf('%s', Yii::t('app', 'Manage Resources')), 'url' => array('/resource/resource/adminByOrganization', 'organization_id' => $model->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'resource-adminByOrganization') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
							array('label' => sprintf('%s', Yii::t('app', 'Create Resource')), 'url' => array('/resource/resource/create', 'organization_id' => $model->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'resource-create') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu'))),
					));
					 ?>
		
		</div>
        </div>
    </div>


<div class="wrapper wrapper-content content-bg content-left-padding">
	<div class="org-padding">
		<div class="row">
<div class="col col-md-11 margin-bottom-lg">
  <h2 style="margin-top: 22px; margin-left: 10px; max-width: 700px;margin-right: 50px;"><?php echo $organization->title ?>
	<?php if (!empty($model->image_logo)): ?>
		<span class="pull-right org-logo-img"><?php echo Html::activeThumb($model, 'image_logo') ?></span>
	<?php endif; ?>
  </h2>
  
</div></div>
<div class="row">
<div class="col col-md-12 margin-bottom-lg">

	<div class="panel panel-default" style="width:90%;">
		<div class="panel-heading"><?php echo Yii::t('cpanel', 'Your profile strength') ?></div>
		<div class="panel-body">
			<div class="progress-bar-container">
					<div style="width:<?php echo $model->score_completeness ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $model->score_completeness ?>" role="progressbar" class="progress-bar progress-bar-<?php echo ($model->score_completeness == 100) ? 'primary' : 'warning' ?>">
						<?php echo $model->score_completeness ?>% 
						<span class="sr-only"><?php echo $model->score_completeness ?>% Completed</span>
					</div>
			</div>
			<?php 
				$tmp = $model->calcProfileCompletenessScore();
				$count = 0;
				foreach ($tmp['check'] as $key => $msg) {
					$count++;
				}
			?>

			<?php if ($model->score_completeness < 100):?>
			<b>You have completed <?php echo $count ?> out of 10 profile requirement</b><br />
			Increase your profile strength to improve visibility on our platform services.
			<a class="margin-top-2x pull-right" href="<?php echo Yii::app()->createUrl('/organization/update', array('id' => $organization->id, 'realm' => 'cpanel')) ?>">Update</a>
			<?php endif; ?>

		</div>
	</div>


	<div class="crud-view my-org">
	<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
			// 'title',
			// array('name'=>'score_completeness', 'type'=>'raw', 'value'=>$scoreBar),
			// echo $model->score_completeness.'<br>';
			'text_oneliner',
			array('name' => 'legalform_id', 'value' => $model->legalform->title),
			'company_number',
			// array('name'=>'image_logo', 'type'=>'raw', 'value'=>Html::activeThumb($model, 'image_logo')),
			array('name' => 'url_website', 'type' => 'raw', 'value' => Html::link($model->url_website, $model->url_website, array('target' => '_blank'))),
			'email_contact',
			array('name' => 'text_short_description', 'type' => 'raw', 'value' => Html::encodeDisplay($model->text_short_description)),
			array('name' => 'inputPersonas', 'type' => 'raw', 'value' => $inputPersonas),
			array('name' => 'inputIndustries', 'type' => 'raw', 'value' => $inputIndustries),
			array('name' => 'inputImpacts', 'type' => 'raw', 'value' => $inputImpacts),
			array('name' => 'inputSdgs', 'type' => 'raw', 'value' => $inputSdgs),
		),
	)); ?>
		
</div>

	

<?php if ($realm == 'backend'): ?>
	<div class="crud-view">
	<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
			'id',
			'code',
			array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
			array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
			array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
		),
	)); ?>
	</div>
	<?php endif; ?>
</div>
<div class="col col-md-11 org-padding">

	<h3>Users <small>(with access right)</small></h3>
	<div class="panel panel-default new-panel">
		<div class="panel-heading"><h3 class="panel-title">Invite New Email</h3></div>
		<div class="panel-body">
			<div class="form"><?php $organization2Email = new Organization2Email; $form = $this->beginWidget('ActiveForm', array(
					'action' => $this->createUrl('organization/addOrganization2Email', array('organizationId' => $model->id, 'realm' => $realm)),
					'method' => 'POST',
					'htmlOptions' => array('class' => 'form-inline')
				)); ?>
			
				<div class="form-group">
					<?php echo $form->bsTextField($organization2Email, 'user_email', array('placeholder' => 'Email')) ?>
				</div>
				<button type="submit" class="btn btn-success">Add</button>
			
			<?php $this->endWidget(); ?></div>

			<p class="text-muted">
			You can add new user to manage this organization along with you by insert his/her email address here. If this email belongs to not registered user, he/she will automatically grant access after signup.
			</p>

			<hr />
			<div class="row text-muted">
				<div class="col-xs-3"><span>Legend:</span></div>
				<div class="col-xs-3 text-center"><span class="text-info"><?php echo Html::faIcon('fa-circle-o') ?></span> <small>Pending</small></div>
				<div class="col-xs-3 text-center"><span class="text-success"><?php echo Html::faIcon('fa-check-circle') ?></span> <small>Approve</small></div>
				<div class="col-xs-3 text-center"><span class="text-danger"><?php echo Html::faIcon('fa-minus-circle') ?></span> <small>Reject</small></div>
			</div>
		</div>
	</div>

	<div id="section-organization2Emails" class="">
		<span class="text-muted"><?php echo Html::faIcon('fa-spinner fa-spin') ?> Loading...</span>
	</div>
	
	<?php Yii::app()->clientScript->registerScript(
					'backend-organization-view',
		sprintf("$('#section-organization2Emails').load('%s', function(){});", $this->createUrl('organization/getOrganization2Emails', array('organizationId' => $model->id, 'realm' => $realm)))
	); ?>

	
</div>

</div><!-- /.row -->
</div>

</div>


<?php endif; ?>



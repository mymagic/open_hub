<div class="sidebard-panel left-bar">
	 	<div id="header" class="my-org-active">
		 	<h3 class="my-org-name"><?php echo $organization->title ?><span class="hidden-desk">
                <a class="container-arrow scroll-to" href="#">
                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a></span></h3>
		 	<a href="<?php echo Yii::app()->createUrl('/organization/select') ?>">
				<h4 class="change-org">Change Company</h4>
			</a>
		</div>
	<div id="content-services">
 	<div class="header-org" class="margin-top-lg">
         	<?php 

			$this->widget('zii.widgets.CMenu', array(
			'items' => array(
					array('label' => sprintf('%s', Yii::t('app', 'Overview')), 'url' => array('/organization/view', 'id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'view') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Update')), 'url' => array('/organization/update', 'id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'update') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Manage Products')), 'url' => array('/product/adminByOrganization', 'organization_id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'product-adminByOrganization') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Create Product')), 'url' => array('/product/create', 'organization_id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'product-create') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Manage Resources')), 'url' => array('/resource/resource/adminByOrganization', 'organization_id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'resource-adminByOrganization') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu')),
					array('label' => sprintf('%s', Yii::t('app', 'Create Resource')), 'url' => array('/resource/resource/create', 'organization_id' => $organization->id, 'realm' => 'cpanel'), 'active' => ($this->activeSubMenuCpanel == 'resource-create') ? true : null, 'linkOptions' => array('class' => 'your-org-subMenu'))),
			));
			 ?>
	 </div>
	</div>
	</div>

	<div class="wrapper wrapper-content content-bg content-left-padding">
	<h3 class="form-header margin-bottom-2x">
		<?php echo Yii::t('backend', 'View Resource'); ?>
		<div class="pull-right btn-group">
			<a class="btn btn-white" href="<?php echo $this->createUrl('/resource/frontend/view', array('id' => $model->id, 'organization_id' => $organization->id))?>" target="_blank">View Webpage</a>
			<a class="btn btn-primary" href="<?php echo $this->createUrl('/resource/resource/update', array('id' => $model->id, 'organization_id' => $organization->id, 'realm' => 'cpanel')) ?>">Update</a>
		</div>
	</h3>


<div class="row">
<div class="col col-sm-8">

	<div class="org-padding">
			<div class="crud-view">
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					'id',
					//'orid',
					//'title',
					'slug',
					//array('name'=>'html_content', 'type'=>'raw', 'value'=>($model->html_content)),
					array('name' => 'image_logo', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_logo', array('method' => 'resize'))),
					'url_website',
					array('name' => 'typefor', 'value' => $model->formatEnumTypefor($model->typefor)),
					//'owner',
					array('name' => 'is_featured', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_featured)),
					array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
					array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
					array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
				),
			)); ?>


    <?php if (!empty($model->full_address) || !empty($model->latlong_address[0])): ?>
    <div class="row"><div class="col col-xs-12">
	<h3><?php echo $model->getAttributeLabel('full_address') ?></h3>
	<p><?php echo $model->full_address ?></p>
	<?php if (!empty($model->latlong_address[0]) && !empty($model->latlong_address[1])): ?>
		<?php echo Html::mapView('map-resourceAddress', $model->latlong_address[0], $model->latlong_address[1]) ?>
	<?php endif; ?>
    </div></div>
    <?php endif; ?>

    <!-- i18n -->
    <ul class="nav nav-tabs"> 
			
		<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>        
		<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>        
		<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>         
	</ul> 
	<div class="tab-content"> 
		
		<!-- English --> 
		<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane active" id="pane-en"> 

		<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
				'title_en',
			array('name' => 'html_content_en', 'type' => 'raw', 'value' => $model->html_content_en),
		),
	)); ?> 
		
		</div> 
		<?php endif; ?>
		<!-- /English --> 
			
		
		<!-- Bahasa --> 
		<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane " id="pane-ms"> 

		<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
				'title_ms',
			array('name' => 'html_content_ms', 'type' => 'raw', 'value' => $model->html_content_ms),
		),
	)); ?> 
		
		</div> 
		<?php endif; ?>
		<!-- /Bahasa --> 
			
		
		<!-- 中文 --> 
		<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane " id="pane-zh"> 

		<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
			),
	)); ?> 
		
		</div> 
		<?php endif; ?>
		<!-- /中文 --> 
			

    </div> 
    <!-- /i18n -->


	</div>
	</div>
</div>
<div class="col col-sm-4">
	<?php if (!empty($inputOrganizations)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('organizations') ?></h5></div>
		<div class="ibox-content"><?php echo $inputOrganizations ?></div>
	</div><?php endif; ?>

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

	<?php if (!empty($inputResourceCategories)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('resourceCategories') ?></h5></div>
		<div class="ibox-content"><?php echo $inputResourceCategories ?></div>
	</div><?php endif; ?>

	<?php if (!empty($inputResourceGeofocuses)): ?><div class="ibox m2mBox">
		<div class="ibox-title"><h5><?php echo $model->getAttributeLabel('geoFocuses') ?></h5></div>
		<div class="ibox-content"><?php echo $inputResourceGeofocuses ?></div>
	</div><?php endif; ?>

</div>
</div>

	</div>
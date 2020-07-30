<h1 class="collectible" data-collection-table_name="resource" data-collection-ref_id="<?php echo $model->id; ?>"><?php echo Yii::t('backend', 'View Resource'); ?></h1>


<div class="row">
<div class="col col-sm-8">

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
			array('name' => 'is_blocked', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_blocked)),
			array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
			array('name' => 'url', 'type' => 'raw', 'value' => Html::link($model->getFrontendUrl(Yii::app()->controller), $model->getFrontendUrl(Yii::app()->controller))),
			array('name' => 'backend', 'label' => sprintf('%s %s', Html::faIcon('fa-tag'), $model->attributeLabel('backend')), 'type' => 'raw', 'value' => Html::csvArea('backend', $model->backend->toString())),
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


<!-- Nav tabs -->
<ul class="nav nav-tabs nav-new" role="tablist">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo $tabModule['title'] ?></a></li>
<?php endforeach; ?><?php endforeach; ?>
</ul>
<!-- Tab panes -->
<div class="tab-content padding-lg white-bg">
<?php foreach ($tabs as $tabModuleKey => $tabModules): ?><?php foreach ($tabModules as $tabModule): ?>
	<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>" id="<?php echo $tabModule['key'] ?>">
		<?php echo $this->renderPartial($tabModule['viewPath'], array('model' => $model, 'resource' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab,
		'inputOrganizations' => $inputOrganizations, 'inputImpacts' => $inputImpacts, 'inputSdgs' => $inputSdgs, 'inputPersonas' => $inputPersonas, 'inputIndustries' => $inputIndustries)) ?>
	</div>
<?php endforeach; ?><?php endforeach; ?>
</div>
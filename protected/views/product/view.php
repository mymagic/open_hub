<?php
/* @var $this ProductController */
/* @var $model Product */
if($realm == 'backend')
{
    $this->breadcrumbs=array(
        Yii::t('backend', 'Products')=>array('index'),
        Yii::t('backend', 'Manage'),
    );
    $this->renderPartial('/organization/_menu',array('model'=>$model, 'organization'=>$organization, 'realm'=>$realm));
}
elseif($realm == 'cpanel')
{
	$this->breadcrumbs=array(
		'Organization'=>array('index'),
		$organization->title=>array('organization/view', 'id'=>$organization->id, 'realm'=>$realm),
		Yii::t('backend', 'Products')=>array('adminByOrganization', 'organization_id'=>$organization->id, 'realm'=>$realm),
		$model->title,
	);
	$this->renderPartial('/cpanel/_menu',array('model'=>$model, 'organization'=>$organization, 'realm'=>$realm));
}
?>


<?php if($realm == 'cpanel'): ?>

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
			'items'=>array(
					array('label'=>sprintf('%s', Yii::t('app', 'Overview')), 'url'=>array('/organization/view', 'id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='view')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Update')), 'url'=>array('/organization/update', 'id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='update')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Manage Products')), 'url'=>array('/product/adminByOrganization', 'organization_id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='product-adminByOrganization')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Create Product')), 'url'=>array('/product/create', 'organization_id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='product-create')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Manage Resources')), 'url'=>array('/resource/resource/adminByOrganization', 'organization_id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='resource-adminByOrganization')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Create Resource')), 'url'=>array('/resource/resource/create', 'organization_id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='resource-create')?true:null,'linkOptions' => array('class'=>'your-org-subMenu'))),
			));
			 ?>
	 </div>
	</div>
	</div>

<?php endif; ?>


<?php if($realm == 'backend'): ?><h1><?php echo Yii::t('backend', 'View Product'); ?></h1><?php endif; ?>

<?php if($realm == 'cpanel'): ?>
<div class="wrapper wrapper-content content-bg content-left-padding">


<h3 class="form-header"><?php echo Yii::t('backend', 'View Product'); ?></h3>
<div class="org-padding">
	<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'organization_id', 'value'=>$model->organization->title),
		array('name'=>'product_category_id', 'value'=>$model->productCategory->title),
		'title',
		array('name'=>'text_short_description', 'type'=>'raw', 'value'=>nl2br($model->text_short_description)),
		array('name'=>'typeof', 'value'=>$model->formatEnumTypeof($model->typeof)),
		array('name'=>'image_cover', 'type'=>'raw', 'value'=>Html::activeThumb($model, 'image_cover')),
		'url_website',
		array('name'=>'price', 'type'=>'raw', 'value'=>$model->renderPrice()),
		array('name'=>'is_active', 'type'=>'raw', 'value'=>Html::renderBoolean($model->is_active)), 
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>

<?php if(Yii::app()->user->isDeveloper): ?>
<div class="crud-view">
<?php if(!empty($model->_metaStructures)):?>
<h2><?php echo Yii::t('core', 'Meta Data') ?></h2>
<?php echo Notice::inline(Yii::t('notice','Meta Data Only accessible by developer role'), Notice_WARNING) ?>
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>$model->metaItems2DetailViewArray(),
)); ?>
<?php endif; ?>
</div>
<?php endif; ?>

</div>
</div>

</div>
<div class="col-sm-11">
<div class="pull-right margin-bottom-2x">
	<a class="btn btn-default" href="<?php echo $this->createUrl('/product/update', array('id'=>$model->id, 'realm'=>$realm)) ?>">Update</a>
</div>
</div>
<?php endif; ?>

<?php if($realm == 'backend'): ?>
<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'organization_id', 'value'=>$model->organization->title),
		array('name'=>'product_category_id', 'value'=>$model->productCategory->title),
		'title',
		array('name'=>'text_short_description', 'type'=>'raw', 'value'=>nl2br($model->text_short_description)),
		array('name'=>'typeof', 'value'=>$model->formatEnumTypeof($model->typeof)),
		array('name'=>'image_cover', 'type'=>'raw', 'value'=>Html::activeThumb($model, 'image_cover')),
		'url_website',
		array('name'=>'price', 'type'=>'raw', 'value'=>$model->renderPrice()),
		array('name'=>'is_active', 'type'=>'raw', 'value'=>Html::renderBoolean($model->is_active)), 
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>

<?php if(Yii::app()->user->isDeveloper): ?>
<div class="crud-view">
<?php if(!empty($model->_metaStructures)):?>
<h2><?php echo Yii::t('core', 'Meta Data') ?></h2>
<?php echo Notice::inline(Yii::t('notice','Meta Data Only accessible by developer role'), Notice_WARNING) ?>
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>$model->metaItems2DetailViewArray(),
)); ?>
<?php endif; ?>
</div>
<?php endif; ?>

</div>
<?php endif; ?>
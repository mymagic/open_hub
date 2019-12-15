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

<?php if($realm == 'backend'): ?><h1><?php echo Yii::t('backend', 'Update Product'); ?></h1><?php endif; ?>

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

	<div class="wrapper wrapper-content content-bg content-left-padding">
		<h3 class="form-header"><?php echo Yii::t('backend', 'Update Product'); ?></h3>

		<?php $this->renderPartial('_formCpanel', array('model'=>$model, 'realm'=>$realm)); ?>	
	</div>
<?php elseif($realm == 'backend'): ?>
	<?php $this->renderPartial('_form', array('model'=>$model, 'realm'=>$realm)); ?>
<?php endif; ?>
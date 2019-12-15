<?php
/* @var $this OrganizationController */
/* @var $model Organization */
if($realm == 'backend')
{
	$this->breadcrumbs=array(
		'Organizations'=>array('index'),
		$model->title=>array('view','id'=>$model->id),
		Yii::t('backend', 'Update'),
	);

	$this->renderPartial('/organization/_menu',array('model'=>$model, 'organization'=>$model, 'realm'=>$realm));
}
elseif($realm == 'cpanel')
{
	$this->breadcrumbs=array(
		'Organization'=>array('index'),
		$model->title,
	);
	$this->renderPartial('/cpanel/_menu',array('model'=>$model, 'organization'=>$model, 'realm'=>$realm));
}
?>

<?php if($realm == 'cpanel'): ?>
	<div class="sidebard-panel left-bar">
 	<div id="header" class="my-org-active">
		 	<h3 class="my-org-name"><?php echo $model->title ?><span class="hidden-desk">
                <a class="container-arrow scroll-to" href="#">
                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a></span></h3>
		 	<a href="<?php echo Yii::app()->createUrl('/organization/select') ?>">
				<h4 class="change-org"><?php echo Yii::t('app', 'Change Company') ?></h4>
			</a>
	</div>
	<div id="content-services">
 	<div class="header-org" class="margin-top-lg">
         	<?php 

			$this->widget('zii.widgets.CMenu', array(
			'items'=>array(
					array('label'=>sprintf('%s', Yii::t('app', 'Overview')), 'url'=>array('/organization/view', 'id'=>$model->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='view')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Update')), 'url'=>array('/organization/update', 'id'=>$model->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='update')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Manage Products')), 'url'=>array('/product/adminByOrganization', 'organization_id'=>$model->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='product-adminByOrganization')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Create Product')), 'url'=>array('/product/create', 'organization_id'=>$organization->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='product-create')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Manage Resources')), 'url'=>array('/resource/resource/adminByOrganization', 'organization_id'=>$model->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='resource-adminByOrganization')?true:null,'linkOptions' => array('class'=>'your-org-subMenu')),
					array('label'=>sprintf('%s', Yii::t('app', 'Create Resource')), 'url'=>array('/resource/resource/create', 'organization_id'=>$model->id, 'realm'=>'cpanel'), 'active'=>($this->activeSubMenuCpanel=='resource-create')?true:null,'linkOptions' => array('class'=>'your-org-subMenu'))),
			));
			 ?>
	 </div>
	</div>
	</div>

	<div class="wrapper wrapper-content content-bg content-left-padding">
		<h3 class="form-header"><?php echo $this->pageTitle ?></h3>
		<?php $this->renderPartial('_formCpanel', array('model'=>$model)); ?>
	</div>

<?php elseif($realm == 'backend'): ?><h1>
	<?php echo $this->pageTitle ?></h1>
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php endif; ?>



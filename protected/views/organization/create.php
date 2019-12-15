<?php
/* @var $this OrganizationController */
/* @var $model Organization */
if($realm == 'backend')
{
	$this->breadcrumbs=array(
		'Organizations'=>array('index'),
		Yii::t('backend', 'Create'),
	);

	$this->menu=array(
		array('label'=>Yii::t('app','Manage Organization'), 'url'=>array('/organization/admin')),
	);
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
        <div id="header">
            <h2>My Company<span class="hidden-desk">
                <a class="container-arrow scroll-to" href="#">
                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a></span>
            </h2>
        </div>
        <div id="content-services">
            <?php $count=0; foreach($org['organizations']['approve'] as $organization): ?>
            <a class="m-t-md pad-30 green-hov" href="<?php echo $this->createUrl('/organization/view', array('id'=>$organization->id, 'realm'=>'cpanel')) ?>">
            <?php echo $organization->title ?>
                <small><?php echo $organization->text_oneliner ?></small>
                <!--  <h6 class="no-margins">Website</h6> -->
            </a> 
            <?php $count++; endforeach; ?>

            <?php $count=0; foreach($org['organizations']['pending'] as $organization): ?>
            <a class="m-t-md pad-30 green-hov">   
                <!-- <?php echo Html::image(ImageHelper::thumb(50, 50, $organization->image_logo), Yii::t('app', 'Logo Image'), array('class'=>"img-circle m-t-xs img-responsive")); ?>
            --> <?php echo $organization->title ?>
                <small><?php echo $organization->text_oneliner ?></small>

                <span class="label label-primary pull-right badge badge-warning noborder-status">Pending</span>
                <!-- <span class="label label-primary pull-left noborder-status <?php echo empty($organization->url_website)?'disabled':'' ?>"><a href="<?php echo $organization->url_website ?>" class=" <?php echo empty($organization->url_website)?'disabled':'' ?>" target="_blank">Visit</a></span> -->
            </a>
            <?php $count++; endforeach; ?>
        </div>
    </div>

	<div class="wrapper wrapper-content content-bg content-left-padding">
		<h3 class="form-header"><?php echo $this->pageTitle ?></h3>
		<?php $this->renderPartial('_formCpanel', array('model'=>$model)); ?>
	</div>

<?php elseif($realm == 'backend'): ?>

    <h1><?php echo $this->pageTitle ?></h1>
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php endif; ?>




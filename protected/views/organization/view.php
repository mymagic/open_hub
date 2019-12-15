<?php
/* @var $this OrganizationController */
/* @var $model Organization */
if($realm == 'backend')
{
	$this->breadcrumbs=array(
		'Organizations'=>array('index'),
		$model->title,
	);
	$this->renderPartial('/organization/_menu',array('model'=>$model, 'organization'=>$organization, 'realm'=>$realm));
}
elseif($realm == 'cpanel')
{
	$this->breadcrumbs=array(
		'Organization'=>array('index'),
		$model->title,
	);
	$this->renderPartial('/cpanel/_menu',array('model'=>$model, 'organization'=>$organization, 'realm'=>$realm));
}
?>

<?php if($realm == 'backend'): ?><h1 class="collectible" data-collection-table_name="organization" data-collection-ref_id="<?php echo $model->id; ?>"><?php echo $this->pageTitle ?></h1><?php endif; ?>

<?php foreach($model->impacts as $impact): ?>
	<?php $inputImpacts .= sprintf('<span class="label">%s</span>&nbsp;', $impact->title) ?>
<?php endforeach; ?>
<?php foreach($model->sdgs as $sdg): ?>
	<?php $inputSdgs .= sprintf('<span class="label">%s</span>&nbsp;', $sdg->title) ?>
<?php endforeach; ?>
<?php foreach($model->personas as $persona): ?>
	<?php $inputPersonas .= sprintf('<span class="label">%s</span>&nbsp;', $persona->title) ?>
<?php endforeach; ?>
<?php foreach($model->industries as $industry): ?>
	<?php $inputIndustries .= sprintf('<span class="label">%s</span>&nbsp;', $industry->title) ?>
<?php endforeach; ?>


<?php $this->renderPartial('_view-main', array('model'=>$model, 'organization'=>$model, 'actions'=>$actions, 'realm'=>$realm,'inputImpacts'=>$inputImpacts, 'inputSdgs'=>$inputSdgs, 'inputPersonas'=>$inputPersonas, 'inputIndustries'=>$inputIndustries)) ?>

<?php if($realm == 'backend'): ?>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-new" role="tablist">
	<?php foreach($tabs as $tabModuleKey=>$tabModules): ?><?php foreach($tabModules as $tabModule): ?>
		<li role="presentation" class="tab-noborder <?php echo ($tab==$tabModule['key'])?'active':'' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
	<?php endforeach; ?><?php endforeach; ?>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content padding-lg white-bg">
	<?php foreach($tabs as $tabModuleKey=>$tabModules): ?><?php foreach($tabModules as $tabModule): ?>
		<div role="tabpanel" class="tab-pane <?php echo ($tab==$tabModule['key'])?'active':'' ?>" id="<?php echo $tabModule['key'] ?>">
			<?php echo $this->renderPartial($tabModule['viewPath'], array('model'=>$model, 'organization'=>$model, 'user'=>$user, 'actions'=>$actions, 'realm'=>$realm, 'tab'=>$tab, 'inputImpacts'=>$inputImpacts, 'inputSdgs'=>$inputSdgs, 'inputPersonas'=>$inputPersonas, 'inputIndustries'=>$inputIndustries)) ?>
		</div>
	<?php endforeach; ?><?php endforeach; ?>
	</div>
<?php elseif($realm == 'cpanel'): ?>

	<div class="wrapper wrapper-content content-bg content-left-padding">
	<div class="col col-md-11">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-new new-dash-tab" role="tablist">
		<?php foreach($tabs as $tabModuleKey=>$tabModules): ?><?php foreach($tabModules as $tabModule): ?>
			<li role="presentation" class="tab-noborder <?php echo ($tab==$tabModule['key'])?'active':'' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
		<?php endforeach; ?><?php endforeach; ?>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content padding-lg white-bg">
		<?php foreach($tabs as $tabModuleKey=>$tabModules): ?><?php foreach($tabModules as $tabModule): ?>
			<div role="tabpanel" class="tab-pane <?php echo ($tab==$tabModule['key'])?'active':'' ?>" id="<?php echo $tabModule['key'] ?>">
				<?php echo $this->renderPartial($tabModule['viewPath'], array('model'=>$model, 'organization'=>$model, 'user'=>$user, 'actions'=>$actions, 'realm'=>$realm, 'tab'=>$tab, 'inputImpacts'=>$inputImpacts, 'inputSdgs'=>$inputSdgs, 'inputPersonas'=>$inputPersonas, 'inputIndustries'=>$inputIndustries)) ?>
			</div>
		<?php endforeach; ?><?php endforeach; ?>
		</div>
	</div>
	</div>

<?php endif; ?>


<br />
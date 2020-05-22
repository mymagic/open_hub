<?php
/* @var $this OrganizationController */
/* @var $model Organization */
if ($realm == 'backend') {
	$this->breadcrumbs = array(
		'Organizations' => array('index'),
		$model->title,
	);
	$this->renderPartial('/organization/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));
} elseif ($realm == 'cpanel') {
	$this->breadcrumbs = array(
		'Organization' => array('index'),
		$model->title,
	);
}
?>

<?php if ($realm == 'backend') : ?><h1 class="collectible" data-collection-table_name="organization" data-collection-ref_id="<?php echo $model->id; ?>"><?php echo $this->pageTitle ?></h1>

	<?php foreach ($model->impacts as $impact) : ?>
		<?php $inputImpacts .= sprintf('<span class="label">%s</span>&nbsp;', $impact->title) ?>
	<?php endforeach; ?>
	<?php foreach ($model->sdgs as $sdg) : ?>
		<?php $inputSdgs .= sprintf('<span class="label">%s</span>&nbsp;', $sdg->title) ?>
	<?php endforeach; ?>
	<?php foreach ($model->personas as $persona) : ?>
		<?php $inputPersonas .= sprintf('<span class="label">%s</span>&nbsp;', $persona->title) ?>
	<?php endforeach; ?>
	<?php foreach ($model->industries as $industry) : ?>
		<?php $inputIndustries .= sprintf('<span class="label">%s</span>&nbsp;', $industry->title) ?>
	<?php endforeach; ?>

	<?php $this->renderPartial('_view-main', array('model' => $model, 'organization' => $model, 'actions' => $actions, 'realm' => $realm, 'inputImpacts' => $inputImpacts, 'inputSdgs' => $inputSdgs, 'inputPersonas' => $inputPersonas, 'inputIndustries' => $inputIndustries)) ?>

<?php endif; ?>


<?php if ($realm == 'backend') : ?>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-new" role="tablist">
		<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
		<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
		<?php endforeach; ?><?php endforeach; ?>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content padding-lg white-bg">
		<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
		<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>" id="<?php echo $tabModule['key'] ?>">
			<?php echo $this->renderPartial($tabModule['viewPath'], array('model' => $model, 'organization' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab, 'inputImpacts' => $inputImpacts, 'inputSdgs' => $inputSdgs, 'inputPersonas' => $inputPersonas, 'inputIndustries' => $inputIndustries)) ?>
		</div>
		<?php endforeach; ?><?php endforeach; ?>
	</div>
<?php elseif ($realm == 'cpanel') : ?>

	<section>
		<div class="px-8 py-6 shadow-panel">
			<h2>Basic Information</h2>
			<div>
				<div>
					<img src="<?php echo StorageHelper::getUrl($model->image_logo) ?>" style="max-height: 128px" class="my-4">
					<h3><?php echo $model->title ?></h3>
				</div>
				<div class="md:inline-block">
					<div class="inline-flex items-center mr-8 my-2">
						<i class="fa fa-link"></i>
						<div class="ml-4"><?php echo $model->url_website ?></div>
					</div>
					<div class="inline-flex items-center mr-8 my-2">
						<i class="fa fa-envelope"></i>
						<div class="ml-4"><?php echo $model->email_contact ?></div>
					</div>
					<div class="inline-flex items-center mr-8 my-2">
						<span class="label label-success"><?php echo $model->getPublicDisplayStatus('text') ?></span>
						<?php if (!empty($model->year_founded)):  ?><div class="ml-4">Since <?php echo $model->year_founded ?></div><?php endif; ?>
					</div>
				</div>
				<div class="mt-4">
					<h5 class="muted text-uppercase"><?php echo Yii::t('app', 'Organization Oneliner') ?></h5>
					<p class="break-all"><?php echo $model->text_oneliner ?></p>
				</div>
				<div class="mt-4">
					<h5 class="muted text-uppercase"><?php echo Yii::t('app', 'Organization Description') ?></h5>
					<p class="break-all"><?php echo Html::encodeDisplay($model->text_short_description) ?></p>
				</div>
			</div>
		</div>

		<div class="px-8 py-6 shadow-panel mt-4">
			<h2><?php echo Yii::t('app', 'Organization Profile') ?></h2>
			<div>
				<div class="mt-4">
					<h5 class="muted text-uppercase"><?php echo Yii::t('app', 'Legal Name') ?></h5>
					<p class="break-all"><?php echo $model->legal_name ?></p>
				</div>
				<div class="mt-4">
					<h5 class="muted text-uppercase"><?php echo Yii::t('app', 'Company Registration Number') ?></h5>
					<p class="break-all"><?php echo $model->company_number ?></p>
				</div>
				<div class="mt-4">
					<h5 class="muted text-uppercase"><?php echo Yii::t('app', 'Type of Organization') ?></h5>
					<p class="break-all"><?php echo $model->legalform->title ?></p>
				</div>
				<div class="mt-4">
					<h5 class="muted text-uppercase"><?php echo Yii::t('app', 'Industry') ?></h5>
					<div>
						<?php foreach ($model->industries as $industry) : ?>
							<span class="label"><?php echo $industry->title ?></span>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	

		<div class="mt-4 flex justify-end">
			<a type="button" class="btn btn-outline btn-default" href="<?php echo $this->createUrl('/organization/update', array('id' => $model->id, 'realm' => $realm)); ?>"><?php echo Yii::t('app', 'Edit Organization Profile') ?> <i class="fa fa-arrow-right"></i></a>
		</div>

		<div class="px-8 py-6 shadow-panel mt-4">
			<ul class="nav nav-tabs nav-new new-dash-tab" role="tablist">
				<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
				<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
				<?php endforeach; ?><?php endforeach; ?>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content padding-lg white-bg">
				<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
				<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>" id="<?php echo $tabModule['key'] ?>">
					<?php echo $this->renderPartial($tabModule['viewPath'], array('model' => $model, 'organization' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab, 'inputImpacts' => $inputImpacts, 'inputSdgs' => $inputSdgs, 'inputPersonas' => $inputPersonas, 'inputIndustries' => $inputIndustries)) ?>
				</div>
				<?php endforeach; ?><?php endforeach; ?>
			</div>
		</div>


	</section>

<?php endif; ?>


<br />
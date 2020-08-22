<?php
$this->breadcrumbs = array(
	Yii::t('frontend', 'Resource Directory') => array('//resource'),
	Yii::t('frontend', 'Add New Resource')
);

?>

<section class="container margin-top-lg">

	<div class="col col-sm-9 margin-top-lg">
		<h2><?php echo Yii::t('frontend', 'Create New Resource'); ?></h2>

		<?php $this->renderPartial('application.modules.resource.views.resource._form', array('model' => $model, 'realm' => 'cpanel', 'organization' => $organization)); ?>
	</div>

</section>
    
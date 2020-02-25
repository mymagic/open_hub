<?php
$this->breadcrumbs = array(
	'Resource Directory' => array('//resource'),
	$model['title']
);

?>
<?php
$subFilters = array_keys($_GET);
unset($subFilters[0]);
$subFilters = implode(',', $subFilters);
$category_filter = $_GET ? explode(',', $subFilters) : array();
$result = json_decode($data, true);
?>


<div class="media" id="page-header">
    <div class="pull-right media-middle">
        <?php if (!empty($model->getImageLogoUrl())): ?>
            <a href="<?php echo $model->getImageLogoUrl() ?>"><img class="media-object" src="<?php echo $model->getImageLogoUrl() ?>" alt="logo" /></a>
        <?php endif; ?>
    </div>
    <div class="media-body">
            <h1 class="media-heading"><?php echo $model->getAttrData('title') ?></h1>
            <div class="">
            <?php echo $model->resourceCategories[0]->title ?>&nbsp; | 
            <a href="<?php echo $this->createUrl('frontend/organization', array('id' => $model->organizations[0]->id, 'brand' => $this->layoutParams['brand']))?>"><?php echo $model->organizations[0]->title ?> &nbsp;<i class="fa fa-chevron-circle-right"></i></a>
        </div>
    </div>
</div>

<hr />
<div style="max-width: 85%; text-align: justify;">
	<p> <?php echo $model->getAttrData('html_content') ?></p>
</div>

<?php if (!empty($model->latlong_address[0]) && !empty($model->latlong_address[1])): ?>
<div class="gm-map">
	<?php echo Html::mapView('map-resourceAddress', $model->latlong_address[0], $model->latlong_address[1]) ?>
</div>
<?php endif; ?>

<br />

<?php if (!empty($model->full_address)): ?> 
    <h3><?php echo Yii::t('resource', 'Address') ?>:</h3>
    <p><?php echo $model->full_address ?></p>
<?php endif; ?>

<?php if (!empty($model->url_website)): ?>
<hr />
<div class="center-block text-center"><div class="btn-group">
    <a class="btn btn-success" href="<?php echo $this->createUrl('go', array('id' => $model->id, 'brand' => $this->layoutParams['brand']))?>" target="_blank"><?php echo Yii::t('resource', 'Link') ?></a>
</div></div>
<?php endif; ?>

<hr />

<div class="btn-group btn-group-sm margin-bottom-lg" role="group">
<a class="btn btn-white" onclick="goBack()"><?php echo Yii::t('resource', 'Back') ?></a>
<!-- <a class="btn btn-white" data-toggle="modal" data-target="#myModalNorm">Report Discrepancy</a> -->
</div>













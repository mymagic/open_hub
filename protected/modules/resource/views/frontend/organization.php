<?php
$this->breadcrumbs=array(
    'Resource Directory'=>array('//resource'),
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

<div>
	
    <div class="media" id="page-header">
		<div class="pull-right media-middle">
			<a href="<?php echo $model->getImageLogoUrl() ?>"><img class="media-object" src="<?php echo $model->getImageLogoUrl() ?>" alt="logo" /></a>
		</div>
		<div class="media-body">
			 <h1 class="media-heading"><?php echo $model->title ?></h1>
			 <div class="">
				<a href="<?php echo $model->url_website ?>"><?php echo $model->url_website ?></a>
			</div>
		</div>
	</div>
    <hr />

    <p style="max-width: 85%; text-align: justify;"> <?php echo $model->text_short_description ?></p>

    <?php if(!empty($model->latlong_address)): ?>
    <div class="gm-map full-width">
        <?php echo Html::mapView('map-resourceAddress', $model->latlong_address[0], $model->latlong_address[1]) ?>
    </div>
    <?php endif; ?>

    <br />

    <?php if(!empty($model->full_address)): ?>
        <h3><?php echo Yii::t('resource', 'Address') ?>:</h3>
        <p><?php echo $model->full_address ?></p>
        <hr />
    <?php endif; ?>

    <?php if(!empty($resources)): ?>
    <h3><?php echo Yii::t('resource', 'Resources by {organizationTitle}', array('{organizationTitle}'=>$model->title)) ?></h3>
    <div class="margin-bottom-2x margin-top-lg"><ol>
    <?php foreach ($resources as $resource ): ?>
    <li>
        <a href="<?php echo $this->createUrl("frontend/view", array('id' => $resource->id, 'brand'=>$this->layoutParams['brand']))?>"><?php echo $resource->getAttrData('title') ?> <small>(<?php echo $resource->resourceCategories[0]->title ?>)</small></a>
    </li>
    <?php endforeach; ?>
    </ol></div>
    <?php endif; ?>

    <div class="btn-group btn-group-sm margin-bottom-lg" role="group">
        <a class="btn btn-white" onclick="goBack()"><?php echo Yii::t('resource', 'Back') ?></a>
        <!--<a class="btn btn-white" data-toggle="modal" data-target="#myModalNorm">Report Discrepancy</a>-->
    </div>

</div>




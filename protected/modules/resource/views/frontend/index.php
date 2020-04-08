<?php
$this->breadcrumbs = array(
	'Resource Directory' => array('//resource'),
	'Home',
); ?>


<?php 
  $offset = 0; //$limit = 10;
  // $page = !isset($_GET['page'])?1:$_GET['page'];
  $offset = ($page - 1) * $limit;
  // $jdata = json_decode($data);
  // $totalItems = $jdata->totalItems;

  $urlCurrent = strstr($_SERVER['QUERY_STRING'], 'page=' . $page) ?
  '?' . $_SERVER['QUERY_STRING'] :
  '?page=' . $page . '&' . $_SERVER['QUERY_STRING'];
  $urlPrev = str_replace("page=$page", 'page=' . ($page - 1), $urlCurrent);
  $urlNext = str_replace("page=$page", 'page=' . ($page + 1), $urlCurrent);
  $maxPage = ceil($totalItems / $limit);
  $thisPageMaxItem = intval($limit + ($offset)); if ($thisPageMaxItem > $totalItems) {
  	$thisPageMaxItem = $totalItems;
  }
  $isFirstPage = $isLastPage = false; if ($page == 1) {
  	$isFirstPage = true;
  } if ($page == $maxPage) {
  	$isLastPage = true;
  }
?>

<?php if (!empty($model['filters'])): ?>
<div id="list-filters" class="margin-bottom-2x">
  <span class="text-muted"><small>Filter(s):</small></span>
  <?php foreach ($model['filters'] as $jdvalue): ?>
  <span class="label label-info"><?php echo $jdvalue['title'] ?></span>
  <?php endforeach; ?>
  <a id="btn-clearAll" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Clear All</a>
</div>
<?php endif;  ?> 

<?php if ($totalItems > 0): ?>
<div id="" class="margin-top-lg">
  <div class="pull-left nopadding btn-group btn-group-xs">
    <a class="btn btn-<?php echo !$isFirstPage ? 'success' : 'default' ?>" <?php if (!$isFirstPage): ?>href="<?php echo $urlPrev ?>"<?php endif; ?>>Prev</a>
    <a class="btn btn-<?php echo !$isLastPage ? 'success' : 'default' ?>" <?php if (!$isLastPage): ?>href="<?php echo $urlNext ?>"<?php endif; ?>>Next</a>
  </div>
  <div class="pull-right"><small><?php echo $offset + 1 ?> - <?php echo $thisPageMaxItem ?> of <?php echo $totalItems ?> Record(s)</small></div>
  <div class="clearfix"></div>
</div>

<!-- result -->
<div id="list-resource">
  <?php if (!empty($model['data'])): foreach ($model['data'] as $resource): ?>
  <div class="item row">
    <div class="col-xs-9">
    <?php if (!empty($resource['slug'])): ?>
      <h3><a href="<?php echo $this->createUrl('/resource/frontend/viewBySlug', array('slug' => $resource['slug'], 'brand' => $this->layoutParams['brand']))?>"><?php echo $resource->getAttrData('title') ?> </a></h3>
    <?php else: ?>
      <h3><a href="<?php echo $this->createUrl('/resource/frontend/view', array('id' => $resource['id'], 'brand' => $this->layoutParams['brand']))?>"><?php echo $resource->getAttrData('title') ?> </a></h3>
    <?php endif; ?>
      <?php echo ysUtil::truncate(strip_tags($resource->getAttrData('html_content'), 250)) ?>
      <div class="text-muted margin-top-lg">
          <?php echo $resource['resourceCategories'][0]['title'] ?>
      </div>
    </div>

    <div class="col-xs-offset-1 col-xs-2 pull-right">
        <a href="<?php echo $this->createUrl('/resource/frontend/organization', array('id' => $resource['organizations'][0]['id'], 'brand' => $this->layoutParams['brand']))?>" class="thumbnail">
        <?php if (!empty($resource['imageLogoUrl'])): ?>
          <img width="125" height="71" src="<?php echo $resource->getImageLogoUrl() ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />
        <?php elseif (!empty($resource['organizations'][0]['imageLogoUrl'])): ?>
          <img width="125" height="71" src="<?php echo $resource['organizations'][0]->getImageLogoUrl() ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />
        <?php endif; ?>
        </a>
    </div>                           
  </div>
  <?php endforeach; endif; ?>
</div>
<!-- /result -->

<div id="" class="margin-top-lg">
  <div class="pull-left nopadding btn-group btn-group-xs">
    <a class="btn btn-<?php echo !$isFirstPage ? 'success' : 'default' ?>" <?php if (!$isFirstPage): ?>href="<?php echo $urlPrev ?>"<?php endif; ?>><?php echo Yii::t('resource', 'Prev') ?></a>
    <a class="btn btn-<?php echo !$isLastPage ? 'success' : 'default' ?>" <?php if (!$isLastPage): ?>href="<?php echo $urlNext ?>"<?php endif; ?>><?php echo Yii::t('resource', 'Next') ?></a>
  </div>
  <div class="pull-right"><small><?php echo $offset + 1 ?> - <?php echo $thisPageMaxItem ?> of <?php echo $totalItems ?> Record(s)</small></div>
  <div class="clearfix"></div>
</div>
<?php elseif (!empty($model['filters'])) : ?>
  <?php echo Notice::inline(Yii::t('notice', '0 record found')) ?>
<?php else: ?>
<div class="jumbotron">
  <h1><?php echo $hero->getAttrData('title') ?></h1>
  <?php echo $hero->getAttrData('html_content') ?>
</div>

<h1 class="hidden"><u><?php echo Yii::t('resource', 'Featured Resources') ?></u></h1>
<br />

<?php if (!empty($highlightedOrganizations)): ?>
<div class="row" style="display: flex; display: -webkit-flex; flex-wrap: wrap; height: 100%;">
<?php foreach ($highlightedOrganizations as $organization): ?>
<?php if (!empty($organization)): ?>
  <div class="col-xs-6 col-sm-4 col-md-2">
    <a class="thumbnail" href="<?php echo $this->createUrl('/resource/frontend/organization', array('id' => $organization->id, 'brand' => $this->layoutParams['brand']))?>" style="border:0"><div class="full-width" style=""><img src="<?php echo $organization->getImageLogoUrl() ?>" alt="<?php echo $organization->title ?>" style="" /></div></a>
  </div>
<?php endif; ?>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="pull-right">
  <a class="btn btn-white" href="<?php echo $this->createUrl('add')?>" target="_blank"><?php echo Yii::t('resource', 'Add New Resource') ?></a>
</div>

<?php endif; ?>
                        



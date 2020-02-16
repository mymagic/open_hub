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
  <span class="label label-info"><?php echo $jdvalue['title']; ?></span>
  <?php endforeach; ?>
  <a id="btn-clearAll" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Clear All</a>
</div>
<?php endif; ?> 

<?php if ($totalItems > 0): ?>
<div id="" class="margin-top-lg">
  <div class="pull-left nopadding btn-group btn-group-xs">
    <a class="btn btn-<?php echo !$isFirstPage ? 'success' : 'default'; ?>" <?php if (!$isFirstPage): ?>href="<?php echo $urlPrev; ?>"<?php endif; ?>>Prev</a>
    <a class="btn btn-<?php echo !$isLastPage ? 'success' : 'default'; ?>" <?php if (!$isLastPage): ?>href="<?php echo $urlNext; ?>"<?php endif; ?>>Next</a>
  </div>
  <div class="pull-right"><small><?php echo $offset + 1; ?> - <?php echo $thisPageMaxItem; ?> of <?php echo $totalItems; ?> Record(s)</small></div>
  <div class="clearfix"></div>
</div>

<!-- result -->
<div id="list-resource">
  <?php if (!empty($model['data'])): foreach ($model['data'] as $resource): ?>
  <div class="item row">
    <div class="col-xs-9">
      <h3><a href="<?php echo $this->createUrl('/resource/frontend/view', array('id' => $resource['id'], 'brand' => $this->layoutParams['brand'])); ?>"><?php echo $resource->getAttrData('title'); ?> </a></h3>
      <?php echo ysUtil::truncate(strip_tags($resource->getAttrData('html_content'), 250)); ?>
      <div class="text-muted margin-top-lg">
          <?php echo $resource['resourceCategories'][0]['title']; ?>
      </div>
    </div>

    <div class="col-xs-offset-1 col-xs-2 pull-right">
        <a href="<?php echo $this->createUrl('/resource/frontend/organization', array('id' => $resource['organizations'][0]['id'], 'brand' => $this->layoutParams['brand'])); ?>" class="thumbnail">
        <?php if (!empty($resource['imageLogoUrl'])): ?>
          <img width="125" height="71" src="<?php echo $resource->getImageLogoUrl(); ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />
        <?php else: ?>
          <img width="125" height="71" src="<?php echo $resource['organizations'][0]->getImageLogoUrl(); ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />
        <?php endif; ?>
        </a>
    </div>                           
  </div>
  <?php endforeach; endif; ?>
</div>
<!-- /result -->

<div id="" class="margin-top-lg">
  <div class="pull-left nopadding btn-group btn-group-xs">
    <a class="btn btn-<?php echo !$isFirstPage ? 'success' : 'default'; ?>" <?php if (!$isFirstPage): ?>href="<?php echo $urlPrev; ?>"<?php endif; ?>><?php echo Yii::t('resource', 'Prev'); ?></a>
    <a class="btn btn-<?php echo !$isLastPage ? 'success' : 'default'; ?>" <?php if (!$isLastPage): ?>href="<?php echo $urlNext; ?>"<?php endif; ?>><?php echo Yii::t('resource', 'Next'); ?></a>
  </div>
  <div class="pull-right"><small><?php echo $offset + 1; ?> - <?php echo $thisPageMaxItem; ?> of <?php echo $totalItems; ?> Record(s)</small></div>
  <div class="clearfix"></div>
</div>
<?php elseif (!empty($model['filters'])) : ?>
  <?php echo Notice::inline(Yii::t('notice', '0 record found')); ?>
<?php else: ?>
<div class="jumbotron">
  <h1><?php echo $hero->getAttrData('title'); ?></h1>
  <img src="<?php echo $this->module->getAssetsUrl() ?>/images/med/logo-psk.png" alt="PSK" align="right" style="margin-left:1em; height:150px"/>  
  <?php echo $hero->getAttrData('html_content'); ?>
</div>


<h3><?php echo Yii::t('resource', 'PAUTAN BAHAGIAN/ AGENSI MED'); ?></h3>
<br />

<div class="row" style="display: flex; display: -webkit-flex; flex-wrap: wrap; height: 100%;">
<?php foreach ($highlightedOrganizations as $organization): ?>
  <div class="col-xs-6 col-sm-4 col-md-2">
    <a class="thumbnail" href="<?php echo $this->createUrl('/resource/frontend/organization', array('id' => $organization->id, 'brand' => $this->layoutParams['brand'])); ?>" style="border:0"><div class="full-width" style=""><img src="<?php echo $organization->getImageLogoUrl(); ?>" alt="<?php echo $organization->title; ?>" style="" /></div></a>
  </div>
<?php endforeach; ?>
</div>

<hr style="border:1px solid red; height:0"/>

<h3><?php echo Yii::t('resource', 'Social Media'); ?></h3>
<br />
<div class="row">
    <div class="col col-xs-12 col-sm-6 col-lg-3 text-center"><a class="text-success" href="https://www.facebook.com/OfficialMEDMalaysia/" target="_top"><?php echo Html::faIcon('fa-facebook-square'); ?> OfficialMEDMalaysia</a></div>
    <div class="col col-xs-12 col-sm-6 col-lg-3 text-center"><a class="text-info"href="https://twitter.com/MEDMalaysia" target="_top"><?php echo Html::faIcon('fa-twitter'); ?> MEDMalaysia</a></div>
    <div class="col col-xs-12 col-sm-6 col-lg-3 text-center"><a class="text-warning"href="https://www.instagram.com/officialmedmalaysia/" target="_top"><?php echo Html::faIcon('fa-instagram'); ?> officialmedmalaysia</a></div>
    <div class="col col-xs-12 col-sm-6 col-lg-3 text-center"><a class="text-danger"href="https://www.youtube.com/channel/UCTjjbfdeUbkBg6c5NRwO0Lg/video" target="_top"><?php echo Html::faIcon('fa-youtube'); ?> medmalaysia</a></div>
</div>

                        

<?php if (!empty($popup)): ?>
<div class="modal fade" id="model-resourcePopup">
<div class="modal-content" style="background:#d00; max-width:500px; margin:30px auto; padding:0">
  <div>
    <button style="position:absolute; right:-15px; top:-26px; color:white;opacity:100; font-size:300%" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><?php echo Html::faIcon('fa fa-times-circle') ?></span></button>
  </div>
  <div class="modal-body text-center row">
    <a data-dismiss="modal">
       <img src="<?php echo StorageHelper::getUrl($popup->getAttrData('image_main')); ?>" />
    </a>
  
    <!-- Begin Mailchimp Signup Form -->
    <div id="mc_embed_signup">
    <form action="https://mymagic.us8.list-manage.com/subscribe/post?u=f70b43b2b98bb62ead38107dd&amp;id=8dca99cad4" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate form-inline" target="_blank" novalidate>
      <div id="mc_embed_signup_scroll">
        <h3 class="margin-top-lg"><?php echo Yii::t('resource', 'Tell us about yourself') ?></h3>
        <div>
          <div class="col-xs-6 col-sm-4"><div class="form-group">
            <input type="text" value="" name="FNAME" class="required form-control full-width" id="mce-FNAME" placeholder="<?php echo Yii::t('resource', 'Full Name') ?>" />
          </div></div>
          <div class="col-xs-6 col-sm-4">
            <input type="email" value="" name="EMAIL" class="required email form-control full-width" id="mce-EMAIL" placeholder="<?php echo Yii::t('resource', 'Email') ?>" />
          </div>
          <div class="col-xs-12 col-sm-4">
            <input type="submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="full-width btn btn-white " style="line-height:28px" />
          </div>
        </div>

        <div id="mce-responses" class="clear">
          <div class="response" id="mce-error-response" style="display:none"></div>
          <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_f70b43b2b98bb62ead38107dd_8dca99cad4" tabindex="-1" value=""></div>
        

      </div>
    </form>
    </div>
    <!--End mc_embed_signup-->
    
  </div>
</div>
</div>
<?php Yii::app()->clientScript->registerScript('resourcePopup-js', "$('#model-resourcePopup').modal('show');"); ?>
<?php endif; ?>




<?php endif; ?>

<?php $this->layoutParams['brand'] == 'psk' ? $this->beginContent('modules.resource.views.layouts.frontend-psk') : $this->beginContent('modules.resource.views.layouts.frontend-default'); ?>

<div class="col col-lg-3 col-md-4 col-sm-5">
  <div class="content-main-left">

    <span class="inline" style="float:left; padding-right:1em;"><a href="<?php echo $this->createUrl('/resource/frontend/index', array('brand' => $this->layoutParams['brand'])); ?>"><?php echo Html::faIcon('fa-home fa-lg text-muted'); ?></a></span>

    <?php if (count(Yii::app()->params['frontendLanguages']) > 1) : ?>
      <div class="flex my-4">
        <?php $last_key = end(array_keys(Yii::app()->params['frontendLanguages']));
        foreach (Yii::app()->params['frontendLanguages'] as $langCode => $langTitle) : ?>
          <div>
            <a href="<?php echo $this->createMultilanguageReturnUrl($langCode); ?>" title="<?php echo $langTitle; ?>" class="<?php echo (Yii::app()->language == $langCode) ? 'text-black font-black' : 'text-gray-700 font-medium'; ?> hover:text-gray-700 focus:text-gray-700 tracking-wider no-underline" style="text-decoration: none"><?php echo $langTitle; ?></a>
          </div>
          <?php if ($langCode !== $last_key) : ?>
            <span class="mx-1 text-black"> | </span>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form id="form-searchResource" method="GET" action="<?php echo $this->createUrl('/resource/frontend/index', array('brand' => $this->layoutParams['brand'])); ?>">

      <!-- keyword -->
      <div class="box-filter">
        <h6 class="lead"><?php echo Yii::t('resource', 'Search'); ?></h6>
        <div class="input-group">
          <input name="keyword" type="text" value="<?php echo Yii::app()->request->getParam('keyword'); ?>" placeholder="Search keyword" class="form-control" />
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit"><?php echo Html::faIcon('fa fa-search'); ?></button>
          </span>
        </div>
      </div>
      <!-- /keyword -->

      <!-- persona -->
      <div class="box-filter checkbox checkbox-info">
        <h6 class="lead"><?php echo Yii::t('resource', 'I am'); ?></h6>
        <?php $filteredPersona = Yii::app()->request->getParam('persona');
        foreach ($this->layoutParams['resourceFilters']['personas'] as $persona) : ?>
          <div class="item"><input <?php if (in_array($persona->slug, $filteredPersona)) {
                                      echo 'checked="checked"';
                                    } ?> id="persona-<?php echo $persona->slug; ?>" name="persona[]" value="<?php echo $persona->slug; ?>" type="checkbox">&nbsp;
            <label for="persona-<?php echo $persona->slug; ?>"><?php echo YsUtil::truncate($persona->getAttrData('title'), 21); ?></label>
            <i class="btn-popover fa fa-info-circle text-info pull-right" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo $persona->getAttrData('text_short_description'); ?>"></i>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- /persona -->

      <!-- category -->
      <div id="box-fiter-cat" class="box-filter checkbox checkbox-info">
        <h6 class="lead"><?php echo Yii::t('resource', 'Categories'); ?></h6>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <?php $filteredCategories = Yii::app()->request->getParam('cat');
          foreach ($this->layoutParams['resourceFilters']['categories'] as $cat) : ?>
            <div class="panel panel-default">
              <div id="heading-<?php echo $cat['slug']; ?>" class="panel-heading" role="tab">
                <div class="item">
                  <input <?php if (in_array($cat['slug'] . '.*', $filteredCategories)) {
                            echo 'checked="checked"';
                          } ?> id="cat-<?php echo $cat['slug'] . '.*'; ?>" type="checkbox" name="cat[]" value="<?php echo $cat['slug'] . '.*'; ?>">
                  <label for="cat-<?php echo $cat['slug'] . '.*'; ?>"><?php echo $cat['title']; ?></label>

                  <a class="pull-right" role="button" data-toggle="collapse" href="#collapse-<?php echo $cat['slug']; ?>" aria-expanded="true" aria-controls="collapse-fund"><i class="fa fa-chevron-down"></i></a>
                </div>
              </div>
              <div id="collapse-<?php echo $cat['slug']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $cat['slug']; ?>">
                <ul class="list-group">
                  <?php foreach ($cat['childs'] as $catChild) : ?>
                    <li>
                      <div class="item">
                        <input class="" <?php if (in_array($catChild->slug, $filteredCategories)) {
                                          echo 'checked="checked"';
                                        } ?> id="cat-<?php echo $cat['slug']; ?>-<?php echo $catChild->slug; ?>" name="cat[]" value="<?php echo $catChild->slug; ?>" type="checkbox">
                        <label for="cat-<?php echo $cat['slug']; ?>-<?php echo $catChild->slug; ?>"><?php echo $catChild->getAttrData('title'); ?></label>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- /category -->


      <!-- startupStages -->
      <div class="box-filter checkbox checkbox-info">
        <h6 class="lead"><?php echo Yii::t('resource', 'Company stage'); ?></h6>
        <?php $filteredStage = Yii::app()->request->getParam('stage');
        foreach ($this->layoutParams['resourceFilters']['startupStage'] as $sst) : ?>
          <div class="item">
            <input <?php if (in_array($sst->slug, $filteredStage)) {
                      echo 'checked="checked"';
                    } ?> id="stage-<?php echo $sst->slug; ?>" name="stage[]" value="<?php echo  $sst->slug; ?>" type="checkbox">&nbsp;
            <label class="" for="stage-<?php echo $sst->slug; ?>"><?php echo $sst->getAttrData('title'); ?></label>
            <i class="btn-popover fa fa-info-circle text-info pull-right" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo $sst->getAttrData('text_short_description'); ?>"></i>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- /startupStages -->

      <!-- geolocation -->
      <div id="box-fiter-location" class="box-filter checkbox checkbox-info">
        <a class="toggle-updown pull-right"><?php echo Html::faIcon('fa fa-sort'); ?></a>
        <p class="lead"><?php echo Yii::t('resource', 'For Location'); ?></p>
        <div class="panel-group" style="display:none">
          <?php $filteredLocation = Yii::app()->request->getParam('location');
          foreach ($this->layoutParams['resourceFilters']['locations'] as $location) : ?>
            <div id="heading-<?php echo $location['slug']; ?>" class="panel-heading" role="tab">
              <div class="item">
                <input <?php echo (in_array($location['slug'], $filteredLocation)) ? 'checked="checked"' : ''; ?> id="location-<?php echo $location['slug']; ?>" type="checkbox" name="location[]" value="<?php echo $location['slug']; ?>">
                <label for="location-<?php echo $location['slug']; ?>"><?php echo $location['title']; ?></label>
                <?php if (!empty($location['childs'])) : ?><a class="pull-right" role="button" data-toggle="collapse" href="#collapse-<?php echo $location['slug']; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $location['slug']; ?>"><i class="fa fa-chevron-down"></i></a><?php endif; ?>
              </div>
            </div>
            <?php if (!empty($location['childs'])) : ?>
              <div id="collapse-<?php echo $location['slug']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $location['slug']; ?>">
                <ul class="list-group">
                  <?php foreach ($location['childs'] as $locationChild) : ?>
                    <li>
                      <div class="item">
                        <input <?php echo (in_array($locationChild['slug'], $filteredLocation)) ? 'checked="checked"' : ''; ?> id="<?php echo $location['slug']; ?>-<?php echo $locationChild->slug; ?>" name="location[]" value="<?php echo $locationChild->slug; ?>" class="childCheckBox" type="checkbox">
                        <label for="<?php echo $location['slug']; ?>-<?php echo $locationChild->slug; ?>"><?php echo $locationChild->getAttrData('title'); ?></label>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- /geolocation -->

      <!-- industry -->
      <div id="box-fiter-inds" class="box-filter checkbox checkbox-info">
        <a class="toggle-updown pull-right"><?php echo Html::faIcon('fa fa-sort'); ?></a>
        <h6 class="lead"><?php echo Yii::t('resource', 'For Industries'); ?></h6>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="display:none">
          <?php $filteredIndustries = Yii::app()->request->getParam('industry');
          foreach ($this->layoutParams['resourceFilters']['industries'] as $inds) : ?>
            <div class="panel panel-default">
              <div id="heading-<?php echo $inds->slug; ?>" class="panel-heading" role="tab">
                <div class="item">
                  <input <?php if (in_array($inds->slug, $filteredIndustries)) {
                            echo 'checked="checked"';
                          } ?> id="inds-<?php echo $inds->slug; ?>" type="checkbox" name="industry[]" value="<?php echo $inds->slug; ?>">
                  <label for="inds-<?php echo $inds->slug; ?>"><?php echo $inds->getAttrData('title'); ?></label>
                </div>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- /industry -->


    </form>

    <!-- google search -->
    <!--<div id="box-search-keyword" class="box-filter checkbox checkbox-info">
  <h6 class="lead">Search</h6>
  <gcse:search></gcse:search>
</div>-->
    <!-- /google search -->

  </div>
</div>


<div class="col col-lg-9 col-md-8 col-sm-7">
  <?php echo $content; ?>
</div>

<?php
// must be inside beginContent scope
$this->layoutParams['gaAccounts'][] = array('id' => 'UA-62910124-9', 'trackerName' => 'resourceTracker');
$this->layoutParams['gaAccounts'][] = array('id' => 'UA-62910124-26', 'trackerName' => 'pskTracker');
?>

<?php $this->endContent(); ?>

<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/frontend.js', CClientScript::POS_END); ?>


<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/frontend.css'); ?>
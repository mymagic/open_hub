<?php if ($viewMode == 'standalone'): ?><h1><?php echo $this->pageTitle; ?></h1><?php endif; ?>

<div id="section-collection-list">
<div class="panel-group" id="accordion-collection" role="tablist" aria-multiselectable="true">
<?php $i = 0; foreach ($model->collectionSubs as $collectionSub): ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="accordionHeading-collectionSub-<?php echo $collectionSub->id; ?>">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion-collection" href="#collectionSub-<?php echo $collectionSub->id; ?>" aria-expanded="true" aria-controls="collectionSub-<?php echo $collectionSub->id; ?>">
            <?php echo $collectionSub->title; ?>
        </a>
      </h4>
    </div>
    <div id="collectionSub-<?php echo $collectionSub->id; ?>" class="panel-collapse collapse <?php echo ($i == 0) ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="accordionHeading-collectionSub-<?php echo $collectionSub->id; ?>">
      <div class="panel-body">
        <?php foreach ($collectionSub->collectionItems as $collectionItem): ?>
            <div class="col col-xs-3 col-sm-2 text-center"><?php echo HubCollection::renderCollectionItem($this, $collectionItem); ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php ++$i; endforeach; ?>
</div>

</section>
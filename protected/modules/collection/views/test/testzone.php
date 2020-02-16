<div>
    <a class="btn btn-white"><i class="fa fa-bookmark"></i></a>
</div>

<h3>Organization</h3>
<div class="row">
<?php foreach ($model['organizations'] as $organization): ?>
    <div class="col col-sm-3"><div class="thumbnail collectible" data-collection-table_name="organization" data-collection-ref_id="<?php echo $organization->id; ?>">
        <img src="<?php echo $organization->getImageLogoThumbUrl(); ?>" class="img-responsive" />
        <div class="caption text-center"><?php echo ysUtil::truncate($organization->title, 25); ?></div>
    </div></div>
<?php endforeach; ?>
</div>

<h3>Resource</h3>
<div class="row">
<?php foreach ($model['resources'] as $resource): ?>
    <div class="col col-sm-3"><div class="thumbnail collectible" data-collection-table_name="resource" data-collection-ref_id="<?php echo $resource->id; ?>">
        <img src="<?php echo $resource->getImageLogoThumbUrl(); ?>" class="img-responsive" />
        <div class="caption text-center"><?php echo ysUtil::truncate($resource->title, 25); ?></div>
    </div></div>
<?php endforeach; ?>
</div>

<h3>Event</h3>
<div class="row">
<?php foreach ($model['events'] as $event): ?>
    <div class="col col-sm-3"><div class="thumbnail collectible" data-collection-table_name="event"  data-collection-ref_id="<?php echo $event->id; ?>" style="min-height:10em">
        <div class="caption text-center">
            <?php echo ysUtil::truncate($event->title, 100); ?><br />
            <small class="text-muted"><?php echo Html::formatDateTime($event->date_started); ?> @ <?php echo $event->at; ?></small>
        </div>
    </div></div>
<?php endforeach; ?>
</div>
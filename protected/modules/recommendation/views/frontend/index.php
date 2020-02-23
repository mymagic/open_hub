<div class="px-8 py-6 shadow-panel">

    <?php if (!empty($challenges)) : ?>
        <section>
            <h3 class="mb-6">Open Innovation Challenges You Can Participate</h3>
            <div class="owl-carousel">
                <?php foreach ($challenges as $challenge) : ?>
                    <?php $this->renderPartial('modules.recommendation.views._cards.event', array('challenge' => $challenge)); ?>
                <?php endforeach; ?>
            </div>
        </section>
        <br><br>
    <?php endif; ?>


    <div class="w-full flex nav-select shadow-panel">
        <div class="md:flex mx-3 py-4 justify-between w-full">
            <div class="inline-block flex items-center">
                <div class="ml-2"><i class="fa fa-cog" style="font-size: 20px"></i></div>
                <div class="ml-6 break-words">Customize your interest so we can learn more about you.</div>
            </div>
            <div>
                <a type="button" class="btn btn-outline btn-default" href="<?php echo $this->createUrl('/interest/interest/setting'); ?>">Go to Settings</a>
            </div>
        </div>
    </div>

    <br><br>


    <?php if (!empty($events)) : ?>
        <section>
            <h3>Upcoming Events You Might Be Interested</h3>
            <div class="row">
                <?php foreach ($events as $event) : ?>
                    <a href="<?php echo $event->getPublicUrl(); ?>" class="text-gray-700 hover:text-gray-600">
                        <div class="col-sm-4 my-4">
                            <div class="font-bold"><?php echo $event->title; ?></div>
                            <div><?php echo ysUtil::truncate(strip_tags($event->getAttrData('text_short_desc'), 250)); ?></div>
                            <small class="mt-2"><?php echo strtoupper(date('d F Y', $event['date_started'])); ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <br><br>
    <?php endif; ?>

    <?php if (!empty($resources)) : ?>

        <section>
            <h3>Collection Of Products And Services</h3>
            <div class="row">
                <?php foreach ($resources as $resource) : ?>

                    <div class="col-sm-4 my-4">
                        <a href="<?php echo $this->createUrl("/resource/frontend/view", array('id' => $resource->id)) ?>" class="text-gray-700 hover:text-gray-600">
                            <div class="font-bold"><?php echo $resource->title; ?></div>
                            <div><?php echo ysUtil::truncate(strip_tags($resource->getAttrData('html_content'), 250)); ?></div>
                            <span class="badge"><?php echo $resource->resourceCategories[0]->title; ?></span>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</div>
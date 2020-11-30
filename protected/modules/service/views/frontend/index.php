<div class="px-8 py-6 shadow-panel">
    <h2><?php echo Yii::t('service', 'Services') ?></h2>
    <div class="row mt-4 container-flex">
        <?php foreach ($services as $service) : ?>
            <div class="col-sm-4 my-4 item-flex">
                <div class="full-width">
                    <h4><?php echo $service['data']['title']; ?></h4>
                    <div><?php echo $service['data']['text_oneliner']; ?></div>
                    <div class="mt-3">
                    <?php foreach ($service['actions'] as $action) : ?>
                        <a type="button" class="btn btn-outline btn-default btn-xs" href="<?php echo $action['url'] ?>"><?php echo $action['title'] ?></a>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
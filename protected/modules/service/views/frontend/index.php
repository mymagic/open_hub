<div class="px-8 py-6 shadow-panel">
    <h2>Services</h2>
    <div class="row mt-4">
        <?php foreach ($service_list as $service) : ?>
            <div class="col-sm-4 my-4">
                <div class="font-bold"><?php echo $service['data']['title']; ?></div>
                <div><?php echo $service['data']['text_oneliner']; ?></div>
                <?php foreach ($service['button'] as $button) : ?>
                    <a type="button" class="btn btn-outline btn-default btn-xs" href="<?php echo $button['url'] ?>"><?php echo $button['title'] ?></a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
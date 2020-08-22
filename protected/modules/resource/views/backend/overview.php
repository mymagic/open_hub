
<h1><?php echo Yii::t('backend', 'Resource Directory Overview'); ?></h1>

<div class="row">
<div class="container-flex">

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>General Stats</h3>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <button type="button" class="btn btn-danger btn-sm m-r-sm"><?php echo $stat['general']['totalResources'] ?></button>
                    Total Resources
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $stat['general']['totalPublishedResources'] ?></button>
                    Published
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-warning btn-sm m-r-sm"><?php echo $stat['general']['totalFeaturedResources'] ?></button>
                    Featured
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-info btn-sm m-r-sm"><?php echo $stat['general']['totalOrganizations'] ?></button>
                    Organizations involved
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>By Category</h3>
        <div class="panel-group" id="accordion-categories" role="tablist" aria-multiselectable="true">
        <?php foreach ($stat['categories'] as $lvl1CatKey => $lvl1CatParams): ?>
            <div class="panel-heading" role="tab" id="heading-<?php echo $lvl1CatKey ?>" style="padding-left:0">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-categories" href="#collapse-<?php echo $lvl1CatKey ?>" aria-controls="collapse-<?php echo $lvl1CatKey ?>">
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $lvl1CatParams['count'] ?></button><?php echo $lvl1CatParams['title'] ?>
                    </a>
                </h4>
            </div>
            <div id="collapse-<?php echo $lvl1CatKey ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading-<?php echo $lvl1CatKey ?>">
            
            <table class="table nopadding">
                <?php foreach ($lvl1CatParams['childs'] as $childCatKey => $childCatParams): ?>
                    <tr>
                        <td>
                            <?php echo $childCatParams['title'] ?>
                            <button type="button" class="btn btn-warning btn-sm m-r-sm pull-left"><?php echo $childCatParams['count'] ?></button>
            
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
                
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>


<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>By Industry</h3>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>By Geo Focus</h3>
    </div>
</div>

</div>
</div>
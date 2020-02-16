<?php if(!empty($actions['individual'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach($actions['individual'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action[url] ?>" title="<?php echo $action['title'] ?>"><?php echo $action[label] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3>Individual Involved</h3>
        <?php if(!empty($model->individualOrganizations)): ?>
        <?php foreach($model->individualOrganizations as $individualOrganization):?>
            <?php if(!$individualOrganization->individual->is_active) continue; ?>
            <li><a href="<?php echo $this->createUrl('individual/view', array('id'=>$individualOrganization->individual->id)) ?>" target="_blank"><strong><?php echo $individualOrganization->individual->full_name ?></strong> (<?php echo $individualOrganization->as_role_code ?>)</a>
            </li>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


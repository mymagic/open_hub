<?php if(!empty($actions['funding'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach($actions['funding'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action[url] ?>" title="<?php echo $action['title'] ?>"><?php echo $action[label] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3>Funding Raised</h3>

        <?php if(!empty($model->organizationFundings)): ?>
        <ol>
        <?php foreach($model->organizationFundings as $organizationFunding):?>
            <li><strong><a href="<?php echo $this->createUrl('/organizationFunding/view', array('id'=>$organizationFunding->id)) ?>" target="_blank"><?php echo Html::formatMoney($organizationFunding->amount, 'USD')?> (<?php echo $organizationFunding->round_type_code ?>)</a></strong> on <?php echo Html::formatDateTime($organizationFunding->date_raised, 'standard', false) ?> from <?php echo $organizationFunding->vc_name ?></li>
        <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>


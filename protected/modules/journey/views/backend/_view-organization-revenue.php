<?php if (!empty($actions['revenue'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['revenue'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action['url'] ?>" title="<?php echo $action['title'] ?>"><?php echo $action['label'] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3>Revenue Reported</h3>
        <?php if (!empty($model->organizationRevenues)): ?>
        <ol>
        <?php foreach ($model->organizationRevenues as $organizationRevenue):?>
            <li><strong><a href="<?php echo $this->createUrl('/organizationRevenue/view', array('id' => $organizationRevenue->id)) ?>" target="_blank"><?php echo Html::formatMoney($organizationRevenue->amount, 'USD')?></a></strong> on <?php echo $organizationRevenue->year_reported ?></li>
        <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>


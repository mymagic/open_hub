<?php echo Html::beginForm(); ?>
<div class="row">
    <div class="col col-sm-6"><h3>Bumi Name List</h3></div>
    <div class="col col-sm-6 text-right">
        <?php echo Html::submitButton('Save', array('class' => 'btn btn-sm btn-primary pull-right margin-bottom-sm')); ?>
    </div>
</div>
<div class="row"><div class="col col-sm-12">
    <textarea name="BumiNameList" class="full-width" rows="30"><?php echo $bumiName ?></textarea>
</div></div>
<?php echo Html::endForm(); ?>

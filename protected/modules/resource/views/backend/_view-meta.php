<div class="row">
<div class="col col-md-12">
	
    
    <div class="crud-view">
    <?php if(!empty($model->_metaStructures)):?>
    <h2><?php echo Yii::t('core', 'Meta Data') ?></h2>
    <?php echo Notice::inline(Yii::t('notice','Meta Data Only accessible by developer role'), Notice_WARNING) ?>
    <?php $this->widget('application.components.widgets.DetailView', array(
        'data'=>$model,
        'attributes'=>$model->metaItems2DetailViewArray(),
    )); ?>
    <?php endif; ?>
    </div>

	
</div>
</div><!-- /.row -->
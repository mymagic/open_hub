<section>
    <div class="px-8 py-6 shadow-panel">
        <h2><?php echo Yii::t('cpanel', 'Profile') ?></h2>
        <p><?php echo Yii::t('cpanel', 'People on entrepreneur ecosystem will get to know you with this information') ?></p>
        <div class="py-4">
            <?php $this->renderPartial('_form', array('model' => $model, 'modelIndividual' => $modelIndividual)); ?>
        </div>
    </div>
</section>
<section>
    <div class="px-8 py-6 shadow-panel">
        <h2><?php echo Yii::t('cpanel', 'Change Password') ?></h2>
        <div class="py-4">
            <?php $this->renderPartial('_changePassword', array('model' => $model)); ?>
        </div>
    </div>
</section>
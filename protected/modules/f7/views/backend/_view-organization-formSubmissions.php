<?php $submissions = $model->getFormSubmissions() ?>

<div class="row">
    <div class="col col-md-12">
        <h3><?php echo Yii::t('f7', 'Form Submissions') ?></h3>
        <?php if (!empty($submissions)): ?>
        <table class="table table-bordered table-striped">
        <tr>
            <th><?php echo yii::t('f7', 'Intake') ?> \ <?php echo yii::t('f7', 'Form') ?></th>
            <th class="text-right"><?php echo yii::t('f7', 'ID') ?></th>
            <th class="text-center"><?php echo yii::t('f7', 'Stage') ?></th>
            <th class="text-center"><?php echo yii::t('f7', 'Status') ?></th>
            <th class="text-center"><?php echo yii::t('f7', 'Last Update') ?></th>
            <th class="text-center"><?php echo yii::t('f7', 'Submitted On') ?></th>
            <th class="text-center"><?php echo yii::t('core', 'Action') ?></th>
        </tr>
        <?php foreach ($submissions as $submission):?>
        <?php $intake = ''; $intake = $submission->form->getIntake(); ?>
        <tr>
            <td>
                <?php if($intake): ?>
                    <a href="<?php echo $this->createUrl('/f7/intake/view', array('id'=>$intake->id)) ?>" target="_blank"><?php echo $intake->title ?></a> \ 
                <?php endif;?>
                <a href="<?php echo $this->createUrl('/f7/form/view', array('id'=>$submission->form->id)) ?>" target="_blank"><?php echo $submission->form->title ?></a>
            </td>
            <td class="text-right">#<?php echo $submission->id ?></td>
            <td class="text-center"><span class="label"><?php echo $submission->formatEnumStage($submission->stage) ?></span></td>
            <td class="text-center"><span class="label"><?php echo $submission->formatEnumStatus($submission->status) ?></span></td> 
            <td class="text-center"><?php echo Html::formatDateTime($submission->date_modified, 'standard', false) ?></td>
            <td class="text-center"><?php echo Html::formatDateTime($submission->date_submitted, 'standard', false) ?></td>
            <td class="text-center">
                <span class="btn-group btn-group-xs">
                    <a class="btn btn-primary" href="<?php echo $this->createUrl('/f7/submission/view', array('id' => $submission->id)) ?>" target="_blank"><?php echo Html::faIcon('fa-search') ?></a>
                    <a class="btn btn-default" href="<?php echo $this->createUrl('/f7/submission/exportPdf', array('id' => $submission->id)) ?>" target="_blank"><?php echo Html::faIcon('fa-file-pdf-o') ?></a>
                </span>
            </td>
         </tr>
        <?php endforeach; ?>
        </table>
        <?php else: ?>
            <?php echo Notice::inline(Yii::t('f7', 'No record found'), Notice_INFO) ?>
        <?php endif; ?>
    </div>
</div>
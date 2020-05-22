<?php

$this->breadcrumbs = array(
	'Organization' => array('index'),
	$model->title,
	Yii::t('app', 'Team'),
);

?>

<div class="px-8 py-6 nav-select shadow-panel">
    <div class="row">
        <div class="col-md-12">
            <h3><?php echo Yii::t('app', 'Invite New User') ?></h3>
            <p><?php echo Yii::t('app', 'You can add new user to manage this organisation along with you by insert their email address here. If this belongs to not registed user, they will automatically grant access after signup.') ?></p>
        </div>
        <div class="col-md-12">
            <?php $organization2Email = new Organization2Email;
			$form = $this->beginWidget('ActiveForm', array(
				'action' => $this->createUrl('/organization/addOrganization2Email', array('organizationId' => $model->id, 'realm' => 'cpanel', 'scenario' => 'team')),
				'method' => 'POST',
				'htmlOptions' => array('class' => 'form-horizontal')
			)); ?>

            <div class="input-group">
                <?php echo $form->bsTextField($organization2Email, 'user_email', array('placeholder' => 'Email')) ?>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><?php echo Yii::t('app', 'Invite Member') ?></button>
                </span>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<?php if (!empty($emails['approve'])) : ?>
    <div class="my-4">
        <h2><?php echo Yii::t('app', 'Team Members') ?></h2>
        <div class="list_content my-3">
            <?php foreach ($emails['approve'] as $email) : ?>
                <div class="row">
                    <div class="col-sm-6 col-md-7">
                        <h4><?php echo $email['user_email']; ?></h4>
                        <p class="text-muted"></p>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="col-xs-6 text-center"></div>
                        <div class="col-xs-6 text-center"><a href="<?php echo $this->createUrl('/organization/deleteOrganization2Email/', array('id' => $email->id, 'realm' => 'cpanel', 'scenario' => 'team')) ?>" class="btn btn-danger btn-sm"><?php echo Yii::t('app', 'Remove') ?></a></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($emails['pending'])) : ?>
    <div class="my-4">
        <h2><?php echo Yii::t('app', 'Member Request') ?></h2>
        <div class="list_content my-3">
            <?php foreach ($emails['pending'] as $email) : ?>
                <div class="row">
                    <div class="col-sm-6 col-md-7">
                        <h4><?php echo $email['user_email']; ?></h4>
                        <p class="text-muted"></p>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="col-xs-6 text-center"></div>
                        <div class="col-xs-6 text-center inline-block">
                            <a href="<?php echo $this->createUrl('/organization/toggleOrganization2EmailStatus', array('id' => $email->id, 'realm' => 'cpanel', 'scenario' => 'team')) ?>" class="btn btn-primary btn-sm"><?php echo Yii::t('app', 'Approve') ?></a>
                            <a href="<?php echo $this->createUrl('/organization/toggleOrganization2EmailStatusReject', array('id' => $email->id)) ?>" class="btn btn-warning btn-sm"><?php echo Yii::t('app', 'Reject') ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($emails['reject'])) : ?>
    <div class="my-4">
        <h2><?php echo Yii::t('app', 'Rejected Request') ?></h2>
        <div class="list_content my-3">
            <?php foreach ($emails['reject'] as $email) : ?>
                <div class="row">
                    <div class="col-sm-6 col-md-7">
                        <h4><?php echo $email['user_email']; ?></h4>
                        <p class="text-muted"></p>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="col-xs-6 text-center"></div>
                        <div class="col-xs-6 text-center"><a href="<?php echo $this->createUrl('/organization/deleteOrganization2Email/', array('id' => $email->id, 'realm' => 'cpanel', 'scenario' => 'team')) ?>" class="btn btn-danger btn-sm"><?php echo Yii::t('app', 'Remove') ?></a></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
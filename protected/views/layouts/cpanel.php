<?php $this->beginContent('layouts.frontend'); ?>

<div class="container">
    <?php if ($this->cpanelMenuInterface === 'cpanelNavOrganizationInformation'):
	?>
        <div class="col-md-12">
            <h2 style="margin: 0;" class="break-word"><?php echo HubCpanel::cpanelNavItems($this, ($this->cpanelMenuInterface === 'cpanelNavOrganizationInformation') ? 'organization-information' : 'default')[0]['label'] ?></h2>
            <a href="<?php echo $this->createUrl('/cpanel/organization'); ?>">
                <p><?php echo Yii::t('app', 'Back to Organization List') ?></p>
            </a>
        </div>
    <?php else: ?>
        <h2><?php echo HubCpanel::cpanelNavItems($this, ($this->cpanelMenuInterface === 'cpanelNavOrganizationInformation') ? 'organization-information' : 'default')[0]['label'] ?></h2>
    <?php endif; ?>
</div>

<div class="col-md-3 mb-12">
    <?php $this->renderPartial('//layouts/_cpanel/_nav', array('navs' => HubCpanel::cpanelNavItems($this, ($this->cpanelMenuInterface === 'cpanelNavOrganizationInformation') ? 'organization-information' : 'default')[0]['items'])); ?>
</div>

<div class="col-md-9 mb-12">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>

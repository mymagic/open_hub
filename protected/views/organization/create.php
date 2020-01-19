<?php
/* @var $this OrganizationController */
/* @var $model Organization */
if ($realm == 'backend') {
    $this->breadcrumbs = array(
        'Organizations' => array('index'),
        Yii::t('backend', 'Create'),
    );

    $this->menu = array(
        array('label' => Yii::t('app', 'Manage Organization'), 'url' => array('/organization/admin')),
    );
} elseif ($realm == 'cpanel') {
    $this->breadcrumbs = array(
        'Organization' => array('index'),
        $model->title,
    );
}
?>

<?php if ($realm == 'cpanel') : ?>

    <section>
        <div class="px-8 py-6 shadow-panel">
            <h2>Create Company</h2>
            <p>People on entrepreneur ecosystem will get to know you with this information</p>
            <div>
                <?php $this->renderPartial('_formCpanel', array('model' => $model)); ?>
            </div>
        </div>
        </div>
    </section>

<?php elseif ($realm == 'backend') : ?>

    <h1><?php echo $this->pageTitle ?></h1>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>

<?php endif; ?>
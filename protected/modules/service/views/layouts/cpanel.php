<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/frontend.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/frontend.js', CClientScript::POS_END); ?>


<header id="universal-header">
    <universal-header <?php echo ($this->layoutParams['enableGlobalSearchBox']) ? 'search-box' : '' ?> sub-menu='<?php echo CJSON::encode($this->menuSub) ?>' central-url="<?php echo Yii::app()->baseUrl; ?>">
        <template slot="breadcrumb">
            <?php $this->renderBreadcrumb(true, true) ?>
        </template>
    </universal-header>
</header>


<?php $this->beginContent('layouts.plain'); ?>

<div class="container">
    <h2><?php echo $this->module->cpanelNavItems($this)[0]['label'] ?></h2>
</div>

<div class="col-md-3 mb-12">
    <?php $this->renderPartial('/_cpanel/_nav', array('')); ?>
</div>

<div class="col-md-9 mb-12">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
<?php
/* @var $this OrganizationController */
/* @var $model Organization */

$this->breadcrumbs = array(
	Yii::t('backend', 'Journey') => array('index'),
	Yii::t('backend', 'Advance Search'),
);

$this->menu = array(
	//array('label'=>Yii::t('app','Create Organization'), 'url'=>array('/organization/create')),
);
?>

<?php if ($showSearchBox): ?>
<div class="row padding-top-lg">
<div class="col col-sm-4">
	<?php if ($this->layout == '//layouts/backend'): ?><h1 class="nopadding"><?php echo $this->pageTitle; ?></h1><?php endif; ?>
</div>
<div class="col col-sm-8 text-right">
	<form class="form-inline" action="<?php echo $this->createUrl('/journey/backend/search2'); ?>">
	<div class="form-group">
		<?php echo Html::TextField('keyword', $model['form']->keyword, array('class' => 'form-control', 'placeholder' => 'keyword')); ?>
	</div>
	<input type="submit" class="btn btn-primary" value="Search" />
	</form>
</div>
</div>
<?php endif; ?>

<div class="row margin-top-2x"><div class="col col-sm-12">
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($result as $key => $params): ?>
        <li><a href="#<?php echo $key; ?>" role="tab" data-toggle="tab"><?php echo $params['tabLabel']; ?> <span class="badge badge-<?php echo $params['result']->totalItemCount > 0 ? 'primary' : 'default'; ?>"><?php echo $params['result']->totalItemCount; ?></span></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content white-bg">
        <?php foreach ($result as $key => $params): ?>
        <div id="<?php echo $key; ?>" role="tabpanel" class="tab-pane fade in active padding-sm">
            <?php $this->widget('application.components.widgets.ListView', array(
				'dataProvider' => $params['result'],
				'itemView' => $params['itemViewPath'],
				'ajaxUpdate' => true,
				'enablePagination' => true,
			)); ?>
        </div>
        <?php endforeach; ?>
    </div>
</div></div>
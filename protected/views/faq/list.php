<?php echo Html::pageHeader($this->pageTitle); ?>

<div id="list-faq">
<?php $this->widget('application.yeebase.components.widgets.ListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'ajaxUpdate'=>false,
	'enablePagination'=>true,
	'summaryText'=>'',
	'pagerCssClass'=>'pagination-dark',
)); ?>
</div>

<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */

$this->breadcrumbs = array(
	Yii::t('backend', 'Portfolios') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Create Portfolio'), 'url' => array('/cv/portfolio/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#cv-portfolio-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<ul class="nav nav-pills nav-pills-title" role="tablist">
  <li role="presentation" class="active"><a href="<?php echo $this->createUrl('admin') ?>"><?php echo Yii::t('backend', 'Active') ?></a></li>
  <li role="presentation" class=""><a href="<?php echo $this->createUrl('adminTrash') ?>"><?php echo Html::faIcon('fa fa-trash') ?><?php echo Yii::t('backend', 'Deleted') ?></a></li>
</ul>
<h1><?php echo Yii::t('backend', 'Manage Portfolios'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-cvPortfolioSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-cvPortfolioSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'cv-portfolio-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		'slug',
		'display_name',
		array('name' => 'visibility', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumVisibility($data->visibility)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumVisibility(false, true)),
		// array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_modified', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_modified, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}{update}{trash}',
			'buttons' => array(
				'delete' => array('visible' => false),
				'trash' => array(
					'url' => 'Yii::app()->controller->createUrl("portfolio/deactivate", array("id"=>$data->id))',
					'label' => '<i class="fa fa-trash"></i>',
					'options' => array('class' => 'btn btn-sm btn-danger'),
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'deactivate'); }),
			),
		),
	),
)); ?>

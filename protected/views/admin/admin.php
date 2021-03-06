<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs = array(
	Yii::t('backend', 'Admins') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('backend', 'Manage Admin'), 'url' => Yii::app()->createUrl('admin/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('backend', 'Create Admin'), 'url' => Yii::app()->createUrl('admin/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#admin-grid').yiiGridView('update', {
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
<h1><?php echo Yii::t('backend', 'Manage Admins'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-adminSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-adminSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'admin-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		//array('name'=>'user_id', 'cssClassExpression'=>'foreignKey', 'value'=>'$data->user->username', 'headerHtmlOptions'=>array('class'=>'foreignKey'), 'filter'=>Admin::model()->getForeignReferList(false, true)),
		array('name' => 'user_id', 'cssClassExpression' => 'foreignKey', 'value' => '$data->user->username', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Html::activeTextField($model, 'username')),
		array('name' => 'user.profile.full_name', 'value' => '$data->user->profile->full_name', 'filter' => Html::activeTextField($model, 'full_name')),
		// array('name' => 'user.is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->user->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => Html::activeBooleanList($model, 'is_active', array('nullable' => true))),
		array('name' => Yii::t('backend', 'Is Online'), 'cssClassExpression' => 'boolean', 'type' => 'raw',  'value' => 'Html::renderBoolean(UserSession::isOnlineNow($data->user->id))', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array('name' => 'user.date_last_login', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->user->date_last_login, \'medium\', \'short\')', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}{trash}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); }),
				'trash' => array(
					'url' => 'Yii::app()->controller->createUrl("admin/block", array("id"=>$data->user_id))',
					'label' => '<i class="fa fa-trash"></i>',
					'options' => array('class' => 'btn btn-sm btn-danger'),
					'visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'block'); }),
			)
		),
	),
)); ?>

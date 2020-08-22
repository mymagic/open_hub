<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs = array(
	Yii::t('backend', 'Members') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array(
		'label' => Yii::t('backend', 'Manage Member'), 'url' => array('/member/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('backend', 'Create Member'), 'url' => array('/member/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#member-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage Members'); ?></h1>

<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-memberSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-memberSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'member-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'user_id', 'cssClassExpression' => 'foreignKey', 'type' => 'raw', 'value' => function ($data) {return sprintf('<a data-popload="%s">%s</a>', Yii::app()->createUrl('backend/getMemberInfo', array('username' => $data->user->username)), $data->user->username);}, 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Html::activeTextField($model, 'username')),
		array('name' => 'user.profile.full_name', 'value' => '$data->user->profile->full_name', 'filter' => Html::activeTextField($model, 'full_name')),
		array('name' => 'user.is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->user->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => Html::activeBooleanList($model, 'is_active', array('nullable' => true))),
		array('name' => Yii::t('app', 'Is Online'), 'cssClassExpression' => 'boolean', 'type' => 'raw',  'value' => 'Html::renderBoolean(UserSession::isOnlineNow($data->user->id))', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => false),
		array('name' => 'user.date_last_login', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->user->date_last_login, \'medium\', \'short\')', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		//array('name'=>'date_joined', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->date_joined, \'medium\', \'short\')', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),
		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'template' => '{view}',
			'buttons' => array(
				'view' => array('visible' => function () { return HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view'); })
			),
		),
	),
)); ?>

<?php
/* @var $this ResourceController */
/* @var $model Resource */

if ($realm == 'backend') {
	$this->breadcrumbs = array(
	Yii::t('backend', 'Resources') => array('index'),
	Yii::t('backend', 'Manage'),
);

	$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Resources'), 'url' => array('/resource/resource/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Resource'), 'url' => array('/resource/resource/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),

	array(
		'label' => Yii::t('app', 'Manage Award'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'award'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Funding'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'fund'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Legislation'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'legislation'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Media'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'media'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Program'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'program'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Space'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'space'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Others'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'other'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	'model' => $model, 'organization' => $organization, 'realm' => $realm
	);
} elseif ($realm == 'cpanel') {
	$this->breadcrumbs = array(
		'Organization' => array('index'),
		$organization->title => array('organization/view', 'id' => $organization->id, 'realm' => $realm),
		Yii::t('backend', 'Resources')
	);
	$this->renderPartial('/cpanel/_menu', array('model' => $model, 'organization' => $organization, 'realm' => $realm));
}

?>
<?php if ($realm == 'backend'): ?><h1><?php echo Yii::t('backend', 'Manage Resources'); ?></h1><?php endif; ?>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'resource-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		//array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
		'title',
		array('name' => 'typefor', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumTypefor($data->typefor)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumTypefor(false, true)),
		'title',
		array('name' => 'is_featured', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_featured)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
		array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
					),
	),
)); ?>

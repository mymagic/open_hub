<?php
$this->breadcrumbs=array(
	Yii::t('app', 'My Account')=>array('index'),
	Yii::t('app', 'View'),
);
?>
<?php $this->renderPartial('/cpanel/_menu',array('model'=>$model,)); ?>

<div class="crud-view">
<div class="panel panel-default">
	<div class="panel-heading"><?php echo Yii::t('default', 'Account Information') ?></div>
	<div class="panel-body">

		<?php $this->widget('application.components.widgets.DetailView', array(
			'data'=>$model->user,
			'attributes'=>array(
				'username',
				//'nickname',		
				array('name'=>'date_activated', 'value'=>Html::formatDateTime($model->user->date_activated, 'long')),
				//array('name'=>'date_added', 'value'=>Html::formatDateTime($model->user->date_added, 'long')),
				//array('name'=>'date_modified', 'value'=>Html::formatDateTime($model->user->date_modified, 'long')),
			),
		)); ?>
	</div>
</div>
</div>





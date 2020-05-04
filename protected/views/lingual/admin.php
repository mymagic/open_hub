<?php
/* @var $this TodoController */
/* @var $model Todo */
/*
$this->breadcrumbs=array(
	Yii::t('app', 'Lingual')=>array('index'),
);

$this->menu=array(
	array('label'=>Yii::t('core', 'Lingual Index'), 'url'=>array('index')),
	array('label'=>Yii::t('core', 'Interface Languages'), 'url'=>array('update')),
);*/

?>

<h1><?php echo Yii::t('core', 'Manage {module}', array('{module}' => Yii::t('core', 'Linguals'))); ?></h1>

<div class="row">
<div class="col-xs-6">
	<div class="panel panel-default">
	<div class="panel-heading"><h4 class="panel-title"><?php echo Yii::t('core', 'Available Languages') ?></h4></div>
	<div class="panel-body ">
		<p><?php echo Yii::t('core', 'These languages are currently available in the system') ?>: </p>
	</div>
	<ul class="list-group">
		<?php $counter = 0; foreach (Yii::app()->params['languages'] as $k => $l): ?>
			<li class="list-group-item">
				<span class="badge pull-left"><?php echo ++$counter; ?></span>&nbsp;<?php echo $l ?>
				<?php if (Yii::app()->sourceLanguage == $k): ?><span class="label label-info pull-right margin-right-md"><?php echo Yii::t('core', 'Source') ?></span><?php endif; ?>
				<?php if (Yii::app()->language == $k): ?><span class="label label-success pull-right margin-right-md"><?php echo Yii::t('core', 'Selected') ?></span><?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	</div>

	<div class="panel panel-default">
	<div class="panel-heading"><h4 class="panel-title"><?php echo Yii::t('core', 'Rescan Language Tags') ?></h4></div>
	<div class="panel-body ">
		<div class="hidden">
			<p><?php echo Yii::t('core', 'This will allows the language tags database to rebuild after update of view/controller in the system code. Only then, new language tags are available for translation.') ?></p>
			<?php echo Html::link(Yii::t('core', 'Rescan'), $this->createUrl('lingual/rescan'), array('class' => 'btn btn-danger btn-sm pull-right')); ?>
		</div>

		<p>php yiic message config/message.php</p>
	</div>
	</div>

</div>

<div class="col-xs-6">

	<div class="panel panel-default">
	<div class="panel-heading"><h4 class="panel-title"><?php echo Yii::t('core', 'Scopes') ?></h4></div>
	<div class="panel-body ">
		<p><?php echo Yii::t('core', 'Interface languages are grouped into the following scopes') ?>: </p>
	</div>
	<ul class="list-group">
		<?php $counter = 0; foreach ($scopes as $s): ?>
			<li class="list-group-item">
				<?php echo $s ?>&nbsp;

				<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'editPredefined') || HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'translate')): ?>
					<div class="btn-group btn-group-xs pull-right">
						<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'editPredefined')): ?>
							<a href="<?php echo $this->createUrl('lingual/editPredefined', array('scope' => $s)) ?>" class="btn btn-default "><?php echo Yii::t('core', 'Edit Predefined') ?></a>
						<?php endif; ?>
						<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'translate')): ?>
							<a href="<?php echo $this->createUrl('lingual/translate', array('scope' => $s, 'lingual' => Yii::app()->language)) ?>" class="btn  btn-primary"><?php echo Yii::t('core', 'Translate') ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	</div>
</div>


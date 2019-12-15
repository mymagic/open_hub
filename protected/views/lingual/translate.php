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

<h1><?php echo Yii::t('core', "Translate '{scope}' Languages", array('{scope}'=>ucwords($scope))); ?> <a class="btn btn-default pull-right" href="<?php echo $this->createUrl('lingual/index') ?>"><?php echo Yii::t('core', 'Back') ?></a></h1>

<form action="<?php echo $this->createUrl('lingual/translate', array('scope'=>$scope, 'lingual'=>$lingual)) ?>" role="form" method="POST">
<input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>" />

<ul class="nav nav-tabs">
<?php $lCounter=0;  foreach(Yii::app()->params['languages'] as $lk=>$lv): ?>
	<li class="<?php echo ($lk==$lingual)?'active':'' ?>"><a href="<?php echo $this->createUrl('lingual/translate', array('scope'=>$scope, 'lingual'=>$lk)) ?>"><?php echo $lv ?></a></li>
	<?php $lCounter++; ?>
<?php endforeach; ?>
</ul>


<div class="tab-content">
<div class="tab-pane active">
	<div class="well text-right padding-sm">
		<a class="btn btn-danger" href="<?php echo $this->createUrl('lingual/index') ?>"><?php echo Yii::t('core', 'Cancel') ?></a>
		<input type="submit" class="btn btn-primary" value="<?php echo Yii::t('core', 'Save') ?>" <?php if(!$canSave):?>disabled="disabled"<?php endif; ?>/>
	</div>

	<?php $counter=0; foreach($items[$lingual] as $k=>$i): ?>

	<div class="row form-group">
		<div class="col-sm-1"><?php echo $counter+1; ?></div>
		<div class="col-sm-5">
			<?php echo Html::htmlArea("langDisplay[$counter]", Html::encode($k), array('class'=>'full-width', 'style'=>'height:3em')) ?>
			<?php echo CHtml::hiddenField("langKey[$counter]", $k) ?>
		</div>
		<div class="col-sm-6">
			<?php echo CHtml::textArea("langValue[$counter]", $i, array('class'=>'full-width')) ?>
		</div>
	</div>
	

	<?php $counter++; ?>
	<?php endforeach; ?>
	
	<div class="well text-right padding-sm">
		<a class="btn btn-danger" href="<?php echo $this->createUrl('lingual/index') ?>"><?php echo Yii::t('core', 'Cancel') ?></a>
		<input type="submit" class="btn btn-primary" value="<?php echo Yii::t('core', 'Save') ?>" <?php if(!$canSave):?>disabled="disabled"<?php endif; ?>/>
	</div>
</div>
</div>
</form>


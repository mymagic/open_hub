<?php
/* @var $this ProofController */
/* @var $model Proof */

$this->breadcrumbs=array(
	'Proofs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

if(empty($forRecord))
$this->menu=array(
	array('label'=>Yii::t('app','Manage Proof'), 'url'=>array('/proof/admin')),
	array('label'=>Yii::t('app','Create Proof'), 'url'=>array('/proof/create')),
	array('label'=>Yii::t('app','View Proof'), 'url'=>array('/proof/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Proof'); ?>
<?php if(!empty($forRecord)): ?><small> for <?php echo $forRecord['title'] ?></small><?php endif; ?>
</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'forRecord'=>$forRecord)); ?>
<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('default', 'Error');
$this->breadcrumbs = array(
	Yii::t('default', 'Error'),
);
?>

<h2><?php echo Yii::t('default', 'Error') ?> <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
<?php echo !empty($url) ? CHtml::encode($url) : ''; ?>
</div>
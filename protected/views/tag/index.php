<?php
/* @var $this MapApplicationController */
/* @var $model MapApplication */

$this->breadcrumbs = array(
	Yii::t('backend', 'Tags') => array('index'),
	Yii::t('backend', 'Browse'),
);
?>

<h1><?php echo Yii::t('backend', 'Browse Tags'); ?></h1>

<div id="tag-browser">
<?php foreach ($model as $tag): ?>
	<li class="">
		<a href="<?php echo $this->createUrl('subject/admin', array('Subject[search_tag]' => $tag['name'])) ?>" class="">
			<strong><?php echo($tag['name']); ?></strong>
			<span class="badge"><?php echo $tag['count'] ?></span>
		</a>
	</li>
<?php endforeach; ?>
</div>
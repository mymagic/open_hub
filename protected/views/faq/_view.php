<div class="item">
	<h4><?php echo $realIndex + 1 ?>. <?php echo Html::encode($data->getAttributeDataByLanguage($data, 'title')); ?></h4>
	<?php echo($data->getAttributeDataByLanguage($data, 'html_content')); ?>
</div>
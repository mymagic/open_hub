<div class="view">

	<h3><?php echo CHtml::encode($data->title); ?></h3>
	
	<p><?php echo Yii::app()->dateFormatter->formatDateTime($data->date_posted, 'long', null); ?></p>

	<div class="text"><?php echo ysUtil::truncate(strip_tags($data->short_description), 250); ?></div>
	
	<span class="readmore"><a href="<?php echo $this->createUrl('bulletin/read', array('id'=>$data->id)) ?>"><?php echo Yii::t('default', 'Read More'); ?></a></span>

</div>
<div class="bulletin-item">

	<h3><a href="<?php echo $this->createUrl('bulletin/read', array('id' => $data->id)) ?>"><?php echo CHtml::encode($data->title); ?></a></h3>
	
	<p class="date"><?php echo Yii::app()->dateFormatter->formatDateTime($data->date_posted, 'long', null); ?></p>

	<div class="text"><?php echo ysUtil::truncate(strip_tags($data->short_description), 250); ?></div>

</div>
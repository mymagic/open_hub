<h1><?php echo Yii::t('default', 'Latest Bulletins') ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_list-item',
	'sortableAttributes'=>array(
        'date_posted'=>Yii::t('default', 'Date Posted'),
        'title',
    ),
)); ?>
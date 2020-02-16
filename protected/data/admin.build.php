<?php
return array(
	//'foreignRefer' => array('key'=>'id', 'title'=>'username'),
	'foreignKey' => array(
		'user_id'=>array( 'relationName'=>'user', 'model'=>'User', 'foreignReferAttribute'=>'username'),
	),
); 
<h2>Available Test Functions</h2>
<p>List are automatically generated from controller</p>
<ul>
<?php foreach ($actions as $action): ?>
	<li><?php echo Html::link($action, $this->createUrl('test/'.$action), array('target'=>'_blank')) ?></li>
<?php endforeach; ?>
</ul>
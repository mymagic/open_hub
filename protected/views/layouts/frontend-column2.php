<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/frontend'); ?>
<div class="container pageStyle-texting"><div class="row">
<div class="col-xs-3 col">
	<div id="nav-side" class="margin-top-3x">
		<?php if (!empty($this->menuSide)): ?>
		<?php $this->widget('zii.widgets.CMenu', array(
            'htmlOptions' => array('class' => 'nav nav-pills nav-stacked'),
            'encodeLabel' => false,
            'items' => $this->menuSide,
        )); ?>
		<?php endif; ?>
	</div>
</div>
<div class="col-xs-9 col padding-bottom-lg">
	<?php echo $content; ?>
</div>

</div></div>

<?php $this->endContent(); ?>
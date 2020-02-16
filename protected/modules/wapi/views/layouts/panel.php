<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._backend', Yii::app()->theme->name)); ?>
<?php Yii::import('webroot.themes.'.Yii::app()->theme->name.'.model.Inspinia'); ?>

<?php Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl . '/css/wapi.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile($this->module->assetsUrl . "/javascript/wapi.js", CClientScript::POS_END); ?>

<!-- container -->
<div class="container-fluid margin-top-lg">

<!-- main-content -->
<div id="main-content">

	<div class="row">
		<div class="col-lg-12 layout-left"> 
			<?php echo $content; ?>
		</div>
	</div>

</div>
<!-- /main-content -->

</div> 
<!-- /container -->
<?php $this->endContent(); ?>

<?php Yii::app()->clientScript->registerScript('wapi-panel-0', "
	$(document).on('click','.btn-filterTag',function(){
		$(this).parents('.tab-pane').find('.btn-filterTag').removeClass('btn-primary').addClass('btn-default');
		$(this).addClass('btn-primary').removeClass('btn-default');
		var selectedTag = $(this).data('tag');
		if(selectedTag == '*')
		{
			$(this).parents('.tab-pane').find('form').show();
		}
		else
		{
			$(this).parents('.tab-pane').find('form').hide();
			$(this).parents('.tab-pane').find('form').each(function(){
				if($(this).hasClass(selectedTag)) $(this).show();
			});
		}
	});
"); ?>

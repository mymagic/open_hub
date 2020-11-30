<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/jquery/jquery.shuffle.min.js', CClientScript::POS_END);  ?>
<div id="site-browseProfile">


<div class="col col-sm-3">
	<?php $form = $this->beginWidget('ActiveForm', array(
		'id' => 'searchPortfolio-form',
		'action' => $this->createUrl('frontend/index'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false,
		'method' => 'GET',
		'htmlOptions' => array(
			'class' => 'form-vertical crud-form',
			'role' => 'form',
			'enctype' => 'multipart/form-data',
		)
	)); ?>

	
	<!-- jobpos -->
	<div id="boxFilter-jobpos" class="box-filter rounded-md">
		<p class="lead"><?php echo Yii::t('cv', 'Job Role') ?></p>
		<div class="checkbox checkbox-info">
			<?php echo $form->checkboxList($searchModel, 'jobpos', ysUtil::convertToKeyValueArray(CvJobpos::model()->getForeignReferList(), 'key', 'title'))?>
		</div>
	</div>
	<!-- /jobpos -->
	
	<!-- looks -->
	<div id="boxFilter-looks" class="box-filter rounded-md">
		<p class="lead"><?php echo Yii::t('cv', 'Looking for') ?></p>
		<div class="checkbox checkbox-info">
			<?php echo $form->checkboxList($searchModel, 'looks', ysUtil::convertToKeyValueArray(CvPortfolio::getLookingList(), 'code', 'title')) ?>
		</div>
	</div>
	<!-- /looks -->
	
	<!-- location -->
	<div id="boxFilter-location" class="box-filter rounded-md">
		<p class="lead"><?php echo Yii::t('cv', 'Location') ?></p>
		<div class="form-group has-feedback ">
			<div class="">
				<?php echo $form->bsTextField($searchModel, 'location', array('class' => 'form-control rounded-sm', 'placeholder' => 'Type a location')); ?>
				<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
			</div>
		</div>
	</div>
	<!-- /location -->
	
	<!-- program -->
	<div id="boxFilter-program" class="box-filter rounded-md hidden">
		<p class="lead"><?php echo Yii::t('cv', 'Course') ?></p>
		<div class="form-group has-feedback ">
			<div class="">
				<?php echo $form->bsTextField($searchModel, 'program', array('class' => 'form-control rounded-sm', 'placeholder' => "Type a course's keyword")); ?>
				<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
			</div>
		</div>
	</div>
	<!-- /program -->
	
	<!-- skillset -->
	<div id="boxFilter-skillset" class="box-filter rounded-md hidden">
		<p class="lead"><?php echo Yii::t('cv', 'Skillset') ?></p>
		<div class="form-group has-feedback ">
			<div class="">
				<?php echo $form->bsTextField($searchModel, 'skillset', array('class' => 'form-control rounded-sm', 'placeholder' => 'Type a skill')); ?>
				<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
			</div>
		</div>
	</div>
	<!-- /skillset -->

	<!-- name -->
	<div id="boxFilter-name" class="box-filter rounded-md">
		<p class="lead"><?php echo Yii::t('cv', 'Name') ?></p>
		<div class="form-group has-feedback ">
			<div class="">
				<?php echo $form->bsTextField($searchModel, 'name', array('class' => 'form-control rounded-sm', 'placeholder' => 'Type a name')); ?>
				<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
			</div>
		</div>
	</div>
	<!-- /name -->
	
	<?php $this->endWidget(); ?>
</div>

<div class="col col-sm-9">

<div id="list-filters" class="margin-bottom-2x">
<span class="text-muted"><?php echo Yii::t('cv', 'Filter(s)')?>:</span>
<?php if (!empty($_GET['CvSearchForm']['jobpos'])): foreach ($_GET['CvSearchForm']['jobpos'] as $g): ?>
	<a class="btn btn-info btn-xs" href="<?php echo $this->createUrl('/cv/frontend/clearSearchTag', array('group' => 'jobpos', 'value' => $g, 'url' => urlencode(Yii::app()->request->url)))?>"><?php echo Html::faIcon('fa-remove') ?> <?php echo ucwords(CvJobPos::id2title($g)) ?></a>
<?php endforeach; endif; ?>
<?php if (!empty($_GET['CvSearchForm']['looks'])): foreach ($_GET['CvSearchForm']['looks'] as $g): ?>
	<a class="btn btn-info btn-xs" href="<?php echo $this->createUrl('/cv/frontend/clearSearchTag', array('group' => 'looks', 'value' => $g, 'url' => urlencode(Yii::app()->request->url)))?>"><?php echo Html::faIcon('fa-remove') ?> <?php echo ucwords(CvPortfolio::lookingCode2Title($g)) ?></a>
<?php endforeach; endif; ?>
<?php if (!empty($_GET['CvSearchForm']['location'])): $g = $_GET['CvSearchForm']['location']; ?>
	<a class="btn btn-info btn-xs" href="<?php echo $this->createUrl('/cv/frontend/clearSearchTag', array('group' => 'location', 'value' => $g, 'url' => urlencode(Yii::app()->request->url)))?>"><?php echo Html::faIcon('fa-remove') ?> <?php echo ucwords($g) ?></a>
<?php endif; ?>
<?php if (!empty($_GET['CvSearchForm']['program'])): $g = $_GET['CvSearchForm']['program']; ?>
	<a class="btn btn-info btn-xs" href="<?php echo $this->createUrl('/cv/frontend/clearSearchTag', array('group' => 'program', 'value' => $g, 'url' => urlencode(Yii::app()->request->url)))?>"><?php echo Html::faIcon('fa-remove') ?> <?php echo ucwords($g) ?></a>
<?php endif; ?>
<?php if (!empty($_GET['CvSearchForm']['skillset'])): $g = $_GET['CvSearchForm']['skillset']; ?>
	<a class="btn btn-info btn-xs" href="<?php echo $this->createUrl('/cv/frontend/clearSearchTag', array('group' => 'skillset', 'value' => $g, 'url' => urlencode(Yii::app()->request->url)))?>"><?php echo Html::faIcon('fa-remove') ?> <?php echo ucwords($g) ?></a>
<?php endif; ?>
<?php if ($searchModel->hasFilter()):?><a id="btn-clearAll" class="btn btn-danger btn-xs" href="<?php echo $this->createUrl('/cv/frontend/index') ?>"><?php echo Html::faIcon('fa-remove') ?> <?php echo Yii::t('cv', 'Clear All') ?></a><?php else: ?>-<?php endif; ?>
</div>


<?php $this->widget('application.components.widgets.ListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_viewPortfolio',
	'template' => '{items} {pager}',
	'pagerCssClass' => 'pagination-dark',
	'id' => 'list-portfolio',
	'itemsCssClass' => 'container-flex',
)); ?>

</div>

</div>


<?php
// temporary disable as it spoiled the layout at bottom part near footer
/*Yii::app()->clientScript->registerScript("list-portfolio", '
$(document).ready(function () {
	 var $grid = $("#list-portfolio");

	$grid.shuffle({
		itemSelector: ".item" // the selector for the items in the grid
	});
});
');*/ ?>
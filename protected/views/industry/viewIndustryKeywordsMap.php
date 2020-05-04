<?php
/* @var $this IndustryController */
/* @var $model Industry */

$this->breadcrumbs = array(
	Yii::t('backend', 'Industries') => array('index'),
	Yii::t('backend', 'Keyword Mappings'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Create Industry'), 'url' => array('/industry/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Industry Keywords Mapping'), 'url' => array('/industry/viewIndustryKeywordsMap'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'viewIndustryKeywordsMap')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Industry Keywords Mapping'); ?></h1>

<ol>
<?php foreach ($industries as $industry): ?>
<li>
    <b><?php echo trim($industry->title)?></b>
    <p><?php echo $industry->renderIndustryKeywords() ?></p>
</li>
<?php endforeach; ?>
</ol>

<hr />
<h2>Markdown</h2>
<textarea class="full-width" rows="20">
<?php foreach ($industries as $industry): ?>
  * **<?php echo trim($industry->title)?>** - <?php echo $industry->renderIndustryKeywords() ?>

<?php endforeach; ?>
</textarea>
<?php 
	// codemirror
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/lib/codemirror.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/addon/edit/matchbrackets.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/addon/scroll/simplescrollbars.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/xml/xml.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/clike/clike.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/htmlmixed/htmlmixed.js', CClientScript::POS_END);

	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/lib/codemirror.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/theme/midnight.css');
?>

<form action="<?php echo $this->createUrl('lingual/editPredefined', array('scope' => $scope)) ?>" role="form" method="POST">
<h1>
<?php echo Yii::t('core', "Edit '{scope}' Predefined Tags", array('{scope}' => ucwords($scope))); ?> 
	<div class="btn-group pull-right">
		<input class="btn btn-primary" type="submit" value="<?php echo Yii::t('core', 'Save') ?>" />
		<a class="btn btn-default" href="<?php echo $this->createUrl('lingual/index') ?>"><?php echo Yii::t('core', 'Back') ?></a>
	</div>
</h1>
<input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>" />

<?php echo Notice::inline(Yii::t('notice', 'File Path') . ': ' . $filePath, Notice_INFO); ?>
<?php echo Html::textArea('content', $content, array('class' => 'full-width', 'rows' => 17)) ?>
</form>


<?php Yii::app()->clientScript->registerScript('js-lingual-editPredefined', <<<JS

var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
    htmlMode: true,
    lineNumbers: true,
    matchBrackets: true,
    mode: "text/html",
    indentUnit: 4,
    indentWithTabs: true,
    lineWrapping: true,
    scrollbarStyle: 'simple',
    theme:'midnight',  
});

JS
, CClientScript::POS_READY);?>
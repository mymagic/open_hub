<div id="select-language">
<?php 
	
	/*
	// Render options as dropDownList
	echo CHtml::form();
	foreach($languages as $key=>$lang) {
		echo CHtml::hiddenField(
			$key, 
			$this->getOwner()->createMultilanguageReturnUrl($key));
	}
	echo CHtml::dropDownList('language', $currentLang, $languages,
		array(
			'submit'=>'',
		)
	); 
	echo CHtml::endForm();*/

?>
	<div class="btn-group">
		<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
			<span id="languageSelectorFlag-<?php echo Yii::app()->language ?>" class="languageSelectorFlag"></span><?php echo $this->translateLanguageCode(Yii::app()->language) ?>&nbsp;
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<?php foreach(Yii::app()->params['languages'] as $langCode=>$language): ?>
				<?php if(Yii::app()->language == $langCode) continue; ?>
				<li><a href="<?php echo $this->getOwner()->createMultilanguageReturnUrl($langCode) ?>"><span id="languageSelectorFlag-<?php echo $langCode ?>" class="languageSelectorFlag"></span><?php echo $language ?></a></li>
			<?php endforeach; ?>
			
		</ul>
	</div>
</div>
<?php
class LanguageSelector extends CWidget
{
    public function run()
    {
        $currentLang = Yii::app()->language;
        $languages = Yii::app()->params->languages;
        $this->render('languageSelector', array('currentLang' => $currentLang, 'languages'=>$languages));
    }
	
	public function translateLanguageCode($lang)
	{
		$languages = Yii::app()->params['languages'];
		if(in_array($lang, array_keys($languages)))
		{
			return $languages[$lang];
		}
		
		return $lang;
	}
}
?>
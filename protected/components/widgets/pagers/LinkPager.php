<?php

class LinkPager extends CLinkPager
{
	// exiang: error, some server dont allow override constant value
	//const CSS_HIDDEN_PAGE='disabled';
	//const CSS_SELECTED_PAGE='selected active';
	public function init()
	{
		$this->hiddenPageCssClass = 'disabled';
		$this->selectedPageCssClass = 'selected active';
		
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','&gt;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt;');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&lt;&lt;');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','&gt;&gt;');
		/*if($this->header===null)
			$this->header=Yii::t('yii','Go to page: ');*/

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='pagination pagination-sm';
	}
}
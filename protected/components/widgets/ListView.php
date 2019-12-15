<?php
Yii::import("zii.widgets.CListView");
Yii::import("application.components.widgets.pagers.LinkPager");

class ListView extends CListView
{
	public $pager=array('class'=>'LinkPager');
	
	//
	public function init()
    {
		//$this->cssFile = true;
		$this->summaryCssClass .= 'text-left text-muted';
		$this->pagerCssClass .= ' text-center';
		$this->template = "{items}\n<div class=\"clearfix\"></div>\n<div class=\"\">&nbsp;{pager}</div>";
       return parent::init();
    }
	
	public function renderItems()
	{
		echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
		$data=$this->dataProvider->getData();
		if(($n=count($data))>0)
		{
			$owner=$this->getOwner();
			$viewFile=$owner->getViewFile($this->itemView);
			$j=0;
			foreach($data as $i=>$item)
			{
				$data=$this->viewData;
				$data['index']=$i;
				$data['data']=$item;
				$data['widget']=$this;
				if($this->dataProvider->pagination) 
				{
					$data['realIndex']=$i+$this->dataProvider->pagination->currentPage*$this->dataProvider->pagination->pageSize;
				} 
				else 
				{
					$data['realIndex']=$i;
				}
				  
				$owner->renderFile($viewFile,$data);
				if($j++ < $n-1)
					echo $this->separator;
			}
		}
		else
			$this->renderEmptyText();
		echo CHtml::closeTag($this->itemsTagName);
	}
}

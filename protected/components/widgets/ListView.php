<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/

Yii::import('zii.widgets.CListView');
Yii::import('application.components.widgets.pagers.LinkPager');

class ListView extends CListView
{
	public $pager = array('class' => 'LinkPager');

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
		echo CHtml::openTag($this->itemsTagName, array('class' => $this->itemsCssClass)) . "\n";
		$data = $this->dataProvider->getData();
		if (($n = count($data)) > 0) {
			$owner = $this->getOwner();
			$viewFile = $owner->getViewFile($this->itemView);
			$j = 0;
			foreach ($data as $i => $item) {
				$data = $this->viewData;
				$data['index'] = $i;
				$data['data'] = $item;
				$data['widget'] = $this;
				if ($this->dataProvider->pagination) {
					$data['realIndex'] = $i + $this->dataProvider->pagination->currentPage * $this->dataProvider->pagination->pageSize;
				} else {
					$data['realIndex'] = $i;
				}

				$owner->renderFile($viewFile, $data);
				if ($j++ < $n - 1) {
					echo $this->separator;
				}
			}
		} else {
			$this->renderEmptyText();
		}
		echo CHtml::closeTag($this->itemsTagName);
	}
}

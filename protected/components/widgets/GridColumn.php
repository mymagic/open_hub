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

abstract class GridColumnBase extends CGridColumn
{
	public function renderHeaderCell()
	{
		$this->headerHtmlOptions['id'] = $this->id;
		$this->headerHtmlOptions['class'] = 'red';
		echo CHtml::openTag('th', $this->headerHtmlOptions);
		$this->renderHeaderCellContent();
		echo '</th>';
	}
}

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

Yii::import('application.components.widgets.DataColumn');
Yii::import('zii.widgets.grid.CGridView');
Yii::import('application.components.widgets.pagers.LinkPager');

class GridView extends CGridView
{
	public $pager = array('class' => 'LinkPager');
	//public $itemCssClass = 'table table-striped table-bordered crud-grid';
	public $itemsHeaderCssClass = 'info';
	public $pagerCssClass = 'text-right';
	public $responsiveMethod = 'default';
	public $itemsHtmlOptions = array();
	public $responsiveOverlayMsg = '';
	public $viewData;

	//
	public function init()
	{
		//$this->cssFile = true;
		$this->summaryCssClass = 'text-left text-muted';
		if ($this->itemsCssClass == 'items') {
			$this->itemsCssClass = 'table table-striped table-bordered crud-grid';
		} else {
			//$this->itemsCssClass .= ' table table-bordered crud-grid ';
		}

		//$this->pagerCssClass = 'text-right';
		// exiang: tried to add additional (style:warning) to filter css class but it will make the js not functioning
		$this->filterCssClass = 'filters';
		$this->template = "<div class=\"row\"><div class=\"col-xs-4\">{summary}</div><div class=\"col-xs-8\">{pager}</div></div>\n{items}\n<div class=\"row\"><div class=\"col-xs-12\">&nbsp;{pager}</div></div>";

		parent::init();

		return true;
	}

	public function renderItems()
	{
		if ($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty) {
			if ($this->responsiveMethod == 'default') {
				echo '<div class="table-responsive">';
			} else {
				echo '<div class="">';
			}

			if (!empty($this->responsiveOverlayMsg)) {
				echo sprintf("<div class=\"table-responsive-OverlayMsg hidden\">%s</div>\n", $this->responsiveOverlayMsg);
			}

			if ($this->responsiveMethod == 'footable') {
				$this->itemsCssClass .= ' table-foo ';
			}

			$tableHtmlOptions = '';
			if (!empty($this->itemsHtmlOptions)) {
				foreach ($this->itemsHtmlOptions as $optionKey => $optionValue) {
					$tableHtmlOptions .= sprintf('%s="%s"', $optionKey, $optionValue);
				}
			}

			echo "<table class=\"
			{$this->itemsCssClass}\" {$tableHtmlOptions}>\n";
			$this->renderTableHeader();
			ob_start();
			$this->renderTableBody();
			$body = ob_get_clean();
			$this->renderTableFooter();
			echo $body; // TFOOT must appear before TBODY according to the standard.
			echo '</table></div>';
		} else {
			$this->renderEmptyText();
		}
	}

	public function renderTableHeader()
	{
		if (!$this->hideHeader) {
			echo "<thead >\n";

			if ($this->filterPosition === self::FILTER_POS_HEADER) {
				$this->renderFilter();
			}

			echo sprintf("<tr class=\"%s\">\n", $this->itemsHeaderCssClass);
			foreach ($this->columns as $column) {
				$column->renderHeaderCell();
			}
			echo "</tr>\n";

			if ($this->filterPosition === self::FILTER_POS_BODY) {
				$this->renderFilter();
			}

			echo "</thead>\n";
		} elseif ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
			echo "<thead>\n";
			$this->renderFilter();
			echo "</thead>\n";
		}
	}

	public function renderPager()
	{
		if (!$this->enablePagination) {
			return;
		}

		$pager = array();
		$class = 'LinkPager';
		if (is_string($this->pager)) {
			$class = $this->pager;
		} elseif (is_array($this->pager)) {
			$pager = $this->pager;
			if (isset($pager['class'])) {
				$class = $pager['class'];
				unset($pager['class']);
			}
		}
		$pager['pages'] = $this->dataProvider->getPagination();

		if ($pager['pages']->getPageCount() > 1) {
			echo '<div class="' . $this->pagerCssClass . '">';
			$this->widget($class, $pager);
			echo '</div>';
		} else {
			$this->widget($class, $pager);
		}
	}

	protected function initColumns()
	{
		if ($this->columns === array()) {
			if ($this->dataProvider instanceof CActiveDataProvider) {
				$this->columns = $this->dataProvider->model->attributeNames();
			} elseif ($this->dataProvider instanceof IDataProvider) {
				// use the keys of the first row of data as the default columns
				$data = $this->dataProvider->getData();
				if (isset($data[0]) && is_array($data[0])) {
					$this->columns = array_keys($data[0]);
				}
			}
		}
		$id = $this->getId();
		foreach ($this->columns as $i => $column) {
			if (is_string($column)) {
				$column = $this->createDataColumn($column);
			} else {
				if (!isset($column['class'])) {
					$column['class'] = 'DataColumn';
				}
				$column = Yii::createComponent($column, $this);
			}
			if (!$column->visible) {
				unset($this->columns[$i]);
				continue;
			}
			if ($column->id === null) {
				$column->id = $id . '_c' . $i;
			}
			$this->columns[$i] = $column;
		}

		foreach ($this->columns as $column) {
			$column->init();
		}
	}

	protected function createDataColumn($text)
	{
		if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
			throw new CException(Yii::t('zii', 'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
		}
		$column = new DataColumn($this);
		$column->name = $matches[1];
		if (isset($matches[3]) && $matches[3] !== '') {
			$column->type = $matches[3];
		}
		if (isset($matches[5])) {
			$column->header = $matches[5];
		}

		return $column;
	}

	public function renderSummary()
	{
		if (($count = $this->dataProvider->getItemCount()) <= 0) {
			return;
		}

		echo '<div class="' . $this->summaryCssClass . '">';
		if ($this->enablePagination) {
			$pagination = $this->dataProvider->getPagination();
			$total = $this->dataProvider->getTotalItemCount();
			$start = $pagination->currentPage * $pagination->pageSize + 1;
			$end = $start + $count - 1;
			if ($end > $total) {
				$end = $total;
				$start = $end - $count + 1;
			}
			if (($summaryText = $this->summaryText) === null) {
				$summaryText = Yii::t('zii', 'Displaying {start}-{end} of {count} results.');
			}
			echo strtr($summaryText, array(
				'{start}' => $start,
				'{end}' => $end,
				'{count}' => $total,
				'{page}' => $pagination->currentPage + 1,
				'{pages}' => $pagination->pageCount,
			));
		} else {
			if (($summaryText = $this->summaryText) === null) {
				$summaryText = Yii::t('zii', 'Total {count} results.');
			}
			echo strtr($summaryText, array(
				'{count}' => $count,
				'{start}' => 1,
				'{end}' => $count,
				'{page}' => 1,
				'{pages}' => 1,
			));
		}
		echo '</div>';
	}
}

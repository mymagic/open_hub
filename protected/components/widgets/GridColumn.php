<?php 
abstract class GridColumnBase extends CGridColumn
{
	public function renderHeaderCell()
	{
		$this->headerHtmlOptions['id']=$this->id;
		$this->headerHtmlOptions['class']='red';
		echo CHtml::openTag('th',$this->headerHtmlOptions);
		$this->renderHeaderCellContent();
		echo "</th>";
	}
}
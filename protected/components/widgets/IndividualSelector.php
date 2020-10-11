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

class IndividualSelector extends CWidget
{
	public $form;
	public $model;
	public $attribute;
	public $data = array();
	public $urlAjax;
	public $htmlOptions;
	public $selected;

	public function run()
	{
		$this->htmlOptions['class'] .= ' select2';

		// active model with form
		if (!empty($this->form) && !empty($this->model)) {
			if (empty($this->data)) {
				$this->data = array($this->attribute => $this->model->{$this->attribute});
			}
			$this->render('activeIndividualSelector', array('form' => $this->form, 'model' => $this->model, 'attribute' => $this->attribute, 'data' => $this->data, 'htmlOptions' => $this->htmlOptions, 'urlAjax' => $this->urlAjax));
		} else {
			$this->htmlOptions['class'] .= ' form-control';

			$this->render('individualSelector', array('model' => $this->model, 'attribute' => $this->attribute, 'selected' => $this->selected, 'data' => $this->data, 'htmlOptions' => $this->htmlOptions, 'urlAjax' => $this->urlAjax));
		}
	}
}

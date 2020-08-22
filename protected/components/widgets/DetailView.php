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

Yii::import('zii.widgets.CDetailView');
class DetailView extends CDetailView
{
	public $htmlOptions = array('class' => 'table-detail-view table table-striped');

	public function init()
	{
		return parent::init();
	}

	public function run()
	{
		$formatter = $this->getFormatter();
		if ($this->tagName !== null) {
			echo CHtml::openTag('div', array('class' => 'table-responsive'));
			echo CHtml::openTag($this->tagName, $this->htmlOptions);
		}

		$i = 0;
		$n = is_array($this->itemCssClass) ? count($this->itemCssClass) : 0;

		foreach ($this->attributes as $attribute) {
			if (is_string($attribute)) {
				if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $attribute, $matches)) {
					throw new CException(Yii::t('zii', 'The attribute must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
				}
				$attribute = array(
					'name' => $matches[1],
					'type' => isset($matches[3]) ? $matches[3] : 'text',
				);
				if (isset($matches[5])) {
					$attribute['label'] = $matches[5];
				}
			}

			if (isset($attribute['visible']) && !$attribute['visible']) {
				continue;
			}

			$tr = array('{label}' => '', '{class}' => $n ? $this->itemCssClass[$i % $n] : '');
			if (isset($attribute['cssClass'])) {
				$tr['{class}'] = $attribute['cssClass'] . ' ' . ($n ? $tr['{class}'] : '');
			}

			if (isset($attribute['label'])) {
				$tr['{label}'] = $attribute['label'];
			} elseif (isset($attribute['name'])) {
				if ($this->data instanceof CModel) {
					$tr['{label}'] = $this->data->getAttributeLabel($attribute['name']);
				} else {
					$tr['{label}'] = ucwords(trim(strtolower(str_replace(array('-', '_', '.'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $attribute['name'])))));
				}
			}

			if (!isset($attribute['type'])) {
				$attribute['type'] = 'text';
			}

			if (isset($attribute['value'])) {
				$value = is_callable($attribute['value']) ? call_user_func($attribute['value'], $this->data) : $attribute['value'];
			} elseif (isset($attribute['name'])) {
				$value = CHtml::value($this->data, $attribute['name']);
			} else {
				$value = null;
			}

			$tr['{value}'] = $value === null ? $this->nullDisplay : $formatter->format($value, $attribute['type']);

			$this->renderItem($attribute, $tr);

			$i++;
		}

		if ($this->tagName !== null) {
			echo CHtml::closeTag($this->tagName);
			echo CHtml::closeTag('div');
		}
	}
}

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

class CurrencyCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * updateCurrencyExchangeRate\ncall the api and record today exchange rate for all currency defined in the system with USD\n";
		echo "\n";
	}

	public function actionUpdateCurrencyExchangeRate()
	{
		$date = date('Y-m-d');
		HUB::recordCurrencyExchangeRates($date);

		Yii::app()->esLog->log(sprintf("called currency\updateCurrencyExchangeRate"), 'command', array('trigger' => 'CurrencyCommand::actionUpdateCurrencyExchangeRate', 'model' => '', 'action' => '', 'id' => ''), '', array('date' => $date));
	}
}

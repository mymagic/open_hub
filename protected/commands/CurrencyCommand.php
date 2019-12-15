<?php

class CurrencyCommand extends CConsoleCommand
{
    public $verbose=false;
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

		Yii::app()->esLog->log(sprintf("called currency\updateCurrencyExchangeRate"), 'command', array('trigger'=>'CurrencyCommand::actionUpdateCurrencyExchangeRate', 'model'=>'', 'action'=>'', 'id'=>''), '', array('date'=>$date));
	}
}
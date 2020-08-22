<?php

class getF7OpeningForms extends Action
{
	public function run()
	{
		$meta = array();

		$dateStart = Yii::app()->request->getPost('dateStart');
		$dateEnd = Yii::app()->request->getPost('dateEnd');
		$forceRefresh = Yii::app()->request->getPost('forceRefresh');

		$meta['input']['dateStart'] = $dateStart;
		$meta['input']['dateEnd'] = $dateEnd;
		$meta['input']['forceRefresh'] = $forceRefresh;

		try {
			$result = HubForm::getOpeningForms($dateStart, $dateEnd);

			$result['meta'] = $meta;

			$this->getController()->outputPipe($result);
		} catch (GuzzleHttp\Exception\ClientException $e) {
			$jsonArray = json_decode($e->getResponse()->getBody()->getContents());
			$this->getController()->outputFail($jsonArray->error, $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}

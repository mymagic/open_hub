<?php

class ApiController extends Controller
{
	public function actionGetOrganizationLog($organizationId, $page = 1)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getEsLogs',
			[
				'form_params' => [
					'page' => $page,
					'filter' => json_encode(['match' => ['organizationId' => $organizationId]])
				],
				'verify' => false,
			]
			);
		} catch (Exception $e) {
			$this->outputJsonFail($e->getMessage());
		}

		header('Content-type: application/json');
		echo $response->getBody();
	}
}

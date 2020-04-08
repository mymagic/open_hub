<?php

class BackendController extends Controller
{
	public $layout = 'layouts.backend';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('getSystemActFeed'),
				'users' => array('@'),
				'expression' => '$user->accessBackend==true',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionGetSystemActFeed($page)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getEsLogSystemActFeed',
			[
				'form_params' => [
					'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'forceRefresh' => $forceRefresh,
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

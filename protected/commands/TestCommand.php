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

class TestCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * organizationComments\nCheck is organization comment injected method behavior working in command environment\n";
		echo "  * createJunk --note=anything\nCreate a junk instance and pass in value, for testing cron job running properly or not\n";
		echo "  * guzzle\nconnect to futurelab and list all program using guzzle to check is guzzle working or not\n";
		echo "  * yiiPath\nto check yii path is correct or not\n";
		echo "  * getPath\nget path from alias\n";
		echo "\n";
	}

	public function actionGetPath()
	{
		echo Yii::getPathOfAlias('wwwroot') . "\n";
		echo Yii::getPathOfAlias('components') . "\n";
	}

	public function actionOrganizationComments()
	{
		var_dump(Yii::app()->getModule('comment')->abc);
		$org = Organization::model()->findByPk(3582);
		echo $org->countAllComments();
		var_dump($org->getActiveComments(1));
	}

	public function actionCreateUrl()
	{
		//echo UrlHelper::toAbsoluteUrl(Html::normalizeUrl(array('address/update', 'id'=>4)));
		//echo Yii::app()->createAbsoluteUrl('address/update', array('id'=>4));
		echo Yii::app()->createAbsoluteUrl('frontend/contact');
	}

	/*public function actionSendNotify()
	{
		RDS::sendNotify('member', 'exiang83@yahoo.com', json_encode(array(
			'msg'=>'Test sending Notify from CLI',
			'link'=>Yii::app()->createAbsoluteUrl('address/update', array('id'=>4)),
			)),
			'Test Sending Notify from CLI', 'No content here', 4
		);
	}*/

	public function actionCreateJunk($note)
	{
		echo "start createJunk()\n";
		$junk = new Junk;
		$junk->code = 'testCronCreateJunk-' . time();
		$junk->content = $note;
		$junk->save();
		echo "end createJunk()\n";
	}

	public function actionYsUtil()
	{
		echo YsUtil::generateUUID();
	}

	public function actionGuzzle()
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->getModule('mentor')->futurelabApiBaseUrl]);

		$response = $client->request(
			'GET',

			'programs/',
			['headers' => [
					'client-secret' => Yii::app()->getModule('mentor')->futurelabApiSecret,
					'Accept' => 'application/json',
					'Content-Type' => 'application/json'
				],
			'form_params' => []
			]
		);
		$body = (string)$response->getBody();
		echo $body;
	}

	public function actionYiiPath()
	{
		Yii::setPathOfAlias('abc', '/var/www');
		echo Yii::getPathOfAlias('abc');
		echo "\n";
		echo Yii::getPathOfAlias('wwwroot');
		echo "\n";
		echo Yii::getPathOfAlias('uploads');
		echo "\n";
	}

	public function actionRemoteImageUpload()
	{
		$urlImage = 'https://dummyimage.com/600x400/7a7a7a/fff';
		$ruf = new RemoteUploadedFile;
		$ruf->setUrl($urlImage);
		var_dump($ruf);

		$title = 'whenso';
		$org = Organization::title2obj($title);
		$org->imageRemote_logo = $ruf;
		$org->save();
		RemoteUploadManager::storeImage($org, 'logo', $org->tableName());

		echo sprintf('<p>%s</p><p>Thumbnail: <img src="%s"></p><p>Fullsize: <img src="%s"></p>', $org->getImageLogoUrl(), $org->getImageLogoThumbUrl(), $org->getImageLogoUrl());
	}

	public function actionEsLog()
	{
		// check is Yii::app()->esLog working properly
		echo Yii::app()->esLog->esTestVar;
		Yii::app()->esLog->esTestVar = 'abc';
		echo Yii::app()->esLog->esTestVar;

		// create a new item
		$response = Yii::app()->esLog->log('test command line', 'command', array('hello' => 'world'), 'exiang83@yahoo.com');

		// try retrieve back the created item
		$params = [
			'index' => Yii::app()->esLog->esLogIndexCode,
			'type' => 'command',
			'id' => $response['_id']
		];
		$response = Yii::app()->esLog->getClient()->get($params);
		var_dump($response);

		// try delete the created item
		$response = Yii::app()->esLog->getClient()->delete($params);
		var_dump($response);
	}
}

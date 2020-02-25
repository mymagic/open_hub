<?php

class deleteCollection extends Action
{
	public function run()
	{
		$meta = array();
		$jwt = Yii::app()->request->getPost('jwt');
		$id = Yii::app()->request->getPost('id');

		$meta['input']['jwt'] = $jwt;
		$meta['input']['id'] = $id;

		$token = $this->getController()->validateJwt($jwt, $meta);
		$user = HUB::getUserByUsername($token->data->username);

		try {
			$this->getController()->outputSuccess(HubCollection::deleteCollection($user, $id), $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}

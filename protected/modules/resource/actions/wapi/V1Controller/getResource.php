<?php

class getResource extends Action
{
	public function run()
	{
		$meta = array();
		$id = Yii::app()->request->getPost('id');
		$meta['input']['id'] = $id;

		try {
			$resource = HUB::getResource($id);
			$this->getController()->outputSuccess($resource->toApi(), $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}

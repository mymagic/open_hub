<?php

class getResourceBySlug extends Action
{
	public function run()
	{
		$meta = array();
		$slug = Yii::app()->request->getPost('slug');
		$meta['input']['slug'] = $slug;

		try {
			$resource = HubResource::getBySlug($slug);
			$this->getController()->outputSuccess($resource->toApi(array('config' => array('mode' => 'public'))), $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}

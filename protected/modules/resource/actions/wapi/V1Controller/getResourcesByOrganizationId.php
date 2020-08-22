<?php

class getResourcesByOrganizationId extends Action
{
	public function run()
	{
		$meta = array();
		$result = array();
		$id = Yii::app()->request->getPost('id');
		$meta['input']['id'] = $id;

		try {
			$organization = HUB::getOrganization($id);
			$tmp = $organization->resources;
			foreach ($tmp as $r) {
				$result[] = $r->toApi(array('-organizations', '-industries', '-personas', '-startupStages', '-resourceCategories', '-resourceGeofocuses'));
			}
			$this->getController()->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}

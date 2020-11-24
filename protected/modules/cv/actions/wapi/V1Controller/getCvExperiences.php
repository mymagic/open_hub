<?php

class getCvExperiences extends Action
{
	public function run()
	{
		$limit = 30;
		if (Yii::app()->params['dev']) {
			$limit = 3;
		}

		$meta = array();
		$username = Yii::app()->request->getPost('username');
		$page = Yii::app()->request->getPost('page');

		$page = empty($page) ? 1 : $page;

		// $meta['input']['username'] = $username; // hide this for privacy issue
		$meta['input']['page'] = $page;
		$meta['output']['limit'] = $limit;

		try {
			$user = HUB::getUserByUsername($username);
			$portfolio = HubCv::getCvPortfolioByUser($user);
			$totalItems = $portfolio->gaugeComposedExperiences();
			$data = $portfolio->getComposedExperiences($page, $limit);

			$meta['output']['limit'] = $limit; // limit of this page
			$meta['output']['countPageItems'] = count($data); // total item in this page
			$meta['output']['totalItems'] = $totalItems; // total item in database to load
			$meta['output']['totalPages'] = ceil($totalItems / $limit); // total pages can be loaded

			$this->getController()->outputSuccess($data, $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}

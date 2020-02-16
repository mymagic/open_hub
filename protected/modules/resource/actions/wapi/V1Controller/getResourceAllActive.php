<?php

class getResourceAllActive extends Action
{
    public function run()
    {
        $meta = array();
        $keyword = Yii::app()->request->getPost('keyword');
        $persona = Yii::app()->request->getPost('persona');
        $stage = Yii::app()->request->getPost('stage');
        $industry = Yii::app()->request->getPost('industry');
        $location = Yii::app()->request->getPost('location');
        $cat = Yii::app()->request->getPost('cat');
        $page = Yii::app()->request->getPost('page');
		$meta['input']['keyword'] = $keyword;
		$meta['input']['persona'] = $persona;
		$meta['input']['stage'] = $stage;
		$meta['input']['industry'] = $industry;
		$meta['input']['location'] = $location;
		$meta['input']['cat'] = $cat;
		$meta['input']['page'] = $page;

		$tmps = HUB::getResourceAllActive(
			$page,
			array(
				'keyword'=>$keyword,
				'persona'=>$persona,
				'stage'=>$stage,
				'industry'=>$industry,
				'location'=>$location,
				'cat'=>$cat,
			)
		);
		
		if(!empty($tmps['items']))
		{
			foreach($tmps['items'] as $tmp)
			{
				$result[] = $tmp->toApi();
			}
		}

		if(Yii::app()->params['dev']) $meta['output']['sql'] = $tmps['sql'];
		$meta['output']['limit'] = $tmps['limit'];
		$meta['output']['countPageItems'] = $tmps['countPageItems'];
		$meta['output']['totalItems'] = $tmps['totalItems'];
		$meta['output']['totalPages'] = $tmps['totalPages'];
		$meta['output']['filters'] = $tmps['filters'];
		
		$this->getController()->outputSuccess($result, $meta);
    }
}
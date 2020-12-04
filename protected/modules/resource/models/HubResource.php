<?php

class HubResource
{
	public static function getTypefors()
	{
		return array(
			'fund' => 'Funding',
			'space' => 'Space',
			'award' => 'Competitions & Awards',
			'program' => 'Dev & Training Program',
			'media' => 'Media & Blogs',
			'legislation' => 'Legislation',
			'other' => 'Other'
		);
	}

	protected static function getSlugTitle($type, $slugArray, $keyword, $language = '')
	{
		//echo sprintf('%s - %s<br>', $type, $keyword);

		foreach ($slugArray as $slugItem) {
			if ($slugItem->slug == $keyword) {
				$varTitle = sprintf('title_%s', $language);

				return array('type' => $type, 'code' => $keyword, 'title' => $slugItem->$varTitle);
			}
		}
	}

	// and unblocked too
	public static function getAllActive($page = '1', $filter = '')
	{
		$page = !empty($page) ? $page : 1;
		// todo: implement cache
		$limitPerPage = 10;
		$limit = $limitPerPage * $page;
		$offset = ($page - 1) * $limitPerPage;
		$bufferFilter = 'r.is_active=1 AND r.is_blocked=0';
		$filters = array();

		$typefors = array_keys(self::getTypefors());

		$slugTitleArray = [
			'personas' => self::getPersonas(true),
			'startupStages' => self::getStartupStages(true),
			'industries' => self::getIndustries(),
			'categories' => self::getCategories(true),
			'locations' => self::getGeofocuses(true)
		];

		if (!empty($filter) && is_array($filter)) {
			// keyword
			$filter['keyword'] = preg_replace('/[^A-Za-z0-9\-\,\.\* ]/', '', $filter['keyword']);
			if (!empty($filter['keyword'])) {
				$filterKeywords = array_map('trim', explode(',', $filter['keyword']));
				$bufferSubFilter = '';
				foreach ($filterKeywords as $keyword) {
					$bufferSubFilter .= sprintf("r.title LIKE '%%%s%%' OR ", $keyword);
					$bufferSubFilter .= sprintf("r.title_ms LIKE '%%%s%%' OR ", $keyword);
					$bufferSubFilter .= sprintf("organization.title LIKE '%%%s%%' OR ", $keyword);
					$filters[] = array('type' => 'keyword', 'code' => 'keyword', 'title' => $keyword);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}

			// persona
			$filter['persona'] = preg_replace('/[^A-Za-z0-9\-\,\.\* ]/', '', $filter['persona']);
			if (!empty($filter['persona'])) {
				$filterPersonas = array_map('trim', explode(',', $filter['persona']));
				$bufferSubFilter = '';
				foreach ($filterPersonas as $keyword) {
					$bufferSubFilter .= sprintf("persona.slug='%s' OR ", $keyword);
					$filters[] = self::getSlugTitle('persona', $slugTitleArray['personas'], $keyword, Yii::app()->language);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}

			// resourceCategory
			$filter['cat'] = preg_replace('/[^A-Za-z0-9\-\,\.\* ]/', '', $filter['cat']);
			if (!empty($filter['cat'])) {
				$filterCats = array_map('trim', explode(',', $filter['cat']));
				$bufferSubFilter = '';
				foreach ($filterCats as $keyword) {
					if (substr($keyword, 0, strlen('biz') == 'biz')) {
						$keyword = substr($keyword, strlen('biz'));
					}

					if (strstr($keyword, '.*')) {
						$typefor = str_replace('.*', '', $keyword);

						if (in_array($typefor, $typefors)) {
							$bufferSubFilter .= sprintf("r.typefor='%s' OR ", $typefor);

							$filters[] = array('type' => 'cat', 'code' => $keyword, 'title' => $slugTitleArray['categories'][$typefor]);
						}
					} else {
						$bufferSubFilter = sprintf("cat.slug='%s' OR ", $keyword);

						$filters[] = array('type' => 'cat', 'code' => $keyword, 'title' => $slugTitleArray['categories'][$keyword]);
						//$filters[] = self::getSlugTitle('cat', $slugTitleArray['categories'], $keyword, Yii::app()->language);

						// ignore parent if any child found
						$tmp = explode('.', $keyword);
						$typefor = $tmp[0];

						if (!empty($typefor)) {
							foreach ($filters as $key => $filter) {
								if ($filter['type'] == 'cat' && $filter['code'] == $typefor . '.*') {
									unset($filters[$key]);
									$bufferSubFilter = str_replace(sprintf("r.typefor='%s' OR ", $typefor), '', $bufferSubFilter);
								}
							}
						}
					}
				}

				if (!empty($bufferSubFilter)) {
					$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
					$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
				}
			}

			// startupStage
			$filter['stage'] = preg_replace('/[^A-Za-z0-9\-\,\.\* ]/', '', $filter['stage']);
			if (!empty($filter['stage'])) {
				$filterStages = array_map('trim', explode(',', $filter['stage']));
				$bufferSubFilter = '';
				foreach ($filterStages as $keyword) {
					$bufferSubFilter .= sprintf("stage.slug='%s' OR ", $keyword);
					//$filters[] = array('type'=>'stage', 'code'=>$keyword, 'title'=>$slugTitleArray['startupStages'][$keyword]);
					$filters[] = self::getSlugTitle('stage', $slugTitleArray['startupStages'], $keyword, Yii::app()->language);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}

			// industry
			$filter['industry'] = preg_replace('/[^A-Za-z0-9\-\,\.\* ]/', '', $filter['industry']);
			if (!empty($filter['industry'])) {
				$filterIndustries = array_map('trim', explode(',', $filter['industry']));
				$bufferSubFilter = '';
				foreach ($filterIndustries as $keyword) {
					$bufferSubFilter .= sprintf("industry.slug='%s' OR ", $keyword);
					//$filters[] = array('type'=>'industry', 'code'=>$keyword, 'title'=>$slugTitleArray['industries'][$keyword]);
					$filters[] = self::getSlugTitle('industry', $slugTitleArray['industries'], $keyword, Yii::app()->language);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}

			// resourceGeofocus
			//$filter['location'] = preg_replace('/[^A-Za-z0-9\,\.]/', '', $filter['location']);
			if (!empty($filter['location'])) {
				$filterLocations = array_map('trim', explode(',', $filter['location']));
				$bufferSubFilter = '';
				foreach ($filterLocations as $keyword) {
					$bufferSubFilter .= sprintf("location.slug='%s' OR ", $keyword);
					$filters[] = array('type' => 'location', 'code' => $keyword, 'title' => $slugTitleArray['locations'][$keyword]);
					//$filters[] = self::getSlugTitle('location', $slugTitleArray['locations'], $keyword, Yii::app()->language);

					// ignore parent if any child found
					$tmp = explode('.', $keyword);
					$typefor = $tmp[0];

					if (!empty($typefor) && !empty($tmp[1])) {
						foreach ($filters as $key => $filter) {
							if ($filter['type'] == 'location' && $filter['code'] == $typefor) {
								unset($filters[$key]);
								$bufferSubFilter = str_replace(sprintf("location.slug='%s' OR ", $typefor), '', $bufferSubFilter);
							}
						}
					}
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}
		}

		// echo $bufferFilter;exit;
		//print_r($filters);exit;

		$sqlCount = sprintf('SELECT COUNT(*) FROM (SELECT r.id FROM resource as `r` 
		LEFT JOIN resource2persona as `r2p` ON r2p.resource_id=r.id 
		LEFT JOIN persona as persona ON r2p.persona_id=persona.id
		
		LEFT JOIN resource2resource_category as `r2c` ON r2c.resource_id=r.id 
		LEFT JOIN resource_category as cat ON r2c.resource_category_id=cat.id
		
		LEFT JOIN resource2startup_stage as `r2s` ON r2s.resource_id=r.id 
		LEFT JOIN startup_stage as stage ON r2s.startup_stage_id=stage.id
		
		LEFT JOIN resource2industry as `r2i` ON r2i.resource_id=r.id 
		LEFT JOIN industry as industry ON r2i.industry_id=industry.id
		
		LEFT JOIN resource2resource_geofocus as `r2g` ON r2g.resource_id=r.id 
		LEFT JOIN resource_geofocus as location ON r2g.resource_geofocus_id=location.id

		LEFT JOIN resource2organization `r2o` ON r2o.resource_id=r.id 
		LEFT JOIN organization as organization ON r2o.organization_id=organization.id
	
		WHERE %s GROUP BY r.id ORDER BY r.title ASC) tmp', $bufferFilter);

		$sql = sprintf('SELECT r.* FROM resource as `r` 
		LEFT JOIN resource2persona as `r2p` ON r2p.resource_id=r.id 
		LEFT JOIN persona as persona ON r2p.persona_id=persona.id
		
		LEFT JOIN resource2resource_category as `r2c` ON r2c.resource_id=r.id 
		LEFT JOIN resource_category as cat ON r2c.resource_category_id=cat.id
		
		LEFT JOIN resource2startup_stage as `r2s` ON r2s.resource_id=r.id 
		LEFT JOIN startup_stage as stage ON r2s.startup_stage_id=stage.id
	
		LEFT JOIN resource2industry as `r2i` ON r2i.resource_id=r.id 
		LEFT JOIN industry as industry ON r2i.industry_id=industry.id
		
		LEFT JOIN resource2resource_geofocus as `r2g` ON r2g.resource_id=r.id 
		LEFT JOIN resource_geofocus as location ON r2g.resource_geofocus_id=location.id
		
		LEFT JOIN resource2organization `r2o` ON r2o.resource_id=r.id 
		LEFT JOIN organization as organization ON r2o.organization_id=organization.id
	
		WHERE %s GROUP BY r.id ORDER BY r.title ASC LIMIT %s, %s ', $bufferFilter, $offset, $limitPerPage);

		// echo $sql;exit;

		$return['sql'] = $sql;
		$return['filters'] = $filters;
		$return['items'] = Resource::model()->findAllBySql($sql);
		$return['countPageItems'] = count($return['items']);
		$return['limit'] = $limitPerPage;
		$return['totalItems'] = Yii::app()->db->createCommand($sqlCount)->queryScalar();
		$return['totalPages'] = ceil($return['totalItems'] / $limit);

		return $return;
	}

	public static function getAllFeatured()
	{
		// todo: implement cache
		$page = 1;
		$limitPerPage = 100;
		$limit = $limitPerPage * $page;
		$offset = ($page - 1) * $limitPerPage;

		$bufferFilter = 'r.is_active=1 AND r.is_featured=1 AND r.is_blocked=0';
		$filters = array();

		$typefors = array_keys(self::getTypefors());

		$tempSql = 'SELECT r.* FROM resource as `r` 
		LEFT JOIN resource2persona as `r2p` ON r2p.resource_id=r.id 
		LEFT JOIN persona as persona ON r2p.persona_id=persona.id
		
		LEFT JOIN resource2resource_category as `r2c` ON r2c.resource_id=r.id 
		LEFT JOIN resource_category as cat ON r2c.resource_category_id=cat.id
		
		LEFT JOIN resource2startup_stage as `r2s` ON r2s.resource_id=r.id 
		LEFT JOIN startup_stage as stage ON r2s.startup_stage_id=stage.id

		LEFT JOIN resource2industry as `r2i` ON r2i.resource_id=r.id 
		LEFT JOIN industry as industry ON r2i.industry_id=industry.id
		
		LEFT JOIN resource2resource_geofocus as `r2g` ON r2g.resource_id=r.id 
		LEFT JOIN resource_geofocus as location ON r2g.resource_geofocus_id=location.id

		WHERE %s GROUP BY r.id ORDER BY r.title ASC ';

		$sql = sprintf($tempSql, $bufferFilter);
		$return['sql'] = $sql;

		$return['filters'] = $filters;
		$return['items'] = Resource::model()->findAllBySql($sql);
		$return['countPageItems'] = count($return['items']);
		$return['limit'] = $limitPerPage;
		$return['totalPages'] = $limitPerPage ? ceil($return['totalItems'] / $limitPerPage) : 0;

		return $return;
	}

	public static function getResource($id)
	{
		$resource = Resource::model()->findByPk($id);
		if ($resource === null) {
			throw new CHttpException(404, 'The requested resource does not exist.');
		}

		return $resource;
	}

	public static function getBySlug($slug)
	{
		$resource = Resource::slug2obj($slug);
		if ($resource === null) {
			throw new CHttpException(404, 'The requested resource does not exist.');
		}

		return $resource;
	}

	public static function getIndustries($lang = '')
	{
		if ($lang == '') {
			$lang = Yii::app()->language;
		}

		$sql = sprintf('SELECT i.* FROM `industry` as i, resource as r, resource2industry as r2i WHERE r2i.resource_id=r.id AND r2i.industry_id=i.id AND r.is_active=1 AND i.is_active=1 GROUP BY i.id ORDER BY i.title_%s ASC', $lang);

		$assocArray = array();
		$return = array();

		return Industry::model()->findAllBySql($sql);
	}

	public static function getStartupStages()
	{
		$sql = 'SELECT s.* FROM `startup_stage` as s, resource as r, resource2startup_stage as r2s WHERE r2s.resource_id=r.id AND r2s.startup_stage_id=s.id AND r.is_active=1 AND s.is_active=1 GROUP BY s.id ORDER BY s.ordering ASC';

		return StartupStage::model()->findAllBySql($sql);
	}

	public static function getPersonas()
	{
		$sql = 'SELECT p.* FROM `persona` as p, resource as r, resource2persona as r2p WHERE r2p.resource_id=r.id AND r2p.persona_id=p.id AND r.is_active=1 AND p.is_active=1 GROUP BY p.id';

		return Persona::model()->findAllBySql($sql);
	}

	public static function tCategoryTitle($value)
	{
		if ($value == 'fund') {
			return Yii::t('resource', 'Fund');
		} elseif ($value == 'space') {
			return Yii::t('resource', 'Space');
		} elseif ($value == 'award') {
			return Yii::t('resource', 'Award');
		} elseif ($value == 'program') {
			return Yii::t('resource', 'Program');
		} elseif ($value == 'media') {
			return Yii::t('resource', 'Media');
		} elseif ($value == 'legislation') {
			return Yii::t('resource', 'Legislation');
		} elseif ($value == 'other') {
			return Yii::t('resource', 'Others');
		}
	}

	public static function getCategories($returnOneAssocArray = false)
	{
		$sql = 'SELECT c.* FROM `resource_category` as c, resource as r, resource2resource_category as r2c WHERE r2c.resource_id=r.id AND r2c.resource_category_id=c.id AND r.is_active=1 AND c.is_active=1 GROUP BY c.id ORDER BY typefor ASC, c.title ASC';
		$assocArray = array();

		$tmps = ResourceCategory::model()->findAllBySql($sql);
		$typefors = array('fund', 'space', 'award', 'program', 'media', 'legislation', 'other');
		foreach ($typefors as $typefor) {
			$childs = array();
			foreach ($tmps as $tmp2) {
				if (substr($tmp2->slug, 0, strlen($typefor . '.')) == $typefor . '.') {
					$assocArray[$tmp2->slug] = $tmp2->title;
					$childs[] = $tmp2;
				}
			}
			$assocArray[$typefor] = self::tCategoryTitle($typefor);
			$return[] = array('slug' => $typefor, 'title' => self::tCategoryTitle($typefor), 'textShortDescription' => '', 'childs' => $childs);
		}

		return $returnOneAssocArray ? $assocArray : $return;
	}

	public static function getGeofocuses($returnOneAssocArray = false)
	{
		$sql = 'SELECT g.* FROM `resource_geofocus` as g, resource as r, resource2resource_geofocus as r2g WHERE r2g.resource_id=r.id AND r2g.resource_geofocus_id=g.id AND r.is_active=1 AND g.is_active=1 GROUP BY g.id ORDER BY g.slug ASC';
		$assocArray = array();

		$tmps = ResourceGeofocus::model()->findAllBySql($sql);
		foreach ($tmps as $tmp) {
			if (!strstr($tmp->slug, '.')) {
				$childs = array();
				foreach ($tmps as $tmp2) {
					// echo $tmp->slug.'|';
					// echo substr($tmp2->slug, 0, strlen($tmp->slug.'.')).'<br>';
					if (substr($tmp2->slug, 0, strlen($tmp->slug . '.')) == $tmp->slug . '.') {
						$assocArray[$tmp2->slug] = $tmp2->title;
						$childs[] = $tmp2;
					}
				}
				$assocArray[$tmp->slug] = $tmp->title;
				$return[] = array('slug' => $tmp->slug, 'title' => $tmp->title, 'textShortDescription' => '', 'childs' => $childs);
			}
		}

		return $returnOneAssocArray ? $assocArray : $return;
	}

	public static function getOrganizations()
	{
		$sql = 'SELECT o.* FROM `organization` as o, resource as r, resource2organization as r2o WHERE r2o.resource_id=r.id AND r2o.organization_id=o.id AND r.is_active=1 AND o.is_active=1 GROUP BY o.id ORDER BY o.title ASC';

		return Organization::model()->findAllBySql($sql);
	}

	public static function getResourcesFromOrganization($organization)
	{
		return Resource::model()->findAllBySql(sprintf('SELECT r.* FROM resource AS r LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id WHERE r2o.organization_id=%s', $organization->id));
	}
}

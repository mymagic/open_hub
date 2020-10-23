<?php

class BuildSetting
{
	private $moduleName;
	private $tableName;
	private $buildFilePath;
	private $buildArray;

	public function setBuildArray($array)
	{
		$this->buildArray = $array;
	}

	public function getBuildArray()
	{
		return $this->buildArray;
	}

	public function getBuildFilePath()
	{
		return $this->buildFilePath;
	}

	public function loadBuildFile($tableName, $moduleName = '')
	{
		$this->tableName = $tableName;
		$this->moduleName = $moduleName;

		// look for build file in module directory first
		$moduleBuildFilePath = sprintf('%s%s%s%sdata%s%s.build.php', Yii::getPathOfAlias('modules'), DIRECTORY_SEPARATOR, $moduleName, DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $tableName);
		//echo $moduleBuildFilePath;exit;
		if (!empty($moduleName) && file_exists($moduleBuildFilePath)) {
			$this->buildFilePath = $moduleBuildFilePath;
		} else {
			$this->buildFilePath = sprintf('%s%s%s.build.php', Yii::getPathOfAlias('data'), DIRECTORY_SEPARATOR, $tableName);
		}

		//echo $this->buildFilePath;exit;
		$this->buildArray = include $this->buildFilePath;
		//echo '<pre>';print_r($this->buildArray);exit;
	}

	public function camel2Word($camel)
	{
		$camel = ucwords($camel);
		preg_match_all('/((?:^|[A-Z])[a-z]+)/', $camel, $matches);
		echo implode(' ', $matches[0]);
	}

	public function getAdminSortDefaultOrder()
	{
		$as = $this->getBuildArray();
		if (!empty($as['admin']['sortDefaultOrder'])) {
			return $as['admin']['sortDefaultOrder'];
		}
	}

	public function getUUIDColumns()
	{
		$as = $this->getBuildArray();
		$results = array();
		foreach ($as['structure'] as $ak => $av) {
			if (isset($av['isUUID']) && $av['isUUID'] == true) {
				$results[] = $ak;
			}
		}

		return $results;
	}

	public function getUniqueColumns()
	{
		$as = $this->getBuildArray();
		$results = array();
		foreach ($as['structure'] as $ak => $av) {
			if (isset($av['isUnique']) && $av['isUnique'] == true) {
				$results[] = $ak;
			}
		}

		return $results;
	}

	public function getEnumColumns()
	{
		$as = $this->getBuildArray();
		$results = array();
		foreach ($as['structure'] as $ak => $av) {
			if ($av['isEnum'] == true) {
				$results[] = $ak;
			}
		}

		return $results;
	}

	public function getJsonColumns()
	{
		$as = $this->getBuildArray();
		$results = array();
		foreach ($as['json'] as $ak => $av) {
			$results[] = $ak;
		}

		return $results;
	}

	public function getJsonColumnData($key)
	{
		$as = $this->getBuildArray();

		return $as['json'][$key];
	}

	public function extractRawJsonColumnName($columnName)
	{
		return str_replace('json_', '', $columnName);
	}

	public function camelizeColumnName($columnName)
	{
		//return ucwords($columnName);
		/*
		  * is_active -> isActive
		*/
		return lcfirst(str_replace(' ', '', ucwords(trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $columnName)))))));
	}

	public function figureEnumFunctionName($columnName)
	{
		//return ucwords($columnName);
		/*
		  * gender -> Gender
		  * gender_sexual -> GenderSexual
		  * gender-sexual -> GenderSexual (should not happen as yii does not allow - in table column name)
		*/
		return str_replace(' ', '', ucwords(trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $columnName))))));
	}

	public function isIdColumn($column)
	{
		if ($column->name == 'id') {
			return true;
		}

		return false;
	}

	public function isUUIdColumn($column)
	{
		$uuidColumns = $this->getUUIDColumns();
		if (in_array($column->name, $uuidColumns)) {
			return true;
		}

		return false;
	}

	public function isPasswordColumn($column)
	{
		if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
			return true;
		}
		if (strpos($column->name, 'password') !== false) {
			return true;
		}

		return false;
	}

	public function isOrderingColumn($column)
	{
		if (substr($column->name, 0, 8) == 'ordering') {
			return true;
		}

		return false;
	}

	public function isBooleanColumn($column)
	{
		if (substr($column->name, 0, 3) == 'is_' && stripos($column->dbType, 'int') !== false) {
			return true;
		}

		return false;
	}

	public function getBooleanColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isBooleanColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isDateColumn($column)
	{
		if (substr($column->name, 0, 5) == 'date_' && stripos($column->dbType, 'int') !== false) {
			return true;
		}

		return false;
	}

	public function getDateColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isDateColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isHtmlColumn($column)
	{
		if (substr($column->name, 0, 5) == 'html_') {
			return true;
		}

		return false;
	}

	public function getHtmlColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isHtmlColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isImageColumn($column)
	{
		if (substr($column->name, 0, 6) == 'image_' && stripos($column->dbType, 'varchar') !== false) {
			return true;
		}

		return false;
	}

	public function getImageColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isImageColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isFileColumn($column)
	{
		if (substr($column->name, 0, 5) == 'file_' && stripos($column->dbType, 'varchar') !== false) {
			return true;
		}

		return false;
	}

	public function getFileColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isFileColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isNumericColumn($column)
	{
		if ((stripos($column->dbType, 'int') !== false)) {
			return true;
		}
		if ((stripos($column->dbType, 'tinyint') !== false)) {
			return true;
		}
		if ((stripos($column->dbType, 'float') !== false)) {
			return true;
		}
		if ((stripos($column->dbType, 'double') !== false)) {
			return true;
		}

		return false;
	}

	// plain text
	public function isTextColumn($column)
	{
		if (substr($column->name, 0, 5) == 'text_' && (stripos($column->dbType, 'varchar') !== false && $column->size >= 255 || stripos($column->dbType, 'text') !== false)) {
			return true;
		}

		return false;
	}

	public function isUrlColumn($column)
	{
		if (substr($column->name, 0, 4) == 'url_' && (stripos($column->dbType, 'varchar') !== false)) {
			return true;
		}

		return false;
	}

	public function getTextColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isTextColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isCsvColumn($column)
	{
		$columnName = $column->name;
		$stripedColumnName = str_replace('csv_', '', $columnName);
		$as = $this->getBuildArray();
		if (substr($column->name, 0, 4) == 'csv_' || isset($as['csv'][$stripedColumnName]) || (isset($as['structure'][$columnName]) && $as['structure'][$columnName]['isCsv'] == true)) {
			return true;
		}

		return false;
	}

	public function getCsvColumns($columns)
	{
		$results = array();
		foreach ($columns as $column) {
			if ($this->isCsvColumn($column)) {
				$results[] = $column;
			}
		}

		return $results;
	}

	public function isTagColumn($column)
	{
		$columnName = $column->name;
		$stripedColumnName = str_replace('tag_', '', $columnName);
		$as = $this->getBuildArray();
		if (isset($as['tag'][$stripedColumnName])) {
			return true;
		}

		return false;
	}

	public function isJsonColumn($column)
	{
		$columnName = $column->name;
		$stripedColumnName = str_replace('json_', '', $columnName);
		$as = $this->getBuildArray();
		if (isset($as['json'][$stripedColumnName]) || (isset($as['structure'][$columnName]) && $as['structure'][$columnName]['isJson'] == true)) {
			return true;
		}

		return false;
	}

	public function isHiddenInFormColumn($column)
	{
		$columnName = $column->name;

		$as = $this->getBuildArray();
		if (isset($as['structure'][$columnName]['isHiddenInForm']) && $as['structure'][$columnName]['isHiddenInForm'] == true) {
			return true;
		}

		return false;
	}

	public function isEnumColumn($column)
	{
		$columnName = $column->name;
		$as = $this->getBuildArray();
		if (isset($as['structure'][$columnName]['isEnum'])) {
			return true;
		}

		return false;
	}

	public function getEnumSelections($columnName)
	{
		$as = $this->getBuildArray();

		return $as['structure'][$columnName]['enumSelections'];
	}

	//
	// isDeleteDisabled (no delete action)
	public function hasIsDeleteDisabled()
	{
		$as = $this->getBuildArray();
		if (isset($as['isDeleteDisabled'])) {
			return true;
		}

		return false;
	}

	public function isDeleteDisabled()
	{
		$as = $this->getBuildArray();
		if ($this->hasIsDeleteDisabled()) {
			return $as['isDeleteDisabled'];
		}

		return false;
	}

	//
	// foreign refer (self table have keys used by others)
	public function hasForeignRefer()
	{
		$as = $this->getBuildArray();
		if (!empty($as['foreignRefer']) && !empty($as['foreignRefer']['key']) && !empty($as['foreignRefer']['title'])) {
			return true;
		}

		return false;
	}

	public function getForeignReferKeyColumn()
	{
		$as = $this->getBuildArray();

		return $as['foreignRefer']['key'];
	}

	public function getForeignReferTitleColumn()
	{
		$as = $this->getBuildArray();

		return $as['foreignRefer']['title'];
	}

	//
	// foreign key (self table containing others table keys)
	public function hasForeignKey()
	{
		$as = $this->getBuildArray();
		if (!empty($as['foreignKey'])) {
			return true;
		}

		return false;
	}

	public function getForeignKeyRelationName($columnName)
	{
		$as = $this->getBuildArray();

		return $as['foreignKey'][$columnName]['relationName'];
	}

	public function getForeignKeyModelName($columnName)
	{
		$as = $this->getBuildArray();

		return $as['foreignKey'][$columnName]['model'];
	}

	public function getForeignKeyReferAttribute($columnName)
	{
		$as = $this->getBuildArray();

		return $as['foreignKey'][$columnName]['foreignReferAttribute'];
	}

	public function isForeignKeyColumn($columnName)
	{
		if ($this->isIdForeignKeyColumn($columnName) || $this->isCodeForeignKeyColumn($columnName)) {
			return true;
		}

		return false;
	}

	public function isIdForeignKeyColumn($columnName)
	{
		if (substr($columnName, -3) == '_id') {
			return true;
		}

		return false;
	}

	public function isCodeForeignKeyColumn($columnName)
	{
		if (substr($columnName, -5) == '_code') {
			return true;
		}

		return false;
	}

	//
	// tag
	public function hasTag()
	{
		$as = $this->getBuildArray();
		if (!empty($as['tag'])) {
			return true;
		}

		return false;
	}

	public function getTags()
	{
		$as = $this->getBuildArray();

		return $as['tag'];
	}

	public function getNeo4jAttributes()
	{
		$build = $this->getBuildArray();

		return $build['neo4j']['attributes'];
	}

	//
	// language
	public function isLanguageColumn($columnName)
	{
		//echo $columnName;
		$languages = Yii::app()->params['languages'];
		if (empty($languages)) {
			return false;
		}

		foreach ($languages as $lk => $lv) {
			$lkLength = strlen("_{$lk}");
			if (substr($columnName, -$lkLength) == "_{$lk}") {
				return true;
			}
		}

		return false;
	}

	public function removeLanguagePostfix($columnName)
	{
		$languages = Yii::app()->params['languages'];
		if (empty($languages)) {
			return $columnName;
		}

		foreach ($languages as $lk => $lv) {
			$lkLength = strlen("_{$lk}");
			if (substr($columnName, -$lkLength) == "_{$lk}") {
				return substr($columnName, 0, -$lkLength);
			}
		}

		return $columnName;
	}

	public function getLayout()
	{
		$as = $this->getBuildArray();

		return $as['layout'];
	}

	public function getMenu($currentPageCode, $thisPage)
	{
		$as = $this->getBuildArray();
		$menuTemplate = $as['menuTemplate'];
		// default menu template
		$defaultMenuTemplate = array(
			'index' => 'create, admin',
			'admin' => 'index, create',
			'create' => 'index, admin',
			'update' => 'index, create, view, admin',
			'view' => 'index, create, update, delete, admin',
		);

		$menuMapping = array(
			'index' => "array('label'=>Yii::t('app','List {$thisPage->modelClass}'), 'url'=>array('/{$thisPage->controller}/index')),",
			'create' => "array('label'=>Yii::t('app','Create {$thisPage->modelClass}'), 'url'=>array('/{$thisPage->controller}/create')),",
			'admin' => "array('label'=>Yii::t('app','Manage {$thisPage->modelClass}'), 'url'=>array('/{$thisPage->controller}/admin')),",
			'view' => "array('label'=>Yii::t('app','View {$thisPage->modelClass}'), 'url'=>array('/{$thisPage->controller}/view', 'id'=>\$model->{$thisPage->tableSchema->primaryKey})),",
			'update' => "array('label'=>Yii::t('app','Update {$thisPage->modelClass}'), 'url'=>array('/{$thisPage->controller}/update', 'id'=>\$model->{$thisPage->tableSchema->primaryKey})),",
			'delete' => "array('label'=>Yii::t('app','Delete {$thisPage->modelClass}'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>\$model->{$thisPage->tableSchema->primaryKey}), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),",
		);
		$returnMenu = "\$this->menu=array(\n";

		if (!empty($menuTemplate) && !empty($menuTemplate[$currentPageCode])) {
			$tmps = explode(',', $menuTemplate[$currentPageCode]);
		} else {
			$tmps = explode(',', $defaultMenuTemplate[$currentPageCode]);
		}

		foreach ($tmps as $tmp) {
			$returnMenu .= "\t" . $menuMapping[trim($tmp)] . "\n";
		}
		$returnMenu .= ");\n";

		return $returnMenu;
	}

	//
	// others
	public function test()
	{
		echo '<pre>';
		print_r($this->getBuildArray());
		exit;
	}

	//
	// meta
	// NOTE: required presetup db structure: meta_structure and meta_item
	public function isAllowMeta()
	{
		$as = $this->getBuildArray();
		if ($as['isAllowMeta']) {
			return true;
		}

		return false;
	}

	//
	// spatial
	public function isSpatialColumn($column)
	{
		$columnName = $column->name;
		$stripedColumnName = str_replace('latlong_', '', $columnName);
		$as = $this->getBuildArray();
		if (isset($as['latlong'][$stripedColumnName]) || (isset($as['structure'][$columnName]) && $as['structure'][$columnName]['isSpatial'] == true)) {
			return true;
		}

		return false;
	}

	public function getSpatialColumns()
	{
		$as = $this->getBuildArray();
		$results = array();
		foreach ($as['spatial'] as $ak => $av) {
			$results[] = $ak;
		}

		return $results;
	}

	public function figureSpatialFunctionName($columnName)
	{
		//return ucwords($columnName);
		/*
		  * latlong_address -> LatLongAddress
		  * latlong -> LatLong
		*/
		$columnName = str_replace('latlong', 'LatLong', $columnName);

		return str_replace(' ', '', ucwords(trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $columnName))))));
	}

	public function getSpatialOnChange($modelName, $columnName)
	{
		$buffer = '';
		$as = $this->getBuildArray();
		if (!empty($as['spatial'][$columnName]) && !empty($as['spatial'][$columnName]['onChangeLinked'])) {
			foreach ($as['spatial'][$columnName]['onChangeLinked'] as $onChangeLink) {
				$buffer .= sprintf('#%s_%s,', $modelName, $onChangeLink);
			}
			$buffer = substr($buffer, 0, -1 * strlen(','));
		}

		return $buffer;
	}

	//
	// many2many
	public function hasMany2Many()
	{
		$as = $this->getBuildArray();
		if (!empty($as['many2many'])) {
			return true;
		}

		return false;
	}

	public function getMany2Many()
	{
		$as = $this->getBuildArray();

		return $as['many2many'];
	}

	public function figureMany2ManyLabel($m2mKey)
	{
		$m2m = $this->getMany2Many();
		$m2mValues = $m2m[$m2mKey];

		if (!empty($m2mValues['label'])) {
			return $m2mValues['label'];
		}

		return $this->camel2Word($m2mValues['relationName']);
	}

	public function figureMany2ManyLinkClassName($m2mKey, $modelClass)
	{
		$m2m = $this->getMany2Many();
		$m2mValues = $m2m[$m2mKey];

		if (!empty($m2mValues['linkClassName'])) {
			return $m2mValues['linkClassName'];
		}

		return sprintf('%s2%s', $modelClass, $m2mValues['className']);
	}
}

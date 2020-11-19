<?php
 /*************************************************************************
 *
 * TAN YEE SIANG CONFIDENTIAL
 * __________________
 *
 *  [2002] - [2007] TAN YEE SIANG
 *  All Rights Reserved.
 *
 * NOTICE:  All information contained herein is, and remains
 * the property of TAN YEE SIANG and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to TAN YEE SIANG
 * and its suppliers and may be covered by U.S. and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from TAN YEE SIANG.
 */

/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

<?php $hasForeignRefer = $hasTag = $hasJson = $hasEnum = $hasDateAdded = $hasDateModified = false; $hasCode = false; ?>

/**
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php $uuidColumns = $this->buildSetting->getUUIDColumns(); if (count($uuidColumns) > 0) {
	$hasUUID = true;
} ?>
<?php $enumColumns = $this->buildSetting->getEnumColumns(); if (count($enumColumns) > 0) {
	$hasEnum = true;
} ?>
<?php $jsonColumns = $this->buildSetting->getJsonColumns(); if (count($jsonColumns) > 0) {
	$hasJson = true;
} ?>
<?php $spatialColumns = $this->buildSetting->getSpatialColumns(); if (count($spatialColumns) > 0) {
	$hasSpatial = true;
} ?>
<?php $dateColumns = $this->buildSetting->getDateColumns($columns); if (count($dateColumns) > 0) {
	$hasDate = true;
} ?>
<?php $imageColumns = $this->buildSetting->getImageColumns($columns); if (count($imageColumns) > 0) {
	$hasImage = true;
} ?>
<?php $tags = $this->buildSetting->getTags(); if (count($tags) > 0) {
	$hasTag = true;
} ?>
<?php $many2many = $this->buildSetting->getMany2Many(); if (count($many2many) > 0) {
	$hasMany2Many = true;
} ?>
<?php $hasForeignRefer = $this->buildSetting->hasForeignRefer(); ?>
<?php foreach ($columns as $column): ?>
	<?php if ($column->name == 'date_added') {
	$hasDateAdded = true;
} ?>
	<?php if ($column->name == 'date_modified') {
	$hasDateModified = true;
} ?>
	<?php if ($column->name == 'code') {
	$hasCode = true;
} ?>
 * @property <?php echo $column->type . ' $' . $column->name . "\n"; ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach ($relations as $name => $relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches)) {
		$relationType = $matches[1];
		$relationModel = $matches[2];

		switch ($relationType) {
			case 'HAS_ONE':
				echo $relationModel . ' $' . $name . "\n";
			break;
			case 'BELONGS_TO':
				echo $relationModel . ' $' . $name . "\n";
			break;
			case 'HAS_MANY':
				echo $relationModel . '[] $' . $name . "\n";
			break;
			case 'MANY_MANY':
				echo $relationModel . '[] $' . $name . "\n";
			break;
			default:
				echo 'mixed $' . $name . "\n";
		}
	}
	?>
<?php endforeach; ?>
<?php endif; ?>
 */
 <?php // exiang: somehow setting the baseClass in ModelGenerator do not works. so hardcode here?>
class <?php echo $modelClass; ?>Base extends <?php echo $this->baseClass . "\n"; ?>
{
	public $uploadPath;

<?php if ($hasMany2Many): ?>
	// m2m
<?php foreach ($many2many as $m2mKey => $m2mValues):?>
	public $input<?php echo ucwords($m2mValues['relationName']) ?>;
<?php endforeach; ?>
<?php endif; ?>
	
<?php
	foreach ($columns as $name => $column) {
		// image
		//if(substr($column->name, 0, 6) == 'image_')
		if ($this->buildSetting->isImageColumn($column)) {
			$imageFileName = str_replace('image_', 'imageFile_', $column->name);
			echo sprintf("\tpublic \$%s;\n", $imageFileName);
		}
		// date, make it searchable
		//elseif(substr($column->name, 0, 5) == 'date_')
		elseif ($this->buildSetting->isDateColumn($column)) {
			echo sprintf("\tpublic \$s%s, \$e%s;\n", $column->name, $column->name);
		}
	}

	if (!empty($jsonColumns)) {
		echo "\n\t// json\n";
		foreach ($jsonColumns as $jsonColumn) {
			$jsonColumnData = $this->buildSetting->getJsonColumnData($jsonColumn);
			$jsonAllExtraFieldKeys = array_keys($jsonColumnData);
			echo sprintf("\tpublic \$jsonArray_%s;\n", $this->buildSetting->extractRawJsonColumnName($jsonColumn));
			if (!empty($jsonAllExtraFieldKeys)) {
				foreach ($jsonAllExtraFieldKeys as $jsonAllExtraFieldKey) {
					$tmp .= sprintf("\tpublic \$%s;\n", $jsonAllExtraFieldKey);
				}
				echo $tmp;
			}
		}
	}

	if (!empty($tags)) {
		echo "\n\t// tag\n";
		$tmp = '';
		foreach ($tags as $tagKey => $tagValues) {
			$tmp .= sprintf("\tpublic \$tag_%s;\n", $tagKey);
		}
		echo $tmp;
	}
?>
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();
<?php if ($this->buildSetting->isAllowMeta()):?>
		// meta
		$this->initMetaStructure($this->tableName());
<?php endif; ?>

		if($this->scenario == "search") {
<?php
	foreach ($columns as $name => $column) {
		// boolean in search
		if ($this->buildSetting->isBooleanColumn($column)) {
			echo "\t\t\t\$this->{$column->name} = null;\n";
		}
	}
?>
		} else {
<?php
	foreach ($columns as $name => $column) {
		// ordering
		if ($this->buildSetting->isOrderingColumn($column)) {
			echo "\t\t\$this->ordering = \$this->count()+1;";
			break;
		}
	}
?>
		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '<?php echo $tableName; ?>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach ($rules as $rule): ?>
			<?php echo $rule . ",\n"; ?>
<?php endforeach; ?>
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
<?php 
	$extraSearchColumns = '';
	foreach ($columns as $column) {
		if ($this->buildSetting->isDateColumn($column)) {
			$extraSearchColumns .= sprintf(', s%s, e%s', $column->name, $column->name);
		}
	}

	// json
	if (!empty($jsonColumns)) {
		foreach ($jsonColumns as $jsonColumn) {
			$jsonColumnData = $this->buildSetting->getJsonColumnData($jsonColumn);
			$jsonAllExtraFieldKeys = array_keys($jsonColumnData);
			//$extraSearchColumns .= sprintf(', json_%s', $this->buildSetting->extractRawJsonColumnName($jsonColumn));
			if (!empty($jsonAllExtraFieldKeys)) {
				foreach ($jsonAllExtraFieldKeys as $jsonAllExtraFieldKey) {
					$extraSearchColumns .= sprintf(', %s', $jsonAllExtraFieldKey);
				}
			}
		}
	}

	// tag
	if (!empty($tags)) {
		foreach ($tags as $tagKey => $tagValues) {
			$extraSearchColumns .= sprintf(', tag_%s', $tagKey);
		}
	}
?>
			array('<?php echo implode(', ', array_keys($columns)) . $extraSearchColumns; ?>', 'safe', 'on'=>'search'),
<?php if ($this->buildSetting->isAllowMeta()):?>
			// meta
			array('_dynamicData', 'safe'),
<?php endif; ?>
		);

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
<?php foreach ($relations as $name => $relation): ?>
<?php if (!in_array($name, array_keys($tags))): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php else: ?>
			<?php echo "//tag: '$name' => $relation,\n"; ?>
<?php endif; ?>
<?php endforeach; ?>

<?php if ($this->buildSetting->isAllowMeta()):?>
			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
<?php endif; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
<?php foreach ($labels as $name => $label): ?>
	<?php 
	if (!empty(Yii::app()->params['languages']) && ysUtil::isLanguageField($name)) {
		foreach (Yii::app()->params['languages'] as $languageKey => $languageName) {
			$languagePostfix = '_' . $languageKey;
			if (substr($name, -1 * (strlen($languagePostfix))) == $languagePostfix) {
				$label = trim(substr(trim($label), 0, -1 * strlen($languageKey)));
				$label = sprintf('%s [%s]', $label, $languageName);
				break;
			}
		}
	}
	?>
	<?php echo "'$name' => Yii::t('app', '$label'),\n"; ?>
<?php endforeach; ?>
		);

<?php if ($hasMany2Many):?>
<?php foreach ($many2many as $m2mKey => $m2mValues): ?>
		$return['input<?php echo ucwords($m2mValues['relationName']) ?>'] = Yii::t('app', '<?php echo $this->buildSetting->figureMany2ManyLabel($m2mKey)?>');
<?php endforeach; ?>
<?php endif; ?>

<?php if ($this->buildSetting->isAllowMeta()):?>
		// meta
		$return = array_merge((array)$return, array_keys($this->_dynamicFields));
		foreach($this->_metaStructures as $metaStruct) {
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}
<?php endif; ?>

		return $return;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

<?php
foreach ($columns as $name => $column) {
		if ($column->type === 'string' && !$this->buildSetting->isEnumColumn($column)) {
			echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
		}
		// no search on json column
		elseif ($this->buildSetting->isJsonColumn($column)) {
		} elseif ($this->buildSetting->isDateColumn($column)) {
			echo "\t\tif(!empty(\$this->s{$column->name}) && !empty(\$this->e{$column->name})) {\n";
			echo "\t\t\t\$sTimestamp = strtotime(\$this->s{$column->name});\n";
			echo "\t\t\t\$eTimestamp = strtotime(\"{\$this->e{$column->name}} +1 day\");\n";
			echo "\t\t\t\$criteria->addCondition(sprintf('{$column->name} >= %s AND {$column->name} < %s', \$sTimestamp, \$eTimestamp));\n";
			echo "\t\t}\n";
		} else {
			echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
		}
	}
?>

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
<?php
$hasSetDefaultOrdering = false;
foreach ($columns as $name => $column) {
	// ordering
	if ($this->buildSetting->isOrderingColumn($column)) {
		$hasSetDefaultOrdering = true;
		echo "\t\t\t'sort' => array('defaultOrder' => 't.ordering ASC'),";
		break;
	}
}

if (!$hasSetDefaultOrdering && !empty($this->buildSetting->getAdminSortDefaultOrder())) {
	$hasSetDefaultOrdering = true;
	echo sprintf("\t\t\t'sort' => array('defaultOrder' => '%s'),", $this->buildSetting->getAdminSortDefaultOrder());
}
?>

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
<?php foreach ($columns as $column) {
	echo sprintf("\t\t\t'%s' => \$this->%s,\n", $this->buildSetting->camelizeColumnName($column->name), $column->name);
	if ($this->buildSetting->isImageColumn($column)) {
		echo sprintf("\t\t\t'%sThumbUrl' => \$this->get%sThumbUrl(),\n", $this->buildSetting->camelizeColumnName($column->name), ucwords($this->buildSetting->camelizeColumnName($column->name)));

		echo sprintf("\t\t\t'%sUrl' => \$this->get%sUrl(),\n", $this->buildSetting->camelizeColumnName($column->name), ucwords($this->buildSetting->camelizeColumnName($column->name)));
	} elseif ($this->buildSetting->isDateColumn($column)) {
		echo sprintf("\t\t\t'f%s' => \$this->render%s(),\n", ucwords($this->buildSetting->camelizeColumnName($column->name)), ucwords($this->buildSetting->camelizeColumnName($column->name)));
	}
} ?>
		
		);
			
		// many2many
<?php if (!empty($many2many)):?><?php foreach ($many2many as $m2mKey => $m2mValues): ?>
		if(!in_array('-<?php echo $m2mValues['relationName'] ?>', $params) && !empty($this-><?php echo $m2mValues['relationName'] ?>)) 
		{
			foreach($this-><?php echo $m2mValues['relationName'] ?> as $<?php echo $this->buildSetting->camelizeColumnName($m2mKey) ?>)
			{
				$return['<?php echo $m2mValues['relationName'] ?>'][] = $<?php echo $this->buildSetting->camelizeColumnName($m2mKey) ?>->toApi(array('-<?php echo $this->buildSetting->camelizeColumnName($modelClass) ?>'));
			}
		}
<?php endforeach; ?><?php endif; ?>

		return $return;
	}
	
	//
	// image
<?php foreach ($imageColumns as $imageColumn): ?>
	public function get<?php echo ucwords($this->buildSetting->camelizeColumnName($imageColumn->name)) ?>Url()
	{
		if(!empty($this-><?php echo $imageColumn->name ?>))
			return StorageHelper::getUrl($this-><?php echo $imageColumn->name ?>);
	}
	public function get<?php echo ucwords($this->buildSetting->camelizeColumnName($imageColumn->name)) ?>ThumbUrl($width=100, $height=100)
	{
		if(!empty($this-><?php echo $imageColumn->name ?>))
			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this-><?php echo $imageColumn->name ?>));
	}

<?php endforeach;?>

	//
	// date
	public function getTimezone()
	{
		return date_default_timezone_get();
	}
<?php foreach ($dateColumns as $dateColumn): ?>

	public function render<?php echo ucwords($this->buildSetting->camelizeColumnName($dateColumn->name))?>()
	{
		return Html::formatDateTimezone($this-><?php echo $dateColumn->name ?>, 'standard', 'standard', '-', $this->getTimezone());
	}
<?php endforeach; ?>

	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),

<?php foreach ($columns as $name => $column) {
	// boolean
	if ($this->buildSetting->isBooleanColumn($column)) {
		echo sprintf("\t\t\t'%s' => array('condition' => 't.%s = 1'),\n", $this->buildSetting->camelizeColumnName($column->name), $column->name);
	}
}
?>

		);
    }

<?php if ($connectionId != 'db'):?>
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()-><?php echo $connectionId ?>;
	}

<?php endif?>
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return <?php echo $modelClass; ?> the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * This is invoked before the record is validated.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeValidate() 
	{
		if($this->isNewRecord) {
<?php if ($hasUUID): ?> 
			// UUID
<?php foreach ($uuidColumns as $uuidColumn): ?>
			$this-><?php echo $uuidColumn ?> = ysUtil::generateUUID();	
<?php endforeach; ?>
<?php endif; ?>
		} else {
<?php if ($hasUUID): ?> 
			// UUID
<?php foreach ($uuidColumns as $uuidColumn): ?>
			if(empty($this-><?php echo $uuidColumn ?>)) $this-><?php echo $uuidColumn ?> = ysUtil::generateUUID();	
<?php endforeach; ?>
<?php endif; ?>
		}

		// todo: for all language filed that is required but data is empty, copy the value from default language so when params.backendLanguages do not include those params.languages, validation error wont throw out

		return parent::beforeValidate();
	}

	protected function afterSave()
{
<?php if (!empty($many2many)) : ?><?php foreach ($many2many as $m2mKey => $m2mValues) : ?>
$this->saveInput<?php echo $m2mValues['className'] ?>();
<?php endforeach; ?><?php endif; ?>

<?php if (!empty($tags)) : ?><?php foreach ($tags as $tagKey => $tagValues) : ?>
$this->setTags($this->tag_<?php echo $tagKey ?>);
<?php endforeach; ?><?php endif; ?>

<?php if ($neo4j) : ?>
	if (Yii::app()->neo4j->getStatus()) {
	<?php echo 'Neo4j' . $modelClass; ?>::model($this)->sync();
	}
<?php endif; ?>

return parent::afterSave();
}


<?php if ($neo4j) : ?>
	protected function afterDelete()
	{
	// custom code here
	// ...
	if (Yii::app()->neo4j->getStatus()) {
	<?php echo 'Neo4j' . $modelClass; ?>::model()->deleteOneByPk($this->id);
	}
	return parent::afterDelete();
	}

<?php endif; ?>

	
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave()) {
<?php foreach ($columns as $name => $column): ?>
<?php if ($column->allowNull && $this->buildSetting->isCodeForeignKeyColumn($column->name)): ?>
			if($this-><?php echo $column->name ?> == '') $this-><?php echo $column->name ?> = NULL;
<?php endif; ?><?php endforeach; ?>
<?php foreach ($columns as $name => $column): ?>
<?php if ($column->allowNull && $this->buildSetting->isBooleanColumn($column)): ?>
			if($this-><?php echo $column->name ?> == '') $this-><?php echo $column->name ?> = NULL;
<?php endif; ?><?php endforeach; ?>
<?php foreach ($columns as $name => $column): ?>
<?php if ($column->name != 'date_added' && $column->name != 'date_modified' && ($this->buildSetting->isDateColumn($column))): ?>
			if(!empty($this-><?php echo $column->name ?>)) {
				if(!is_numeric($this-><?php echo $column->name ?>)) {
					$this-><?php echo $column->name ?> = strtotime($this-><?php echo $column->name ?>);
				}
			}
<?php endif; ?>
<?php endforeach; ?>

<?php if ($hasDateAdded && $hasDateModified): ?>
			// auto deal with date added and date modified
			if($this->isNewRecord) {
				$this->date_added=$this->date_modified = time();
			} else {
				$this->date_modified = time();
			}
<?php endif; ?>	

<?php if (!empty($jsonColumns)): ?>
			// json
<?php foreach ($jsonColumns as $jsonColumn) {
	$jsonColumnData = $this->buildSetting->getJsonColumnData($jsonColumn);

	$jsonAllExtraFieldKeys = array_keys($jsonColumnData);
	if (!empty($jsonAllExtraFieldKeys)) {
		foreach ($jsonAllExtraFieldKeys as $jsonAllExtraFieldKey) {
			echo sprintf("\t\t\t\$this->jsonArray_%s->%s = \$this->%s;\n", $jsonColumn, $jsonAllExtraFieldKey, $jsonAllExtraFieldKey);
		}
	}
	echo sprintf("\t\t\t\$this->json_%s = json_encode(\$this->jsonArray_%s);\n", $jsonColumn, $jsonColumn);
	echo sprintf("\t\t\tif(\$this->json_%s == 'null') \$this->json_%s = null;\n", $jsonColumn, $jsonColumn);
} ?>
<?php endif; ?>

			// save as null if empty
<?php foreach ($columns as $name => $column): ?>
<?php if ($column->allowNull): ?>
	<?php if ($this->buildSetting->isNumericColumn($column)): ?>
		<?php echo sprintf("\t\tif(empty(\$this->%s) && \$this->%s !==0) \$this->%s = null;\n", $column->name, $column->name, $column->name); ?>
	<?php else: ?>
		<?php echo sprintf("\t\tif(empty(\$this->%s)) \$this->%s = null;\n", $column->name, $column->name, $column->name); ?>
	<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>

			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * This is invoked after the record is found.
	 */
	protected function afterFind()
	{
		// boolean
<?php foreach ($columns as $name => $column): ?><?php if ($this->buildSetting->isBooleanColumn($column)): ?>
		if($this-><?php echo $name ?> != '' || $this-><?php echo $name ?> != null) $this-><?php echo $name ?> = intval($this-><?php echo $name ?>);
<?php endif; ?><?php endforeach; ?>

<?php if (!empty($jsonColumns)): ?><?php foreach ($jsonColumns as $jsonColumn): ?>
<?php $jsonColumnData = $this->buildSetting->getJsonColumnData($jsonColumn); ?>
		$this->jsonArray_<?php echo $jsonColumn ?> = json_decode($this->json_<?php echo $jsonColumn ?>);
<?php $jsonAllExtraFieldKeys = array_keys($jsonColumnData); ?>
<?php if (!empty($jsonAllExtraFieldKeys)): ?><?php foreach ($jsonAllExtraFieldKeys as $jsonAllExtraFieldKey): ?>
		$this-><?php echo $jsonAllExtraFieldKey ?> = $this->jsonArray_<?php echo $jsonColumn ?>-><?php echo $jsonAllExtraFieldKey ?>;
<?php endforeach; ?><?php endif; ?>
<?php endforeach; ?><?php endif; ?>

<?php if (!empty($tags)) :?><?php foreach ($tags as $tagKey => $tagValues): ?>
		$this->tag_<?php echo $tagKey ?> = $this-><?php echo $tagKey ?>->toString();
<?php endforeach; ?><?php endif; ?>

<?php if (!empty($many2many)):?><?php foreach ($many2many as $m2mKey => $m2mValues): ?>
		foreach($this-><?php echo $m2mValues['relationName']?> as $<?php echo $m2mKey?>) $this->input<?php echo ucwords($m2mValues['relationName']) ?>[] = $<?php echo $m2mKey?>->id;
<?php endforeach; ?><?php endif; ?>

		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array(
<?php if (!empty($spatialColumns)): ?>
			'spatial' => array(
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => array(
					// all spatial fields here
					<?php echo "'" . implode("','", $spatialColumns) . "'"; ?>				
				),
			),
<?php endif;?>
			
<?php if (!empty($tags)) :?><?php foreach ($tags as $tagKey => $tagValues): ?>

			'<?php echo $tagKey ?>' => array
			(
				'class' => 'application.yeebase.extensions.taggable-behavior.ETaggableBehavior',
				'tagTable' => '<?php echo $tagValues['tagTable'] ?>',
				'tagBindingTable' => '<?php echo $tagValues['tagBindingTable'] ?>',
				'modelTableFk' => '<?php echo $tagValues['modelTableFk'] ?>',
				'tagTablePk' => '<?php echo $tagValues['tagTablePk'] ?>',
				'tagTableName' => '<?php echo $tagValues['tagTableName'] ?>',
				'tagBindingTableTagId' => '<?php echo $tagValues['tagBindingTableTagId'] ?>',
				'cacheID' => '<?php echo $tagValues['cacheID'] ?>',
				'createTagsAutomatically' => true,
			)

<?php endforeach; ?><?php endif; ?>
		);
	}
	
<?php if ($hasEnum): ?>
	/**
	 * These are function for enum usage
	 */
<?php foreach ($enumColumns as $c):?>
<?php
	$enumFunctionName = $this->buildSetting->figureEnumFunctionName($c);
	$enumSelections = $this->buildSetting->getEnumSelections($c);

?>
	public function getEnum<?php echo $enumFunctionName?>($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code' => '', 'title' => $this->formatEnum<?php echo $enumFunctionName?>(''));
		
<?php foreach ($enumSelections as $e => $eLbl):?>
		$result[] = array('code' => '<?php echo $e?>', 'title' => $this->formatEnum<?php echo $enumFunctionName?>('<?php echo $e?>'));
<?php endforeach; ?>
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnum<?php echo $enumFunctionName?>($code)
	{
		switch($code)
		{
<?php foreach ($enumSelections as $e => $eLbl):?>			
			case '<?php echo $e?>': {return Yii::t('app', '<?php echo $eLbl ?>'); break;}
<?php endforeach; ?>
			default: {return ''; break;}
		}
	}
<?php endforeach; ?>
	 
<?php endif; ?>


<?php if ($hasForeignRefer): ?>
	/**
	 * These are function for foregin refer usage
	 */
	public function getForeignReferList($isNullable=false, $is4Filter=false)
	{
		$language = Yii::app()->language;		
<?php 
	$foreignReferTitleColumn = $this->buildSetting->getForeignReferTitleColumn();
	if ($this->buildSetting->isLanguageColumn($foreignReferTitleColumn)) {
		// remvoe language postfix
		$foreignReferTitleColumn = sprintf('%s_{$language}', $this->buildSetting->removeLanguagePostfix($foreignReferTitleColumn));
	}
?>
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key' => '', 'title' => '');
		$result = Yii::app()->db->createCommand()->select("<?php echo $this->buildSetting->getForeignReferKeyColumn()?> as key, <?php echo $foreignReferTitleColumn ?> as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}
<?php endif; ?>

<?php if ($hasCode): ?>
	public function isCodeExists($code)
	{
		$exists = <?php echo $modelClass; ?>::model()->find('code=:code', array(':code' => $code));
		if($exists===null) {
			return false;
		}
		
		return true;
	}
<?php endif; ?>

	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
<?php if ($hasSpatial): ?>
		$record = $this;
		$criteria = new CDbCriteria();
		$lineString = '';
		
		$alias = $record->getTableAlias();

		foreach ($this->spatialFields as $field) {
			$asField = (($alias  && $alias  != 't') ? $alias.'_'.$field : $field);
			$field = ($alias  ? ("`" . $alias  . "`.") : "") . "`" . $field . "`";
			$lineString.='AsText(' . $field . ') AS ' . $asField . ',';
		}
		$lineString = substr($lineString, 0, -1);
		$criteria->select = (($record->DBCriteria->select == '*') ? '*, ' : '') . $lineString;
		$criteria->addSearchCondition('id', $record->id);
		$record->dbCriteria->mergeWith($criteria);

		$obj = $record->find($criteria);
		foreach ($this->spatialFields as $field) 
		{
			$this->$field = $obj->$field;
		}
		<?php endif; ?>
	}

<?php if ($hasSpatial): ?>
<?php foreach ($spatialColumns as $spatialColumn):?>
	public function set<?php echo $this->buildSetting->figureSpatialFunctionName($spatialColumn) ?>($pos)
	{
		if(!empty($pos))
		{
			if(is_array($pos)) {
				$this-><?php echo $spatialColumn ?> = $pos;
			} else {
				$this-><?php echo $spatialColumn ?> = self::latLngString2Flat($pos);
			}
		}
	}

<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($many2many)) :?><?php foreach ($many2many as $m2mKey => $m2mValues): ?>
	<?php $relName = ucwords($m2mValues['relationName']); ?>
	
	//
	// <?php echo $m2mKey ?>

	public function getAll<?php echo $relName ?>Key()
	{
		$return = array();
		if(!empty($this-><?php echo $m2mValues['relationName']?>)) {
			foreach($this-><?php echo $m2mValues['relationName']?> as $r) {
				$return[] = $r->id;
			}
		}
		return $return;
	}

	public function has<?php echo $m2mValues['className']?>($key)
	{
		if(in_array($key, $this->getAll<?php echo $relName ?>Key())) {
			return true;
		}
		
		return false;
	}
	
	public function hasNo<?php echo $m2mValues['className']?>($key)
	{
		if(!in_array($key, $this->getAll<?php echo $relName ?>Key())) {
			return true;
		}
		
		return false;
	}
	
	public function remove<?php echo $m2mValues['className']?>($key)
	{
		if($this->has<?php echo $m2mValues['className']?>($key)) {
			$many2many = <?php echo $this->buildSetting->figureMany2ManyLinkClassName($m2mKey, $modelClass) ?>::model()->findByAttributes (array('<?php echo $tableName; ?>_id' => $this->id, '<?php echo $m2mKey ?>_id' => $key));
			if(!empty($many2many)) return $many2many->delete();
		}
		return false;
	}
	
	public function add<?php echo $m2mValues['className']?>($key)
	{
		if($this->hasNo<?php echo $m2mValues['className']?>($key)) {
			$many2many = new <?php echo $this->buildSetting->figureMany2ManyLinkClassName($m2mKey, $modelClass) ?>;
			$many2many-><?php echo $tableName; ?>_id = $this->id;
			$many2many-><?php echo $m2mKey ?>_id = $key;
			return $many2many->save();
		}
		return false;
	}

	protected function saveInput<?php echo $m2mValues['className']?>()
	{
		// loop thru existing
		foreach($this-><?php echo $m2mValues['relationName']?> as $r) {
			// remove extra
			if(!in_array($r->id, $this->input<?php echo $relName ?>)) {
				$this->remove<?php echo $m2mValues['className']?>($r->id);	
			}
		}

		// loop thru each input
		foreach($this->input<?php echo $relName ?> as $input) {
			// if currently dont have
			if($this->hasNo<?php echo $m2mValues['className']?>($input)) {
				$this->add<?php echo $m2mValues['className']?>($input);
			}		
		}
	}

<?php endforeach; ?><?php endif; ?>
}

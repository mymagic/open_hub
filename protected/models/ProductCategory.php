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

class ProductCategory extends ProductCategoryBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		// meta
		$this->initMetaStructure($this->tableName());
		parent::init();
	}

	public function rules()
	{
		$return = parent::rules();
		// meta
		$return[] = array('_dynamicData', 'safe');

		return $return;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();
		$return = array_merge($return, array_keys($this->_dynamicFields));

		// meta
		foreach ($this->_metaStructures as $metaStruct) {
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}

		return $return;
	}

	protected function afterFind()
	{
		//if(empty($this->image_cover)) $this->image_cover = 'uploads/product_category/cover.default.jpg';
		if (empty($this->image_cover)) {
			$this->image_cover = 'images/placeholder.default.jpg';
		}
		parent::afterFind();
	}

	public function toApi($params = '')
	{
		$return = array(
			'id' => $this->id,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'imageCover' => $this->image_cover,
			'imageCoverThumbUrl' => $this->getImageCoverThumbUrl(),
			'imageCoverUrl' => $this->getImageCoverUrl(),
			'ordering' => $this->ordering,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
		);

		return $return;
	}

	public function getImageCoverUrl()
	{
		return StorageHelper::getUrl($this->image_cover);
	}

	public function getImageCoverThumbUrl($width = 100, $height = 100)
	{
		return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_cover));
	}

	public function getForeignReferList($isNullable = false, $is4Filter = false, $htmlOptions = array())
	{
		$language = Yii::app()->language;

		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('key' => '', 'title' => '');
		}

		if ($htmlOptions['params']['mode'] == 'idea-isEnabled') {
			$sql = sprintf("SELECT pc.id as `key`, pc.title as `title` FROM `product_category` as pc 
			INNER JOIN `meta_structure` as ms on ms.ref_table='product_category' INNER JOIN `meta_item` as mi on mi.meta_structure_id=ms.id 
			WHERE 
			(ms.code='ProductCategory-idea-isEnabled' AND mi.value=1 AND mi.ref_id=pc.id)
			GROUP BY pc.id
			ORDER BY pc.ordering ASC");

			$result = Yii::app()->db->createCommand($sql)->queryAll();
		} else {
			$result = Yii::app()->db->createCommand()->select('id as key, title as title')->from(self::tableName())->queryAll();
		}

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}
			return $newResult;
		}

		return $result;
	}
}

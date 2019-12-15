<?php

class Product extends ProductBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function init()
	{
		// meta
		$this->initMetaStructure($this->tableName());
		parent::init();
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on'=>sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on'=>'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through'=>'metaStructures'),
		);
	}
	 
	public function rules()
	{
		$return = parent::rules();
		// meta
		$return[] = array('_dynamicData', 'safe');
		return $return;
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();
		$return['product_category_id'] = Yii::t('app', 'Category');
		$return['text_short_description'] = Yii::t('app', 'Description');
		$return['typeof'] = Yii::t('app', 'Type');
		$return['image_cover'] = Yii::t('app', 'Cover Image');
		$return['url_website'] = Yii::t('app', 'Website URL');
		$return['price'] = Yii::t('app', 'Price');
		$return['price_min'] = Yii::t('app', 'Minimum Price');
		$return['price_max'] = Yii::t('app', 'Maximum Price');
		
		// meta
		$return = array_merge($return, array_keys($this->_dynamicFields));
		foreach($this->_metaStructures as $metaStruct)
		{
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}
		return $return;
	}

	protected function afterFind()
	{
		if(empty($this->image_cover)) $this->image_cover = 'uploads/product/cover.default.jpg';
		parent::afterFind();
	}

	public function toApi($params='')
	{
		$return = array(
			'id' => $this->id,
			'organizationId' => $this->organization_id,
			'productCategoryId' => $this->product_category_id,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'typeof' => $this->typeof,
			'imageCover' => $this->image_cover,
			'imageCoverThumbUrl'=>$this->getImageCoverThumbUrl(),
			'imageCoverUrl'=>$this->getImageCoverUrl(),
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
			'priceMin' => $this->price_min,
			'priceMax' => $this->price_max,
			'fRenderPrice' => $this->renderPrice(),
		);
		
		if(!in_array('-productCategory', $params) && !empty($this->productCategory))
			$return['productCategory'] = $this->productCategory->toApi();
		if(!in_array('-organization', $params) && !empty($this->organization)) 
			$return['organization'] = $this->organization->toApi(array('-products'));
		return $return;
	}

	public function getImageCoverUrl()
	{
		return StorageHelper::getUrl($this->image_cover);
	}
	public function getImageCoverThumbUrl($width=100, $height=100)
	{
		return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_cover));
	}

	public function belongs2IdeaActiveAccreditedEnterprise()
	{
		if(!$this->organization->isIdeaEnterprise()) return false;
		if(!$this->organization->isIdeaEnterpriseActiveAccreditedMembership()) return false;
		return true;
	}

	public function renderPrice()
	{
		$currencyCode = Yii::app()->params['sourceCurrency'];
		
		// have different min and max value
		if($this->price_min != '' && $this->price_max != '' && $this->price_max != $this->price_min) 
			return sprintf('From %s %s to %s', $currencyCode, $this->price_min, $this->price_max);
		// only have min value
		else if($this->price_min != '' && $this->price_max == '') 
			return sprintf('From %s %s to %s', $currencyCode, $this->price_min, $this->price_max);
		// only hav max value
		else if($this->price_min == '' && $this->price_max != '') 
			return sprintf('Max %s %s', $currencyCode, $this->price_min, $this->price_max);
		// max and min same value
		else if($this->price_min == $this->price_max && $this->price_max != '') 
			return sprintf('%s %s', $currencyCode, $this->price_min);
		// all empty
		else
			return '';
	}
}


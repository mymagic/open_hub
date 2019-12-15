<?php

class IdeaWishlist extends IdeaWishlistBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'partner' => array(self::BELONGS_TO, 'Organization', 'partner_organization_code'),
			'enterprise' => array(self::BELONGS_TO, 'Organization', 'enterprise_organization_code'),
		);
	}


	public function toApi($params='')
	{
		$return = array(
			'id' => $this->id,
			//'productId' => $this->product_id,
			'partnerOrganizationCode' => $this->partner_organization_code,
			'enterpriseOrganizationCode' => $this->enterprise_organization_code,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
		);

		/*if(!in_array('-product', $params) && !empty($this->product)) 
		{
			$return['product'] = $this->product->toApi();
		}*/
		if(!in_array('-partner', $params) && !empty($this->partner)) 
		{
			$return['partner'] = $this->partner->toApi(array('-products'));
		}
		if(!in_array('-enterprise', $params) && !empty($this->enterprise)) 
		{
			$return['enterprise'] = $this->enterprise->toApi(array('-products'));
		}
			
		return $return;
	}
}

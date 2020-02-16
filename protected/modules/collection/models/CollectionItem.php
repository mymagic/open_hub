<?php

class CollectionItem extends CollectionItemBase
{
    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function init()
    {
        // custom code here
        // ...

        parent::init();

        // return void
    }

    public function beforeValidate()
    {
        // custom code here
        // ...

        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        // custom code here
        // ...

        return parent::afterValidate();
    }

    protected function beforeSave()
    {
        // custom code here
        // ...

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        // custom code here
        // ...

        return parent::afterSave();
    }

    protected function beforeFind()
    {
        // custom code here
        // ...

        parent::beforeFind();

        // return void
    }

    protected function afterFind()
    {
        // custom code here
        // ...

        parent::afterFind();

        // return void
    }

    public function attributeLabels()
    {
        $return = parent::attributeLabels();

        // custom code here
        // $return['title'] = Yii::t('app', 'Custom Name');

        return $return;
    }

    public function getItemObject()
    {
        switch ($this->table_name) {
            case 'organization': return Organization::model()->findByPk($this->ref_id);
            case 'individual': return Individual::model()->findByPk($this->ref_id);
            case 'event': return Event::model()->findByPk($this->ref_id);
            case 'resource': return Resource::model()->findByPk($this->ref_id);
            case 'tag': return Tag::model()->findByPk($this->ref_id);
            default: return null;
        }
    }

    public function getItemObjectTitle()
    {
		$object = $this->getItemObject();
        switch ($this->table_name) {
            case 'organization': return $object->title;
            case 'individual': return $object->full_name;
            case 'event': return $object->title;
            case 'resource': return $object->title;
            case 'tag': return $object->name;
            default: return sprintf('# %s', $object->id);
        }
    }

    public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'collectionSubId' => $this->collection_sub_id,
			'refId' => $this->ref_id,
			'tableName' => $this->table_name,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
            'fDateModified'=>$this->renderDateModified(),
            
            'collectionId' => $this->collectionSub->collection->id,
		);
			
		// many2many

		return $return;
	}
}

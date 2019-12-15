<?php

class OrganizationMergeHistory extends OrganizationMergeHistoryBase
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
        return $return;
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
			'srcOrganization' => array(self::BELONGS_TO, 'Organization', 'src_organization_id'),
			'destOrganization' => array(self::BELONGS_TO, 'Organization', 'dest_organization_id'),
            'user' => array(self::BELONGS_TO, 'User', 'admin_code'),
        );
    }
}

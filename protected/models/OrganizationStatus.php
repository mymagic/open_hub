<?php

class OrganizationStatus extends OrganizationStatusBase
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

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
            'proofs' => array(self::HAS_MANY, 'Proof', 'ref_id',
                'condition' => 'proofs.ref_table=:refTable',
                'params' => array(':refTable' => 'organization_status'),
                'order' => 'proofs.date_modified DESC',
            ),
        );
    }

    public function renderStatus($mode = 'text')
    {
        if ($mode == 'text') {
            return ucwords($this->status);
        } elseif ($mode == 'html') {
            if ($this->status == 'active') {
                return '<span class="label label-primary">Active</span>';
            } elseif ($this->status == 'inactive') {
                return '<span class="label label-danger">Inactive</span>';
            } else {
                return sprintf('<span class="label label-default">%s</span>', $this->status);
            }
        }
    }
}

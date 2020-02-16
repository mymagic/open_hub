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

class OrganizationRevenue extends OrganizationRevenueBase
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
        if (isset($this->amount)) {
            $this->amount = str_replace(',', '', $this->amount);
        }

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
        $return['amount'] = Yii::t('app', 'Revenue Amount (USD)');
        $return['amount_profit'] = Yii::t('app', 'Profit Amount (USD)');
        $return['amount_profit_before_tax'] = Yii::t('app', 'Profit Before Tax Amount (USD)');

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
                'params' => array(':refTable' => 'organization_revenue'),
                'order' => 'proofs.date_modified DESC',
            ),
        );
    }
}

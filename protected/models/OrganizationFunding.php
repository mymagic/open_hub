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

class OrganizationFunding extends OrganizationFundingBase
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
        $return['isAmountUndisclosed'] = Yii::t('app', 'Amount undisclosedable');
        $return['amount'] = Yii::t('app', 'Amount (USD)');

        return $return;
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
            'vcOrganization' => array(self::BELONGS_TO, 'Organization', 'vc_organization_id'),
            'proofs' => array(self::HAS_MANY, 'Proof', 'ref_id',
                'condition' => 'proofs.ref_table=:refTable',
                'params' => array(':refTable' => 'organization_funding'),
                'order' => 'proofs.date_modified DESC',
            ),
            'resource2OrganizationFundings' => array(self::HAS_MANY, 'Resource2OrganizationFunding', 'organization_funding_id'),
        );
    }

    public function getForeignReferList($isNullable = false, $is4Filter = false)
    {
        $language = Yii::app()->language;

        if ($is4Filter) {
            $isNullable = false;
        }
        if ($isNullable) {
            $result[] = array('key' => '', 'title' => '');
        }
        $result = Yii::app()->db->createCommand()
        ->select(array('t.id as key', "CONCAT('#', t.id, ' - ', o.title, ' - $', t.amount) as title"))
        ->from(self::tableName().' as t')
        ->join('organization o', 'o.id=t.organization_id')
        ->queryAll();
        if ($is4Filter) {
            $newResult = array();
            foreach ($result as $r) {
                $newResult[$r['key']] = $r['title'];
            }

            return $newResult;
        }

        return $result;
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('organization_id', $this->organization_id);
        if (!empty($this->sdate_raised) && !empty($this->edate_raised)) {
            $sTimestamp = strtotime($this->sdate_raised);
            $eTimestamp = strtotime("{$this->edate_raised} +1 day");
            $criteria->addCondition(sprintf('date_raised >= %s AND date_raised < %s', $sTimestamp, $eTimestamp));
        }
        $criteria->compare('vc_organization_id', $this->vc_organization_id);
        $criteria->compare('vc_name', $this->vc_name, true);
        $criteria->compare('is_amount_undisclosed', $this->is_amount_undisclosed);
        
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('round_type_code', $this->round_type_code);
        $criteria->compare('source', $this->source, true);
        if (!empty($this->sdate_added) && !empty($this->edate_added)) {
            $sTimestamp = strtotime($this->sdate_added);
            $eTimestamp = strtotime("{$this->edate_added} +1 day");
            $criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
        }
        if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
            $sTimestamp = strtotime($this->sdate_modified);
            $eTimestamp = strtotime("{$this->edate_modified} +1 day");
            $criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
        }
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_publicized', $this->is_publicized);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.date_raised DESC',
            ),
        ));
    }
}

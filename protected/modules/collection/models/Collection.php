<?php

class Collection extends CollectionBase
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

    public function title2Obj($user, $title)
    {
        $collection = self::model()->find(array(
            'condition' => 't.title=:title AND t.creator_user_id=:userId',
            'params' => array(':title' => $title, ':userId' => $user->id),
            'order' => 'id DESC',
        ));
        if (!empty($collection)) {
            return $collection;
        }
    }
}

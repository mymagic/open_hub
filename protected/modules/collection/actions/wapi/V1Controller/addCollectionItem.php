<?php

class addCollectionItem extends Action
{
    public function run()
    {
        $meta = array();
        $jwt = Yii::app()->request->getPost('jwt');
        $itemId = Yii::app()->request->getPost('itemId');
        $tableName = Yii::app()->request->getPost('tableName');
        $collection = Yii::app()->request->getPost('collection');
        $collectionSub = Yii::app()->request->getPost('collectionSub');

        $meta['input']['jwt'] = $jwt;
        $meta['input']['itemId'] = $itemId;
        $meta['input']['tableName'] = $tableName;
        $meta['input']['collection'] = $collection;
        $meta['input']['collectionSub'] = $collectionSub;

        $token = $this->getController()->validateJwt($jwt, $meta);
        $user = HUB::getUserByUsername($token->data->username);

        try {
            $this->getController()->outputSuccess(HubCollection::addCollectionItem($user, $tableName, $itemId, $collection, $collectionSub), $meta);
        } catch (Exception $e) {
            $this->getController()->outputFail($e->getMessage(), $meta);
        }
    }
}

<?php

class moveCollectionSub extends Action
{
    public function run()
    {
        $meta = array();
        $jwt = Yii::app()->request->getPost('jwt');
        $id = Yii::app()->request->getPost('id');
        $targetCollectionId = Yii::app()->request->getPost('targetCollectionId');

        $meta['input']['jwt'] = $jwt;
        $meta['input']['id'] = $id;
        $meta['input']['targetCollectionId'] = $targetCollectionId;

        $token = $this->getController()->validateJwt($jwt, $meta);
        $user = HUB::getUserByUsername($token->data->username);

        try {
            $this->getController()->outputSuccess(HubCollection::moveCollectionSub($user, $id, $targetCollectionId), $meta);
        } catch (Exception $e) {
            $this->getController()->outputFail($e->getMessage(), $meta);
        }
    }
}

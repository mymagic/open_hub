<?php

class renameCollectionSub extends Action
{
    public function run()
    {
        $meta = array();
        $jwt = Yii::app()->request->getPost('jwt');
        $id = Yii::app()->request->getPost('id');
        $newTitle = Yii::app()->request->getPost('newTitle');

        $meta['input']['jwt'] = $jwt;
        $meta['input']['id'] = $id;
        $meta['input']['newTitle'] = $newTitle;

        $token = $this->getController()->validateJwt($jwt, $meta);
        $user = HUB::getUserByUsername($token->data->username);

        try {
            $this->getController()->outputSuccess(HubCollection::renameCollectionSub($user, $id, $newTitle), $meta);
        } catch (Exception $e) {
            $this->getController()->outputFail($e->getMessage(), $meta);
        }
    }
}

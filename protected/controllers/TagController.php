<?php

class TagController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function actions()
    {
        return array(
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'getProgramSkillsets'),
                'users' => array('@'),
                'expression' => '$user->accessBackend==true && $user->isAdmin==true',
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $tags = Subject::model()->getAllTagsWithModelsCount(array('order' => 'name'));
        $this->render('index', array('model' => $tags));
    }

    public function actionAdmin()
    {
        $this->redirect('index');
    }

    /*public function actionDelete($id)
    {
        $post->removeAllTags()->save();
    }*/

    public function actionGetProgramSkillsets()
    {
        header('Content-type: application/json');

        //$result = array('apple', 'manggo', 'orange', 'cow', 'zebra', 'bee', 'cat', 'dog');
        $tmps = Skillset::model()->findAll(array('select' => 'name', 'order' => 'name ASC'));
        foreach ($tmps as $t) {
            $result[] = $t->name;
        }
        echo CJSON::encode(!empty($result) ? $result : '');
        Yii::app()->end();
    }
}

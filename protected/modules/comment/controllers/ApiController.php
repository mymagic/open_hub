<?php
class ApiController extends Controller 
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
					
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array(
				),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			)
		);
	}
	
	public function init()
	{
		parent::init();
		//$this->layout = '/layouts/frontend';
		// $this->activeMenuCpanel = 'mentor';
		// $this->activeMenuMain = 'mentor';
		//$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', //$this->layoutParams['bodyClass']);
		
		$this->pageTitle = 'Comment';
	}

	public function actions()
	{
		return array
		(
 		);
    }

    // work as toggle
    public function actionUpvoteComment()
    {
        $commentId = Yii::app()->request->getPost('commentId');
        $userId = Yii::app()->user->id;
        
        if(isset($commentId) && !empty($commentId) && !empty($userId))
        {
            if(!CommentUpvote::isExists($commentId, $userId))
            {
                $upvote = new CommentUpvote;
                $upvote->comment_id = $commentId;
                $upvote->user_id = $userId;
                if($upvote->save())
                {
                    $this->outputJsonSuccess(array());
                }
            }
            else
            {
                $upvote = CommentUpvote::model()->findByAttributes
                (array(), array(
                    'condition' => 'comment_id=:commentId AND user_id=:userId', 'params' => array(':commentId'=>$commentId, ':userId'=>$userId)
                ));
                
                if(!empty($upvote) && $upvote->delete())
                    $this->outputJsonSuccess(array());
            }
        }
    }

    public function actionDeleteComment($id)
    {
        $comment = Comment::model()->findByPk($id);
        if(self::isCreatedByCurrentUser($comment))
        {
           if($comment->delete())
           {
                $return = array();
                $this->outputJsonSuccess($return);
           }
        }

    }
    
    public function actionPostComment($key)
    {
        $user=User::model()->userId2obj(Yii::app()->user->id);
        if(!empty($user))
        {
            $comment = new Comment;
            $comment->object_key = $key;
            $comment->parent_id = Yii::app()->request->getPost('parent');
            $comment->html_content = Yii::app()->request->getPost('content');
            $comment->creator_user_id = $user->id;
            $comment->creator_fullname = $user->profile->full_name;
            $comment->url_creator_profile = $user->profile->image_avatar;
            $comment->csv_ping = implode(',', Yii::app()->request->getPost('pings'));
            
            if($comment->save())
            {
                $return = array(
                    'id'=> $comment->id, 
                    'parent'=> $comment->parent_id,
                    'created'=> date('Y-m-d', $comment->date_added),
                    'modified'=> date('Y-m-d', $comment->date_modified),
                    'content'=> $comment->html_content,
                    'pings'=> explode(',', $comment->csv_ping),
                    'creator'=> $comment->creator_user_id,
                    'fullname'=> $comment->creator_fullname,
                    'profile_picture_url'=> $comment->url_creator_profile,
                    'created_by_admin'=> self::isCreatedByAdmin($comment),
                    'created_by_current_user'=> self::isCreatedByCurrentUser($comment),
                    'upvote_count'=> $comment->countCommentUpvotes,
                    'user_has_upvoted'=> $comment->hasUserUpvote($user->id),
                    'is_new'=> self::isNewComment($comment)
                );

                $this->outputJsonSuccess($return);
            }
        }
    }

    public function actionUpdateComment($id)
    {
        $user=User::model()->userId2obj(Yii::app()->user->id);
        if(!empty($user))
        {
            $comment = Comment::model()->findByPk($id);
            $comment->parent_id = Yii::app()->request->getPost('parent');
            $comment->html_content = Yii::app()->request->getPost('content');
            $comment->creator_user_id = $user->id;
            $comment->creator_fullname = $user->profile->full_name;
            $comment->url_creator_profile = $user->profile->image_avatar;
            $comment->csv_ping = implode(',', Yii::app()->request->getPost('pings'));

            if($comment->save())
            {
                $return = array(
                    'id'=> $comment->id, 
                    'parent'=> $comment->parent_id,
                    'created'=> date('Y-m-d', $comment->date_added),
                    'modified'=> date('Y-m-d', $comment->date_modified),
                    'content'=> $comment->html_content,
                    'pings'=> explode(',', $comment->csv_ping),
                    'creator'=> $comment->creator_user_id,
                    'fullname'=> $comment->creator_fullname,
                    'profile_picture_url'=> $comment->url_creator_profile,
                    'created_by_admin'=> self::isCreatedByAdmin($comment),
                    'created_by_current_user'=> self::isCreatedByCurrentUser($comment),
                    'upvote_count'=> $comment->countCommentUpvotes,
                    'user_has_upvoted'=> $comment->hasUserUpvote($user->id),
                    'is_new'=> self::isNewComment($comment)
                );

                $this->outputJsonSuccess($return);
            }
        }
    }

    public function actionGetComments($key)
    {
        $comments = array();
        $comments[] = array(
            'id' => 0,
            'created' => '2019-01-01',
            'content' => 'Feel free to comment here',
            'fullname' => 'Skynet',
            'profile_picture_url' => Yii::app()->params['masterUrl'].$this->module->getAssetsUrl().'/images/skynet.avatar.png',
            'upvote_count' => 0,
            'user_has_upvoted' => false
        );
        
        $user=User::model()->userId2obj(Yii::app()->user->id);
        if(!empty($user))
        {
            $tmps = Comment::model()->findAll(array('condition'=>'is_active=1 AND object_key=:key', 'params'=>array(':key'=>$key), 'order'=>'date_added DESC'));

            foreach($tmps as $comment)
            {
                $comments[] = array(
                    'id'=> $comment->id, 
                    'parent'=> $comment->parent_id,
                    'created'=> date('Y-m-d H:i:s', $comment->date_added),
                    'modified'=> date('Y-m-d H:i:s', $comment->date_modified),
                    'content'=> $comment->html_content,
                    'pings'=> explode(',', $comment->csv_ping),
                    'creator'=> $comment->creator_user_id,
                    'fullname'=> $comment->creator_fullname,
                    'profile_picture_url'=> $comment->url_creator_profile,
                    'created_by_admin'=> self::isCreatedByAdmin($comment),
                    'created_by_current_user'=> self::isCreatedByCurrentUser($comment),
                    'upvote_count'=> $comment->countCommentUpvotes,
                    'user_has_upvoted'=> $comment->hasUserUpvote($user->id),
                    'is_new'=> self::isNewComment($comment)
                );
            }
        }

        $this->outputJsonSuccess($comments);
    }
	
	public function actionGetUsers()
	{
        $tmps = Admin::model()->findAll();
        foreach($tmps as $admin)
        {
            $users[] = array(
                'id'=>$admin->user_id, 
                'fullname'=>$admin->user->profile->full_name, 
                'email'=>$admin->username, 
                'profile_picture_url'=>$admin->user->profile->image_avatar
            );
        }

        $this->outputJsonSuccess($users);
    }

    protected function isCreatedByAdmin($comment)
    {
        return false;
    }

    protected function isCreatedByCurrentUser($comment)
    {
        if($comment->creator_user_id == Yii::app()->user->id && !empty(Yii::app()->user->id )) return true;
        return false;
    }

    protected function isNewComment($comment)
    {
        if(HUB::now() - $comment->date_added < 60*60*24) return true;
        return false;
    }

    
}
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

class User extends UserBase
{
    public $cusername;
    public $cpassword;
    public $opassword;
    public $npassword;

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

    public function init()
    {
        parent::init();
        $this->stat_login_count = 0;
        $this->stat_login_success_count = 0;
        $this->stat_reset_password_count = 0;
        $this->signup_type = 'default';
    }

    public function behaviors()
    {
        foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
            if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['User'])) {
                $return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['User'];
                $return[$moduleKey]['model'] = $this;
            }
        }

        return $return;
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();

        $attributeLabels['opassword'] = Yii::t('app', 'Current Password');
        $attributeLabels['npassword'] = Yii::t('app', 'New Password');
        $attributeLabels['cpassword'] = Yii::t('app', 'Confirm New Password');

        $attributeLabels['date_added'] = Yii::t('app', 'Date Registered');

        return $attributeLabels;
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username', 'required', 'on' => array('create', 'signup')),
            array('username', 'email', 'allowEmpty' => false, 'checkMX' => true, 'on' => array('create', 'signup')),
            array('username', 'unique', 'allowEmpty' => false, 'className' => 'User', 'attributeName' => 'username', 'caseSensitive' => false, 'on' => array('create', 'signup')),
            //array('nickname', 'unique', 'allowEmpty'=>false, 'className'=>'User', 'attributeName'=>'nickname', 'caseSensitive'=>false, 'on'=>array('create', 'signup')),
            //array('nickname', 'match', 'pattern'=>'/^([a-z0-9_-])+$/', 'message'=>Yii::t('app', '{attribute} only accept valid character set like a-z, 0-9, - and _')),

            array('cusername', 'required', 'on' => 'signup'),
            array('cusername', 'compare', 'compareAttribute' => 'username', 'on' => 'signup'),

            array('opassword, npassword, cpassword', 'length', 'min' => 6, 'max' => 32, 'on' => 'changePassword'),
            array('opassword, npassword, cpassword', 'required', 'on' => 'changePassword'),
            array('cpassword', 'compare', 'compareAttribute' => 'npassword', 'on' => 'changePassword'),
            array('npassword', 'compare', 'compareAttribute' => 'opassword', 'operator' => '!=', 'on' => 'changePassword', 'message' => Yii::t('core', 'New password must be different from current one')),

            array('stat_reset_password_count, stat_login_count, stat_login_success_count, is_active, date_activated, date_added, date_modified', 'numerical', 'integerOnly' => true),

            array('username, password', 'length', 'max' => 128),
            array('reset_password_key', 'length', 'max' => 32),

            array('username', 'required', 'on' => 'lostPassword'),
            array('username, reset_password_key', 'required', 'on' => 'resetLostPassword'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, reset_password_key, stat_reset_password_count, stat_login_count, stat_login_success_count, signup_type, signup_ip, is_active, date_activated, date_added, date_modified', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'admin' => array(self::HAS_ONE, 'Admin', 'user_id'),
            //'admins' => array(self::HAS_MANY, 'Admin', 'username'),
            'logs' => array(self::HAS_MANY, 'Log', 'user_id'),
            'member' => array(self::HAS_ONE, 'Member', 'user_id'),
            //'members' => array(self::HAS_MANY, 'Member', 'username'),
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
            'roles' => array(self::MANY_MANY, 'Role', 'role2user(user_id, role_id)'),
            'sessions' => array(self::HAS_MANY, 'UserSession', 'user_id'),
        );
    }

    // username
    public function username2id($username)
    {
        $user = User::model()->find('t.username=:username', array(':username' => $username));
        if (!empty($user)) {
            return $user->id;
        }
    }

    public function username2obj($username)
    {
        $user = User::model()->find('t.username=:username', array(':username' => $username));
        if (!empty($user)) {
            return $user;
        }
    }

    public function userId2obj($id)
    {
        $user = User::model()->find('t.id=:id', array(':id' => $id));
        if (!empty($user)) {
            return $user;
        }
    }

    public function findBySocial($provider, $identifier)
    {
        $user = User::model()->find('t.social_provider=:provider AND t.social_identifier=:identifier', array(':provider' => strtolower($provider), ':identifier' => $identifier));
        if (!empty($user)) {
            return $user;
        }
    }

    public function findByAuthSocial($username, $identifier)
    {
        return $this->findByAttributes(array(
             'username' => $username,
             'social_identifier' => $identifier,
        ));
    }

    public function isUniqueUsername($username)
    {
        $user = User::model()->find('t.username=:username', array(':username' => $username));
        if (!empty($user) && !empty($user->username)) {
            return false;
        }

        return true;
    }

    // nickname
    /*public function nickname2id($nickname)
    {
        $user = User::model()->find('t.nickname=:nickname', array(':nickname'=>$nickname));
        if(!empty($user))
        {
            return $user->id;
        }
    }

    public function nickname2obj($nickname)
    {
        $user = User::model()->find('t.nickname=:nickname', array(':nickname'=>$nickname));
        if(!empty($user))
        {
            return $user;
        }
    }

    public function isUniqueNickname($nickname)
    {
        $user = User::model()->find('t.nickname=:nickname', array(':nickname'=>$nickname));
        if(!empty($user) && !empty($user->nickname))
        {
            return false;
        }
        return true;
    }*/

    public function isValidUsername($username)
    {
        $username = trim($username);
        // check length
        if (strlen($username) <= 24 && strlen($username) >= 5) {
            if (preg_match('/^[a-z0-9_]+$/', $username)) {
                return true;
            }
        }

        return false;
    }

    public function isUniqueEmail($email)
    {
        $user = User::model()->find('t.email=:email', array(':email' => $email));
        if (!empty($user) && !empty($user->email)) {
            return false;
        }

        return true;
    }

    public function isValidEmail($email)
    {
        $email = trim($email);
        $validator = new CEmailValidator();
        $validator->checkMX = false;

        // check length
        if (strlen($email) <= 128) {
            if ($validator->validateValue($email)) {
                return true;
            }
        }

        return false;
    }

    //
    // role
    public function getAllRolesCode()
    {
        $userRoles = array();
        if (!empty($this->roles)) {
            foreach ($this->roles as $role) {
                $userRoles[] = $role->code;
            }
        }

        return $userRoles;
    }

    public function hasRole($roleCode)
    {
        if (in_array($roleCode, $this->getAllRolesCode())) {
            return true;
        }

        return false;
    }

    public function hasNoRole($roleCode)
    {
        if (!in_array($roleCode, $this->getAllRolesCode())) {
            return true;
        }

        return false;
    }

    public function removeRole($roleCode)
    {
        if ($this->hasRole($roleCode)) {
            $roleId = Role::code2id($roleCode);
            $role2user = Role2User::model()->findByAttributes(array('user_id' => $this->id, 'role_id' => $roleId));

            return $role2user->delete();
        }

        return false;
    }

    public function addRole($roleCode)
    {
        if ($this->hasNoRole($roleCode)) {
            $roleId = Role::code2id($roleCode);
            $role2user = new Role2User();
            $role2user->user_id = $this->id;
            $role2user->role_id = $roleId;

            return $role2user->save();
        }

        return false;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if (!empty($this->password) && !ysUtil::isSha1($this->password)) {
                $this->password = sha1($this->password);
            }

            if (!empty($this->date_last_login)) {
                if (!is_numeric($this->date_last_login)) {
                    $this->date_last_login = strtotime($this->date_last_login);
                }
            }
            if (!empty($this->date_activated)) {
                if (!is_numeric($this->date_activated)) {
                    $this->date_activated = strtotime($this->date_activated);
                }
            }

            if ($this->isNewRecord) {
                $this->date_added = $this->date_modified = time();
                if ($this->is_active) {
                    $this->date_activated = time();
                }
            } else {
                $this->date_modified = time();
            }

            return true;
        } else {
            return false;
        }
    }

    // Terminate Account

    // Terminate Account

    public function isUserTerminatedInConnect()
    {
        $httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https:' : 'http:';

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $httpOrHttps.Yii::app()->params['connectUrl'].'/api/isUserTerminated',
            array(
                'form_params' => array(
                    'email' => $this->username,
                    'auth_token' => Yii::app()->params['connectSecretKeyApi'],
                ),
            )
        );
        $body = (string) $response->getBody();
        $return = json_decode($body);

        return $return->message;
    }

    public function setStatusToTerminateInConnect()
    {
        $httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https:' : 'http:';

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $httpOrHttps.Yii::app()->params['connectUrl'].'/api/terminateAccount',
            array(
                'form_params' => array(
                    'email' => $this->username,
                    'auth_token' => Yii::app()->params['connectSecretKeyApi'],
                ),
            )
        );
        $body = (string) $response->getBody();
        $return = json_decode($body);
        if ($return->message === 'OK') {
            return true;
        } else {
            return false;
        }
    }

    public function setStatusToEnableInConnect()
    {
        $httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https:' : 'http:';
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $httpOrHttps.Yii::app()->params['connectUrl'].'/api/enableAccount',
            array(
                'form_params' => array(
                    'email' => $this->username,
                    'auth_token' => Yii::app()->params['connectSecretKeyApi'],
                ),
            )
        );
        $body = (string) $response->getBody();
        $return = json_decode($body);
        if ($return->message === 'OK') {
            return true;
        } else {
            return false;
        }
    }

    //This call will completely remove the user in connect db
    //IT also ensure the user will be able to register using this email
    public function destroyRemoteConnectUser()
    {
        try {
            $httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https:' : 'http:';

            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                $httpOrHttps.Yii::app()->params['connectUrl'].'/api/destroyUserAccount',
                array(
                    'form_params' => array(
                        'email' => $this->username,
                        'auth_token' => Yii::app()->params['connectSecretKeyApi'],
                    ),
                )
            );
            $body = (string) $response->getBody();
            $return = json_decode($body);
            if ($return->message === 'success') {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw 'Failed to remove connect user: '.$e->getMessage();
        }
    }

    /**
     * These are function for enum usage.
     */
    public function getEnumSignupType($isNullable = false, $is4Filter = false)
    {
        if ($is4Filter) {
            $isNullable = false;
        }
        if ($isNullable) {
            $result[] = array('code' => '', 'title' => $this->formatEnumSignupType(''));
        }

        $result[] = array('code' => 'default', 'title' => $this->formatEnumSignupType('default'));
        $result[] = array('code' => 'facebook', 'title' => $this->formatEnumSignupType('facebook'));
        $result[] = array('code' => 'google', 'title' => $this->formatEnumSignupType('google'));
        $result[] = array('code' => 'admin', 'title' => $this->formatEnumSignupType('admin'));
        $result[] = array('code' => 'connect', 'title' => $this->formatEnumSignupType('connect'));

        if ($is4Filter) {
            $newResult = array();
            foreach ($result as $r) {
                $newResult[$r['code']] = $r['title'];
            }

            return $newResult;
        }

        return $result;
    }

    public function formatEnumSignupType($code)
    {
        switch ($code) {
            case 'default': return Yii::t('app', 'Default'); break;

            case 'facebook': return Yii::t('app', 'Facebook'); break;

            case 'google': return Yii::t('app', 'Google'); break;
            case 'admin': return Yii::t('app', 'Admin'); break;
            case 'connect': return Yii::t('app', 'MaGIC Connect'); break;
            default: return ''; break;
        }
    }

    public function toApi($params = array())
    {
        $return = array(
            'id' => $this->id,
            'username' => $this->username,
            'socialProvider' => $this->social_provider,
            'socialIdentifier' => $this->social_identifier,
            'jsonSocialParams' => $this->json_social_params,
            'password' => $this->password,
            'resetPasswordKey' => $this->reset_password_key,
            'statResetPasswordCount' => $this->stat_reset_password_count,
            'statLoginCount' => $this->stat_login_count,
            'statLoginSuccessCount' => $this->stat_login_success_count,
            'lastLoginIp' => $this->last_login_ip,
            'dateLastLogin' => $this->date_last_login,
            'fDateLastLogin' => $this->renderDateLastLogin(),
            'signupType' => $this->signup_type,
            'signupIp' => $this->signup_ip,
            'isActive' => $this->is_active,
            'dateActivated' => $this->date_activated,
            'fDateActivated' => $this->renderDateActivated(),
            'dateAdded' => $this->date_added,
            'fDateAdded' => $this->renderDateAdded(),
            'dateModified' => $this->date_modified,
            'fDateModified' => $this->renderDateModified(),

            'urlBackendView' => Yii::app()->createAbsoluteUrl('/member/view', array('id' => $this->id)),
        );

        if (!in_array('-profile', $params) && !empty($this->profile)) {
            $return['profile'] = $this->profile->toApi();
        }

        // many2many

        return $return;
    }
}

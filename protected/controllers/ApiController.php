<?php
/**
* NOTICE OF LICENSE.
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
*
* @see https://github.com/mymagic/open_hub
*
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class ApiController extends Controller
{
    public function actionIndex()
    {
        echo 'test';
        Yii::app()->end();
    }

    public function actionGetUserOrganizationsCanJoin($keyword)
    {
        $return['status'] = 'fail';
        $return['msg'] = 'Unknown Error';
        $return['meta'] = null;
        $return['data'] = null;

        $return['meta']['input']['keyword'] = $keyword;

        if (strlen($keyword) < 2) {
            $return['msg'] = 'Please insert longer keyword';
        }
        if (Yii::app()->user->isGuest || empty(Yii::app()->user->username)) {
            $return['msg'] = 'Invalid Access';
        }

        $return['meta']['input']['email'] = Yii::app()->user->username;

        $tmps = HUB::getUserOrganizationsCanJoin($keyword, Yii::app()->user->username);

        if (!empty($tmps)) {
            $return['status'] = 'success';
            $return['msg'] = '';
            foreach ($tmps as $tmp) {
                $return['data'][] = $tmp->toApi(array('-products', '-impacts', '-individualOrganizations', 'eventOrganizations', 'eventOrganizationsSelectedParticipant'));

                if (strtolower($tmp->title) === strtolower($keyword)) {
                    $return['meta']['output']['exactMatchId'] = $tmp->id;
                }
            }
        }

        if (!empty($return['data'])) {
            echo $this->outputJsonSuccess($return['data'], $return['meta']);
        } else {
            echo $this->outputJsonFail($return['msg'], $return['meta']);
        }
    }

    public function actionGetRandomProfiles($looking = '', $limit = 10)
    {
        /*$return['status'] = 'fail';
        $return['msg'] = 'Unknown Error';
        $return['meta'] = '';
        $return['data'] = null;

        $return['meta']['input']['limit'] = $limit;
        $return['meta']['input']['looking'] = $looking;

        if ($limit > 100) {
            $limit = 100;
        }

        if (!empty($looking)) {
            $arrayLooking = explode(',', $looking);
        }
        $filterLooking = '';
        if (!empty($arrayLooking)) {
            $filterLooking .= '(';
            if (in_array('fulltime', $arrayLooking)) {
                $filterLooking .= ' r1.is_looking_fulltime=1 OR ';
            }
            if (in_array('contract', $arrayLooking)) {
                $filterLooking .= ' r1.is_looking_contract=1 OR ';
            }
            if (in_array('freelance', $arrayLooking)) {
                $filterLooking .= ' r1.is_looking_freelance=1 OR ';
            }
            if (in_array('cofounder', $arrayLooking)) {
                $filterLooking .= ' r1.is_looking_cofounder=1 OR ';
            }
            if (in_array('internship', $arrayLooking)) {
                $filterLooking .= ' r1.is_looking_internship=1 OR ';
            }
            if (in_array('apprenticeship', $arrayLooking)) {
                $filterLooking .= ' r1.is_looking_apprenticeship=1 OR ';
            }
            $filterLooking = substr($filterLooking, 0, -3) . ') AND';
        }

        // base on http://stackoverflow.com/questions/18943417/how-to-quickly-select-3-random-records-from-a-30k-mysql-table-with-a-where-filte

        // ys: this sql give error and sometime without results or not fill up to the limit
        //$sql = sprintf('SELECT r1.* FROM portfolio AS r1 INNER JOIN (SELECT (RAND() * (SELECT MAX(id) FROM portfolio)) AS id) AS t ON r1.id >= t.ID WHERE %s r1.is_active=1 ORDER BY r1.id ASC LIMIT %s', $filterLooking, $limit);

        // ys: this just not working
        // $sql = sprintf('SELECT r1.* FROM portfolio AS r1 WHERE ((%s r1.is_active=1) AND RAND() < %s * %s/30000) LIMIT %s;', $filterLooking, $limit*5, $limit, $limit);

        // ys: this is stable and the best althought taxing
        $sql = sprintf('SELECT r1.* FROM portfolio AS r1 WHERE %s r1.is_active=1 AND r1.visibility="public" GROUP BY r1.id ORDER BY RAND() LIMIT %s;', $filterLooking, $limit);

        //echo $sql;exit;
        $result = Portfolio::model()->findAllBySql($sql);
        if (!empty($result)) {
            foreach ($result as $portfolio) {
                $jsonPortfolio = $portfolio->toApi();
                $jsonPortfolio['portfolioUrl'] = Orang::getPortfolioUrl($portfolio, true);
                $return['data'][] = $jsonPortfolio;
            }
            $return['status'] = 'success';
            $return['msg'] = '';
        }
        $return['meta']['output']['limit'] = $limit;
        $return['meta']['output']['total'] = count($return['data']);

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        echo CJSON::encode($return);
        Yii::app()->end();*/
    }

    public function actionKeepAlive()
    {
        echo 'OK';
        Yii::app()->end();
    }

    // dir: map_application/se_application
    // code: pitch_deck/product_demo
    // uid: startup code? 280916... using the name uid instead of id to avoid yii default url routing & mapping issue
    // format: pdf
    public function actionGetUploadedFile($dir, $code, $uid, $format)
    {
        /*if (empty($dir) || empty($code) || empty($uid) || empty($format)) {
            Notice::page(Yii::t('notice', 'Please supply the required params'), Notice_ERROR);
        }

        $fileName = sprintf('%s.%s.%s', $code, $uid, $format);
        $filePath = sprintf('%s%s%s%s%s', Yii::getPathOfAlias('uploads'), DIRECTORY_SEPARATOR, $dir, DIRECTORY_SEPARATOR, $fileName);
        // if file exists
        if (Yii::app()->file->set($filePath)->exists) {
            $hasAccess = false;
            // check security
            if ($dir == 'map_application' || $dir == 'se_application') {
                $startup = Startup::model()->find('code=:code', array(':code' => $uid));
                // can access if it is user own file
                if ($startup && $startup->user_id == Yii::app()->user->id) {
                    $hasAccess = true;
                }
                // can access if session is admin
                // todo: need to specific down to role
                if (!Yii::app()->user->isGuest && Yii::app()->user->accessBackend) {
                    $hasAccess = true;
                }
            }

            if ($hasAccess) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . ($fileName));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
                readfile($filePath);

                Yii::app()->end();
            } else {
                Notice::page(Yii::t('notice', 'Invalid Access'), Notice_ERROR);
            }
        } else {
            Notice::page(Yii::t('notice', 'Requested file not found: {fileName}', ['{fileName}' => $fileName]), Notice_ERROR);
        }*/
    }

    public function actionRenderStateList($country_code)
    {
        $countryCode = trim($country_code);
        $data = State::model()->findAll(array(
            'select' => 't.code, t.title',
            'condition' => "country_code='{$countryCode}'",
            'order' => 't.title ASC',
            //'group'=>'t.batch',
            //'distinct'=>true,
        ));
        $data = Html::listData($data, 'code', 'title');
        //print_r($data);exit;
        echo "<option value=''>Select State</option>";
        foreach ($data as $value => $state) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($state), true);
        }
    }

    public function actionRenderCityList($state_code)
    {
        $stateCode = trim($state_code);
        $data = City::model()->findAll(array(
            'select' => 't.id, t.title',
            'condition' => "state_code='{$stateCode}'",
            'order' => 't.title ASC',
            //'group'=>'t.batch',
            //'distinct'=>true,
        ));
        $data = Html::listData($data, 'id', 'title');
        echo "<option value=''>Select City</option>";
        foreach ($data as $value => $city) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($city), true);
        }
    }

    public function actionGetUserActFeed()
    {
        $meta = array();
        $user = HUB::getUserByUsername(Yii::app()->user->username);
        if (empty($user)) {
            $this->outputJsonFail('Invalid User', $meta);
        }

        $year = Yii::app()->request->getQuery('year', date('Y'));
        $services = Yii::app()->request->getQuery('services', '*');

        $meta['output']['email'] = $user->username;
        $meta['input']['year'] = $year;
        $meta['input']['services'] = $services;

        try {
            $user = HUB::getUserByUsername($user->username);
            $tmps = HUB::getUserActFeed($user, $year, $services);
            if (!empty($tmps)) {
                foreach ($tmps as $tmp) {
                    $result[] = $tmp;
                }
            }

            $this->outputJsonSuccess($result, $meta);
        } catch (Exception $e) {
            $this->outputJsonFail($e->getMessage(), $meta);
        }
    }

    public function actionGetOrganizationByTitle()
    {
        $status = 'fail';
        $data = null;

        if (Yii::app()->user->isGuest || empty(Yii::app()->user->username)) {
            $return['msg'] = 'Invalid Access';
        }

        $title = Yii::app()->request->getParam('title');

        if (empty($title)) {
            $this->renderJSON(array('status' => $status));
        }

        $organization = Organization::title2obj($title);

        if (!empty($organization)) {
            $status = 'success';

            $data = $organization->toApi(array('-products', '-impacts', '-personas', '-industries'));
        }

        $this->layout = false;
        header('Content-type: application/json');
        $this->renderJSON(array('status' => $status, 'data' => $data));
        Yii::app()->end();
    }

    public function actionGetUsersByOrganization()
    {
        $status = 'fail';
        $data = null;

        if (Yii::app()->user->isGuest || empty(Yii::app()->user->username)) {
            $return['msg'] = 'Invalid Access';
        }

        $title = Yii::app()->request->getParam('title');

        if (empty($title)) {
            $this->renderJSON(array('status' => $status));
        }

        $tmp = Organization::model()->with('organization2Emails')->findByAttributes(array('title' => $title));

        $data = array();

        foreach ($tmp->organization2Emails as $o2e) {
            $email = $o2e->user_email;

            $user = User::model()->with('profile')->find('t.username=:username', array(':username' => $email));

            $arr = ['email' => $email, 'fullName' => $user->profile->full_name];
            $data[] = $arr;
            $status = 'success';
        }

        $this->layout = false;
        header('Content-type: application/json');
        $this->renderJSON(array('status' => $status, 'data' => $data));
        Yii::app()->end();
    }

    public function actionSetOrganization()
    {
        $status = 'fail';

        $title = trim(Yii::app()->request->getParam('title'));
        if (empty($title)) {
            $this->renderJSON(array('status' => $status));
        }

        $text_oneliner = yii::app()->request->getParam('oneliner');
        $url_website = yii::app()->request->getParam('website');

        $params['organization']['text_oneliner'] = trim($text_oneliner);
        $params['organization']['url_website'] = trim($url_website);
        $params['userEmail'] = Yii::app()->user->username;

        $organization = HubOrganization::getOrCreateOrganization($title, $params);
        if (!empty($organization->id)) {
            $status = 'success';
        }

        header('Content-type: application/json');
        $this->renderJSON(array('status' => $status));
        Yii::app()->end();
    }

    public function actionRenderResourceCategoryList($typefor_code, $resource_id = '')
    {
        $resource_id = trim($resource_id);
        $typefor_code = trim($typefor_code);

        if (!empty($resource_id)) {
            $resource = Resource::model()->findByPk($resource_id);
        }
        if (!empty($resource->resourceCategories)) {
            foreach ($resource->resourceCategories as $resourceCategory) {
                if ($resourceCategory->typefor == $typefor_code) {
                    $selecteds[] = $resourceCategory->id;
                }
            }
        }

        $data = ResourceCategory::model()->findAll(array(
            'select' => 't.id, t.title',
            'condition' => "typefor='{$typefor_code}'",
            'order' => 't.title ASC',
            //'group'=>'t.batch',
            //'distinct'=>true,
        ));
        $data = Html::listData($data, 'id', 'title');
        //print_r($data);exit;
        foreach ($data as $value => $category) {
            $selected = (in_array($value, $selecteds)) ? true : false;
            echo CHtml::tag('option', array('value' => $value, 'selected' => $selected), CHtml::encode($category), true);
        }
    }

    public function actionGetMilestone($id, $year)
    {
        $msg = '';
        $status = '';
        $result = '';
        $meta = array();

        // set meta
        $meta['id'] = $id;
        $meta['year'] = $year;

        $milestone = Milestone::model()->findByPk($id);

        // public cant access
        if (Yii::app()->user->isGuest || (!Yii::app()->user->accessCpanel && !Yii::app()->user->accessBackend)) {
            $status = 'fail';
            $msg = 'Unable to retrieve milestone. You have no access to this milestone.';
        }
        // user can access backend
        elseif (Yii::app()->user->accessBackend) {
        }
        // user can access cpanel and is not owner of the startup
        /*elseif(Yii::app()->user->accessCpanel && $milestone->username != Yii::app()->user->username)
        {
            $status = 'fail';
            $msg = "Unable to update monthly target. You have no access to this startup.";
        }*/ else {
            $status = 'fail';
            $msg = 'Invalid Access';
        }

        if ($status != 'fail') {
            try {
                $result = $milestone->toApi();
                $status = 'success';
            } catch (Exception $e) {
                $status = 'fail';
                $msg = 'Error: '.$e->getMessage();
            }
        }

        $this->layout = false;
        header('Content-type: application/json');
        echo $this->renderJSON(array('status' => $status, 'data' => $result, 'msg' => $msg, 'meta' => $meta));
        Yii::app()->end();
    }

    public function actionUpdateMilestoneWeekValue($id)
    {
        $msg = '';
        $status = '';
        $result = '';
        $meta = array();

        // set meta
        $meta['organizationId'] = '';
        $meta['id'] = $id;
        $meta['year'] = $_POST['year'];
        $meta['month'] = $_POST['month'];
        $meta['week'] = $_POST['week'];
        $meta['content'] = trim($_POST['content']);
        $meta['domId'] = $_POST['domId'];

        $milestone = Milestone::model()->findByPk($id);
        $meta['organizationId'] = $milestone->organization_id;

        // public cant access
        if (Yii::app()->user->isGuest || (!Yii::app()->user->accessCpanel && !Yii::app()->user->accessBackend)) {
            $status = 'fail';
            $msg = 'Unable to update milestone. You have no access to this milestone.';
        }
        // user can access backend
        elseif (Yii::app()->user->accessBackend) {
        }
        // user can access cpanel and is not owner of the startup
        /*elseif(Yii::app()->user->accessCpanel && $milestone->username != Yii::app()->user->username)
        {
            $status = 'fail';
            $msg = "Unable to update monthly target. You have no access to this startup.";
        }*/ else {
            $status = 'fail';
            $msg = 'Invalid Access';
        }

        if ($status != 'fail') {
            try {
                $content = strip_tags(trim($_POST['content']));
                $year = $_POST['year'];
                $month = $_POST['month'];
                $week = $_POST['week'];

                if (isset($content) && $content != '-' && $content != '') {
                    if (($milestone->preset_code == 'funding' || $milestone->preset_code == 'revenue') && !is_numeric($content)) {
                        throw new Exception('Only numeric value allowed');
                    }
                }

                if ($content == '-') {
                    $content = '';
                }
                $milestone->jsonArray_value[$year][$month][$week]['value'] = $content;
                if ($milestone->save()) {
                    $status = 'success';
                    $msg = 'Saved!';
                }
            } catch (Exception $e) {
                $status = 'fail';
                $msg = 'Error: '.$e->getMessage();
            }
        }

        $this->layout = false;
        header('Content-type: application/json');
        echo $this->renderJSON(array('status' => $status, 'data' => $result, 'msg' => $msg, 'meta' => $meta));
        Yii::app()->end();
    }

    public function actionUpdateMilestoneWeekRealized($id)
    {
        $msg = '';
        $status = '';
        $result = '';
        $meta = array();

        // set meta
        $meta['organizationId'] = '';
        $meta['id'] = $id;
        $meta['year'] = $_POST['year'];
        $meta['month'] = $_POST['month'];
        $meta['week'] = $_POST['week'];
        $meta['content'] = trim($_POST['content']);
        $meta['domId'] = $_POST['domId'];

        $milestone = Milestone::model()->findByPk($id);
        $meta['organizationId'] = $milestone->organization_id;

        // public cant access
        if (Yii::app()->user->isGuest || (!Yii::app()->user->accessCpanel && !Yii::app()->user->accessBackend)) {
            $status = 'fail';
            $msg = 'Unable to update milestone. You have no access to this milestone.';
        }
        // user can access backend
        elseif (Yii::app()->user->accessBackend) {
        }
        // user can access cpanel and is not owner of the startup
        /*elseif(Yii::app()->user->accessCpanel && $milestone->username != Yii::app()->user->username)
        {
            $status = 'fail';
            $msg = "Unable to update monthly target. You have no access to this startup.";
        }*/ else {
            $status = 'fail';
            $msg = 'Invalid Access';
        }

        if ($status != 'fail') {
            try {
                $content = strip_tags(trim($_POST['content']));
                $year = $_POST['year'];
                $month = $_POST['month'];
                $week = $_POST['week'];

                if ($milestone->jsonArray_value[$year][$month][$week]['value'] == '') {
                    throw new Exception('Cant realized if value is not set');
                }
                $milestone->jsonArray_value[$year][$month][$week]['realized'] = $content;
                if ($milestone->save()) {
                    $status = 'success';
                    $msg = 'Saved!';
                }
            } catch (Exception $e) {
                $status = 'fail';
                $msg = 'Error: '.$e->getMessage();
            }
        }

        $this->layout = false;
        header('Content-type: application/json');
        echo $this->renderJSON(array('status' => $status, 'data' => $result, 'msg' => $msg, 'meta' => $meta));
        Yii::app()->end();
    }

    public function actionUpdateMilestoneViewMode($id)
    {
        $msg = '';
        $status = '';
        $result = '';
        $meta = array();

        // set meta
        $meta['id'] = $id;
        $meta['viewMode'] = $_POST['viewMode'];

        $milestone = Milestone::model()->findByPk($id);

        // public cant access
        if (Yii::app()->user->isGuest || (!Yii::app()->user->accessCpanel && !Yii::app()->user->accessBackend)) {
            $status = 'fail';
            $msg = 'Unable to update milestone. You have no access to this milestone.';
        }
        // user can access backend
        elseif (Yii::app()->user->accessBackend) {
        }
        // user can access cpanel and is not owner of the startup
        /*elseif(Yii::app()->user->accessCpanel && $milestone->username != Yii::app()->user->username)
        {
            $status = 'fail';
            $msg = "Unable to update monthly target. You have no access to this startup.";
        }*/ else {
            $status = 'fail';
            $msg = 'Invalid Access';
        }

        if ($status != 'fail') {
            try {
                $milestone->viewMode = $meta['viewMode'];
                if ($milestone->save()) {
                    $status = 'success';
                    $msg = 'Saved!';
                }
            } catch (Exception $e) {
                $status = 'fail';
                $msg = 'Error: '.$e->getMessage();
            }
        }

        $this->layout = false;
        header('Content-type: application/json');
        echo $this->renderJSON(array('status' => $status, 'data' => $result, 'msg' => $msg, 'meta' => $meta));
        Yii::app()->end();
    }
}

<?php

use function GuzzleHttp\json_decode;

class HubForm
{

    public static function getOrCreateIntake($title, $params = array())
    {
        try {
            $intake = self::getIntakeByTitle($title);
        } catch (Exception $e) {
            $intake = self::createIntake($title, $params);
        }

        return $intake;
    }

    public static function getOrCreateIntakeForm($intakeId, $formTitle, $params = array())
    {
        $return = null;
        $intake = Intake::model()->findByPk($intakeId);
        if (!empty($intake->forms)) {
            foreach ($intake->forms as $form) {
                if ($form->title == $formTitle) {
                    $return = $form;
                    break;
                }
            }
        }

        if (empty($return)) {
            $return = new Form();
        }

        return $return;
    }

    public static function getOrCreateForm2Intake($intakeId, $formId)
    {
        $form2Intake = Form2Intake::model()->findByAttributes(array('intake_id' => $intakeId, 'form_id' => $formId));
        if (empty($form2Intake)) {
            $return = new Form2Intake();
            $return->intake_id = $intakeId;
            $return->form_id = $formId;
            $return->is_active = 1;
            $return->save();
        } else {
            $return = $form2Intake;
        }

        return $return;
    }

    public static function getIntakeByTitle($title)
    {
        $model = Intake::model()->title2obj($title);
        if ($model === null) {
            throw new CHttpException(404, 'The requested intake does not exist.');
        }

        return $model;
    }

    public static function createIntake($title, $params = array())
    {
        $intake = new Intake();
        $intake->title = $title;
        $intake->save();

        return $intake;
    }

    public static function convertJsonToHtml($isEnabled, $json, $data, $slug, $sid, $eid = '')
    {
        $htmlBody = '';
        $decoded = json_decode($json, true);
        $decodedData = empty($data) ? null : json_decode($data, true);
        $formType = strtolower($decoded['form_type']);
        $jScripts = $decoded['jscripts'];
        unset($decoded['form_type']);
        unset($decoded['form_type']);
        unset($decoded['builder']);

        $jsTags = '';
        if (!empty($jScripts)) {
            $jsTags = self::getJavaScripts($jScripts);
        }

        foreach ($decoded as $item) {
            $key = $item['tag'];
            $value = $item['prop'];

            $members = null;
            if ($key === 'section') {
                $members = $item['members'];
            }

            $innerElements = null;
            if ($key === 'group') {
                $innerElements = $item['members'];
            }

            $htmlBody .= self::getHtmlTag($isEnabled, $key, $formType, $value, $members, $innerElements, $decodedData);
        }

        $csrfTokenName = Yii::app()->request->csrfTokenName;
        $csrfToken = Yii::app()->request->csrfToken;
        // $session = Yii::app()->session;
        // $session[$csrfTotkenName] = $csrfToken;
        if (empty($eid)) {
            $actionURL = $isEnabled ? "/f7/publish/save/$slug/$sid" : '';
        } elseif (!empty($eid) && empty($sid)) {
            $actionURL = $isEnabled ? "/f7/publish/save/$slug/?eid=$eid" : '';
        } elseif (!empty($eid) && !empty($sid)) {
            $actionURL = $isEnabled ? "/f7/publish/save/$slug/?sid=$sid&eid=$eid" : '';
        }

        if ($formType === 'horizontal') {
            $htmlForm = sprintf('
            <div style="font-size:0">
            <span id="auto-save-span" style="color:gray">Form saved...</span>
            </div>

            <div class="alert alert-error" id="alert-autosave">
                <span>
                    Form saved...
                </span>
            </div>
            <form id="f7-form" class="form-horizontal" action="%s" method="%s" enctype="multipart/form-data">
                <input type="hidden" name="%s" value="%s" />
                %s
                <br />
                <input class=" btn btn-primary" type="submit" name="yt1" value="Submit">
            </form>
              %s
            ', $actionUrl, 'POST', $csrfTokenName, $csrfToken, $htmlBody, $jsTags);
        } else {
            $htmlForm = sprintf('

            <span id="auto-save-span" style="color:gray">Form saved...</span>

            <form id="f7-form" action="%s" method="%s" enctype="multipart/form-data">
                <input type="hidden" name="%s" value="%s" />
                %s
            </form>
            <style>    
            input[type=checkbox] { 
                display:none;
            }
            
            input[type=checkbox] + label:before {
                font-family: FontAwesome;
                display: inline-block;
                content: "\f096";
                letter-spacing: 10px;
                cursor: pointer;
            }
            
            input[type=checkbox]:checked + label:before { 
                content: "\f046";
            } 
            
            input[type=checkbox]:checked + label:before { 
                letter-spacing: 8px;
            }
            
            input[type=radio] + label,
            input[type=checkbox]+ label { 
                display: block;
                padding-left: 1.5em;
                text-indent: -.8em;
            }
            </style>
              %s
                ', $actionURL, 'POST', $csrfTokenName, $csrfToken, $htmlBody, $jsTags);
        }

        // replace predefined variable
        if (!empty($eid)) {
            $event = HUB::getEvent($eid);
            $htmlForm = str_replace('%EventTitle%', $event->title, $htmlForm);
            $htmlForm = str_replace('%EventID%', $event->id, $htmlForm);
        }

        if (!Yii::app()->user->isGuest) {
            $htmlForm = str_replace('%UserEmail%', Yii::app()->user->username, $htmlForm);
        } else {
            $htmlForm = str_replace('%UserEmail%', '', $htmlForm);
        }

        return $htmlForm;
    }

    protected function getHtmlTag($isEnabled = true, $key, $formType, $value, $members, $innerElements, $decodedData)
    {
        $htmlTag = null;
        switch ($key) {
            case 'section':
                $htmlTag = self::getSectionTag($isEnabled, $formType, $value, $members, $innerElements, $decodedData);
                break;
            case 'group':
                $htmlTag = self::getGroupTag($isEnabled, $formType, $value, $members, $innerElements, $decodedData);
                break;
            case 'label':
                $htmlTag = self::getLabelTag($formType, $value);
                break;
            case 'headline':
                $htmlTag = self::getHeadlineTag($value);
                break;
            case 'break':
                $htmlTag = self::getBreakTag($value);
                break;
            case 'divider':
                $htmlTag = self::getDividerTag($value);
                break;
            case 'button':
                $htmlTag = self::getButtonTag($isEnabled, $value);
                break;

            case 'googleplace':
                $htmlTag = self::getGooglePlaceTag($isEnabled, $value, $decodedData);
                break;
            case 'url':
                $htmlTag = self::getUrlTag($isEnabled, $value, $decodedData);
                break;
            case 'email':
                $htmlTag = self::getEmailTag($isEnabled, $value, $decodedData);
                break;
            case 'phone':
                $htmlTag = self::getPhoneTag($isEnabled, $value, $decodedData);
                break;
            case 'textbox':
                $htmlTag = self::getTextboxTag($isEnabled, $value, $decodedData);
                break;
            case 'number':
                $htmlTag = self::getNumberTag($isEnabled, $value, $decodedData);
                break;
            case 'textarea':
                $htmlTag = self::getTextareaTag($isEnabled, $value, $decodedData);
                break;
            case 'list':
                $htmlTag = self::getListTag($isEnabled, $value, $decodedData);
                break;
            case 'checkbox':
                $htmlTag = self::getCheckboxTag($isEnabled, $value, $decodedData);
                break;
            case 'radio':
                $htmlTag = self::getRadiobuttonTag($isEnabled, $value, $decodedData);
                break;
            case preg_match('/upload.*/', $key) ? true : false:
                $htmlTag = self::getUploadTag($isEnabled, $value, $decodedData);
                break;
            case 'rating':
                $htmlTag = self::getRatingTag($isEnabled, $value, $decodedData);
                break;
            default:
                throw new Exception('Item is not supported');
                break;
        }

        return $htmlTag;
    }

    protected function getJavaScripts($jScripts)
    {
        $tags = self::getJsTags($jScripts);

        $jsTags = sprintf('
      <script>
      $( document ).ready(function() {
        %s
      }); 
      </script>
    ', $tags);

        return $jsTags;
    }

    protected function getJsTags($jsObjects)
    {
        $tags = '';

        foreach ($jsObjects as $jsObj) {
            $caller = $jsObj['caller'];
            $action = $jsObj['action'];
            $items = $jsObj['items'];
            $condition = $jsObj['condition'];

            switch (key($condition)) {
                case 'select':
                    $tags .= self::getJsTagForSelectCondition($caller, $condition['select'], $action, $items);
                    break;
                case 'check':
                    $tags .= self::getJsTagForCheckCondition($caller, $condition['check'], $action, $items);
                    break;
                default:
                    throw new Exception('condition is not supported.');
            }
        }

        return $tags;
    }

    //Most probably this is a dropdown list
    protected function getJsTagForSelectCondition($caller, $condition, $action, $items)
    {
        $content = '';
        $negate = '';
        foreach ($items as $item) {
            if ($action === 'disable') {
                $content .= sprintf('
                $( "#%s" ).attr(\'disabled\',\'disabled\');
                ', $item);
                $negate .= sprintf('
                $( "#%s" ).removeAttr(\'disabled\');
                ', $item);
            } elseif ($action === 'enable') {
                $content .= sprintf('
                $( "#%s" ).removeAttr(\'disabled\');
                ', $item);
                $negate .= sprintf('
                $( "#%s" ).attr(\'disabled\',\'disabled\');
                ', $item);
            } elseif ($action === 'hide') {
                $content .= sprintf('
                $( "#%s" ).hide();
                ', $item);
                $negate .= sprintf('
                $( "#%s" ).show();
                ', $item);
            } elseif ($action === 'show') {
                $content .= sprintf('
                $( "#%s" ).show();
                ', $item);
                $negate .= sprintf('
                $( "#%s" ).hide();
                ', $item);
            }
        }

        $tag = sprintf('
        %s
        $( "#%s" ).change(function() {
        if ($("#%s option:selected").text() == \'%s\')
        {
          %s
        }
        else
        {
          %s
        }
      });
    ', $negate, $caller, $caller, $condition, $content, $negate);

        return $tag;
    }

    //Most probably this event is for a radio/checkbox
    protected function getJsTagForCheckCondition($caller, $condition, $action, $items)
    {
        $content = '';
        $negate = '';
        foreach ($items as $item) {
            if ($action === 'disable') {
                $content .= sprintf('
                $( "#%s" ).attr(\'disabled\',\'disabled\');
                ', $item);
                $negate .= sprintf('
                $( "#%s" ).removeAttr(\'disabled\');
                ', $item);
            } elseif ($action === 'enable') {
                $content .= sprintf('
                $( "#%s" ).removeAttr(\'disabled\');
                ', $item);
                $negate .= sprintf('
                $( "#%s" ).attr(\'disabled\',\'disabled\');
                ', $item);
            } elseif ($action === 'hide') {
                $content .= sprintf('
                $( "label[for=\'inputtext-%s\']" ).closest("div.form-group").hide();
                ', $item);
                $negate .= sprintf('
                $( "label[for=\'inputtext-%s\']" ).closest("div.form-group").show();
                ', $item);
            } elseif ($action === 'show') {
                $content .= sprintf('
                $( "label[for=\'inputtext-%s\']" ).closest("div.form-group").show();
                ', $item);
                $negate .= sprintf('
                $( "label[for=\'inputtext-%s\']" ).closest("div.form-group").hide();
                ', $item);
            }
        }
        $tag = '';
        // if ($condition === "No")
        // {

        $tag = sprintf('
          
            %s
          $( "input:radio[name=\"%s\"]" ).change(function() {
            var checked = $("input:radio[name=\"%s\"]:checked").val();
            
            if(checked == "%s") 
            {
              %s
            }
            else
            {
              %s
            }
          });
      ', $negate, $caller, $caller, $condition, $content, $negate);

        return $tag;
    }

    protected function getGroupTag($isEnabled, $formType, $params, $members, $innerElements, $decodedData)
    {
        $innerHtml = '';
        foreach ($innerElements as $element) {
            $key = $element['tag'];
            $value = $element['prop'];
            if ($key === 'group') {
                throw new Exception('We dont support multiple level of groupping!');
            }

            $innerHtml .= self::getHtmlTag($isEnabled, $key, $formType, $value, $members, $innerElements, $decodedData);
        }

        $html = sprintf('<div class="form-group margin-bottom-lg %s">%s</div>', $params['css'], $innerHtml);

        return $html;
    }

    protected function getGooglePlaceTag($isEnabled, $params, $decodedData)
    {
        $value = empty($decodedData[$params['name']]) ? '' : $decodedData[$params['name']];

        $disable = $isEnabled ? '' : 'disabled';

        $html = sprintf('
            <input %s id="%s" name="%s" value="%s" style="%s" class="form-control googleplace %s" placeholder="%s"
               onFocus="geolocate()" type="text">
            </input>
            <input id="googleplace_address_%s" name="googleplace_address_%s" type="hidden" value="">
            <input id="googleplace_latlng_%s" name="googleplace_latlng_%s" type="hidden" value="">
            <input id="googleplace_place_id_%s" name="googleplace_place_id_%s" type="hidden" value="">
      ', $disable, $params['name'], $params['name'], $value, $params['style'], $params['css'], $params['text'], $params['name'], $params['name'], $params['name'], $params['name'], $params['name'], $params['name']);

        return $html;
    }

    protected function getLabelTag($formType, $params)
    {
        if ($formType === 'horizontal') {
            if ($params['required'] === 1) {
                $html = sprintf('<label style="%s" class="form-label control-label %s" for="%s">%s <font color="red">*</font></label>', $params['style'], $params['css'], $params['for'], $params['value']);
            } else {
                $html = sprintf('<label style="%s" class="form-label control-label %s" for="%s">%s</label>', $params['style'], $params['css'], $params['for'], $params['value']);
            }
        } else {
            if (empty($params['css'])) {
                if ($params['required'] === 1) {
                    $html = sprintf('<label style="%s" class="form-label" for="%s">%s <font color="red">*</font></label>', $params['style'], $params['for'], $params['value']);
                } else {
                    $html = sprintf('<label style="%s" class="form-label" for="%s">%s</label>', $params['style'], $params['for'], $params['value']);
                }
            } elseif ($params['required'] === 1) {
                $html = sprintf('<label style="%s" class="form-label %s" for="%s">%s <font color="red">*</font></label>', $params['style'], $params['css'], $params['for'], $params['value']);
            } else {
                $html = sprintf('<label style="%s" class="form-label %s" for="%s">%s</label>', $params['style'], $params['css'], $params['for'], $params['value']);
            }
        }

        return $html;
    }

    protected function getHeadlineTag($params)
    {
        if ($params['required'] === 1) {
            $html = sprintf('<h%s style="%s" class="form-header %s">%s <font color="red">*</font></h%s>', $params['size'], $params['style'], $params['css'], $params['text'], $params['size']);
        } else {
            $html = sprintf('<h%s style="%s" class="form-header %s">%s</h%s>', $params['size'], $params['style'], $params['css'], $params['text'], $params['size']);
        }

        return $html;
    }

    protected function getUrlTag($isEnabled, $params, $decodedData)
    {
        $value = empty($decodedData[$params['name']]) ? $params['value'] : $decodedData[$params['name']];

        $disable = $isEnabled ? '' : 'disabled';

        $html = sprintf('<div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-link"></i>
            </div>
            <input %s type="url" style="%s" class="form-control %s" value="%s" id="%s" name="%s" %s placeholder="%s" />
        </div>', $disable, $params['style'], $params['css'], $value, $params['name'], $params['name'], !empty($params['pattern']) ? sprintf('pattern="%s"', $params['pattern']) : '', $params['text']);

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getEmailTag($isEnabled, $params, $decodedData)
    {
        $value = empty($decodedData[$params['name']]) ? $params['value'] : $decodedData[$params['name']];

        $disable = $isEnabled ? '' : 'disabled';

        $html = sprintf('<div class="input-group">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-envelope"></span>
            </div>
            <input %s type="email" style="%s" class="form-control %s" value="%s" id="%s" name="%s">
        </div>', $disable, $params['style'], $params['css'], $value, $params['name'], $params['name']);

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getPhoneTag($isEnabled, $params, $decodedData)
    {
        $value = empty($decodedData[$params['name']]) ? $params['value'] : $decodedData[$params['name']];

        $disable = $isEnabled ? '' : 'disabled';

        $html = sprintf('<div class="input-group">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-phone"></span>
            </div>
            <input %s type="tel" style="%s" class="form-control %s" value="%s" id="%s" name="%s">
        </div>
        ', $disable, $params['style'], $params['css'], $value, $params['name'], $params['name']);

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getBreakTag($params, $decodedData = '')
    {
        $html = sprintf('<br />');

        return $html;
    }

    protected function getDividerTag($params, $decodedData = '')
    {
        $html = sprintf('<hr style="%s" class="%s" />', $params['css'], $params['class']);

        return $html;
    }

    protected function getButtonTag($isEnabled, $params)
    {
        if (!$isEnabled) {
            return '';
        }

        $disable = $isEnabled ? '' : 'disabled';

        foreach ($params['items'] as $btn) {
            if ($btn['value'] === 'Draft') {
                $btns .= sprintf('<button %s id="submit" name="%s" value="%s" style="%s" class="button-draft btn %s">%s</button>&nbsp;', $disable, $btn['name'], $btn['value'], $btn['style'], $btn['css'], !empty($btn['text']) ? $btn['text'] : $btn['value']);
            } else {
                $btns .= sprintf('<button %s id="submit" name="%s" value="%s" style="%s" class="button-submit btn %s">%s</button>&nbsp;', $disable, $btn['name'], $btn['value'], $btn['style'], $btn['css'], !empty($btn['text']) ? $btn['text'] : $btn['value']);
            }
        }

        $html = sprintf('
            <div class="row %s">
                <div class="col-sm-12 %s">
                  %s
                </div>
            </div>
            ', $params['css1'], $params['css2'], $btns);

        return $html;
    }

    protected function getTextboxTag($isEnabled, $params, $decodedData, $linkText = '')
    {
        $disable = $isEnabled ? '' : 'disabled';

        $modelClass = $params['model_mapping'][$params['name']];

        $mappedModelValue = self::getMappedModelData($modelClass);

        $value = empty($mappedModelValue) ? empty($decodedData[$params['name']]) ?
        $params['value'] : $decodedData[$params['name']] : $mappedModelValue;
        $html = '';

        $html .= sprintf('<input %s type="text" style="%s" class="form-control %s" value="%s" name="%s" id="%s">', $disable, $params['style'], $params['css'], $value, $params['name'], $params['name']);

        if (!empty($linkText)) {
            $modalID = sprintf('%s-Modal', $modelClass);
            $html .= sprintf('
            <a href="" data-toggle="modal" data-target="#%s">%s</a><div id="startup-alert" style="color:red;display:none;">This name is taken. Choose another name.</div>
            <!-- Modal -->
            <div class="modal fade" id="%s" role="dialog">
                <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Organization</h4>
                    </div>
                    <div class="modal-body">
                        <div id="org-form-modal">
                        <div id="org-alert-modal" style="display:none" class="alert alert-danger">
                            <strong>Error!</strong> Organization name already exists. Please choose a different name.

                        </div>
                        <div class="form-group margin-bottom">
                                <label for="form-label org-name-modal">Organization Name</label>
                                <input type="text" class="form-control" id="org-name-modal" name="org-name-modal" placeholder="Enter organization name">
                        </div>
                        <div class="form-group margin-bottom">
                                <label for="form-label org-url-modal">Website</label>
                                <input type="text" class="form-control" id="org-url-modal" name="org-url-modal" placeholder="Enter website">
                        </div>
                        <div class="form-group margin-bottom">
                                <label for="form-label org-oneliner-modal">Oneliner</label>
                                <input type="text" class="form-control" id="org-oneliner-modal" name="org-oneliner-modal" placeholder="Enter oneliner">
                        </div>
                            <button name="org-button-modal" id="org-button-modal" class="btn btn-default btn-success btn-block">Create</button>
                        </div>
                    </div>
                </div>

                </div>
            </div>
            ', $modalID, $linkText, $modalID);
        }

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getNumberTag($isEnabled, $params, $decodedData, $linkText = '')
    {
        $disable = $isEnabled ? '' : 'disabled';

        $modelClass = $params['model_mapping'][$params['name']];

        $mappedModelValue = self::getMappedModelData($modelClass);

        $value = empty($mappedModelValue) ? empty($decodedData[$params['name']]) ?
        $params['value'] : $decodedData[$params['name']] : $mappedModelValue;
        $html = '';

        $html .= sprintf('<input %s type="number" style="%s" class="form-control %s" value="%s" name="%s" id="%s">', $disable, $params['style'], $params['css'], $value, $params['name'], $params['name']);

        if (!empty($linkText)) {
            $modalID = sprintf('%s-Modal', $modelClass);
            $html .= sprintf('
            <a href="" data-toggle="modal" data-target="#%s">%s</a><div id="startup-alert" style="color:red;display:none;">This name is taken. Choose another name.</div>
            <!-- Modal -->
            <div class="modal fade" id="%s" role="dialog">
                <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Organization</h4>
                    </div>
                    <div class="modal-body">
                        <div id="org-form-modal">
                        <div id="org-alert-modal" style="display:none" class="alert alert-danger">
                            <strong>Error!</strong> Organization name already exists. Please choose a different name.

                        </div>
                        <div class="form-group margin-bottom">
                                <label for="form-label org-name-modal">Company Name</label>
                                <input type="text" class="form-control" id="org-name-modal" name="org-name-modal" placeholder="Enter Company name">
                        </div>
                        <div class="form-group margin-bottom">
                                <label for="form-label org-url-modal">Website</label>
                                <input type="text" class="form-control" id="org-url-modal" name="org-url-modal" placeholder="Enter website">
                        </div>
                        <div class="form-group margin-bottom">
                                <label for="form-label org-oneliner-modal">Oneliner</label>
                                <input type="text" class="form-control" id="org-oneliner-modal" name="org-oneliner-modal" placeholder="Enter oneliner">
                        </div>
                            <button name="org-button-modal" id="org-button-modal" class="btn btn-default btn-success btn-block">Create</button>
                        </div>
                    </div>
                </div>

                </div>
            </div>
            ', $modalID, $linkText, $modalID);
        }

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getOrganizationModalForm($isEnabled, $modelClass, $linkText = 'Create')
    {
        if (!$isEnabled) {
            return '';
        }

        $modelId = sprintf('%s-Modal', $modelClass);
        $html = Yii::app()->controller->renderPartial('application.modules.f7.views.hubForm._getOrganizationModalForm', array('modelId' => $modelId, 'linkText' => $linkText), true);

        return $html;
    }

    protected function getTextareaTag($isEnabled, $params, $decodedData)
    {
        $disable = $isEnabled ? '' : 'disabled';

        $value = empty($decodedData[$params['name']]) ? $params['value'] : $decodedData[$params['name']];
        $html = '';

        $html .= sprintf('<textarea %s rows="5" style="%s" class="form-control %s" rows="5"  name="%s" id="%s">%s</textarea>', $disable, $params['style'], $params['css'], $params['name'], $params['name'], $value);

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getListTag($isEnabled, $params, $decodedData)
    {
        $dataClass = $params['model_mapping'][$params['name']];

        $orgs = self::getMappedModelData($dataClass, $params['model_mapping']);

        $disable = $isEnabled ? '' : 'disabled';

        if ((empty($orgs) || count($orgs) === 0) && strtolower($dataClass) === 'organization') {
            return self::getTextboxTag($isEnabled, $params, $decodedData, 'Create');
        }

        $selectedItem = empty($decodedData[$params['name']]) ? $params['selected'] : $decodedData[$params['name']];

        $defaultItem = sprintf('<option value="">%s</option>', $params['text']);

        $options .= $defaultItem;

        if (empty($orgs) || count($orgs) === 0) {
            foreach ($params['items'] as $item) {
                if ($selectedItem === $item['text']) {
                    $options .= sprintf('<option value="%s" selected>%s</option>', $item['text'], $item['text']);
                } else {
                    $options .= sprintf('<option value="%s">%s</option>', $item['text'], $item['text']);
                }
            }
        } else {
            foreach ($orgs as $item) {
                $item = ucwords(strtolower($item));
                if ($selectedItem === $item) {
                    $options .= sprintf('<option value="%s" selected>%s</option>', $item, $item);
                } else {
                    $options .= sprintf('<option value="%s">%s</option>', $item, $item);
                }
            }
        }
        $html = sprintf('<div><select %s data-class="%s" style="%s" class="form-control %s" text="%s" name="%s" id="%s">%s</select></div>', $disable, strtolower($dataClass), $params['style'], $params['css'], $params['text'], $params['name'], $params['name'], $options);

        if (strtolower($dataClass) === 'organization') {
            $html .= self::getOrganizationModalForm($isEnabled, $dataClass, 'or, Create a new one here');
        }

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    protected function getCheckboxTag($isEnabled, $params, $decodedData)
    {
        $disable = $isEnabled ? '' : 'disabled';

        $checked = 1;
        if (!empty($decodedData[$params['name']])) {
            $checked = 1;
        } else {
            if ($params['checked'] == 0) {
                $checked = 0;
            }
        }

        if ($params['checked'] == 1) {
            $checked = 1;
        }

        if ($params['isgroup'] == 0) {
            if (empty($checked)) {
                $html = sprintf('
                <div class="form-check">
                <input %s type="checkbox" style="%s" class=" %s" type="checkbox" value="%s" name="%s" id="%s">
                <label class="form-check-label" for="%s">
                %s
                </label>
                </div>',
                $disable, $params['style'], $params['css'], $params['value'], $params['name'], $params['name'], $params['name'], $params['text']);
            } else {
                $html = sprintf('
                    <div class="form-check">
                    <input %s type="checkbox" style="%s" class="selectives form-check-input %s" type="checkbox" value="%s" checked="%s" name="%s" id="%s">
                    <label class="form-check-label" for="%s">
                    %s
                    </label>
                    </div>',
                    $disable, $params['style'], $params['css'], $params['value'], $checked, $params['name'], $params['name'], $params['name'], $params['text']);
            }
        } elseif ($params['isgroup'] == 1) {
            $n = 0;
            $checkboxes = '';
            foreach ($params['items'] as $chkbox) {
                if ($chkbox['checked'] == 1) {
                    $checkboxes = $checkboxes.'<input class="selectives" type="checkbox"  checked="1" name="option[]" value="'.$chkbox['text'].'-'.$n.'"/>'.$chkbox['text'].'<br>';
                } else {
                    $checkboxes = $checkboxes.'<input class="selectives" type="checkbox"  name="option[]" value="'.$chkbox['text'].'-'.$n.'"/>'.$chkbox['text'].'<br>';
                }

                ++$n;
            }

            $required = $params['required'] === 1 ? "<label><font color='red'>*</font></label>" : '';

            $html = sprintf('
            %s
            <div class="form-group options">
                <label class="">%s</label>
                <div class="">
                    %s
                </div>
            </div>', $required, $params['value'], $checkboxes);
        } else {
            //structure is wrong or missing isgroup property.
        }

        return $html;
    }

    protected function getRadiobuttonTag($isEnabled, $params, $decodedData)
    {
        $radioHTML = '';

        $disable = $isEnabled ? '' : 'disabled';

        foreach ($params['items'] as $value) {
            $isItemChecked = $decodedData[$params['name']] === $value['text'] ? true : false;

            if ($value['checked'] === 1 || $isItemChecked) {
                $radioHTML .= sprintf('
                    <div class="radio">
                    <input %s name="%s" type="radio" id="%s" value="%s" checked>
                    <label for="form-label %s">%s</label>
                    </div>', $disable, $params['name'], $params['name'], $value['text'], $params['name'], $value['text']);
            } else {
                $radioHTML .= sprintf('
                    <div class="radio">
                    <input %s name="%s" type="radio" id="%s" value="%s">
                    <label for="form-label %s">%s</label>
                    </div>', $disable, $params['name'], $params['name'], $value['text'], $params['name'], $value['text']);
            }
        }
        $isItemChecked = $decodedData[$params['name']] === 'other' ? true : false;

        if ($params['other'] === 1) {
            if ($isItemChecked) {
                $radioHTML .= sprintf('
                <div class="radio">
                <input %s name="%s" type="radio" checked="1" id="other-%s" value="%s">
                <label for="form-label %s">%s</label>
                </div>
                <input %s name="other-%s" id="other-%s" value="%s" maxlength="40" size="40">', $disable, $params['name'], $params['name'], 'other', $params['name'], 'other', $disable, $params['name'], $params['name'], $decodedData['other-'.$param['name']]);
            } else {
                $radioHTML .= sprintf('
                <div class="radio">
                <input %s name="%s" type="radio" id="other-%s" value="%s">
                <label for="form-label %s">%s</label>
                </div>
                <input %s name="other-%s" id="other-%s" value="%s" maxlength="40" size="40">', $disable, $params['name'], $params['name'], 'other', $params['name'], 'other', $disable, $params['name'], $params['name'], $decodedData['other-'.$param['name']]);
            }
        }

        $html = $radioHTML;

        return $html;
    }

    protected function getSectionTag($isEnabled, $formType, $params, $members, $innerElements, $decodedData)
    {
        if ($params['mode'] == 'accordion') {
            $html = sprintf('<div class="panel-group margin-bottom-lg %s" id="%s" role="tablist" aria-multiselectable="true" style="%s">', $params['class'], $params['name'], $params['style']);

            $html .= sprintf('<div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="panelHeading-%s">', $params['name']);

            $html .= sprintf('<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#%s" href="#panelCollapse-%s" aria-expanded="true" aria-controls="panelCollapse-%s">%s</a></h4></div>', $params['name'], $params['name'], $params['name'], $params['text']);

            $html .= sprintf('<div id="panelCollapse-%s" class="panel-collapse collapse %s" role="tabpanel" aria-labelledby="panelCollapse-%s">', $params['name'], $params['accordionOpen'], $params['name']);

            $html .= '<div class="panel-body">';
        } else {
            $html = sprintf('<section id="%s" class="%s" style="%s">', $params['name'], $params['class'], $params['style']);
        }

        $htmlBody = '';
        $seen = 0;
        $label = '';
        foreach ($members as $element) {
            $key = $element['tag'];
            $value = $element['prop'];
            $members = null;
            if ($key === 'section') {
                $members = $element['members'];
            }

            $htmlBody .= self::getHtmlTag($isEnabled, $key, $formType, $value, $members, $innerElements, $decodedData);
        }

        $html .= $htmlBody;

        if ($params['mode'] == 'accordion') {
            $html .= '</div></div></div></div>';
        } else {
            $html .= '</section>';
        }

        return $html;
    }

    protected function getUploadTag($isEnabled, $params, $decodedData)
    {
        if (is_null($params)) {
            return;
        }
        $disable = $isEnabled ? '' : 'disabled';

        //'uploadfile.aws_path'
        $awsPath = $params['name'].'.aws_path';
        $value = empty($decodedData[$awsPath]) ? '' : $decodedData[$awsPath];
        $relativeUrl = $value;

        $session = Yii::app()->session;

        if (empty($value) && !empty($session['uploadfiles'][$awsPath])) {
            $value = $session['uploadfiles'][$awsPath];
        }

        if (!empty($value)) {
            $value = join('_', array_slice(explode('_', basename($value)), 1));
        }

        $html = '<div class="form-group">';
        $html .= sprintf('<input %s type="file" name="%s" id="%s" style="%s" class="form-control %s">', $disable, $params['name'], $params['name'], $params['style'], $params['css']);

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        $html .= empty($value) ? '' : sprintf('<div><p>Attached File:</p><ul><li>
    %s</li></ul></div>', CHtml::link(CHtml::encode($value), array('publish/download/'.basename($relativeUrl)), array('target' => '_blank')));
        $html .= '</div>';

        return $html;
    }

    public function getRatingTag($isEnabled, $params, $decodedData)
    {
        $disable = $isEnabled ? '' : 'disabled';
        $seed = explode('-', $params['name'])[1];
        $value = empty($decodedData[$params['name']]) ? $params['value'] : $decodedData[$params['name']];
        $html = '';

        $cells = '';
        if (empty($value)) {
            $cells = sprintf('
            <div id="1-%s" class="rating col-xs-2">1</div>
            <div id="2-%s" class="rating col-xs-2">2</div>
            <div id="3-%s" class="rating col-xs-2">3</div>
            <div id="4-%s" class="rating col-xs-2">4</div>
            <div id="5-%s" style="border-right-width:1.5px;" class="rating col-xs-2">5</div>', $seed, $seed, $seed, $seed, $seed);
        } else {
            if ($value === '1') {
                $cells = sprintf('
                <div id="1-%s" style="background-color:black;color:white" class="rating col-xs-2">1</div>
                <div id="2-%s" class="rating col-xs-2">2</div>
                <div id="3-%s" class="rating col-xs-2">3</div>
                <div id="4-%s" class="rating col-xs-2">4</div>
                <div id="5-%s" style="border-right-width:1.5px;" class="rating col-xs-2">5</div>', $seed, $seed, $seed, $seed, $seed);
            } elseif ($value === '2') {
                $cells = sprintf('
                <div id="1-%s" class="rating col-xs-2">1</div>
                <div id="2-%s" style="background-color:black;color:white" class="rating col-xs-2">2</div>
                <div id="3-%s" class="rating col-xs-2">3</div>
                <div id="4-%s" class="rating col-xs-2">4</div>
                <div id="5-%s" style="border-right-width:1.5px;" class="rating  col-xs-2">5</div>', $seed, $seed, $seed, $seed, $seed);
            } elseif ($value === '3') {
                $cells = sprintf('
                <div id="1-%s" class="rating col-xs-2">1</div>
                <div id="2-%s" class="rating col-xs-2">2</div>
                <div id="3-%s" style="background-color:black;color:white" class="rating col-xs-2">3</div>
                <div id="4-%s" class="rating col-xs-2">4</div>
                <div id="5-%s" style="border-right-width:1.5px;" class="rating  col-xs-2">5</div>', $seed, $seed, $seed, $seed, $seed);
            } elseif ($value === '4') {
                $cells = sprintf('
                <div id="1-%s" class="rating col-xs-2">1</div>
                <div id="2-%s" class="rating col-xs-2">2</div>
                <div id="3-%s" class="rating col-xs-2">3</div>
                <div id="4-%s" style="background-color:black;color:white" class="rating col-xs-2">4</div>
                <div id="5-%s" style="border-right-width:1.5px;" class="rating  col-xs-2">5</div>', $seed, $seed, $seed, $seed, $seed);
            } elseif ($value === '5') {
                $cells = sprintf('
                <div id="1-%s" class="rating col-xs-2">1</div>
                <div id="2-%s" class="rating col-xs-2">2</div>
                <div id="3-%s" class="rating col-xs-2">3</div>
                <div id="4-%s" class="rating col-xs-2">4</div>
                <div id="5-%s" style="background-color:black;color:white; border-right-width:1.5px;" class="rating col-xs-2">5</div>', $seed, $seed, $seed, $seed, $seed);
            }
        }
        $html .= sprintf('
        <div class="container margin-top-md" style="max-width:600px; margin:0">
            <div class="row"><div id="rating-%s">%s</div></div>
            <div class="row">
                <div class="rating-label nopadding col-xs-6"><small>&larr;Strongly Disagree</small></div>
                <div class="rating-label col-xs-4 nopadding" style="text-align:right;"><small>Strongly Agree&rarr;</small></div>
            </div>
            <input type="hidden" id="voted-%s" name="voted-%s" value="%s">
        </div>
        
        <script>
        $(\'#rating-%s\').click(function(e) {
            var num = $(\'#\' + e.target.id).text();
            if( num == "1" || num == "2" || num == "3" || num == "4" || num == "5")
            {
                $(this).children("div").each(function (x,y) {
                    if (e.target.id != y.id)
                    {
                        $(\'#\' + y.id).css("background-color", "white");
                        $(\'#\' + y.id).css("color", "black");
                    }
                });
                
                
                    $(\'#voted-%s\').val(num);
                    $(\'#\' + e.target.id).css("background-color", "black");
                    $(\'#\' + e.target.id).css("color", "white");
            }
            });
        </script>', $seed, $cells, $seed, $seed, $value, $seed, $seed);

        if (!empty($params['hint'])) {
            $html .= sprintf('<span class="help-block"><small>%s</small></span>', $params['hint']);
        }

        return $html;
    }

    public function validateCustomForm($jsonForm, $postedData)
    {
        $errors = array();

        $formObject = json_decode($jsonForm, true);
        $jScripts = $formObject['jscripts'];

        foreach ($formObject as $value) {
            if ($value['tag'] === 'break' || $value['tag'] === 'divider' || $value['tag'] === 'label' || $vale['tag'] === 'YII_CSRF_TOKEN' || $vale['tag'] === 'button' || $vale['tag'] === 'label') {
                continue;
            }

            if ($value['tag'] === 'section') {
                $members = $value['members'];
                foreach ($members as $member) {
                    if (array_key_exists('required', $member['prop']) && $member['prop']['required'] === 1) {
                        $error = self::validate($member['tag'], $member['prop']['name'], $member['prop']['error'], $member['prop']['validation'], $postedData, $jScripts);

                        if (!empty($error)) {
                            $errors[] = $error;
                        }
                    }
                }
            } elseif ($value['tag'] === 'group') {
                $members = $value['members'];
                foreach ($members as $member) {
                    if ($member['tag'] === 'label') {
                        continue;
                    }

                    if (array_key_exists('required', $member['prop']) && $member['prop']['required'] === 1) {
                        $error = self::validate($member['tag'], $member['prop']['name'], $member['prop']['error'], $member['prop']['validation'], $postedData, $jScripts);

                        if (!empty($error)) {
                            $errors[] = $error;
                        }
                    }
                }
            } else {
                if (array_key_exists('required', $value['prop']) && $value['prop']['required'] === 1) {
                    $error = self::validate($value['tag'], $value['prop']['name'], $value['prop']['error'], $member['prop']['validation'], $postedData, $jScripts);

                    if (!empty($error)) {
                        $errors[] = $error;
                    }
                }
            }
        }

        return array(empty($errors), $errors);
    }

    //Either the text of error should be identified in json as error property
    //or we should specify here.
    // exiang: this is stupid, @mohammad should not break label and form element as different element. told him so but never listen. now is hard to get label
    protected function validate($element, $value, $error, $validation, $postedData, $jScripts)
    {
        // ys: upload required has bug when submit. temporary fix it by disable required check on it
        if ($element === 'label' || $element === 'headline' || $element === 'upload') {
            return;
        }

        if (self::isControlHiddenOrDisable($value, $postedData, $jScripts)) {
            return;
        }

        if ($element === 'radio') {
            if (empty($postedData[$value])) {
                return $error;
            }
        } elseif ($element === 'checkbox') {
            if (!array_key_exists('option', $postedData)) {
                return empty($error) ? 'At least one checkbox must be selected.' : $error;
            }
        } elseif ($element === 'email') {
            if (empty($postedData[$value])) {
                return $error;
            }

            if (empty(filter_var($postedData[$value], FILTER_VALIDATE_EMAIL))) {
                return 'Please provide a valid email.';
            }
        } elseif ($element === 'phone') {
            if (empty($postedData[$value])) {
                return $error;
            }

            if (!is_numeric($postedData[$value])) {
                return 'Contact/Phone number should only consist of digits.';
            }

            if (strlen($postedData[$value]) < 7) {
                return 'Please provide a valid Contact/Phone number (7-15 digits). ';
            }
        } elseif ($element === 'textbox' && !empty($validation)) {
            if (strtolower($validation) === 'url' && !filter_var($postedData[$value], FILTER_VALIDATE_URL)) {
                return "Please enter a valid URL for the field $value.";
            }
        } else {
            if (empty($postedData[$value])) {
                return empty($error) ? "$value is required." : $error;
            }
        }
    }

    protected function isControlHiddenOrDisable($value, $postedData, $jScripts)
    {
        foreach ($jScripts as $script) {
            if (in_array($value, $script['items']) && ($script['action'] === 'hide' || $script['action'] === 'disable')) {
                if (key($script['condition']) === 'check' && array_key_exists($script['caller'], $postedData)) {
                    return true;
                }

                if (key($script['condition']) === 'select' && $postedData[$script['caller']] === $script['condition']['select']) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function getMappedModelData($model, $mappingParams = '')
    {
        if (empty($model)) {
            return '';
        }
        $organizations = array();
        try {
            $organizations = HubOrganization::getUserActiveOrganizations(Yii::app()->user->username);
        } catch (Exception $e) {
        }

        if (strtolower($model) == 'organization') {
            return array_map(create_function('$o', 'return $o->title;'), $organizations);
        } elseif (strtolower($model) == 'industry') {
            $industries = array_map(create_function('$t', 'return $t[title];'), HubOrganization::getOrganizationIndustries());

            if (!$mappingParams['hideOthers']) {
                $industries[] = 'Other (Please State)';
            }

            return $industries;
        } elseif (strtolower($model) == 'sdg') {
            $sdgs = array_map(create_function('$t', 'return $t[title];'), Sdg::model()->isActive()->findAll());

            return $sdgs;
        } elseif (strtolower($model) == 'heard') {
            return array('Social Media', 'Word of Mouth', 'Printed Ads', 'Online Media Portal', 'MaGIC Newsletter', 'Events organized by MaGIC', 'Email / Newsletter by other organizations');
        } elseif (strtolower($model) == 'gender') {
            return array('Male', 'Female');
        } elseif (strtolower($model) == 'country') {
            $countries = Country::model()->findAll();

            return array_map(create_function('$t', 'return $t->printable_name;'), $countries);
        }
    }

    public static function getRandomCode()
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function storeFile($file, $uploadPath = '')
    {
        $uploadFolderName = 'forms';

        //$storeId = time();

        $saveFileName = basename($file);

        // if using s3 as storage
        if (Yii::app()->params['storageMode'] == 's3') {
            $mimeType = ysUtil::getMimeType($file);
            $pathInAWS = sprintf('uploads/%s/%s', $uploadFolderName, $saveFileName);
            $result = Yii::app()->s3->upload(
                $file,
                $pathInAWS,
                Yii::app()->params['s3Bucket'],
                array(),
                array('Content-Type' => $mimeType)
            );
            if ($result) {
                unlink($file);
            }
        }
        // if using local as storage
        else {
            //$modelFileFile->saveAs(sprintf($uploadPath.DIRECTORY_SEPARATOR.'%s', $saveFileName));
        }

        return $pathInAWS;
    }

    public static function updateJsonForm($jsonData, $elementName, $newValue, $newkey = '')
    {
        $updatedObj = array();
        $obj = json_decode($jsonData, true);
        $obj[$elementName] = $newValue;

        return json_encode($obj);
    }

    public static function getListOfUploadControls($formCode)
    {
        $result = Yii::app()->db->createCommand()
            ->select('json_structure')
            ->from('form')
            ->where('code=:code', array(':code' => $formCode))->queryRow();

        if (count($result) == 0) {
            return array();
        }

        $items = json_decode($result['json_structure'], true);

        $ret = array();

        foreach ($items as $item) {
            if ($item['tag'] === 'upload') {
                $ret[] = $item['prop']['name'];
            } elseif ($item['tag'] === 'group') {
                $members = $item['members'];
                foreach ($members as $member) {
                    if ($member['tag'] === 'upload') {
                        $ret[] = $member['prop']['name'];
                    }
                }
            }
        }

        return $ret;
    }

    public static function getListOfExistingUploadControlsWithValue($jsonData)
    {
        $ret = array();
        if (empty($jsonData)) {
            return $ret;
        }

        $dataObjArray = json_decode($jsonData, true);
        foreach ($dataObjArray as $key => $value) {
            if (preg_match('/uploadfile\..*/', $key)) {
                $ret[$key] = $value;
            }
        }

        return $ret;
    }

    public static function isForm2IntakeExists($formId, $intakeId)
    {
        $condition = 'form_id=:formId && intake_id=:intakeId ';
        $params = array(':formId' => $formId, ':intakeId' => $intakeId);

        return Form2Intake::model()->exists($condition, $params);
    }

    public static function canSubmit($formModel, $submissionId)
    {
        if ($formModel->is_multiple === 1) {
            return true;
        } elseif ($formModel->is_multiple === 0) {
            $allSubmissionsForThisForm = FormSubmission::model()->findAllByAttributes(array('form_code' => $formModel->code, 'user_id' => Yii::app()->user->id));

            if (count($allSubmissionsForThisForm) == 0) {
                return true;
            }

            if (empty($submissionId)) {
                return false;
            }
            //we dont accept new submission

            //Check if we are submitting/drafting the same form
            foreach ($allSubmissionsForThisForm as $submission) {
                if ($submission->id !== $submissionId) {
                    return false;
                }
            }

            return true;
        } else {
            throw new Exception('Form is not in a correct state.');
        }
    }

    public static function getFormSubmissions($user)
    {
        $condition = 'user_id=:userId';
        $params = array(':userId' => $user->id);

        return FormSubmission::model()->findAll($condition, $params);
    }

    public static function CanUserChooseThisOrgization($userEmail, $orgTitleSubmittedByUser)
    {
        if (empty($orgTitleSubmittedByUser)) {
            throw new Exception('Organization title cannot be empty.');
        }

        $org = Organization::title2obj($orgTitleSubmittedByUser);
        if (is_null($org)) {
            return true;
        }

        $orgToEmail = Organization2Email::model()->findByAttributes(
            array('organization_id' => $org->id, 'user_email' => $userEmail)
        );

        return !empty($orgToEmail);
    }

    public static function SyncSubmissionsToEvent($intake = '', $pipeline = '', $form = '', $importas = '')
    {
        if (empty('intake')) {
            // Commands will reach here
            $allIntakes = Intake::model()->findAll();

            foreach ($allIntakes as $intake) {
                self::SyncSingleIntakeToEvent($intake, $pipeline);
            }
        } else {
            // Web will hit this

            $intake = Intake::model()->findByAttributes(array('title' => $intake));

            self::SyncSingleIntakeToEvent($intake, $pipeline, $form, $importas);
        }
    }

    protected function SyncSingleIntakeToEvent($intake, $pipeline, $selectedForm = '', $importas = '')
    {
        if (is_null($intake)) {
            return;
        }

        $title = $intake->title;

        $forms = $intake->forms;

        $event = Event::model()->findByAttributes(array('title' => $title));

        EventOrganization::model()->deleteAllByAttributes(array('event_code' => $event->code));

        if (is_null($event)) { //Assuing the event is already created.
            return;
        }

        foreach ($forms as $form) {
            if ($selectedForm !== '' && strtolower($selectedForm) !== strtolower($form->slug)) {
                continue;
            }

            $submissions = $form->formSubmissions;

            foreach ($submissions as $submission) {
                if (strtolower($submission->stage) !== strtolower($pipeline)) {
                    continue;
                }

                self::AddOrUpdateSubmissionToEvent($event, $submission, $importas);
            }
        }
    }

    protected function AddOrUpdateSubmissionToEvent($event, $submission, $importas = '')
    {
        $json = $submission->json_data;

        $decoded = json_decode($json, true);

        $org = Organization::model()->findByAttributes(array('title' => $decoded['startup']));

        if (is_null($org)) {
            return;
        }
        if (empty($importas)) {
            $org->addEventOrganization($event->code, 'participant', array('eventVendorCode' => 'F7'));
        } else {
            $org->addEventOrganization($event->code, $importas, array('eventVendorCode' => 'F7'));
        }

        $org->save();
    }
}

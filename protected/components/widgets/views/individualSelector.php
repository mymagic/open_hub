<?php

$jsEmbedId = sprintf('%s-%s-individualSelector', $model, $attribute) ;
// dropDownList(string $name, string $select, array $data, array $htmlOptions=array())
echo Html::dropDownList($attribute, $selected, $data, $htmlOptions);
Yii::app()->clientScript->registerScript($jsEmbedId, '
$("#' . $attribute . '").select2({
    ajax: {
        url: "' . $urlAjax . '",
        delay: 250
    },
    templateResult: function(item){
        if (!item.id) {
            return item.text;
        }
        var $item = $(
            "<div class=\"media\"><div class=\"media-left\"><img src=\"" + item.imagePhotoThumbUrl + "\" height=\"50px\" /></div><div class=\"media-body\"><h4 class=\"media-heading\">" + item.text + "</h4></div></div>"
        );
        return $item;
    }
})');

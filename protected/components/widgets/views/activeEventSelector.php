<?php

$jsEmbedId = sprintf('%s-%s-eventSelector', $form->id, $attribute) ;
echo $form->bsDropDownList($model, $attribute, $data, $htmlOptions);
Yii::app()->clientScript->registerScript($jsEmbedId, '
$("#' . get_class($model) . '_' . $attribute . '").select2({
    ajax: {
        url: "' . $urlAjax . '",
        delay: 250
    },
    templateResult: function(item){
        if (!item.id) {
            return item.text;
        }
        var $item = $(
            "<div class=\"media\"><div class=\"media-left\"></div><div class=\"media-body\"><h4 class=\"media-heading\">" + item.text + "</h4>"+item.at+"<br /><small>"+item.dateStarted+" - "+item.dateEnded+"</small></div></div>"
        );
        return $item;
    }
})');

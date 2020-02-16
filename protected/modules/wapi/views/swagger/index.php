<div id="swagger-ui"></div>
 
<?php

foreach($apis as $apiKey=>$apiParams)
{
    $active = ($apiParams['code'] == $code && $apiParams['format'] == $format)?true:false;
	$this->menu[] = array('label'=>Yii::t('swagger', ucwords($apiParams['code'])), 'url'=>array('/wapi/swagger', 'code'=>$apiParams['code'], 'format'=>$apiParams['format'], 'module'=>$apiParams['module']), 'active'=>$active);
}
?>

<?php Yii::app()->clientScript->registerScript('wapi-swagger-index-0', sprintf("
	window.onload = function() {
    const ui = SwaggerUIBundle({
        url: '%s',
        dom_id: '#swagger-ui',
        presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
        ]
    })
    window.ui = ui
    }
", Yii::app()->createUrl('/wapi/swagger/getApiDef', array('code'=>$code, 'module'=>$module, 'format'=>$format)))); ?>

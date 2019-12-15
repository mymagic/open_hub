<?php

class HubSeolytic
{
    public static function getMatchingSeolytic($urlPath)
    {
        $seolytics = Seolytic::model()->findAll(array('condition' => 'is_active=1', 'order' => 'ordering ASC'));
        if (!empty($seolytics)) {
            foreach ($seolytics as $seolytic) {
                //echo sprintf('%s vs %s', $seolytic->path_pattern, $urlPath);exit;
                $matches = array();
                preg_match($seolytic->path_pattern, $urlPath, $matches);
                //print_r($matches);exit;
                if (!empty($matches)) {
                    return $seolytic;
                }
            }
        }

        return null;
    }
}

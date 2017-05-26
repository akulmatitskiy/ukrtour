<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Map;

/**
 * Site controller
 */
class MapController extends Controller {
    
    /**
     * Hotels markers
     * @return array json
     */
    public function actionMarks()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cache   = Yii::$app->cache;
        $lang = Yii::$app->language;
        
        // Get markers
        $marks = $cache->get('mapMarkers' . $lang);
        if($marks === false) {
            $marks = Map::markers();
            
            // Caching results 
            $cache->set('mapMarkers' . $lang, $marks, Map::MAP_CACHE_EXPIRATION);
        }

        return $marks;
    }
}

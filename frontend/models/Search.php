<?php

namespace frontend\models;

use Yii;
use common\models\Languages;

/**
 * This is the model class for Search.
 */
class Search extends \yii\base\Model {

    /**
     * Search results for current language
     * @param type $searchData
     * @return array $results The search results
     */
    public static function filterResults($searchData)
    {
        $results = [];
        $langId  = Languages::getCurrentLangId();

        if(!empty($searchData)) {
            foreach($searchData as $data) {

                // Push to array only current lang results
                if($data->langId == $langId) {
                    $results[] = $data;
                }
            }
        }
        return $results;
    }

}

<?php
/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use frontend\models\Search;

class SearchController extends Controller
{
    const PAGE_SIZE = 10;
    
    public $bodyId;

    public function actionIndex($q = '')
    {
        $this->bodyId = 'page-hotel';
        
        /** @var \himiklab\yii2\search\Search $search */
        $search = Yii::$app->search;
        $searchData = $search->find($q); // Search by full index.
        //$searchData = $search->find($q, ['model' => 'page']); // Search by index provided only by model `page`.
        
        // current lang results
        $results = Search::filterResults($searchData['results']);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $results,
            'pagination' => ['pageSize' => self::PAGE_SIZE],
        ]);

        return $this->render(
            'index',
            [
                'hits' => $dataProvider->getModels(),
                'pagination' => $dataProvider->getPagination(),
                'query' => $searchData['query']
            ]
        );
    }

    // Of course, this function should be in the console part of the application!
    public function actionIndexing()
    {
        /** @var \himiklab\yii2\search\Search $search */
        $search = Yii::$app->search;
        $search->index();
    }
}

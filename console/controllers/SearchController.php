<?php 
namespace console\controllers;
use Yii;
use yii\console\Controller;

class SearchController extends Controller
{

    public function actionIndexing()
    {
       /** @var \himiklab\yii2\search\Search $search */
        $search = Yii::$app->search;
        $search->index();
        chmod($search->indexDirectory, 0777);
    }
} 

<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Categories;
use common\models\Pages;
use common\models\Languages;
use common\models\Map;
use common\models\Banners;
use frontend\models\Offers;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $bodyId;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            [
                'class' => 'yii\filters\PageCache',
                //'only' => ['index'],
                'duration' => Pages::PAGES_EXPIRATION,
                'variations' => [
                    Yii::$app->language,
                    Yii::getAlias('@device')
                ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT COUNT(*) FROM post',
//                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $this->bodyId = 'page-hotel';
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->bodyId = null;

        // Page 
        $page = Pages::findOne([
                'status' => Pages::PAGES_STATUS_VISIBLE,
                'type' => Pages::PAGES_TYPE_HOME
        ]);

        // Get categories
        $categories = Categories::homeCategories();

        // Map regions rating
        $regionsRating = Map::regionsRatings();

        // Banners
        $banners = Banners::getBanners();

        // Get offers
        $offers = Offers::getOffers(4);
        
        // Map
        $mapItems = Map::items();
        $mapRegions = Map::mapRegions();

        return $this->render('index', [
                'page' => $page,
                'categories' => $categories,
                'regionsRating' => $regionsRating,
                'banners' => $banners,
                'offers' => $offers,
                'map' => ['items' => $mapItems, 'regions' => $mapRegions],
        ]);
    }

    /**
     * Header
     * @return type
     */
    public function actionHeader($lang)
    {
        Yii::$app->language = Languages::getLangByIso($lang);
        return $this->renderPartial('/layouts/_header');
    }

    /**
     * Footer
     * @return type
     */
    public function actionFooter($lang)
    {
        Yii::$app->language = Languages::getLangByIso($lang);
        return $this->renderPartial('/layouts/_footer');
    }

}

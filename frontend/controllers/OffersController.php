<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use frontend\models\Offers;

class OffersController extends \yii\web\Controller {

    /**
     * Body id attribute
     * @var string body ID 
     */
    public $bodyId;

    /**
     * All offers for home page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionList()
    {
        $lang = Yii::$app->language;

        // Get offers
        $cache  = Yii::$app->cache;
        $offers = $cache->get('offersList' . $lang);
        if($offers === false) {
            $offers = Offers::getOffers();
            $cache->set('offersList' . $lang, $offers, Offers::OFFERS_LIST_EXPIRATION);
        }

        // Return result
        if($offers) {
            return $this->renderPartial('list', [
                    'offers' => $offers
            ]);
        } else {
            throw new NotFoundHttpException('Not found');
        }
    }

    public function actionView($slug)
    {
        // Set body ID
        $this->bodyId = 'page-hotel';

        // Get offer model
        $offer = self::findModelBySlug($slug);

        // Image
        $offer->defaultImage();

        return $this->render('view', [
                'offer' => $offer
        ]);
    }

    /**
     * Find model by slug
     * @param string $slug
     * @return mixes
     * @throws NotFoundHttpException
     */
    protected static function findModelBySlug($slug)
    {
        $model = Offers::find()
            ->joinWith('descr')
            ->where('slug = :slug', [':slug' => $slug])
            ->andWhere(['status' => Offers::OFFERS_STATUS_VISIBLE])
            ->one();
        if(!empty($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Сторінку не знайдено'));
        }
    }

}

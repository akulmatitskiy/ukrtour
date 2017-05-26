<?php

namespace frontend\controllers;

use Yii;
use common\models\Pages;
use yii\web\NotFoundHttpException;

class PagesController extends \yii\web\Controller {
    
    /**
     * Body id attribute
     * @var string body ID 
     */
    public $bodyId;

    public function actionView($slug)
    {
        $model = self::findModelBySlug($slug);
        // Set body id
        $this->bodyId = 'page-hotel';
        
        if($model->type == Pages::PAGES_TYPE_CONTACTS) {
            // Set body id
            $this->bodyId = 'page-contacts';
            
            return $this->render('contacts', [
                    'model' => $model
            ]);
        }
        return $this->render('view', [
                'model' => $model
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
        $model = Pages::find()
            ->joinWith('descr')
            ->where('slug = :slug', [':slug' => $slug])
            ->andWhere(['status' => Pages::PAGES_STATUS_VISIBLE])
            ->one();
        if(!empty($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Сторінку не знайдено'));
        }
    }

}

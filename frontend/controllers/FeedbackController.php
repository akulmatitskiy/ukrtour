<?php
/**
 * Feedback controller
 */

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use frontend\models\Feedback;

class FeedbackController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Callback
     * @return array
     */
    public function actionCallback()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $message = Feedback::callbackSend(Yii::$app->request->post('phone'));
        if($message) {
            return ['success'];
        } else {
            return ['error'];
        }
    }
    
    /**
     * Booking conference room
     * @return array
     */
    public function actionBooking()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = Yii::$app->request->post('type');
        $name = Yii::$app->request->post('name');
        $phone = Yii::$app->request->post('phone');
        $id = Yii::$app->request->post('id');
        $date = Yii::$app->request->post('date');
        
        $message = Feedback::bookingSend($type, $name, $phone, $id, $date);
        if($message) {
            return ['success'];
        } else {
            return ['error'];
        }
    }
    
    /**
     * Feedback form
     * @return array
     */
    public function actionFeedback()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $name = Yii::$app->request->post('name');
        $phone = Yii::$app->request->post('phone');
        $email = Yii::$app->request->post('email');
        
        $message = Feedback::feedbackSend($name, $phone, $email);
        if($message) {
            $result = Yii::t('app', 'Успішно надіслано');
            return [$result];
        } else {
            $error = Yii::t('app', 'Помилка');
            return [$error];
        }
    }
    
    /**
     * Callback template
     * @return type
     */
    public function actionCallbackTemplate()
    {
        return $this->renderPartial('callback');
    }
    
    /**
     * Booking template
     * @return type
     */
    public function actionReserveTemplate($type, $item)
    {
        return $this->renderPartial('reserve', [
            'type' => $type,
            'itemId' => $item,
        ]);
    }

}

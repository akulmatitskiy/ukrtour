<?php

namespace frontend\models;

use Yii;
use frontend\models\ConfRooms;
use frontend\models\Tours;
use frontend\models\Hostels;

/**
 * This is the model class for feedback.
 */
class Feedback extends \yii\base\Model {

    const FEEDBACK_TYPE_CONFROOM = 'room';
    const FEEDBACK_TYPE_TOUR     = 'tour';
    const FEEDBACK_TYPE_HOSTEL   = 'hostel';

    /**
     * Send callback request message
     * @param string $phone
     * @return boolean
     */
    public static function callbackSend($phone)
    {
        // Settings
        $adminEmail = Yii::$app->params['adminEmail'];

        if(!empty($phone)) {
            // Send mail
            $message = Yii::$app->mailer->compose()
                ->setFrom($adminEmail)
                ->setTo($adminEmail)
                ->setSubject('Запрос обратного звонка')
                ->setTextBody('Номер телефона: ' . $phone)
                ->send();

            if($message) {
                return true;
            }
        }
        return false;
    }

    /**
     * Send booking notification
     * @param string $name
     * @param string $phone
     * @return boolean
     */
    public static function bookingSend($type, $name, $phone, $id, $date = null)
    {
        // Settings
        $adminEmail = Yii::$app->params['adminEmail'];
        $email      = Yii::$app->params['reservationEmail'];
        //$email      = Yii::$app->params['debugEmail'];
        $formatter  = \Yii::$app->formatter;

        if(!empty($phone) && !empty($id) && !empty($type)) {
            $item = '';
            if($type == self::FEEDBACK_TYPE_CONFROOM) {
                // Conference room
                $itemModel = ConfRooms::confRoomName($id);
                $item = 'Зал: ' . $itemModel;
            }
            if($type == self::FEEDBACK_TYPE_TOUR) {
                // Conference room
                $itemModel = Tours::findOne($id);
                if(!empty($itemModel)) {
                    $item = 'Тур: ' . $itemModel->descr->title;
                }
            }
            if($type == self::FEEDBACK_TYPE_HOSTEL) {
                // Conference room
                $itemModel = Hostels::findOne($id);
                if(!empty($itemModel)) {
                    $item = 'Турбаза: ' . $itemModel->descr->title;
                }
            }

            // Message body
            $txtBody = 'Имя: ' . $name . PHP_EOL;
            $txtBody .= 'Номер телефона: ' . $phone . PHP_EOL;
            $txtBody .= $item . PHP_EOL;
            if(!empty($date)) {
                //$txtBody .= 'Дата: ' . $formatter->asDate($date, 'yyyy-MM-dd') . PHP_EOL;
                $txtBody .= 'Дата: ' . $date . PHP_EOL;
            }

            // Send mail
            $message = Yii::$app->mailer->compose()
                ->setFrom($adminEmail)
                ->setTo($email)
                ->setSubject('Запрос на бронирование')
                ->setTextBody($txtBody)
                ->send();

            if($message) {
                return true;
            } else {
                Yii::warning($message);
                return false;
            }
        }
        Yii::warning($phone.':'.$id.':'.$type);
        return false;
    }

    /**
     * Site feedback
     * @param string $name
     * @param string $phone
     * @param string $email
     * @return boolean
     */
    public static function feedbackSend($name, $phone, $email)
    {
        // Settings
        $adminEmail = Yii::$app->params['adminEmail'];

        if(!empty($name)) {
            // Message body
            $txtBody = 'Имя: ' . $name . PHP_EOL;
            if(!empty($phone)) {
                $txtBody .= 'Номер телефона: ' . $phone . PHP_EOL;
            }
            if(!empty($email)) {
                $txtBody .= 'E-mail: ' . $email;
            }

            // Send mail
            $message = Yii::$app->mailer->compose()
                ->setFrom($adminEmail)
                ->setTo($adminEmail)
                ->setSubject('Обратная связь сайта')
                ->setTextBody($txtBody)
                ->send();

            if($message) {
                return true;
            }
        }
        return false;
    }

}

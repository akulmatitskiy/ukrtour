<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\models\Languages;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use SORApp\Models\Booking\AbstractBookingFactory;

class ServioController extends \yii\web\Controller {

    public function actionRooms()
    {

        // Lang
        $lang = Languages::getIsoCode();

        $searchRequestFactory = AbstractBookingFactory::getFactory('SearchRequest');

        $post = Yii::$app->request->post();

        $searchRequest = $searchRequestFactory->createEntity();

        $search = $post['search'];

        $search['rooms'] = array_slice($search['rooms'], 0, $post['roomsCount']);
        $searchRequest->autoSetAttributes($search);

        if(!$searchRequest->validate() || !$searchRequest->execute() || !$searchRequestFactory->saveEntity($searchRequest)) {
            throw new BadRequestHttpException('Invalid request');
        }

        // Устанавливаем контекст бронирования
        //$this->setHashKey($searchRequest->hashKey);
        //$searchRequest = $searchRequestFactory->getEntity($searchRequest->hashKey);

        $reservationFactory = AbstractBookingFactory::getFactory('Reservation');

        $reservation = $reservationFactory->getEntity($searchRequest->hashKey);

        $reservation->addRelation($searchRequest);

        $nextStep = '/booking/customer?hashKey=' . $searchRequest->hashKey
            . '&refStep=1&lang=' . $lang;

        // Если выбраны типы номеров
        if($searchRequest && isset($post['selectedRoom'])) {

            $reservation->selectedRooms = $this->post['selectedRoom'];
            if(!$reservation->validate() || !$reservation->calculateCostServices() || !$reservationFactory->saveEntity($reservation)) {

                throw new BadRequestHttpException('Invalid reservation request');
            }


            $this->redirect([$nextStep]);
        }

        if(isset($post['reservation'])) {

            $reservation->autoSetAttributes($this->post['reservation']);

            if($reservationFactory->saveEntity($reservation)) {
                $this->redirect([$nextStep]);
            }

            throw new BadRequestHttpException('Invalid reservation request');
        }

        if($reservation && empty($reservation->customer)) {
            $reservation->setCustomerDefault();
        }

        // Если ничего не найдено
        if(!$searchRequest || !count($searchRequest->foundRooms['roomsGroups'])) {
            //throw new Exceptions\HttpException(404, App::_('search', 'Rooms_Not_Found'));
            throw new NotFoundHttpException('Rooms not found');
        }


        $result = [];

        $rooms = $searchRequest->foundRooms['roomsGroups'][0];

        foreach($searchRequest->getRoomsInfo() as $room) {
            // Name
            if(!empty($room['translates'][$lang]['name'])) {
                $name = $room['translates'][$lang]['name'];
            } else {
                $name = $room['name'];
            }

            // Description
            if(!empty($room['translates'][$lang]['descr'])) {
                $descr = $room['translates'][$lang]['descr'];
            } else {
                $descr = '';
            }

            // Price
            if(isset($rooms[$room['servioId']]['prices']['PriceTotal'])) {
                $priceTotal = $rooms[$room['servioId']]['prices']['PriceTotal'];
                if($priceTotal > Yii::$app->params['roomsMinPrice']) {
                    $result[] = [
                        'id' => $room['servioId'],
                        'room_id' => $room['id'],
                        'name' => $name,
                        'beds' => $room['beds'],
                        'image' => '/booking/uploads/rooms/room' . $room['servioId']
                        . '/thumb_' . $room['photo'] . '.jpg',
                        'price' => $priceTotal,
                        'descr' => $descr,
                        'hashKey' => $searchRequest->hashKey,
                    ];
                }
            }
        }

        // Prepare array for sorting
        $count = count($result);

        if($count > 0) {
            foreach($result as $key => $row) {
                $id[$key]      = $row['id'];
                $name[$key]    = $row['name'];
                $beds[$key]    = $row['beds'];
                $image[$key]   = $row['image'];
                $price[$key]   = $row['price'];
                $descr[$key]   = $row['descr'];
                $hashKey[$key] = $row['hashKey'];
            }

            // Sorting array
            switch ($post['sort']) {

                case 'beds-asc':
                    array_multisort($beds, SORT_ASC, $id, SORT_ASC, $result);
                    break;

                case 'beds-desc':
                    array_multisort($beds, SORT_DESC, $id, SORT_ASC, $result);
                    break;

                case 'price-desc':
                    array_multisort($price, SORT_DESC, $id, SORT_ASC, $result);
                    break;

                case 'price-asc':
                default:
                    array_multisort($price, SORT_ASC, $id, SORT_ASC, $result);
                    break;
            }
        }

        return $this->renderPartial('rooms', [
                'rooms' => $result,
                'hotel' => $post['search']['hotelId']
        ]);
    }

}

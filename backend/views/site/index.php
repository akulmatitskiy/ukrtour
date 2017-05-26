<?php

use backend\models\search\HotelsSearch;
use backend\models\search\ConfRoomsSearch;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Ukrtour';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-6">
                <h2>Отели</h2>
                <?php
                $hotelsModel = new HotelsSearch();
                $hotels      = $hotelsModel->search(Yii::$app->request->queryParams);
                echo GridView::widget([
                    'dataProvider' => $hotels,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [

                            'label' => 'Город',
                            'value' => function($model) {
                                return $model->hotelCity();
                            }
                        ],
                        [
                            'label' => 'Название',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a($model->hotelName(), [
                                        'hotels/update',
                                        'id' => $model->id
                                ]);
                            }
                            ],
                            [
                                'label' => 'Статус',
                                'attribute' => 'visible',
                                'value' => function($model) {
                                    $labels = $model->statusesLabels();
                                    return $labels[$model->visible];
                                }
                            ],
                            [
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                                        'hotels/update',
                                        'id' => $model->id
                                ]);
                            }
                            ],
                            
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <h2>Конференц-залы</h2>
                    <?php
                    $confRoomsModel = new ConfRoomsSearch();
                    $confRooms      = $confRoomsModel->search(Yii::$app->request->queryParams);
                    echo GridView::widget([
                        'dataProvider' => $confRooms,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'hotel_id',
                                'value' => function($model) {
                                    return $model->getHotel();
                                },
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::a($model->descr->name, [
                                        'conf-rooms/update',
                                        'id' => $model->id
                                ]);
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'value' => function($model) {
                                    return $model->getStatusLabel();
                                },
                            ],
                            [
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                                        'conf-rooms/update',
                                        'id' => $model->id
                                ]);
                                }
                            ],
                        ],
                    ]);
                    ?>
            </div>
        </div>

    </div>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RoomsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// Icons
$this->registerCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');

$this->title                   = 'Номера';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rooms-index">

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'hotelId',
                'value' => function($model) {
                    return $model->hotelName($model->hotelId);
                },
                'filter' => Html::activeDropDownList(
                    $searchModel, 'hotelId', $searchModel->getHotels(), [
                    'class' => 'form-control',
                    'prompt' => '< Все >'
                    ]
                ),
            ],
            //'servioId',
            'name',
            [
                'attribute' => 'roomFeatures',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->roomFeaturesIcons();
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]);
    ?>
</div>

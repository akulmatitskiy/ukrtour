<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ConfRoomsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Конференц залы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conf-rooms-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Добавить конференц зал', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'parent_id',
                'value' => function($model) {
                    if($model->type == $model::CONF_ROOMS_TYPE_HOTEL) {
                        return $model->getHotel();
                    } else {
                        return $model->getHostel();
                    }
                },
//                'filter' => Html::activeDropDownList(
//                    $searchModel, 'hotel_id', $searchModel->getHotels(), [
//                    'class' => 'form-control',
//                    'prompt' => '< Все >'
//                    ]
//                ),
            ],
            [
                'attribute' => 'name',
                'value' => function($model) {
                    return $model->descr->name;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabel();
                },
                'filter' => Html::activeDropDownList(
                    $searchModel, 'status', $searchModel->statusesLabels(), [
                    'class' => 'form-control',
                    'prompt' => '< Все >'
                    ]
                ),
            ],
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}'
            ],
        ],
    ]);
    ?>
</div>

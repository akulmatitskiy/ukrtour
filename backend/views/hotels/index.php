<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\HotelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Отели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotels-index">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'value' => function($model) {
                    return $model->hotelName();
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
            'sort_order',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]);
    ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-index">

    <p>
        <?php echo Html::a('Создать баннер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'value' => function($model) {
                    return $model->getTypeLabel();
                }
            ],
            [
                'attribute' => 'title',
                'value' => function($model) {
                    return $model->descr->title;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabel();
                }
            ],
            'sort_order',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}'
                ],
        ],
    ]);
    ?>
</div>

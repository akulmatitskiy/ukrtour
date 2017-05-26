<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offers-index">
    <p>
        <?php echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'value' => function($model) {
                    return $model->descr->title;
                }
            ],
            [
                'attribute' => 'type',
                'value' => function($model) {
                    return $model->getTypeLabel();
                },
                'filter' => Html::activeDropDownList(
                    $searchModel, 'type', $searchModel->typesLabels(), [
                    'class' => 'form-control',
                    'prompt' => '< Все >'
                    ]
                ),
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
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}'],
        ],
    ]);
    ?>
</div>

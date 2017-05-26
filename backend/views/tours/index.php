<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ToursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Туры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-index">
    <p>
        <?php echo Html::a('Добавить тур', ['create'], ['class' => 'btn btn-success']) ?>
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
                    if(!empty($model->descr->title)) {
                        return $model->descr->title;
                    } else {
                        return null;
                    }
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}'
            ],
        ],
    ]);
    ?>
</div>

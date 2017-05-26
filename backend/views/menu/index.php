<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\MenuItems;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-items-index">

    <p>
        <?php echo Html::a('Создать пункт меню', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'menu_id',
                'value' => function($model) {
                    return $model->getTypeLabel();
                },
                'filter' => Html::activeDropDownList(
                    $searchModel, 'menu_id', $searchModel->typesLabels(), [
                    'class' => 'form-control',
                    'prompt' => '< Все >'
                    ]
                ),
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
            'sort_order',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}'
            ],
        ],
    ]);
    ?>
</div>

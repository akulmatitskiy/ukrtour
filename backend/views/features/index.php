<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

// Icons
$this->registerCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');

$this->title                   = 'Характеристики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="features-index">

    <p>
        <?php echo Html::a('Добавить характеристику', ['create'], ['class' => 'btn btn-success']) ?>
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
                'format' => 'raw',
                'value' => function($model) {
                    return $model->descr->title;
                }
            ],
            [
                'attribute' => 'icon',
                'format' => 'raw',
                'value' => function($model) {
                    return '<i class="material-icons">'
                        . $model->icon . '</i>';
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

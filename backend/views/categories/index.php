<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">

    <p>
        <?php echo Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Категория',
                'value' => function($model) {
                    
                    $title = $model->descr;
                    if($title != null) {
                        $title = $title->title;
                    }
                    return $title;
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
                'attribute' => 'slug',
                'value' => function($model) {
                    return $model->descr->slug;
                }
            ],
            

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}'],
        ],
    ]); ?>
</div>

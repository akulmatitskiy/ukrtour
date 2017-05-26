<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статичесике страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <p>
        <?php echo Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Заголовок',
                'value' => function($model) {
                    if(isset($model->descr->title)) {
                        return $model->descr->title;
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'type',
                'value' => function($model) {
                    return $model->getTypeLabel();
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabel();
                }
            ],
            

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}   {delete}'],
        ],
    ]); ?>
</div>

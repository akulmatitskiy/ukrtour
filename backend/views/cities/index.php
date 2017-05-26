<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочник населенных пунктов (Servio)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servio-cities-index">

    <p>
        <?php echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'alias',
            [
                'label' => 'Название',
                'value' => function($model) {
                    if(!empty($model->descr->name)) {
                        return $model->descr->name;
                    } else {
                        return null;
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}   {delete}'
                ],
        ],
    ]); ?>
</div>

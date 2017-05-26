<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ConfRooms */
// title
if(!empty($model->descr->name)) {
    $title = $model->descr->name;
} else {
    $title = $model->id;
}


$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Конференц залы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="conf-rooms-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'features' => $features,
    ]) ?>

</div>

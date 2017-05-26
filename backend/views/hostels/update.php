<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Hostels */

// title
if(!empty($model->descr->title)) {
    $title = $model->descr->title;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Турбазы', 'url' => ['index']];
?>
<div class="hostels-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'images' => $images,
    ]) ?>

</div>

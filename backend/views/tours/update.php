<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tours */

// title
if(!empty($model->descr->title)) {
    $title = $model->descr->title;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['index']];
?>
<div class="tours-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'images' => $images,
    ]) ?>

</div>

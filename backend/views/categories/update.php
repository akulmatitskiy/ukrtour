<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */

// title
if(!empty($model->descr->title)) {
    $title = $model->descr->title;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование категории: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="categories-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

<?php

/* @var $this yii\web\View */
/* @var $model common\models\Offers */

// title
if(!empty($model->descr->title)) {
    $title = $model->descr->title;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
?>
<div class="offers-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

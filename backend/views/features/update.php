<?php

/* @var $this yii\web\View */
/* @var $model common\models\Features */

// title
if(!empty($model->descr->title)) {
    $title = $model->descr->title;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'UpdaРедактированиеte';
?>
<div class="features-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

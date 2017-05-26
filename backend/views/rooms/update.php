<?php

/* @var $this yii\web\View */
/* @var $model common\models\Rooms */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Номера', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="rooms-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'features' => $features,
    ]) ?>

</div>

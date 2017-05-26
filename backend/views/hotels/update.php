<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Hotels */
$name = $model->hotelName();
$this->title = 'Редактирование отеля: ' . $name;
$this->params['breadcrumbs'][] = ['label' => 'Отели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $name;
?>
<div class="hotels-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'features' => $features,
        'images' => $images,
    ]) ?>

</div>

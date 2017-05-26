<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Banners */

// title
if(!empty($model->descr->title)) {
    $title = $model->descr->title;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="banners-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

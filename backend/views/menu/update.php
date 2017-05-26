<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MenuItems */

// Title
if(!empty($model->descr->name)) {
    $title = $model->descr->name;
} else {
    $title = $model->id;
}

$this->title = 'Редактирование пункта меню: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="menu-items-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

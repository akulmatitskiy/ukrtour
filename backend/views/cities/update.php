<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ServioCities */
if(!empty($model->descr->name)) {
    $title = $model->descr->name;
} else {
    $title = $model->id;
}
$this->title = 'Редактирование: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Населенные пункты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="servio-cities-update">


    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

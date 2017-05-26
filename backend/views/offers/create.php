<?php

/* @var $this yii\web\View */
/* @var $model common\models\Offers */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offers-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

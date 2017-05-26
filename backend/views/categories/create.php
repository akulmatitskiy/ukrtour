<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Categories */

$this->title = 'Создание категории';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

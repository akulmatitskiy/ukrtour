<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Features */

$this->title = 'Добавить характеристику';
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="features-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

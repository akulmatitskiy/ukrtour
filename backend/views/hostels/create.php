<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Hostels */

$this->title = 'Добавление турбазы';
$this->params['breadcrumbs'][] = ['label' => 'Турбазы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hostels-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

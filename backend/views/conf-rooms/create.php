<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ConfRooms */

$this->title = 'Создание конференц зала';
$this->params['breadcrumbs'][] = ['label' => 'Конференц залы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conf-rooms-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'features' => $features,
    ]) ?>

</div>

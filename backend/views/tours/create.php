<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tours */

$this->title = 'Добавление тура';
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

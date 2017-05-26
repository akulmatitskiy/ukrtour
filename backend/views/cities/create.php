<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServioCities */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servio-cities-create">


    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

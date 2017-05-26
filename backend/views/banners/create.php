<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Banners */

$this->title = 'Создание баннера';
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MenuItems */

$this->title = 'Создание пункта меню';
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-items-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>

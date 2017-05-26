<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\RoomsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rooms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hotelId') ?>

    <?= $form->field($model, 'servioId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'beds') ?>

    <?php // echo $form->field($model, 'extBeds') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

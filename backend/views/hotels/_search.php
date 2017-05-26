<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\HotelsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotels-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cityId') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'serverId') ?>

    <?= $form->field($model, 'servioId') ?>

    <?php // echo $form->field($model, 'tourTax') ?>

    <?php // echo $form->field($model, 'manager_emails') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Rooms */
/* @var $form yii\widgets\ActiveForm */

// Load room features
$model->roomFeatures = $model->roomFeatures();
?>

<div class="rooms-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset class="col-md-5">
        <?php
        echo $form->field($model, 'roomFeatures')
            ->checkboxList($features)
        ?>
    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

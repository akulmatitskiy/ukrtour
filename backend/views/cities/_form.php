<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServioCities */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="servio-cities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    echo $form->field($model, 'alias')->textInput(['maxlength' => true]);
    echo $form->field($model, 'name[uk-UA]')
        ->textInput(['maxlength' => true])
        ->label('Название (укр.)');
    
    echo $form->field($model, 'name[ru-RU]')
        ->textInput(['maxlength' => true])
        ->label('Название (рус.)');
    
    echo $form->field($model, 'name[en-US]')
        ->textInput(['maxlength' => true])
        ->label('Название (eng.)');
    ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

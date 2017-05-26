<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Features */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="features-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset>
        <legend>Заголовок:</legend>
        <?php
        foreach($langs as $code => $lang) {
            // Fields
            echo $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-sm-3']
                ])
                ->textInput()->label($lang['label']);
        }
        ?>
    </fieldset>
    <div class="clearfix"></div>
    <br>
    <br>
    <br>
    <?php
    echo $form->field($model, 'icon', ['options' => ['class' => 'col-sm-3']])
        ->textInput(['maxlength' => true])
        ->hint('Имя иконки с '
            . Html::a('Material icons', 'https://material.io/icons/', [
                'target' => '_blank'
                ]
            )
    );

    echo $form->field($model, 'type', ['options' => ['class' => 'col-sm-3']])
        ->dropDownList($model->typesLabels(), ['prompt' => 'Выберите тип...']);
    
    echo $form->field($model, 'status', ['options' => ['class' => 'col-sm-3']])
        ->dropDownList($model->statusesLabels());

    echo $form->field($model, 'sort_order', [
            'options' => ['class' => 'col-sm-3']
        ])
        ->input('number');
    ?>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

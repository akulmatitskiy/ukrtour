<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\MenuItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-items-form">

    <?php $form  = ActiveForm::begin(); ?>
    <fieldset>
        <?php
        echo $form->errorSummary($model, [
            'footer' => 'При необходимости проверьте все языковые вкладки'
        ]);
        ?>
        <?php
        // tabs
        $items = [];
        foreach($langs as $code => $lang) {
            // Fields
            $content = $form->field($model, 'name[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'url[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            // Items
            $items[] = [
                'label' => $lang['label'],
                'content' => $content,
            ];
        }
        echo Tabs::widget(['items' => $items]);
        ?>
    </fieldset>
    <br>
    <br>

    <fieldset class="col-md-5">
        <?php echo $form->field($model, 'menu_id')->dropDownList($model->typesLabels()) ?>

        <?php echo $form->field($model, 'status')->dropDownList($model->statusesLabels()) ?>

        <?php echo $form->field($model, 'sort_order')->input('number') ?>
    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form  = ActiveForm::begin(); ?>
    <fieldset>
        <?php
        echo $form->errorSummary($model, [
            'footer' => 'При необходимости проверьте все языковые вкладки'
        ]);
        ?>

        <?php
        $items = [];
        foreach($langs as $code => $lang) {
            // Fields
            $content = $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            // Url
            if(empty($model->type)) {
                $url = 'url: ' . $model->genUrl($code, $model->slug[$code]);
            } else {
                $url = false;
            }

            $content .= $form->field($model, 'slug[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput()->hint($url);

            $content .= $form->field($model, 'h1[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'meta_description[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'text[' . $code . ']', [
                    'options' => ['class' => 'col-md-12']
                ])
                ->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinderFrontend', [/* Options */]),
            ]);

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
    <div class="clearfix"></div>
    <fieldset class="col-md-5">
        <?php
        echo $form->field($model, 'type')
            ->dropDownList($model->typesLabels(), ['prompt' => 'Выберите тип'])
        ?>

        <?php
        echo $form->field($model, 'status')
            ->dropDownList($model->statusesLabels())
        ?>
    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

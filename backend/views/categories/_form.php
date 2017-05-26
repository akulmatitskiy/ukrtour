<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form  = ActiveForm::begin(); ?>
    <?php
    echo $form->errorSummary($model, [
        'footer' => 'При необходимости проверьте все языковые вкладки'
    ]);
    ?>
    <fieldset>
        <?php
        // Tabs
        $items = [];
        foreach($langs as $code => $lang) {
            // Fields
            $content = $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'slug[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'annotation[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'h1[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'meta_title[' . $code . ']', [
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
        // Image
        if(!empty($model->image)) {
            $model->image = '/images/categories/' . $model->image;
            echo Html::img($model->image, [
                'width' => 90,
                'height' => 100
            ]);
        }

        echo $form->field($model, 'image')->widget(InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'filter' => 'image', // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => false       // возможность выбора нескольких файлов
        ]);

        echo $form->field($model, 'icon')->textInput(['maxlength' => true]);
        ?>
    </fieldset>
    <fieldset class="col-md-5">
        <?php
        echo $form->field($model, 'status')
            ->dropDownList($model->statusesLabels());

        echo $form->field($model, 'sort_order')->input('number', ['maxlength' => true]);
        echo $form->field($model, 'type')->dropDownList($model->typesLabels(), ['prompt' => 'Выберите тип']);
        ?>
    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

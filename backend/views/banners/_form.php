<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\Banners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banners-form">

    <?php $form  = ActiveForm::begin(); ?>
    <?php
    echo $form->errorSummary($model, [
        'footer' => 'При необходимости проверьте все языковые вкладки'
    ]);
    ?>
    <fieldset>
        <?php
        // tabs
        $items = [];
        foreach($langs as $code => $lang) {
            // Fields
            $content = $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            
            $content .= $form->field($model, 'text[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            
            $content .= $form->field($model, 'price[' . $code . ']', [
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
    <div class="clearfix"></div>
    <fieldset class="col-md-5">
        <?php echo $form->field($model, 'type')->dropDownList($model->typesLabels()) ?>

        <?php
        // Image
        if(!empty($model->image)) {
            $model->image = '/images/banners/' . $model->id . '/' . $model->image;
            echo Html::img($model->image, [
                'width' => 192,
                'height' => 85
            ]);
        }
        echo $form->field($model, 'image')->widget(InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image', // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => true,
        ]);
        ?>

        <?php echo $form->field($model, 'status')->dropDownList($model->statusesLabels()) ?>
        
        <?php echo $form->field($model, 'category')
            ->dropDownList($model->categoriesLabels(), ['prompt' => 'На всех страницах']) ?>

        <?php echo $form->field($model, 'sort_order')->input('number') ?>
    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

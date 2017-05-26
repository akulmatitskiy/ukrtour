<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Url;
use common\models\Map;

/* @var $this yii\web\View */
/* @var $model common\models\Hostels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hostels-form">

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
            $content = $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'slug[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            $content .= $form->field($model, 'meta_description[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            
            $content .= $form->field($model, 'annotation[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput(['maxlength' => 130]);
            
            $content .= $form->field($model, 'address[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            
            $content .= $form->field($model, 'description[' . $code . ']', [
                    'options' => ['class' => 'col-md-12']
                ])
                ->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinderFrontend', [/* Options */]),
            ]);
            

            // Items
            $items[] = [
                'label' => $lang['label'],
                'content' => $content,
                'options' => ['class' => 'col-md-12'],
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
            $model->image = '/images/hostel/' . $model->image;
            echo Html::img($model->image, [
                'width' => 90,
                'height' => 100
            ]);
        }

        echo $form->field($model, 'image')->widget(InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image',
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => false
        ]);
        
        // Phone 
        echo $form->field($model, 'phone')
            ->textInput()
            ->hint('Введите номер (несколько значений разделяйте запятыми)');
        
        // Latitude
        echo $form->field($model, 'latitude')->textInput();
        
        // Longitude
        echo $form->field($model, 'longitude')->textInput();
        
        // Region
        echo $form->field($model, 'region')
            ->dropDownList(Map::regionsLabels(), ['prompt' => 'Выберите область']);
        
        // City
        echo $form->field($model, 'city_id')
            ->dropDownList($model->citiesTitles(), ['prompt' => 'Выберите город']);

        echo $form->field($model, 'status')
            ->dropDownList($model->statusesLabels());

        ?>
    </fieldset>
    <div class="clearfix"></div>
    <fieldset class="col-md-12">
        <h2>Фото галерея</h2>
        <?php
        echo $form->field($model, 'images')->widget(InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image', // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => true,
        ])->label(false);
        
        // Images
        if(!empty($images)) {
            ?>
            <span class="glyphicon glyphicon-trash"></span> Удалить изображение
            <div id="gallery-images">
                <?php
                // Display images
                foreach($images as $image) {
                    ?>
                    <div class="preview">
                        <img width="150" alt="" 
                             src="/images/gallery/hostel/<?php echo $model->id ?>/<?php echo $image['image'] ?>">
                        <a href="<?php
                        echo Url::to([
                            'gallery/delete-image',
                            'id' => $image['id'],
                            'route' => 'hostels/update',
                            'gallery' => $model->id,
                        ]);
                        ?>" data-method="post">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
            <?php
        }
    ?>

    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use common\models\Map;

/* @var $this yii\web\View */
/* @var $model backend\models\Hotels */
/* @var $form yii\widgets\ActiveForm */

// Load hotels features
$model->hotelFeatures = $model->hotelFeatures();
?>

<div class="hotels-form">

    <?php $form                 = ActiveForm::begin(); ?>
    <?php
    echo $form->errorSummary($model, [
        'footer' => 'При необходимости проверьте все языковые вкладки'
    ]);
    ?>
    <fieldset>
        <?php
        // Tabs
        $items                = [];
        foreach($langs as $code => $lang) {
            // Fields
            $content = $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])
                ->textInput();

            $content .= $form->field($model, 'slug[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])
                ->textInput();

            $content .= $form->field($model, 'h1[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])
                ->textInput();

            $content .= $form->field($model, 'meta_description[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])
                ->textInput();

            $content .= $form->field($model, 'description[' . $code . ']', [
                    'options' => ['class' => 'col-md-12']
                ])
                ->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinderFrontend', [/* Options */]),
            ]);
            $content .= $form->field($model, 'address[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'map[' . $code . ']', [
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
        <?php
        // Image
        echo $form->field($model, 'image')->widget(InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'filter' => 'image', // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control col-md-8'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => false       // возможность выбора нескольких файлов
        ]);
        ?>
        <?php
        // rating
        echo $form->field($model, 'rating')
            ->radioList([0, 1, 2, 3, 4, 5]);

        // Phone 
        echo $form->field($model, 'phone')
            ->textInput()
            ->hint('Введите номер (несколько значений разделяйте запятыми)');

        // Region
        echo $form->field($model, 'region')
            ->dropDownList(Map::regionsLabels(), ['prompt' => 'Выберите область']);
        
        // Sort order
        echo $form->field($model, 'sort_order')->input('number');
        
        ?>
    </fieldset>
    <fieldset class="col-md-5">
        <legeng>Расстояние до отеля</legeng>
        <?php echo $form->field($model, 'dist_aero')->textInput() ?>

        <?php echo $form->field($model, 'dist_railway')->textInput() ?>

        <?php echo $form->field($model, 'dist_avto')->textInput() ?>
    </fieldset>
    <fieldset class="col-md-5">
        <?php echo $form->field($model, 'hotelFeatures')->checkboxList($features) ?>
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
                             src="/images/gallery/<?php echo $model->id ?>/<?php echo $image['image'] ?>">
                        <a href="<?php
                        echo Url::to([
                            'gallery/delete-image',
                            'id' => $image['id'],
                            'route' => 'hotels/update',
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
        <?php
        echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

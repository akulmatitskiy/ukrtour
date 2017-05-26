<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use mihaildev\elfinder\InputFile;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use backend\assets\DepdropAsset;

/* @var $this yii\web\View */
/* @var $model common\models\ConfRooms */
/* @var $form yii\widgets\ActiveForm */

// Dependent Dropdown asset
DepdropAsset::register($this);
$depdrop = '$("#parent").depdrop({
        url: "/index.php?r=conf-rooms/parents",
        depends: ["type"],
        initialize: true,
        initDepends: ["type"],
        params: ["roomId"],
    });';
$this->registerJs($depdrop);

// Load conference room features
$model->confRoomFeatures = $model->confRoomFeatures();
?>

<div class="conf-rooms-form">

    <?php $form                    = ActiveForm::begin(); ?>
    <?php
    echo $form->errorSummary($model, [
        'footer' => 'При необходимости проверьте все языковые вкладки'
    ]);
    ?>
    <fieldset>
        <?php
        // tabs
        $items                   = [];
        foreach($langs as $code => $lang) {
            // Fields
            $content = $form->field($model, 'name[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();

            $content .= $form->field($model, 'title[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            $content .= $form->field($model, 'meta_description[' . $code . ']', [
                    'options' => ['class' => 'col-md-9']
                ])->textInput();
            $content .= $form->field($model, 'slug[' . $code . ']', [
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
        <input id="roomId" type="hidden" name="roomId" value="<?php echo $model->id ?>">
        <?php
        echo $form->field($model, 'type')
            ->dropDownList($model->getTypes(), [
                'id' => 'type',
                'prompt' => 'Выберите тип...'
                ]);

        echo $form->field($model, 'parent_id')
            ->dropDownList([], [
                'id' => 'parent',
                'prompt' => 'Выберите ...',
                ]);
        ?>

        <?php echo $form->field($model, 'people_min')->textInput() ?>

        <?php echo $form->field($model, 'people_max')->textInput() ?>

        <?php
        // Image
        if(!empty($model->image)) {
            echo $form->field($model, 'oldImage')
                ->hiddenInput(['value' => $model->image])
                ->label(false);


            $img = '/images/conference-rooms/'
                . $model->id . '/' . $model->image;

            echo Html::img($img, [
                'width' => 192,
                'height' => 85
            ]);
            $model->image = null;
        }
        echo $form->field($model, 'image')->widget(InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image', // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => false,
        ]);
        ?>


        <?php echo $form->field($model, 'status')->dropDownList($model->statusesLabels()) ?>
    </fieldset>
    <fieldset class="col-md-5">
        <legend>Цены</legend>
        <?php echo $form->field($model, 'price_1')->textInput() ?>

        <?php echo $form->field($model, 'price_3')->textInput() ?>

        <?php echo $form->field($model, 'price_24')->textInput() ?>
    </fieldset>


    <fieldset class="col-md-5">
        <?php
        echo $form->field($model, 'confRoomFeatures')
            ->checkboxList($features)
        ?>
    </fieldset>
    <div class="clearfix"></div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if(isset($this->blocks['content-header'])) { ?>
            <h1><?php echo $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                }
                ?>
            </h1>
        <?php } ?>

        <?php
        echo Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        )
        ?>
    </section>

    <section class="content">
<?php echo $content ?>
    </section>
</div>

<footer class="main-footer">
    <strong>Copyright &copy; 2016 UkrTour.</strong> All rights reserved.
</footer>

<div class='control-sidebar-bg'></div>
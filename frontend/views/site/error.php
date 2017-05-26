<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;

$css = '.site-error {text-align: center;}';
$this->registerCss($css);
?>
<div class="site-error">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?php echo nl2br(Html::encode($message)) ?>
    </div>

    <p>
        <?php echo Yii::t('app', 'Сталася помилка під час обробки вашого запиту.') ?>
    </p>

</div>

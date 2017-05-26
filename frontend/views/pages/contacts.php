<?php

use yii\helpers\Url;

/**
 * Contacts page template
 * @var $this yii\web\View
 */
// title
$title       = $model->descr->title;
$this->title = $title;

// Meta Description
if(!empty($model->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $model->descr->meta_description
    ]);
}

// H1
if(empty($h1 = $model->descr->h1)) {
    $h1 = $title;
}
?>
<div id="gmap">
    <div class="overlay" onClick="style.pointerEvents = 'none'"></div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2540.4760587742207!2d30.594889315731354!3d50.450859179475415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cfee23267735%3A0x27e99da6d44b1778!2z0LLRg9C70LjRhtGPINCg0LDRl9GB0Lgg0J7QutGW0L_QvdC-0ZcsIDIsINCa0LjRl9CyLCAwMjAwMg!5e0!3m2!1suk!2sua!4v1478868758986" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<section id="main">
    <h1><?php echo $h1 ?></h1>
    <p class="line2">
        <?php echo Yii::t('app', 'Оставьте Ваши контакты и наши сотрудники свяжутся с Вами!') ?>
    </p>
    <div class="row">
        <div id="contacts" class="row col s12 m7">
            <div class="contact col s12 m6 l4 center-align">
                <div class="name">
                    <?php echo Yii::t('app', 'оператор') ?>
                </div>
                <div>
                    <a href="tel:0800211050" class="phone waves-effect btn-flat"
                               title="<?php echo Yii::t('app', 'Зателефонувати') ?>">
                        0(800) 211-050
                    </a>
                </div>
                <div>
                    <a href="mail-to:info@ukrtour.pro" class="mail waves-effect btn-flat"
                               title="<?php echo Yii::t('app', 'Написати') ?>">
                        info@ukrtour.pro
                    </a>
                </div>
            </div>
            <div class="contact col s12 m6 l4 center-align">
                <div class="name">
                    <?php echo Yii::t('app', 'бухгалтерія') ?>
                </div>
                <a href="tel:+380445684014" class="phone waves-effect btn-flat"
                           title="<?php echo Yii::t('app', 'Зателефонувати') ?>">
                    +38(044)568-40-14
                </a>
                <a href="mail-to:manager@ukrtour.pro" class="mail waves-effect btn-flat" 
                           title="<?php echo Yii::t('app', 'Написати') ?>">
                    manager@ukrtour.pro
                </a>
            </div>
            <div class="contact col s12 m6 l4 center-align">
                <div class="name">
                    <?php echo Yii::t('app', 'маркетинг') ?>
                </div>
                <a href="tel:+380445684213" class="phone waves-effect btn-flat"
                           title="<?php echo Yii::t('app', 'Зателефонувати') ?>">
                    +38(044)568-42-13
                </a>
                <a href="mail-to:marketing@ukrtour.pro" class="mail waves-effect btn-flat"
                           title="<?php echo Yii::t('app', 'Написати') ?>">
                    marketing@ukrtour.pro
                </a>
            </div>
        </div>
        <div id="feedback" class="row col s12 m5">
            <form id="feedbackForm" class="col s12 center-align" name="feedback"
                  action="<?php echo Url::to(['feedback/feedback']) ?>" method="post">
                <input id="feedback-name" type="text" name="name" class="text-field" 
                       placeholder="<?php echo Yii::t('app', 'Ваше ім\'я') ?>" required>
                <br>
                <input id="feedback-email" type="email" name="email" class="text-field" 
                       placeholder="<?php echo Yii::t('app', 'Ваш e-mail') ?>">
                <br>
                <input id="feedback-phone" type="text" name="phone" class="text-field" 
                       placeholder="<?php echo Yii::t('app', 'Ваш телефон') ?>">
                <br>
                <button type="submit" class="submit waves-effect waves-light btn-flat">
                    <?php echo Yii::t('app', 'зв\'язатися з нами') ?>
                </button>
            </form>
            <div id="result"></div>
        </div>
    </div>
    <div class="text">
        <?php
        if(!empty($model->descr->text)) {
            echo $model->descr->text;
        }
        ?>
    </div>
</section>
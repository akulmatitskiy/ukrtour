<?php

use yii\helpers\Url;
use frontend\models\MenuItems;

/**
 * Footer template
 */
// Menu items
if(empty($menuItems)) {
    $menuItems = MenuItems::getMainMenu();
}
?>
<div id="footer-top" class="row">
    <div id="footer-top-left" class="col m8 l6 hide-on-small-only">
        <nav id="footer-main">
            <?php foreach($menuItems as $item) { ?>
                <a href="<?php echo $item['url'] ?>" title="<?php echo $item['title'] ?>"
                   class="waves-effect waves-light btn-flat">
                       <?php echo $item['name'] ?>
                </a>
            <?php } ?>
        </nav>
        <div id="footer-search-m" class="row hide-on-large-only">
            <form action="<?php echo Url::to(['search/index']) ?>">
                <div class="input-field">
                    <input id="search-input" name="q" type="text">
                    <label for="search-input"><?php echo Yii::t('app', 'Пошук') ?></label>
                </div>
            </form>
        </div>
    </div>
    <div id="footer-contacts" class="col s12 m4 l3">
        <div class="hide-on-small-only">
            <?php echo Yii::t('app', 'Центральний відділ бронювання') ?>
        </div>
        <div class="phone">
            <?php echo Yii::$app->params['phone'] ?>
        </div>
        <div class="callback">
            <i class="material-icons">local_phone</i>
            <button class="waves-effect waves-light btn-flat"
                    onclick="callback();"
                    title="<?php echo Yii::t('app', 'Замовити зворотній дзвінок') ?>">
                        <?php echo Yii::t('app', 'Замовити зворотній дзвінок') ?>
            </button>
        </div>
        <div class="social social-m hide-on-med-and-up center-align">
            <a class="icon instagram waves-effect" 
               href="<?php echo Yii::$app->params['instagram'] ?>"
               target="_blank" rel="nofollow" title="Instagram">
            </a>
            <a class="icon facebook waves-effect" 
               href="<?php echo Yii::$app->params['facebook'] ?>"
               target="_blank" rel="nofollow" title="Facebook">
            </a>
            <a class="icon tripadvisor waves-effect" 
               href="<?php echo Yii::$app->params['tripadvisor'] ?>"
               target="_blank" rel="nofollow" title="Tripadvisor">
            </a>
            <a class="icon ok waves-effect" 
               href="<?php echo Yii::$app->params['ok'] ?>"
               target="_blank" rel="nofollow" title="Одноклассники">
            </a>
            <a class="icon vk waves-effect" 
               href="<?php echo Yii::$app->params['vk'] ?>"
               target="_blank" rel="nofollow" title="ВКонтакте">
            </a>
        </div>
    </div>
    <!-- search input -->
    <div id="footer-search" class="row col m12 l3 hide-on-med-and-down">
        <form action="<?php echo Url::to(['search/index']) ?>">
            <div class="input-field">
                <input id="search-input" name="q" type="text">
                <label for="search-input"><?php echo Yii::t('app', 'Пошук') ?></label>
            </div>
        </form>
    </div>
</div>
<!-- /search input -->
<div id="footer-bottom" class="row valign-wrapper">
    <div id="copyright" class="row col s12 m7 l6 valign-wrapper">
        <div class="col s12 m5 l5 valign">
            <img id="footer-logo" src="/theme/img/logo-sm.png" alt="Ukrtour.ua" 
                 width="45" height="45">
            <div class="name">
                UKRTOUR.PRO
            </div>
        </div>
        <div class="col s12 m7 l7 valign">
            <?php echo Yii::t('app', 'Всі права захищені') ?> &copy; 2016 Ukrtour.ua
        </div>
    </div>
    <div class="col m4 l6 hide-on-small-only right-align valign">
        <div class="social">
            <div class="label hide-on-med-only valign">
                <?php echo Yii::t('app', 'Додавайте нас в соціальних мережах:') ?>
            </div>
            <a class="icon instagram waves-effect waves-light" 
               href="<?php echo Yii::$app->params['instagram'] ?>"
               target="_blank" rel="nofollow" title="Instagram">
            </a>
            <a class="icon facebook waves-effect waves-light" 
               href="<?php echo Yii::$app->params['facebook'] ?>"
               target="_blank" rel="nofollow" title="Facebook">
            </a>
            <a class="icon tripadvisor waves-effect waves-light" 
               href="<?php echo Yii::$app->params['tripadvisor'] ?>"
               target="_blank" rel="nofollow" title="Tripadvisor">
            </a>
            <a class="icon ok waves-effect" 
               href="<?php echo Yii::$app->params['ok'] ?>"
               target="_blank" rel="nofollow" title="Одноклассники">
            </a>
            <a class="icon vk waves-effect" 
               href="<?php echo Yii::$app->params['vk'] ?>"
               target="_blank" rel="nofollow" title="ВКонтакте">
            </a>
        </div>
    </div>
</div>
<a id="to-top" href="#header" class="hide-on-med-and-up">
    <i class="material-icons">keyboard_arrow_up</i>
</a>
<div id="callback" class="modal"></div>

<?php

use yii\helpers\Url;
use frontend\models\MenuItems;
use common\models\Languages;

/**
 * Header template
 */
// Menu items
if(empty($menuItems)) {
    $menuItems = MenuItems::getMainMenu();
}

// Current lang
$langIso3 = Languages::getIsoCode(null, 'iso3');
?>
<header id="header">
    <div class="row hide-on-small-only">
        <!-- logo -->
        <div id="logo" class="col m1 l2 valign-wrapper">
            <a id="logo-img" href="<?php echo Url::to(['site/index']) ?>" 
               title="Ukrtour.ua" class="valign">
                <img src="/theme/img/logo.png" width="108" height="108" alt="logo Ukrtour">
            </a>
            <a id="logo-text" class="valign hide-on-med-only" title="Ukrtour.pro" 
               href="<?php echo Url::to(['site/index']) ?>">
                Ukrtour.pro
            </a>
        </div>
        <!-- /logo -->
        <div id="header-right" class="row col m11 l10">
            <div id="top" class="row col s12">
                <!-- callback -->
                <div class="callback right">
                    <i class="material-icons">local_phone</i>
                    <button class="waves-effect waves-light btn-flat hide-on-med-and-down"
                            onclick="callback();"
                            title="<?php echo Yii::t('app', 'Замовити зворотній дзвінок') ?>">
                                <?php echo Yii::t('app', 'Замовити зворотній дзвінок') ?>
                    </button>
                </div>
                <!-- /callback -->
                <!-- lang switch -->
                <div id="lang" class="right">
                    <span class="dropdown-button btn-flat transparent lang lang-<?php echo $langIso3 ?>" data-activates="lang-switch">
                        <?php echo $langIso3 ?>
                        <i class="material-icons">keyboard_arrow_down</i>
                    </span>
                    <ul id="lang-switch" class="dropdown-content">
                        <li>
                            <a href="/" title="Українська" class="lang lang-ukr">
                                ukr
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/ru" title="Русский" class="lang lang-rus">
                                rus
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/en" title="English" class="lang lang-eng">
                                eng
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /lang switch -->
                <!-- social links -->
                <div class="social right">
                    <div class="label hide-on-small-only">
                        <?php echo Yii::t('app', 'Додавайте нас в соціальних мережах:') ?>
                    </div>
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
                <!-- /social links -->
            </div>
            <div id="top-menu" class="row col s12">
                <!-- main menu -->
                <nav id="menu-main" class="col">
                    <?php
                    foreach($menuItems as $item) {
                        if($item['url'] == Url::current()) {
                            $active = ' active';
                        } else {
                            $active = '';
                        }
                        ?>
                        <a href="<?php echo $item['url'] ?>" 
                           class="waves-effect waves-light btn-flat<?php echo $active ?>"
                           title="<?php echo $item['title'] ?>">
                               <?php echo $item['name'] ?>
                        </a>
                    <?php } ?>
                </nav>
                <!-- /main menu -->
                <div id="phone" class="col">
                    <div id="phone-number">
                        <?php echo Yii::$app->params['phone'] ?>
                    </div>
                    <div id="free-calls">
                        <?php echo Yii::t('app', 'дзвінки безкоштовні') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(\Yii::getAlias('@device') == 'mobile') { ?>
        <div id="header-mobile" class="row hide-on-med-and-up valign-wrapper">
            <div class="col s4 left-align valign">
                <i id="search-icon" class="material-icons">search</i>
                <form id="header-search" action="<?php echo Url::to(['search/index']) ?>">
                    <div class="input-field">
                        <label for="search-query-m">
                            <?php echo Yii::t('app', 'Пошук') ?>
                        </label>
                        <input id="search-query-m" type="text" name="q">
                    </div>
                    <i id="search-close" onclick="searchClose()" class="material-icons">close</i>
                </form>
            </div>
            <div id="logo-m" class="col s4 center-align valign">
                <a href="<?php echo Url::to(['site/index']) ?>" title="Ukrtour.pro">
                    <img src="/theme/img/logo-m.png" width="61" height="61" alt="logo Ukrtour">
                </a>
            </div>
            <div id="open-menu" class="col s4 right-align valign">
                <i class="material-icons">menu</i>
            </div>
        </div>
        <div id="menu-main-m" class="hide-on-med-and-up">
            <nav class="row center-align">
                <?php foreach($menuItems as $item) { ?>
                    <span class="col s12 center-align">
                        <a href="<?php echo $item['url'] ?>" title="<?php echo $item['title'] ?>">
                            <?php echo $item['name'] ?>
                        </a>
                    </span>
                <?php } ?>
            </nav>
            <div id="menu-close">
                <i class="material-icons">highlight_off</i>
            </div>
        </div>
    <?php } ?>
</header>
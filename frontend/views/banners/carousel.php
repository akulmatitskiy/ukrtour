<?php

/**
 * Carousel
 */
use yii\web\View;
use common\models\Languages;

$slick = '$(".banners").slick({
  dots: true,
  infinite: true,
  speed: 700,
  slidesToShow: 1,
  autoplay: true,
  autoplaySpeed: 3000,
  });';
View::registerJs($slick, View::POS_READY);


/**
 *  Booking
 */
// Lang
$langCode = Languages::getIsoCode();

// Get servio app
$servio = \SORApp\Components\App::getInstance();

// Set current lang
$servio->lang = $langCode;

// js
View::registerJsFile('/booking/static/js/jquery.datetimepicker.js');
View::registerJsFile('/booking/static/js/servio.' . $langCode . '.js');
View::registerJsFile('/booking/static/js/servio.js');
?>
<div id="carousel-wrapper" class="">
    <div id="booking" class="">
        <input id="form-token" form="servioSearchForm" type="hidden" 
               name="<?php echo Yii::$app->request->csrfParam ?>"
               value="<?php echo Yii::$app->request->csrfToken ?>">
               <?php
               // Booking widget
               echo $servio->runController('site', 'module', 'index')->send();

               // Init select
               $formJs = '$("select").material_select();';
               $this->registerJs($formJs, $this::POS_READY);
               ?>
    </div>
    <div id="carousel" class="banners"> 
        <?php foreach($banners as $banner) { ?>
            <div class="image ">
                <div class="banners-item valign-wrapper right-align" 
                     style="background-image: url(<?php echo $banner['img'] ?>);">
                    <div class="valign banner-text right-align">
                        <div class="type">
                            <?php echo $banner['type'] ?>
                        </div>
                        <div class="title">
                            <?php echo $banner['title'] ?>
                        </div>
                        <div class="description">
                            <?php echo $banner['description'] ?>
                        </div>
                        <div class="price">
                            <?php echo $banner['price'] ?>
                        </div>
                        <a href="<?php echo $banner['link'] ?>" 
                           class="waves-effect waves-white blue btn button-more" 
                           title="<?php echo Yii::t('app', 'Детальніше') ?>">
                               <?php echo Yii::t('app', 'Детальніше') ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <a id="button-skip" class="hide-on-small-only"  href="#carousel-end">
        <i class="material-icons">expand_more</i>
    </a>
</div>
<div id="carousel-end"></div>

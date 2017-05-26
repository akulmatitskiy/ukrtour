<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

// title
if(!empty($page->descr->h1)) {
    $title = $page->descr->title;
} else {
    $title = 'Ukrtour.pro';
}

$this->title = $title;

// H1
if(!empty($page->descr->h1)) {
    $h1 = $page->descr->h1;
} else {
    $h1 = $title;
}

// Text
$text = '';
if(!empty($page->descr->text)) {
    $text = $page->descr->text;
}

// Offers carousel
$offersCarousel = 'if($(document).width() < 600) {
        $("#offers").slick({
          infinite: true,
          speed: 300,
          slidesToShow: 1,
        });
    }';
$this->registerJs($offersCarousel, $this::POS_READY);
?>
<section id="main">
    <?php echo $this->render('/banners/carousel', ['banners' => $banners]) ?>
    <!-- categories -->
    <div id="categories" class="row">
        <?php foreach($categories as $categ) { ?>
            <div class="category col s12 m4" style="background-image: url(<?php echo $categ['image'] ?>)"
                 onclick="location.href = '<?php echo $categ['url'] ?>'">
                <div class="wrapper">
                    <div class="title">
                        <img src="<?php echo $categ['icon'] ?>" alt="<?php echo $categ['title'] ?>  " 
                             width="70" height="70" class="category-icon">
                        <a href="<?php echo $categ['url'] ?>" title="<?php echo $categ['title'] ?>  ">
                            <?php echo $categ['title'] ?>                  
                        </a>
                    </div>
                    <div class="text">
                        <?php echo $categ['annotation'] ?>  
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /categories -->

    <!-- map -->
    <div id="hotels-map" class="cont hide-on-small-only">
        <h2><?php echo Yii::t('app', 'Виберіть напрямок') ?></h2>
        <div id="map"></div>
        <div id="hotels">
            <!-- hotels: city -->
            <?php foreach($map['items'] as $item) { ?>
                <div id="<?php echo $item['id'] ?>" class="hotel card">
                    <div class="header" style="background-image: url(<?php echo $item['image'] ?>)">
                        <div class="background valign-wrapper">
                            <div class="valign">
                                <a href="<?php echo $item['url'] ?>" 
                                   class="waves-effect waves-blue btn-flat">
                                    <i class="material-icons">visibility</i>
                                </a>
                                <a href="<?php echo $item['url'] ?>" 
                                   class="waves-effect waves-blue btn-flat" 
                                   title="<?php echo Yii::t('app', 'Детальніше') ?>">
                                       <?php echo Yii::t('app', 'Детальніше') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper">
                        <div class="title">
                            <strong>
                                <?php echo $item['city'] ?>:
                            </strong>
                            &nbsp;<?php echo $item['name'] ?>
                            <?php if($item['rating'] > 0) { ?>
                                <div class="stars">
                                    <?php for($i = 0; $i > $item['rating']; $i++) { ?>
                                        <i class="material-icons">star</i>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="text">
                            <?php echo $item['text'] ?>
                        </div>
                        <?php if($item['type'] == 'hotel') { ?>
                            <a href="<?php echo Url::to(['/search-rooms/' . $item['id']]) ?>" 
                               class="waves-effect waves-blue btn-flat button-more" 
                               title="<?php echo Yii::t('app', 'Забронювати') ?>">
                                   <?php echo Yii::t('app', 'Забронювати') ?>
                            </a>
                        <?php } elseif($item['type'] == 'hostel') { ?>
                            <button onclick="showReserve('hostel', '<?php echo $item['hostelId'] ?>')"
                                    class="waves-effect waves-blue btn-flat button-more">
                                <div id="action-<?php echo $item['hostelId'] ?>" 
                                     data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>"
                                     data-error="<?php echo Yii::t('app', 'Помилка') ?>">
                                    <?php echo Yii::t('app', 'Забронювати') ?>
                                </div>
                            </button>
                        <?php } ?>
                        <a href="<?php echo $item['url'] ?>" 
                           title="<?php echo Yii::t('app', 'Детальніше') ?>" 
                           class="waves-effect waves-blue btn-flat button-more">
                               <?php echo Yii::t('app', 'Детальніше') ?>
                        </a>
                    </div>
                    <button class="waves-effect waves-circle waves-light btn-floating transparent button-close"
                            onclick="hideHotel('<?php echo $item['id'] ?>');">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
            <?php } ?>

            <!-- /hotels: city -->
            <!-- hotels: regions -->
            <?php foreach($map['regions'] as $region) { ?>
                <div id="<?php echo $region['id'] ?>" class="hotels-list card">
                    <div class="header valign-wrapper center-align">
                        <div class="valign">
                            <?php echo $region['title'] ?>
                        </div>
                    </div>
                    <div class="wrapper">
                        <?php foreach($region['items'] as $item) { ?>
                            <div class="hotel-item">
                                <a href="<?php echo $item['url'] ?>"
                                   class="title<?php echo ($item['rating'] > 0) ? ' w-stars' : '' ?>"
                                   title="<?php echo $item['name'] ?>">
                                       <?php echo $item['name'] ?>
                                </a>
                                <?php if($item['rating'] > 0) { ?>
                                    <div class="stars">
                                        <?php for($i = 0; $i > $item['rating']; $i++) { ?>
                                            <i class="material-icons">star</i>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="waves-effect waves-circle waves-light btn-floating transparent button-close"
                            onclick="hideHotel('<?php echo $region['id'] ?>');">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
            <?php } ?>
            <!-- /hotels: regions -->
        </div>
        <div id="reserve-modal" class="modal"></div>
    </div>
    <!-- /map -->

    <!-- offers -->
    <?php if(!empty($offers)) { ?>
    <section id="offers-container" class="cont row center-align">
        <h2 class="center-align">
            <?php echo Yii::t('app', 'Акції') ?>
        </h2>
        <div id="offers" class="col s12 left-align">
            <?php echo $this->render('/offers/list', ['offers' => $offers]); ?>
        </div>
        <button id="offers-show-all" 
                class="button-see-all waves-effect waves-light blue btn hide-on-small-only">
                    <?php echo Yii::t('app', 'Показати всі акції') ?>
        </button>
    </section>
    <?php } ?>
    <!-- offers -->

    <!-- text -->
    <div id="text" class="cont" hide-xs>
        <h1><?php echo $h1 ?></h1>
        <?php echo $text ?>
    </div>
    <!-- /text -->
</section>
<?php
/**
 * Map
 * Hide for mobile
 */
//if(Yii::getAlias('@device') != 'mobile') {
    //  map js
    $this->registerJsFile('http://d3js.org/d3.v3.min.js');
    $this->registerJsFile('http://d3js.org/topojson.v1.min.js');
    $this->registerJsFile('/theme/js/map.js');


// Map css
    $css = '';
    foreach($regionsRating as $regionId => $rate) {
        $css .= '#' . $regionId . ' {fill-opacity: ' . $rate . ';} ';
    }
    $this->registerCss($css);
//}
?>

<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use mp\bmicrodata\BreadcrumbsUtility;
use common\models\Languages;

// Title
if(empty($hotel->descr->title)) {
    $title = 'Hotel';
} else {
    $title = $hotel->descr->title;
}

// City  name
if(!empty($hotel->servioCity->name)) {
    $this->params['breadcrumbs'][] = [
        'label' => $hotel->servioCity->name,
        'url' => null
    ];
}

// Breadcrumbs
$this->title                   = $title;
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['hotels/view', 'slug' => $hotel->descr->slug]
];

// Meta title
$this->title = $title;

// Meta Description
if(!empty($hotel->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $hotel->descr->meta_description
    ]);
}

// h1
if(empty($hotel->descr->h1)) {
    $h1 = $title;
} else {
    $h1 = $hotel->descr->h1;
}

// Distanses
$showDistanses = false;
if(!empty($hotel->dist_aero) || !empty($hotel->dist_raiway) || !empty($hotel->dist_avto)) {
    $showDistanses = true;
}

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
$this->registerJsFile('/booking/static/js/jquery.datetimepicker.js');
$this->registerJsFile('/booking/static/js/servio.' . $langCode . '.js');
$this->registerJsFile('/booking/static/js/servio.js');

// Get rooms
$this->registerJs('getRooms("'. $hotel->id . '", "'
    . $langCode. '", "'. $params. '");');

// Slick
$slick = '$(".hotel-carousel").slick({
  dots: false,
  infinite: true,
  dragable: true,
  speed: 700,
  slidesToShow: 1,
  autoplay: true,
  autoplaySpeed: 5000,
  appendArrows: "#carousel-nav",
  });';
$this->registerJs($slick, $this::POS_READY);

// Lightbox
$this->registerJsFile('/theme/js/lightbox.min.js', [
    'depends' => 'yii\web\YiiAsset'
]);
$lightbox = 'lightbox.option({"showImageNumberLabel": false})';
$this->registerJs($lightbox, $this::POS_END);
$this->registerCssFile('/theme/css/lightbox.min.css');
?>
<div id="carousel-hotel">
    <div id="carousel-hotel-images" class="images hotel-carousel">
        <?php foreach($banners as $banner) { ?>
            <div class="banners-item" style="background-image: url('<?php echo $banner['url'] ?>')"></div>
        <?php } ?>
    </div>
    <div class="wrapper">
        <div class="name">
            <?php echo $hotel->servioCity->name . ' ' . $hotel->servioName->name ?>
        </div>
        <div class="stars" layout="row" layout-align="center center">
            <?php for($stars = 0; $stars < $hotel->rating; $stars++) { ?>
                <i class="material-icons">star</i>
            <?php } ?>
        </div>
        <div class="address">
            <span class="hide-on-small-only">
                <?php echo $hotel->descr->address ?>
            </span>
            <?php if(!empty($hotel->phone)) { ?>
                <?php foreach(explode(',', $hotel->phone) as $phone) { ?>
                    <a class="phone" href="tel:<?php echo preg_replace('/[^0-9\+]/i', '', $phone) ?>" title="<?php echo Yii::t('app', 'Зателефонувати') ?>">
                        <?php echo $phone ?>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="gallery">
            <?php foreach($banners as $banner) { ?>
                <span>
                    <a href="<?php echo $banner['url'] ?>" data-lightbox="gallery">
                        <img src="<?php echo $banner['thumbUrl'] ?>" class="img-thumbnail"
                             width="82" height="62" alt="<?php echo $banner['alt'] ?>">
                    </a>
                </span>
            <?php } ?>
            <span id="photo-all">
                <a href="/gallery/hotel/<?php echo $hotel->id ?>" 
                   class="waves-effect waves-light btn-flat hide-on-small-only" 
                   title="<?php echo Yii::t('app', 'Переглянути всі фото') ?>">
                       <?php echo Yii::t('app', 'Всі фото') ?>
                </a>
            </span>
        </div>
        <div id="carousel-nav"></div>
    </div>
</div>
<?php
echo Breadcrumbs::widget([
    'homeLink' => BreadcrumbsUtility::getHome(Yii::t('app', 'Головна'), Yii::$app->getHomeUrl()), // Link home page with microdata
    'links' => isset($this->params['breadcrumbs']) ? BreadcrumbsUtility::UseMicroData($this->params['breadcrumbs']) : [], // Get other links with microdata    
    'options' => [ // Set microdata for container BreadcrumbList     
        'id' => 'breadcrumbs',
        'itemscope itemtype' => 'http://schema.org/BreadcrumbList'
    ],
]);
?>
<section id="main" class="row">
    <div id="booking" class="col s12 m4">
        <input id="form-token" form="servioSearchForm" type="hidden" 
               name="<?php echo Yii::$app->request->csrfParam ?>"
               value="<?php echo Yii::$app->request->csrfToken ?>">
               <?php
               // Booking widget
               echo $servio->runController('site', 'module', 'index')->send();

               // Current hotel id
               $formJs = '$("#servioHotelId").val(' . $hotel->id . ');';
               
               // tourist tax
               if($isTouristTax) {
                   $formJs .= '$("#servioTouristTax").prop("checked", true);';
               }
               
               // Init select
               $formJs .= '$("select").material_select();';
               $this->registerJs($formJs, $this::POS_READY);
               ?>
    </div>
    <div id="description" class="col s12 m8">
        <h1><?php echo $h1 ?></h1>
        <div class="text">
            <?php
            if(!empty($hotel->descr->description)) {
                echo $hotel->descr->description;
            }
            ?>
        </div>
        <?php if(!empty($hotel->features)) { ?>
            <div class="features row">
                <?php foreach($hotel->features as $feature) { ?>
                    <div class="col s6 l4">
                        <i class="material-icons">
                            <?php echo $feature->feature->icon ?>
                        </i>
                        <?php echo $feature->descr->title ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if($showDistanses) { ?>
            <div id="distances-wrapper">
                <div id="distances-title">
                    <?php echo Yii::t('app', 'Відстань до готелю від') ?>
                </div>
                <div id="distances" class="row">
                    <?php if(!empty($hotel->dist_aero)) { ?>
                        <div class="distance col s4 l2">
                            <div class="title">
                                &hellip;&nbsp;<?php echo Yii::t('app', 'аэропорту') ?>
                            </div>
                            <div class="value">
                                <?php echo $hotel->dist_aero . '&nbsp;' . Yii::t('app', 'км') ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if(!empty($hotel->dist_railway)) { ?>
                        <div class="distance col s4 l2">
                            <div class="title">
                                &hellip;&nbsp;<?php echo Yii::t('app', 'з/д вокзалу') ?>
                            </div>
                            <div class="value">
                                <?php echo $hotel->dist_railway . '&nbsp;' . Yii::t('app', 'км') ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if(!empty($hotel->dist_avto)) { ?>
                        <div class="distance col s4 l2">
                            <div class="title">
                                &hellip;&nbsp;<?php echo Yii::t('app', 'авто-вокзалу') ?>
                            </div>
                            <div class="value">
                                <?php echo $hotel->dist_avto . '&nbsp;' . Yii::t('app', 'км') ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col s12 l6 center-align" id="button-map">
                        <?php if(!empty($hotel->descr->map)) { ?>
                            <a href="<?php echo $hotel->descr->map ?>" target="_blank"
                               class="waves-effect waves-light btn blue">
                                   <?php echo Yii::t('app', 'Переглянути маршрути на мапі') ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<section id="rooms-container" class="center-align">
    <div class="preloader-wrapper active valign-wrapper ">
        <div class="spinner-layer spinner-blue-only valign">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</section>
<?php if(!empty($rooms)) { ?>
    <section id="conference-rooms" class="row">
        <hr>
        <h2>
            <?php echo Yii::t('app', 'до Вашої уваги також пропонуєм конференц-зали') ?>
        </h2>
        <div class="row col s12 m10" data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>">
            <?php foreach($rooms as $room) { ?>
                <div class="room card col s12 m6">
                    <img src="<?php echo $room['image'] ?>" alt="<?php echo $room['name'] ?>" 
                         class="image" width="275" height="215">
                    <div class="wrapper row right">
                        <div class="name row">
                            <?php echo $room['name'] ?>
                        </div>
                        <div class="features row right-align">
                            <?php foreach($room['features'] as $feature) { ?>
                                <i class="material-icons" title="<?php echo $feature['title'] ?>">
                                    <?php echo $feature['icon'] ?>
                                </i>
                            <?php } ?>
                        </div>
                        <div class="prices row">
                            <?php foreach($room['prices'] as $price) { ?>
                                <div class="col right">
                                    <div class="price">
                                        <?php echo $price['price'] . '&nbsp;' . Yii::t('app', 'грн') ?>
                                    </div>
                                    <div class="term">
                                        <?php echo $price['term'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <button onclick="showReserve('room', '<?php echo $room['id'] ?>')" 
                                class="waves-effect waves-light btn button-booking">
                            <span data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>"
                                  date-error="<?php echo Yii::t('app', 'Помилка') ?>">
                                      <?php echo Yii::t('app', 'Забронювати') ?>
                            </span>
                        </button>

                    </div>
                </div>
            <?php } ?>
        </div>
        <div id="reserve-modal" class="modal"></div>
    </section>
<?php } ?>

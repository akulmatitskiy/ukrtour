<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use mp\bmicrodata\BreadcrumbsUtility;
use common\models\Languages;

// Title
$title       = $hostel->descr->title;
$this->title = $hostel->descr->title;

// Breadcrumbs
if(!empty($category)) {
    $this->params['breadcrumbs'][] = [
        'label' => $category->descr->title,
        'url' => ['categories/view', 'slug' => $category->descr->slug]
    ];
}
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['hostels/view', 'slug' => $hostel->descr->slug]
];

// Meta Description
if(!empty($hostel->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $hostel->descr->meta_description
    ]);
}

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
            <div class="banners-item" 
                 style="background-image: url('<?php echo $banner['url'] ?>')">
            </div>
        <?php } ?>
    </div>
    <div class="wrapper">
        <div class="name">
            <h1><?php echo $hostel->descr->title ?></h1>
        </div>
        <div class="address">
            <span class="hide-on-small-only">
                <?php echo $hostel->descr->address ?>
            </span>
            <?php if(!empty($hostel->phone)) { ?>
                <?php foreach(explode(',', $hostel->phone) as $phone) { ?>
                    <a class="phone" href="tel:<?php echo preg_replace('/[^0-9\+]/i', '', $phone) ?>" title="<?php echo Yii::t('app', 'Зателефонувати') ?>">
                        <?php echo $phone ?>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
        <?php if(!empty($banners)) { ?>
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
                    <a href="/gallery/hostel/<?php echo $hostel->id ?>" 
                       class="waves-effect waves-light btn-flat hide-on-small-only" 
                       title="<?php echo Yii::t('app', 'Переглянути всі фото') ?>">
                           <?php echo Yii::t('app', 'Всі фото') ?>
                    </a>
                </span>
            </div>
        <?php } ?>
        <div id="carousel-nav"></div>
    </div>
</div>
<?php
echo Breadcrumbs::widget([
    'homeLink' => BreadcrumbsUtility::getHome(Yii::t('app', 'Головна'), Yii::$app->getHomeUrl()), // Link home page with microdata
    'links' => isset($this->params['breadcrumbs']) ? BreadcrumbsUtility::UseMicroData($this->params['breadcrumbs']) : [], // Get other links with microdata    
    'options' => [ // Set microdata for container BreadcrumbList     
        'id' => 'breadcrumbs',
        'class' => 'breadcrumb',
        'itemscope itemtype' => 'http://schema.org/BreadcrumbList'
    ],
]);
?>
<section id="main">
    <div>
        <?php
        if(!empty($hostel->descr->description)) {
            echo $hostel->descr->description;
        } else {
            ?>
            <div id="offer-image">
                <img src="<?php echo $hostel->image ?>" alt="<?php echo $hostel->descr->title ?>">
            </div>
        <?php } ?>
    </div>
    <div id="confroom-booking">
        <button onclick="showReserve('hostel', '<?php echo $hostel->id ?>')"
                class="waves-effect waves-light blue btn-flat button-booking">
            <span id="action-<?php echo $hostel->id ?>" 
                  data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>"
                  data-error="<?php echo Yii::t('app', 'Помилка') ?>">
                      <?php echo Yii::t('app', 'Забронювати') ?>
            </span>
        </button>
    </div>
    <div id="reserve-modal" class="modal"></div>
</section>
<?php if(!empty($confRooms)) { ?>
    <section id="conference-rooms" class="row">
        <hr>
        <h2>
            <?php echo Yii::t('app', 'до Вашої уваги також пропонуєм конференц-зали') ?>
        </h2>
        <div class="row col s12" data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>">
            <?php foreach($confRooms as $room) { ?>
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
    </section>
<?php } ?>

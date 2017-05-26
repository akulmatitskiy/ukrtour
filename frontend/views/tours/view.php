<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use mp\bmicrodata\BreadcrumbsUtility;
use common\models\Languages;

// Title
$title       = $tour->descr->title;
$this->title = $tour->descr->title;

// Breadcrumbs
if(!empty($category)) {
    $this->params['breadcrumbs'][] = [
        'label' => $category->descr->title,
        'url' => ['categories/view', 'slug' => $category->descr->slug]
    ];
}
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['tours/view', 'slug' => $tour->descr->slug]
];

// Meta Description
if(!empty($tour->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $tour->descr->meta_description
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
            <h1><?php echo $tour->descr->title ?></h1>
        </div>
        <div class="address">
            <?php if(!empty($tour->phone)) { ?>
                <?php foreach(explode(',', $tour->phone) as $phone) { ?>
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
                    <a href="/gallery/tour/<?php echo $tour->id ?>" 
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
<section id="main" ng-controller="ConfRoomCtrl" data-item-id="<?php echo $tour->id ?>" data-type="tour" data-lang="<?php echo \common\models\Languages::getIsoCode() ?>">
    <div>
        <?php
        if(!empty($tour->descr->description)) {
            echo $tour->descr->description;
        } else {
            ?>
            <div id="offer-image">
                <img src="<?php echo $tour->image ?>" alt="<?php echo $tour->descr->title ?>">
            </div>
        <?php } ?>
    </div>
    <div id="confroom-booking">
        <button onclick="showReserve('tour', '<?php echo $tour->id ?>')"
                class="waves-effect waves-light blue btn-flat button-booking">
            <span id="action-<?php echo $tour->id ?>" 
                  data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>"
                  data-error="<?php echo Yii::t('app', 'Помилка') ?>">
                      <?php echo Yii::t('app', 'Забронювати') ?>
            </span>
        </button>
    </div>
    <div id="reserve-modal" class="modal"></div>
</section>

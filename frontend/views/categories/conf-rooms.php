<?php
/* @var $this yii\web\View */

// Meta title
$metaTitle = $category->descr->meta_title;
if(empty($metaTitle)) {
    $metaTitle = $category->descr->title;
}
$this->title = $metaTitle;

// Meta Description
if(!empty($category->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $category->descr->meta_description
    ]);
}


$h1 = Yii::t('app', 'Наші послуги');
if(!empty($category->descr->h1)) {
    $h1 = $category->descr->h1;
}
?>
<?php echo $this->render('/banners/carousel', ['banners' => $banners]) ?>
<section id="services" class="row">
    <h1><?php echo $h1 ?></h1>
    <ul id="services-icons" class="row">
        <li id="classroom" class="col s3">
            <?php printf(Yii::t('app', 'Зал на %d осіб'), 200) ?>
        </li>
        <li id="microphone" class="col s3">
            <?php echo Yii::t('app', 'Звукове обладнання') ?>
        </li>
        <li id="movie-projector" class="col s3">
            <?php echo Yii::t('app', 'Відеопроектор') ?>
        </li>
        <li id="training" class="col s3">
            <?php echo Yii::t('app', 'Інтерактівна дошка') ?>
        </li>
        <li id="waiter" class="col s3">
            <?php echo Yii::t('app', 'Кейтеринг') ?>
        </li>
        <li id="van" class="col s3">
            <?php echo Yii::t('app', 'Трансфери') ?>
        </li>
        <li id="language" class="col s3">
            <?php echo Yii::t('app', 'Синхронний переклад') ?>
        </li>
        <li id="wifi" class="col s3">
            <?php echo Yii::t('app', 'Швидкісний інтернет') ?>
        </li>
    </ul>
    <!-- text -->
    <div>
        <?php
        if(!empty($category->descr->text)) {
            echo $category->descr->text;
        }
        ?>
    </div>
    <div id="text-after" hide-xs>
        <?php
        echo Yii::t(
            'app', '{n, plural, one{... які ми надаємо в # місті} '
            . 'few{... які ми надаємо в # містах} '
            . 'many{... які ми надаємо в # містах} '
            . 'other{... які ми надаємо в # місті}}', ['n' => $citiesQuantity]
        );
        ?>
    </div>
    <!-- /text -->
    <div id="services-hotels">
        <?php echo $this->render('/conf-rooms/list', ['rooms' => $rooms])?>
        <div id="all-rooms" class="city-hotel center-align">
            <button id="conf-rooms-show-all"  
                       class="button-see-all waves-effect waves-light blue btn">
                <?php echo Yii::t('app', 'відобразити більше') ?>
            </button>
        </div>
    </div>
</section>

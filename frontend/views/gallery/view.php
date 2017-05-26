<?php
/* @var $this yii\web\View */
$this->title = $gallery['title'] . ' | ' . Yii::t('app', 'Фото галерея');
// Lightbox
$this->registerJsFile('/theme/js/lightbox.min.js', [
    'depends' => 'yii\web\YiiAsset'
]);
$lightbox = 'lightbox.option({"showImageNumberLabel": false})';
$this->registerJs($lightbox, $this::POS_END);
$this->registerCssFile('/theme/css/lightbox.min.css');

?>
<h1><?php echo $gallery['title'] ?></h1>
<div id="gallery"  data-gallery="<?php echo $gallery['id'] ?>" data-type="<?php echo $gallery['type'] ?>">
    <?php foreach($images as $image) { ?>
        <span>
            <a href="<?php echo $image['url'] ?>" title="<?php echo $gallery['title'] ?>"
               data-lightbox="gallery">
                <img src="<?php echo $image['thumbUrl'] ?>" class="img-thumbnail"
                     width="300" height="255" alt="<?php echo $gallery['title'] ?>">
            </a>
        </span>
    <?php } ?>

</div>

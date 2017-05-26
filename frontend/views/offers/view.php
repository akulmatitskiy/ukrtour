<?php
/**
 * Offer page template
 * @var $this yii\web\View
 */


// title
$this->title = $offer->descr->title;

// Meta Description
if(!empty($offer->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $offer->descr->meta_description
    ]);
}
?>
<section id="main" data-room-id="<?php echo $offer->id ?>">
    <h1><?php echo $offer->descr->title ?></h1>
    <div>
        <?php
        if(!empty($offer->descr->text)) {
            echo $offer->descr->text;
        } else {
            ?>
            <div id="offer-image">
                <img src="<?php echo $offer->image ?>" alt="<?php echo $offer->descr->title ?>">
            </div>
        <?php } ?>
    </div>
</section>
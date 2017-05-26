<?php
/* @var $this yii\web\View */

// title
if(!empty($room->descr->title)) {
    $title = $room->descr->title;
} else {
    $title = $room->descr->name;
}
$this->title = $title;

// Meta Description
if(!empty($room->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $room->descr->meta_description
    ]);
}
?>
<section id="main">
    <h1><?php echo $room->descr->name ?></h1>
    <div>
        <div id="conf-room-features" class="features center-align">
            <div id="roominess"><?php echo $roominess ?></div>
            <div class="center-align">
                <?php foreach($room->features as $feature) { ?>
                    <i class="material-icons" title="<?php echo $feature->descr->title ?>">
                        <?php echo $feature->feature->icon ?>
                    </i>
                <?php } ?>
            </div>
        </div>
        <div id="conf-room-prices" class="center-align">
            <?php foreach($prices as $price) { ?>
                <div>
                    <div class="price">
                        <?php echo $price['price'] . '&nbsp;' . Yii::t('app', 'грн') ?>
                    </div>
                    <div class="term">
                        <?php echo $price['term'] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        if(!empty($room->descr->description)) {
            echo $room->descr->description;
        } else {
            ?>
            <div id="confroom-image">
                <img src="<?php echo $room->image ?>" alt="<?php echo $room->descr->name ?>">
            </div>
        <?php } ?>
    </div>
    <div id="confroom-booking">
        <button onclick="showReserve('room', '<?php echo $room->id ?>')"
                class="waves-effect waves-light blue btn-flat button-booking">
            <span id="action-<?php echo $room->id ?>" 
                 data-success="<?php echo Yii::t('app', 'Успішно надіслано') ?>"
                 data-error="<?php echo Yii::t('app', 'Помилка') ?>">
                     <?php echo Yii::t('app', 'Забронювати') ?>
            </span>
        </button>
    </div>
    <div id="reserve-modal" class="modal"></div>
</section>

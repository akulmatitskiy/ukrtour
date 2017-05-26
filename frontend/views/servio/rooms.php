<?php

use common\models\Languages;
use frontend\models\Rooms;

/* @var $this yii\web\View */

$i   = 1;
$all = Yii::$app->params['showRooms'];

// Lang
$langIso = Languages::getIsoCode();

$features = Rooms::getRoomsFeatures($hotel);
?>
<?php if(!empty($rooms)) { ?>
    <div id="rooms-header" class="row">
        <h2 class="col left"><?php echo Yii::t('app', 'Наші номери') ?></h2>
        <div id="sort" class="input-field right col">
            <select id="sort-select">
                <option value="price-asc"><?php echo Yii::t('app', 'зростанням ціни') ?></option>
                <option value="price-desc"><?php echo Yii::t('app', 'спаданням ціни') ?></option>
                <option value="beds-asc"><?php echo Yii::t('app', 'зростанням кількості місць') ?></option>
                <option value="beds-desc"><?php echo Yii::t('app', 'спаданням кількості місць') ?></option>
            </select>
            <label id="sort-title" for="sort-select" class="hide-on-small-only">
                <?php echo Yii::t('app', 'Сортувати за ') ?>
            </label>
        </div>
    </div>
    <div id="rooms" class="row">
        <?php foreach($rooms as $room) { ?>
            <div class="room card col s12 l6<?php echo ($i++ > $all ) ? ' hide' : ''; ?>">
                <img src="<?php echo $room['image'] ?>" alt="<?php echo $room['name'] ?>" 
                     class="image" width="355" height="338">
                <div class="name">
                    <?php echo $room['name'] ?>
                </div>
                <div class="price">
                    <?php echo Yii::t('app', 'від') ?>&nbsp;
                    <?php echo $room['price'] ?>&nbsp;
                    <?php echo Yii::t('app', 'грн') ?>
                </div>
                <div class="term">
                    <?php echo Yii::t('app', 'за період') ?>
                </div>
                <div class="features row right">
                    <?php if(!empty($features[$room['room_id']])) { ?>
                        <?php foreach($features[$room['room_id']] as $feature) { ?>
                            <i class="material-icons">
                                <?php echo $feature ?>
                            </i>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="buttons">
                    <a href="#descr<?php echo $room['room_id'] ?>" title="<?php echo Yii::t('app', 'Детальніше') ?>" 
                       class="button-more waves-effect waves-blue btn-flat">
                        <span class="hide-on-small-only"><?php echo Yii::t('app', 'Детальніше') ?></span>
                        <i hide-xs class="material-icons hide-on-small-only right">
                            keyboard_arrow_down
                        </i>
                        <i class="material-icons hide-on-med-and-up">
                            arrow_forward
                        </i>
                    </a>
                    <div class="booking-form">
                        <form action="/booking/search?hashKey=<?php echo $room['hashKey'] ?>&refStep=1&lang=uk"
                              method="post">
                            <input type="hidden" name="selectedRoom[0]" value="<?php echo $room['id'] ?>">
                            <button type="submit" class="button-booking waves-effect waves-light btn">
                                <?php echo Yii::t('app', 'Забронювати') ?>
                            </button>
                        </form>
                    </div>
                </div>
                <?php if(!empty($room['descr'])) { ?>
                    <div class="modal room-more" id="descr<?php echo $room['room_id'] ?>">
                        <div class="modal-content">
                            <h4><?php echo $room['name'] ?></h4>
                            <button class="waves-effect waves-blue btn-flat modal-close">
                                <i class="material-icons">clear</i>
                            </button>
                            <p>
                                <?php echo $room['descr'] ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <?php if($i > $all) { ?>
        <div class="center-align">
            <button onclick="showAll();" id="button-all-rooms" class="waves-effect waves-white btn-flat">
                <?php echo Yii::t('app', 'Показати всі номери') ?>
            </button>
        </div>
    <?php } ?>
<?php } else { ?>
    <div id="rooms-header" class="row">
        <p class="col left">
            <?php echo Yii::t('app', 'Вільних номерів не знайдено') ?>
        </p>
    </div>
<?php } ?>

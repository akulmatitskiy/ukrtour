<?php

/**
 * Callback template
 * @var $this yii\web\View
 */
use yii\helpers\Url;
?>
<div class="modal-header blue text-gray center-align">
    <button class="modal-close waves-effect waves-circle waves-light btn-floating transparent button-close">
        <i class="material-icons">close</i>
    </button>
    <h4><?php echo Yii::t('app', 'Забронювати') ?></h4>
</div>
<div class="modal-content row">
    <form id="formReserve" action="<?php echo Url::to(['feedback/booking']) ?>" 
          method="post" name="formReserve"
          onsubmit="reserveSend('formReserve');return false;">
        <input id="reserve-type" type="hidden" name="type" value="<?php echo $type ?>">
        <input id="reserve-item-id" type="hidden" name="item" value="<?php echo $itemId ?>">
        <p class="center-align"><?php echo Yii::t('app', 'Введіть ваше ім\'я та номер телефону') ?></p>
        <div class="input-field">
            <i class="material-icons prefix">account_circle</i>
            <input id="reserve-name" type="text" name="name" required="" aria-required="true"
                   class="validate">
            <label for="reserve-name"><?php echo Yii::t('app', 'Ім\'я') ?></label>
        </div>
        <div class="input-field">
            <i class="material-icons prefix">date_range</i>
            <input id="reserve-date" name="date" type="text" class="datepicker">
            <label for="reserve-date"><?php echo Yii::t('app', 'Дата') ?></label>
        </div>
        <div class="input-field">

            <i class="material-icons prefix">phone</i>
            <input id="reserve-phone" name="phone" type="text" required="" aria-required="true">
            <label for="reserve-phone">
                0## ###-##-##
            </label>
        </div>
        <div class="modal-footer">
            <span id="cancel-reserve" class="waves-effect btn-flat modal-close">
                <?php echo Yii::t('app', 'Скасувати') ?>
            </span>
            <input id="reserve-submit" type="submit" 
                   class="waves-effect btn-flat" value="<?php echo Yii::t('app', 'Надіслати') ?>">
        </div>
    </form>
</div>


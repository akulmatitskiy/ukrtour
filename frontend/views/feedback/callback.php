<?php

use yii\helpers\Url;

/**
 * Callback template
 * @var $this yii\web\View
 */
?>
<div class="modal-header blue text-gray center-align valign-wrapper">
    <button class="modal-close waves-effect waves-circle waves-light btn-floating transparent button-close">
        <i class="material-icons">close</i>
    </button>
    <h4 class="valign"><?php echo Yii::t('app', 'Замовити зворотній дзвінок') ?></h4>
</div>
<div class="modal-content row">
    <form id="formCallback" action="<?php echo Url::to(['feedback/callback']) ?>" 
          method="post" name="formCallback"
          onsubmit="callbackSend('formCallback');return false;">
        <p class="center-align">
            <?php echo Yii::t('app', 'Введіть номер телефону') ?>
        </p>
        <div class="input-field">
            <input id="callback-phone" name="phone" type="text"
                   required="" aria-required="true">
            <label for="reserve-phone">
                0## ###-##-##
            </label>
        </div>
        <div class="modal-footer">
            <button onclick="callbackCancel('callback');" class="waves-effect btn-flat">
                <?php echo Yii::t('app', 'Скасувати') ?>
            </button>
            <input id="callback-submit" type="submit" 
                   class="waves-effect btn-flat" value="<?php echo Yii::t('app', 'Надіслати') ?>">
        </div>
    </form>
</div>
<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&subset=cyrillic',
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'theme/css/materialize.min.css',
        'theme/css/slick.css',
        'theme/css/slick-theme.css',
        'booking/static/css/booking.css',
        'booking/static/css/jquery.datetimepicker.css',
        'theme/css/style.css',
    ];
    public $js = [
        //'https://code.jquery.com/jquery-2.1.1.min.js',
        'theme/js/materialize.min.js',
        'theme/js/slick.min.js',
        'theme/js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}

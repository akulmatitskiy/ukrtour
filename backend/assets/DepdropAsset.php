<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DepdropAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kartik-v/dependent-dropdown/';
    //public $baseUrl = '@web';
    public $css = [
        'css/dependent-dropdown.min.css',
    ];
    public $js = [
        'js/dependent-dropdown.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

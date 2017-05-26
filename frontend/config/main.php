<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'ukrtour',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'assetsAutoCompress',
        'devicedetect'
    ],
    'language' => 'uk-UA',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['uk' => 'uk-UA', 'en' => 'en-US', 'ru' => 'ru-RU'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableLanguagePersistence' => false,
            'enableLanguageDetection' => false,
            'ignoreLanguageUrlPatterns' => [
                '#^site/(header|footer)/(.*)#' => '#site/(header|footer)#',
                '#^rooms-features/[0-9]+#' => '#hotels/rooms-features#',
                '#^booking#' => '#booking#',
            ],
            'rules' => [
                'hotels/items' => 'hotels/items',
                'hotels' => 'hotels/index',
                'hotels-search' => 'hotels/hotels-search',
                'search-rooms/hotel-<id:[0-9]+>' => 'hotels/rooms',
                'hotels/rooms' => 'servio/rooms',
                'rooms-features/<hotel:[0-9]+>' => 'hotels/rooms-features',
                'hotels-list' => 'hotels/list',
                'hotels/<slug:[A-Za-z\-0-9_]+>' => 'hotels/view',
                'gallery-images/<type:[a-z]+>/<id:\d+>' => 'gallery/gallery-images',
                'gallery/<type:[a-z]+>/<id:\d+>' => 'gallery/view',
                'pages/<slug:[A-Za-z\-0-9_]+>' => 'pages/view',
                'offers' => 'offers/index',
                'offers-list' => 'offers/list',
                'offers/<slug:[A-Za-z\-0-9_]+>' => 'offers/view',
                'slider/<type:[a-z]+>/<id:[0-9]+>' => 'gallery/slider',
                'tours/<slug:[A-Za-z\-0-9_]+>' => 'tours/view',
                'hostels/<slug:[A-Za-z\-0-9_]+>' => 'hostels/view',
                'banners/<categ:[0-9]+>' => 'banners/index',
                'banners' => 'banners/index',
                'conference-rooms' => 'conf-rooms/index',
                'search' => 'search/index',
                'confrooms-list' => 'conf-rooms/list',
                'conference-rooms/<slug:[A-Za-z\-0-9_]+>' => 'conf-rooms/view',
                'site/header/<lang:[a-z]+>' => 'site/header',
                'site/footer/<lang:[a-z]+>' => 'site/footer',
                //'feedback/callback-template' => 'feedback/reserve-template',
                'feedback/feedback-template/<type:[a-z]+>/<item:[0-9]+>' => 'feedback/reserve-template',
                'feedback/booking' => 'feedback/booking',
                '/<slug:[A-Za-z\-0-9_]+>' => 'categories/view',
                '/' => 'site/index',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'uk-UA',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'search' => [
            'class' => 'himiklab\yii2\search\Search',
            'models' => [
                'common\models\HotelsDescriptions',
                'common\models\ConfRoomsDescriptions',
                'common\models\OffersDescriptions',
            ],
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\DummyCache',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'php:d-M-Y H:i:s'
        ],
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect'
        ],
    ],
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
        ],
    ],
    'params' => $params,
];

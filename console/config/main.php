<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
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
            'indexDirectory' => '@frontend/runtime/search',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache'
        ],
    ],
    'modules' => [
        'rbac' => 'dektrium\rbac\RbacConsoleModule',
    ],
    'params' => $params,
];

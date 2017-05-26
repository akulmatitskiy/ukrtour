<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?php
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                        'label' => 'Меню',
                        'options' => ['class' => 'header']
                    ],
                    [
                        'label' => 'Категории',
                        'icon' => 'fa fa-folder ',
                        'url' => ['/categories/index'],
                    ],
                    [
                        'label' => 'Отели',
                        'icon' => 'fa fa-bed',
                        'url' => ['/hotels/index'],
                    ],
                    [
                        'label' => 'Конференц-залы',
                        'icon' => 'fa fa-users ',
                        'url' => ['/conf-rooms/index'],
                    ],
                    [
                        'label' => 'Баннеры',
                        'icon' => 'fa fa-picture-o',
                        'url' => ['/banners/index'],
                    ],
                    [
                        'label' => 'Страницы',
                        'icon' => 'fa fa-file-text-o',
                        'url' => ['/pages/index'],
                    ],
                    [
                        'label' => 'Акции',
                        'icon' => 'fa fa-tags',
                        'url' => ['/offers/index'],
                    ],
                    [
                        'label' => 'Туры',
                        'icon' => 'fa fa-bus',
                        'url' => ['/tours/index'],
                    ],
                    [
                        'label' => 'Турбазы',
                        'icon' => 'fa fa-tree',
                        'url' => ['/hostels/index'],
                    ],
                    [
                        'label' => 'Меню',
                        'icon' => 'fa fa-bars',
                        'url' => ['/menu/index'],
                    ],
                    [
                        'label' => 'Справочник характеристик',
                        'icon' => 'fa fa-book',
                        'url' => ['/features/index'],
                    ],
                    [
                        'label' => 'Справочник городов',
                        'icon' => 'fa fa-map',
                        'url' => ['/cities/index'],
                    ],
                    [
                        'label' => 'Характеристики номеров',
                        'icon' => 'fa fa-bed',
                        'url' => ['/rooms/index'],
                    ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'fa fa-user',
                        'url' => ['/user/admin'],
                    ],
                    [
                        'label' => 'Tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
                
            ]
        );
        echo Html::a('Выйти', Url::to(['/user/security/logout']), [
            'data-method' => 'post',
            'class' => 'btn'
            ]
        );
        ?>


    </section>

</aside>

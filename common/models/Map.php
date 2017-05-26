<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use frontend\models\Hotels as FrontendHotels;
use frontend\models\Hostels as FrontendHostels;

/**
 * Map
 */
class Map extends Model {

    /**
     * Cache
     * 60*60 = 3600
     */
    const MAP_CACHE_EXPIRATION = 0;

    /**
     *  Regions
     * @var array
     */
    private static $regions = [
        1 => [
            'alias' => 'crimea',
            'title' => [
                'uk-UA' => 'Крим',
                'ru-RU' => 'Крым',
                'en-US' => 'Crimea',
            ],
        ],
        2 => [
            'alias' => 'vn',
            'title' => [
                'uk-UA' => 'Вінницька область',
                'ru-RU' => 'Винницкая область',
                'en-US' => 'Vinnytsia oblast',
            ],
        ],
        3 => [
            'alias' => 'volyn',
            'title' => [
                'uk-UA' => 'Волинська область',
                'ru-RU' => 'Волынская область',
                'en-US' => 'Volyn oblast',
            ],
        ],
        4 => [
            'alias' => 'dp',
            'title' => [
                'uk-UA' => 'Дніпропетровська область',
                'ru-RU' => 'Днепропетровская область',
                'en-US' => 'Dnipropetrovsk oblast',
            ],
        ],
        5 => [
            'alias' => 'dn',
            'title' => [
                'uk-UA' => 'Донецька область',
                'ru-RU' => 'Донецкая область',
                'en-US' => 'Donetsk oblast',
            ],
        ],
        6 => [
            'alias' => 'zt',
            'title' => [
                'uk-UA' => 'Житомирська область',
                'ru-RU' => 'Житомирская область',
                'en-US' => 'Zhytomyr oblast',
            ],
        ],
        7 => [
            'alias' => 'uz',
            'title' => [
                'uk-UA' => 'Закарпатська область',
                'ru-RU' => 'Закарпатская область',
                'en-US' => 'Zakarpattia oblast',
            ],
        ],
        8 => [
            'alias' => 'zp',
            'title' => [
                'uk-UA' => 'Запорізька область',
                'ru-RU' => 'Запорожская область',
                'en-US' => 'Zaporizhzhia oblast',
            ],
        ],
        9 => [
            'alias' => 'if',
            'title' => [
                'uk-UA' => 'Івано-Франківська область',
                'ru-RU' => 'Ивано-Франковская область',
                'en-US' => 'Ivano-Frankivsk oblast',
            ],
        ],
        10 => [
            'alias' => 'kiev',
            'title' => [
                'uk-UA' => 'Київська область',
                'ru-RU' => 'Киевская область',
                'en-US' => 'Kyiv oblast',
            ],
        ],
        12 => [
            'alias' => 'kr',
            'title' => [
                'uk-UA' => 'Кіровоградська область',
                'ru-RU' => 'Кировоградская область',
                'en-US' => 'Kirovohrad oblast',
            ],
        ],
        13 => [
            'alias' => 'lg',
            'title' => [
                'uk-UA' => 'Луганська область',
                'ru-RU' => 'Луганская область',
                'en-US' => 'Luhansk oblast',
            ],
        ],
        14 => [
            'alias' => 'lviv',
            'title' => [
                'uk-UA' => 'Львівська область',
                'ru-RU' => 'Львовская область',
                'en-US' => 'Lviv oblast',
            ],
        ],
        15 => [
            'alias' => 'mk',
            'title' => [
                'uk-UA' => 'Миколаївська область',
                'ru-RU' => 'Николаевская область',
                'en-US' => 'Mykolaiv oblast',
            ],
        ],
        16 => [
            'alias' => 'od',
            'title' => [
                'uk-UA' => 'Одеська область',
                'ru-RU' => 'Одесская область',
                'en-US' => 'Odesa oblast',
            ],
        ],
        17 => [
            'alias' => 'pl',
            'title' => [
                'uk-UA' => 'Полтавська область',
                'ru-RU' => 'Полтавская область',
                'en-US' => 'Poltava oblast',
            ],
        ],
        18 => [
            'alias' => 'rv',
            'title' => [
                'uk-UA' => 'Рівненська область',
                'ru-RU' => 'Ровенская область',
                'en-US' => 'Rivne oblast',
            ],
        ],
        19 => [
            'alias' => 'sm',
            'title' => [
                'uk-UA' => 'Сумська область',
                'ru-RU' => 'Сумская область',
                'en-US' => 'Sumy oblast',
            ],
        ],
        20 => [
            'alias' => 'te',
            'title' => [
                'uk-UA' => 'Тернопільська область',
                'ru-RU' => 'Тернопольская область',
                'en-US' => 'Ternopil oblast',
            ],
        ],
        21 => [
            'alias' => 'kh',
            'title' => [
                'uk-UA' => 'Харківська область',
                'ru-RU' => 'Харьковская область',
                'en-US' => 'Kharkiv oblast',
            ],
        ],
        22 => [
            'alias' => 'ks',
            'title' => [
                'uk-UA' => 'Херсонська область',
                'ru-RU' => 'Херсонская область',
                'en-US' => 'Kherson oblast',
            ],
        ],
        23 => [
            'alias' => 'km',
            'title' => [
                'uk-UA' => 'Хмельницька область',
                'ru-RU' => 'Хмельницкая область',
                'en-US' => 'Khmelnytskyi oblast',
            ],
        ],
        24 => [
            'alias' => 'ck',
            'title' => [
                'uk-UA' => 'Черкаська область',
                'ru-RU' => 'Черкасская область',
                'en-US' => 'Cherkasy oblast',
            ],
        ],
        25 => [
            'alias' => 'cn',
            'title' => [
                'uk-UA' => 'Чернігівська область',
                'ru-RU' => 'Черниговская область',
                'en-US' => 'Chernihiv oblast',
            ],
        ],
        26 => [
            'alias' => 'cv',
            'title' => [
                'uk-UA' => 'Чернівецька область',
                'ru-RU' => 'Черновицкая область',
                'en-US' => 'Chernivtsi oblast',
            ],
        ],
    ];

    /**
     * Regions
     * @return array
     */
    public static function regions()
    {
        return self::$regions;
    }

    /**
     * Regiona labels
     * @return array the regions labels
     */
    public static function regionsLabels()
    {
        $lang    = Yii::$app->language;
        $regions = [];
        foreach(self::regions() as $id => $region) {
            $regions[$id] = $region['title'][$lang];
        }
        // Rm Crimea
        unset($regions[1]);

        return $regions;
    }

    /**
     * Map pins
     * @param type $param
     * @return type
     */
    public static function markers()
    {
        // Get hotels markers
        $marks = FrontendHotels::getHotelsGeo();

        // Get hostels markers
        $hostelsMarks = FrontendHostels::getHostelsGeo();

        // Add hostels marks to array
        foreach($hostelsMarks as $mark) {
            // Change hostel ID
            $mark['id'] = 'hostel-' . $mark['id'];

            // Push to markers array
            array_push($marks, $mark);
        }

        return $marks;
    }

    /**
     * Map items
     * @return type
     */
    public static function items()
    {
        // Hotels
        $items = FrontendHotels::getHotels(false);

        // Hostels
        $hostels = FrontendHostels::getHostels();

        // Hostels array
        foreach($hostels as $hostel) {
            array_push($items, [
                'id' => 'hotel-hostel-' . $hostel['id'],
                'hostelId' => $hostel['id'],
                'name' => $hostel['title'],
                'rating' => 0,
                'city' => Yii::t('app', 'Турбаза'),
                'url' => $hostel['url'],
                'image' => $hostel['image'],
                'text' => $hostel['annotation'],
                'type' => 'hostel'
            ]);
        }

        return $items;
    }

    /**
     * Map regions
     * @return type
     */
    public static function mapRegions()
    {
        $result = [];
        $lang   = Yii::$app->language;

        // Get regions
        $regions = self::regions();

        // Work with regions
        foreach($regions as $id => $region) {
            $items  = [];
            //Hotels in region
            $hotels = FrontendHotels::find()
                ->where([
                    'visible' => FrontendHotels::HOTEL_STATUS_VISIBLE,
                    'region' => $id
                ])
                ->all();

            // Hotels data
            if(!empty($hotels)) {
                foreach($hotels as $hotel) {
                    $item = self::hotelRegionData($hotel);
                    if(!empty($item)) {
                        $items[] = $item;
                    }
                }
            }

            // Hostels
            $hostels = FrontendHostels::find()
                ->where([
                    'status' => FrontendHostels::HOSTELS_STATUS_VISIBLE,
                    'region' => $id
                ])
                ->all();

            // Hostels data
            if(!empty($hostels)) {
                foreach($hostels as $hostel) {
                    $item = self::hostelRegionData($hostel);
                    if(!empty($item)) {
                        $items[] = $item;
                    }
                }
            }

            // Regions array
            if(!empty($items)) {
                $result[] = [
                    'id' => 'hotels-ls-' . $region['alias'],
                    'title' => $region['title'][$lang],
                    'items' => $items
                ];
            }
        }

        return $result;
    }

    /**
     * Hotel data
     * @param type $hotel
     * @return array $item The hotel data
     */
    protected static function hotelRegionData($hotel)
    {
        // Hotel name
        $name = $hotel->servioName;
        if(!empty($name)) {
            $name = $name->name;
        }

        // Hotel url
        if(!empty($hotel->descr->slug)) {
            $slug = $hotel->descr->slug;
            $url  = Url::to(['hotels/view', 'slug' => $slug]);
        } else {
            $url = '';
        }

        $item = [
            'name' => Yii::t('app', 'Готель:') . ' ' . $name,
            'rating' => $hotel->rating,
            'url' => $url,
        ];

        return $item;
    }

    /**
     * Hotel data
     * @param type $hotel
     * @return array $item The hotel data
     */
    protected static function hostelRegionData($hostel)
    {
        $title = '';
        $url   = '';

        if(!empty($hostel->descr->title)) {
            $title = $hostel->descr->title;
            // Hotel url
            if(!empty($hostel->descr->slug)) {
                $slug = $hostel->descr->slug;
                $url  = Url::to(['hostels/view', 'slug' => $slug]);
            }


            $item = [
                'name' => Yii::t('app', 'Турбаза:') . ' ' . $title,
                'rating' => 0,
                'url' => $url,
            ];

            return $item;
        } else {
            return null;
        }
    }
    
    /**
     * Regions ratins
     * count hotels in region / max hotels in regions
     * @return array regions ratings
     */
    public static function regionsRatings()
    {
        // Regions
        $regions = self::regions();

        // Hotels
        $hotels = FrontendHotels::findAll(['visible' => FrontendHotels::HOTEL_STATUS_VISIBLE]);
        $max    = 1;
        foreach($hotels as $hotel) {
            if(!empty($regions[$hotel->region]['rate'])) {
                // New rate
                $rate = $regions[$hotel->region]['rate'] + 1;

                // push to regions
                $regions[$hotel->region]['rate'] = $rate;

                // Maximum
                if($rate > $max) {
                    $max = $rate;
                }
            } else {
                $regions[$hotel->region]['rate'] = 1;
            }
        }
        
        // Hostels
        $hostels = FrontendHostels::findAll(['status' => FrontendHostels::HOSTELS_STATUS_VISIBLE]);
        foreach($hostels as $hostel) {
            if(!empty($regions[$hostel->region]['rate'])) {
                // New rate
                $rate = $regions[$hostel->region]['rate'] + 1;

                // push to regions
                $regions[$hostel->region]['rate'] = $rate;

                // Maximum
                if($rate > $max) {
                    $max = $rate;
                }
            } elseif(!empty($hostel->region)) {
                $regions[$hostel->region]['rate'] = 1;
            }
        }

        // Ratings
        $rating = [];
        foreach($regions as $regionId => $region) {
        	if(!empty($regionId)) {
	            if(!empty($region['rate'])) {
	                $rating[$region['alias']] = round($region['rate'] / $max + 0.45 , 1);
	                if($rating[$region['alias']] > 1) {
	                    // Max opacity = 1
	                    $rating[$region['alias']] = 1;
	                }
	                // Minimun opacity = 0.3
	                if($rating[$region['alias']] < 0.4) {
	                    $rating[$region['alias']] = 0.4;
	                }
	            } else {
	                // Default opacity = 0.3
	                $rating[$region['alias']] = '0.3';
	            }
	        }
        }
        return $rating;
    }

}
